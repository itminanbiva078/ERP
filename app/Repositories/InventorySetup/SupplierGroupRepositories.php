<?php

namespace App\Repositories\InventorySetup;
use App\Exports\SupplierGroupsExports;
use App\Imports\SupplierGroupsImports;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use App\Helpers\Helper;
use Illuminate\support\Facades\Auth;
use App\Models\SupplierGroup;
use App\Models\Supplier;

class SupplierGroupRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var SupplierGroup
     */
    private $supplierGroup;
    /**
     * SupplierGroupRepositories constructor.
     * @param SupplierGroup $supplierGroup
     */
    public function __construct(SupplierGroup $supplierGroup)
    {
        $this->supplierGroup = $supplierGroup;
       
    }


    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
      
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('inventorySetup.supplierGroup.edit') ? 1 : 0;
        $delete = Helper::roleAccess('inventorySetup.supplierGroup.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->supplierGroup::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $supplierGroups = $this->supplierGroup::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->supplierGroup::count();
        } else {
            $search = $request->input('search.value');
            $supplierGroups = $this->supplierGroup::select($columns)->company()->where(function ($q) use ($columns,$search) {
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
            $totalFiltered = $this->supplierGroup::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }


        $columns = Helper::getQueryProperty();
        $data = array();
        if ($supplierGroups) {
            foreach ($supplierGroups as $key => $supplierGroup) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                if($value == 'status'):
                if ($supplierGroup->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('inventorySetup.supplierGroup.status', [$supplierGroup->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('inventorySetup.supplierGroup.status', [$supplierGroup->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                $nestedData['status'] = $status;
                    else:
                        $nestedData[$value] = $supplierGroup->$value;
                    endif;
                endforeach;
                if ($ced != 0) :
                    if ($edit != 0)
                        $edit_data = '<a href="' . route('inventorySetup.supplierGroup.edit', $supplierGroup->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    else
                        $edit_data = '';

                    if ($delete != 0)
                    if($this->checkSupplierExistsBySupplierGroup($supplierGroup->id) === false):
                        $delete_data = '<a delete_route="' . route('inventorySetup.supplierGroup.destroy', $supplierGroup->id) . '" delete_id="' . $supplierGroup->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $supplierGroup->id . '"><i class="fa fa-times"></i></a>';
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

    public function checkSupplierExistsBySupplierGroup($supplierType){
        $supplierGroupList = Supplier::where('supplier_type', $supplierType)->count();
        if( $supplierGroupList > 0){
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
        $result = $this->supplierGroup::find($id);
        return $result;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function implodeSupplierGroup(){
        DB::beginTransaction();
        try {
            Excel::import(new SupplierGroupsImports,request()->file('importFile'));
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
    public function exploadSupplierGroup()
    {
        return Excel::download(new SupplierGroupsExports, 'supplierGroup-list.xlsx');

    }

    public function store($request)
    {
        $supplierGroup = new $this->supplierGroup();
        $supplierGroup->name = $request->name;
        $supplierGroup->status = 'Approved';
        $supplierGroup->created_by = helper::userId();
        $supplierGroup->company_id = helper::companyId();
        $supplierGroup->save();
        return $supplierGroup;
    }

    public function update($request, $id)
    {
        $supplierGroup = $this->supplierGroup::findOrFail($id);
        $supplierGroup->name = $request->name;
        $supplierGroup->status = 'Approved';
        $supplierGroup->updated_by = helper::userId();
        $supplierGroup->company_id = helper::companyId();
        $supplierGroup->save();
        return $supplierGroup;
    }

    public function statusUpdate($id, $status)
    {
        $supplierGroup = $this->supplierGroup::find($id);
        $supplierGroup->status = $status;
        $supplierGroup->save();
        return $supplierGroup;
    }

    public function destroy($id)
    {
        $supplierGroup = $this->supplierGroup::find($id);
        $supplierGroup->delete();
        return true;
    }
}