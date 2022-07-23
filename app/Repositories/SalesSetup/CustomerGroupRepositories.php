<?php

namespace App\Repositories\SalesSetup;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerGroup;
use App\Models\Customer;
use App\Exports\CustomerGroupExports;
use App\Imports\CustomerGroupImports;
use Maatwebsite\Excel\Facades\Excel;
use DB;
class CustomerGroupRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var CustomerGroup
     */
    private $customerGroup;
    /**
     * CourseRepository constructor.
     * @param customerGroup $customerGroup
     */
    public function __construct(CustomerGroup $customerGroup)
    {
        $this->customerGroup = $customerGroup;
        
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('salesSetup.customerGroup.edit') ? 1 : 0;
        $delete = Helper::roleAccess('salesSetup.customerGroup.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->customerGroup::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $customerGroups = $this->customerGroup::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->customerGroup::count();
        } else {
            $search = $request->input('search.value');
            $customerGroups = $this->customerGroup::select($columns)->company()->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->customerGroup::select($columns)->company()->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }

        $columns = Helper::getQueryProperty();
        $data = array();
        if ($customerGroups) {
            foreach ($customerGroups as $key => $customerGroup) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                    if ($customerGroup->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('salesSetup.customerGroup.status', [$customerGroup->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('salesSetup.customerGroup.status', [$customerGroup->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                    $nestedData['status'] = $status;
                else:
                    $nestedData[$value] = $customerGroup->$value;
                endif;
            endforeach;
            if ($ced != 0) :
                if ($edit != 0)
                $edit_data = '<a href="' . route('salesSetup.customerGroup.edit', $customerGroup->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                else
                    $edit_data = '';

                if ($delete != 0)
                if($this->checkCustomerExistsByCustomerGroup($customerGroup->id) === false):
                    $delete_data = '<a delete_route="' . route('salesSetup.customerGroup.destroy', $customerGroup->id) . '" delete_id="' . $customerGroup->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $customerGroup->id . '"><i class="fa fa-times"></i></a>';
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

    public function checkCustomerExistsByCustomerGroup($customerType){
        $customerGroupList = Customer::where('customer_type', $customerType)->count();
        if( $customerGroupList > 0){
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
        $result = $this->customerGroup::find($id);
        return $result;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function implodeCustomerGroup(){
        DB::beginTransaction();
        try {
            Excel::import(new CustomerGroupImports,request()->file('importFile'));
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
    public function explodeCustomerGroup()
    {
        return Excel::download(new CustomerGroupExports, 'customer-group-list.xlsx');
    }

    /**
     * @param $request
     * @return mixed
     */
    public function store($request)
    {
        $customerGroup = new $this->customerGroup();
        $customerGroup->name = $request->name;
        $customerGroup->status = 'Approved';
        $customerGroup->created_by = helper::userId();
        $customerGroup->company_id = helper::companyId();
        $customerGroup->save();
        return $customerGroup;
    }

    public function update($request, $id)
    {
        $customerGroup = $this->customerGroup::findOrFail($id);
        $customerGroup->name = $request->name;
        $customerGroup->status = 'Approved';
        $customerGroup->updated_by =  helper::userId();
        $customerGroup->company_id = helper::companyId();
        $customerGroup->save();
        return $customerGroup;
    }

    public function statusUpdate($id, $status)
    {
        $customerGroup = $this->customerGroup::find($id);
        $customerGroup->status = $status;
        $customerGroup->save();
        return $customerGroup;
    }

    public function destroy($id)
    {
        $customerGroup = $this->customerGroup::find($id);
        $customerGroup->delete();
        return true;
    }
}
