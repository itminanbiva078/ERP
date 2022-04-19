<?php

namespace App\Repositories\InventorySetup;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductUnit;
use App\Models\Product;
use App\Imports\ProductUnitsImport;
use App\Exports\ProductUnitsExport;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class UnitRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var ProductUnit
     */
    private $productUnit;
    /**
     * CourseRepository constructor.
     * @param productUnit $productUnit
     */
    public function __construct(ProductUnit $productUnit)
    {
        $this->productUnit = $productUnit;
       
    }

    /**
     * @param $request
     * @return mixed
     */
    
    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id"); 
        $edit = Helper::roleAccess('inventorySetup.unit.edit') ? 1 : 0;
        $delete = Helper::roleAccess('inventorySetup.unit.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->productUnit::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $productUnits = $this->productUnit::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->productUnit::count();
        } else {
            $search = $request->input('search.value');
            $productUnits = $this->productUnit::select($columns)->company()->where(function ($q) use ($columns,$search) {
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
            $totalFiltered = $this->productUnit::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }

        $columns = Helper::getTableProperty();
        $data = array();
        if ($productUnits) {
            foreach ($productUnits as $key => $productUnit) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                if ($productUnit->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('inventorySetup.unit.status', [$productUnit->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('inventorySetup.unit.status', [$productUnit->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                    $nestedData['status'] = $status;
                else:
                    $nestedData[$value] = $productUnit->$value;
                endif;
            endforeach;
            if ($ced != 0) :
                if ($edit != 0)
                $edit_data = '<a href="' . route('inventorySetup.unit.edit', $productUnit->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                else
                    $edit_data = '';
                if ($delete != 0)
                if($this->checkUnitByExistsProduct($productUnit->id) === false):
                    $delete_data = '<a delete_route="' . route('inventorySetup.unit.destroy', $productUnit->id) . '" delete_id="' . $productUnit->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $productUnit->id . '"><i class="fa fa-times"></i></a>';
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
    public function checkUnitByExistsProduct($unitId){
        $unitList = Product::where('unit_id' ,$unitId)->count();
        if($unitList >  0){
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
        $result = $this->productUnit::find($id);
        return $result;
    }

    public function implodeUnit(){
        DB::beginTransaction();
        try {
            Excel::import(new ProductUnitsImport,request()->file('importFile'));
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
    public function exploadUnit()
    {
        return Excel::download(new ProductUnitsExport, 'unit-list.xlsx');

    }
    public function store($request)
    {
        $productUnit = new $this->productUnit();
        $productUnit->name = $request->name;
        $productUnit->status = 'Approved';
        $productUnit->created_by = helper::userId();
        $productUnit->company_id = helper::companyId();
        $productUnit->save();
        return $productUnit;
    }

    public function update($request, $id)
    {
        $productUnit = $this->productUnit::findOrFail($id);
        $productUnit->name = $request->name;
        $productUnit->status = 'Approved';
        $productUnit->updated_by = helper::userId();
        $productUnit->company_id = helper::companyId();
        $productUnit->save();
        return $productUnit;
    }

    public function statusUpdate($id, $status)
    {
        $productUnit = $this->productUnit::find($id);
        $productUnit->status = $status;
        $productUnit->save();
        return $productUnit;
    }

    public function destroy($id)
    {
        $productUnit = $this->productUnit::find($id);
        $productUnit->delete();
        return true;
    }
}