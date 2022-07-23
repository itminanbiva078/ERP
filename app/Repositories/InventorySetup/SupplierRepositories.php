<?php

namespace App\Repositories\InventorySetup;
use App\Exports\SuppliersExports;
use App\Imports\SuppliersImports;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use App\Helpers\Helper;
use App\Models\Purchases;
use Illuminate\support\Facades\Auth;
use App\Models\Supplier;
class SupplierRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Supplier
     */
    private $supplier;
    /**
     * CourseRepository constructor.
     * @param Supplier $supplier
     */
    public function __construct(Supplier $supplier)
    {
        $this->supplier = $supplier;
    }

/**
     * @param $request
     * @return mixed
     */
    public function supplierCode()
    {
        $code = $this->supplier::select('id')->latest()->first();
        $code =  "SID" . date("y") . date("m"). str_pad($code->id ?? 0 +1, 5, "0", STR_PAD_LEFT);
        return $code;
    }
    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
      
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('inventorySetup.supplier.edit') ? 1 : 0;
        $delete = Helper::roleAccess('inventorySetup.supplier.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->supplier::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $suppliers = $this->supplier::select($columns)->company()->with('supplierType')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->supplier::count();
        } else {
            $search = $request->input('search.value');
            $suppliers = $this->supplier::select($columns)->company()->with('supplierType')->where(function ($q) use ($columns,$search) {
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
            $totalFiltered = $this->supplier::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }

        foreach($suppliers as $key => $value):
            if(!empty($value->supplier_type))
               $value->supplier_type = $value->supplierType->name ?? '';
        endforeach;
        
        $columns = Helper::getQueryProperty();
        $data = array();
        if ($suppliers) {
            foreach ($suppliers as $key => $supplier) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                if($value == 'status'):
                if ($supplier->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('inventorySetup.supplier.status', [$supplier->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('inventorySetup.supplier.status', [$supplier->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                $nestedData['status'] = $status;
                    else:
                        $nestedData[$value] = $supplier->$value;
                    endif;
                endforeach;
                if ($ced != 0) :
                    if ($edit != 0)
                        $edit_data = '<a href="' . route('inventorySetup.supplier.edit', $supplier->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    else
                        $edit_data = '';

                    if ($delete != 0)
                    if($this->checkSupplierByExistsPurchases($supplier->id)===false):
                        $delete_data = '<a delete_route="' . route('inventorySetup.supplier.destroy', $supplier->id) . '" delete_id="' . $supplier->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $supplier->id . '"><i class="fa fa-times"></i></a>';
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
    public function details($id)
    {
        $result = $this->supplier::find($id);
        return $result;
    }

     /**
     * @param $request
     * @return mixed
     */
    public function checkSupplierByExistsPurchases($supplierId){
        $supplierList = Purchases::where('supplier_id', $supplierId)->count();
        if($supplierList > 0){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * @param $request
     * @return mixed
     */
    public function implodeSupplier(){
        DB::beginTransaction();
        try {
            Excel::import(new SuppliersImports,request()->file('importFile'));
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
    public function exploadSupplier()
    {
        return Excel::download(new SuppliersExports, 'supplier-list.xlsx');

    }
    public function store($request)
    {
        $supplier = new $this->supplier();
        $supplier->code = $this->supplierCode();
        $supplier->contact_person = $request->contact_person;
        $supplier->supplier_type = $request->supplier_type;
        $supplier->name = $request->name;
        $supplier->branch_id  = $request->branch_id;
        $supplier->division_id  = $request->division_id ;
        $supplier->district_id  = $request->district_id ;
        $supplier->upazila_id  = $request->upazila_id ;
        $supplier->union_id  = $request->union_id ;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->pay_term = $request->pay_term;
        $supplier->pay_term_type = $request->pay_term_type;
        $supplier->status = 'Approved';
        $supplier->created_by = helper::userId();
        $supplier->company_id = helper::companyId();
        $supplier->save();
        return $supplier;
    }

    public function update($request, $id)
    {
        $supplier = $this->supplier::findOrFail($id);
        $supplier->code = $request->code;
        $supplier->contact_person = $request->contact_person;
        $supplier->supplier_type = $request->supplier_type;
        $supplier->name = $request->name;
        $supplier->branch_id   = $request->branch_id;
        $supplier->division_id  = $request->division_id ;
        $supplier->district_id  = $request->district_id ;
        $supplier->upazila_id  = $request->upazila_id ;
        $supplier->union_id  = $request->union_id ;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->pay_term = $request->pay_term;
        $supplier->pay_term_type = $request->pay_term_type;
        $supplier->status = 'Approved';
        $supplier->updated_by = helper::userId();
        $supplier->company_id = helper::companyId();
        $supplier->save();
        return $supplier;
    }

    public function statusUpdate($id, $status)
    {
        $supplier = $this->supplier::find($id);
        $supplier->status = $status;
        $supplier->save();
        return $supplier;
    }

    public function destroy($id)
    {
        $supplier = $this->supplier::find($id);
        $supplier->delete();
        return true;
    }
}