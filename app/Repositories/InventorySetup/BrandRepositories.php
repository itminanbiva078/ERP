<?php

namespace App\Repositories\InventorySetup;

use App\Exports\BrandExport;
use App\Helpers\Helper;
use App\Imports\BrandImport;
use Illuminate\Support\Facades\Auth;
use App\Models\Brand;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class BrandRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Brand
     */
    private $brand;
    /**
     * CourseRepository constructor.
     * @param brand $brand
     */
    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
      
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('inventorySetup.brand.edit') ? 1 : 0;
        $delete = Helper::roleAccess('inventorySetup.brand.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->brand::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $brands = $this->brand::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->brand::count();
        } else {
            $search = $request->input('search.value');
            $brands = $this->brand::select($columns)->company()->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->brand::select($columns)->company()->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }

        $columns = Helper::getQueryProperty();
        $data = array();
        if ($brands) {
            foreach ($brands as $key => $brand) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                    if ($brand->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('inventorySetup.brand.status', [$brand->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('inventorySetup.brand.status', [$brand->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                    $nestedData['status'] = $status;
                else:
                    $nestedData[$value] = $brand->$value;
                endif;
            endforeach;
            if ($ced != 0) :
                if ($edit != 0)
                $edit_data = '<a href="' . route('inventorySetup.brand.edit', $brand->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                else
                    $edit_data = '';

                if ($delete != 0)
                if($this->checkBrandByExistsProduct($brand->id) === false):
                    $delete_data = '<a delete_route="' . route('inventorySetup.brand.destroy', $brand->id) . '" delete_id="' . $brand->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $brand->id . '"><i class="fa fa-times"></i></a>';
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
    public function checkBrandByExistsProduct($brandId){
        $brandList = Product::where('brand_id', $brandId)->count();
        if($brandList > 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    public function details($id)
    {
        $result = $this->brand::find($id);
        return $result;
    }
    /**
     * @param $request
     * @return mixed
     */
    public function implodeBrand($request)
    {

        DB::beginTransaction();
        try {
            Excel::import(new BrandImport,request()->file('importFile'));
            DB::commit();
            // all good
            return 1;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }

    }

    public function store($request)
    {
        $brand = new $this->brand();
        $brand->name = $request->name;
        $brand->status = 'Approved';
        $brand->created_by = helper::userId();
        $brand->company_id = helper::companyId();;
        $brand->save();
        return $brand;
    }

    public function update($request, $id)
    {
        $brand = $this->brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->status = 'Approved';
        $brand->updated_by = helper::userId();
        $brand->company_id = helper::companyId();
        $brand->save();
        return $brand;
    }

    public function statusUpdate($id, $status)
    {
        $brand = $this->brand::find($id);
        $brand->status = $status;
        $brand->save();
        return $brand;
    }

    public function exploadBrand()
    {
        return Excel::download(new BrandExport, 'brand-list.xlsx');
    }


    public function destroy($id)
    {
        $brand = $this->brand::find($id);
        $brand->delete();
        return true;
    }
}
