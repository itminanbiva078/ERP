<?php

namespace App\Repositories\InventorySetup;
use App\Helpers\Helper;
use App\Imports\CategoryImport;
use App\Exports\CategoryExport;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use DB;
use Maatwebsite\Excel\Facades\Excel;


class CategoryRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Category
     */
    private $category;
    /**
     * CourseRepository constructor.
     * @param category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
      
    }
/**
     * @param $request
     * @return mixed
     */
    
    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id"); 
        $edit = Helper::roleAccess('inventorySetup.category.edit') ? 1 : 0;
        $delete = Helper::roleAccess('inventorySetup.category.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->category::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $categorys = $this->category::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->category::count();
        } else {
            $search = $request->input('search.value');
            $categorys = $this->category::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                // ->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->category::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }


        $columns = Helper::getQueryProperty();
        $data = array();
        if ($categorys) {
            foreach ($categorys as $key => $category) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                if ($category->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('inventorySetup.category.status', [$category->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('inventorySetup.category.status', [$category->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                    $nestedData['status'] = $status;
                else:
                    $nestedData[$value] = $category->$value;
                endif;
            endforeach;
            if ($ced != 0) :
                if ($edit != 0)
                $edit_data = '<a href="' . route('inventorySetup.category.edit', $category->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                else
                    $edit_data = '';
                if ($view =! 0)

                if ($delete != 0)
                if($this->checkProductExistByCategory($category->id) === false): 
                    $delete_data = '<a delete_route="' . route('inventorySetup.category.destroy', $category->id) . '" delete_id="' . $category->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $category->id . '"><i class="fa fa-times"></i></a>';
                else: 
                    $delete_data = '';
                endif;
                else
                    $delete_data = '';

                 $nestedData['action'] = $edit_data . ' ' . $delete_data;
            else :
                $nestedData['action'] = '';
            endif;
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        return $json_data;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function checkProductExistByCategory($categoryId)
    {
        $productList = Product::where('category_id',$categoryId)->count(); 
        if($productList > 0){
            return true;
        }else{
            return false;
        }
    }


    /**
     * @param $request
     * @return mixed
     */
    public function getActiveCategory()
    {
        $activeCategoryList = Category::where('status','Approved')->get(); 
       return $activeCategoryList;
    }

    public function implodeCategory(){
        DB::beginTransaction();
        try {
            Excel::import(new CategoryImport,request()->file('importFile'));
            DB::commit();
            // all good
            return 1;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    public function explodeCategory()
    {
        return Excel::download(new CategoryExport, 'category-list.xlsx');

    }
    /**
     * @param $request
     * @return mixed
     */
    public function details($id)
    {
        $result = $this->category::find($id);
        return $result;
    }

    public function store($request)
    {
        $category = new $this->category();
        $category->name = $request->name;
        $category->parent_id = $request->parent_id;
        $category->priority = $request->priority;
        $category->status = 'Approved';
        $category->created_by = helper::userId();
        $category->company_id = helper::companyId();
        $category->save();
        return $category;
    }

    public function update($request, $id)
    {
        $category = $this->category::findOrFail($id);
        $category->name = $request->name;
        $category->parent_id = $request->parent_id;
        $category->priority = $request->priority;
        $category->status = 'Approved';
        $category->updated_by = helper::userId();
        $category->company_id = helper::companyId();
        $category->save();
        return $category;
    }

    public function statusUpdate($id, $status)
    {
        $category = $this->category::find($id);
        $category->status = $status;
        $category->save();
        return $category;
    }

    public function destroy($id)
    {
        
        $category = $this->category::find($id);
        $category->delete();
        return true;
    }
}