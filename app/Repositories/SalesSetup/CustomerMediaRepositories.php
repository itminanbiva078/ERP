<?php

namespace App\Repositories\SalesSetup;
use DB;
use App\Helpers\Helper;
use App\Models\Customer;
use App\Models\CustomerMedia;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomerMediaExports;
use App\Imports\CustomerMediaImports;

class CustomerMediaRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var CustomerMedia
     */
    private $customerMedia;
    /**
     * CourseRepository constructor.
     * @param customerMedia $customerMedia
     */
    public function __construct(CustomerMedia $customerMedia)
    {
        $this->customerMedia = $customerMedia;
        
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('salesSetup.customerMedia.edit') ? 1 : 0;
        $delete = Helper::roleAccess('salesSetup.customerMedia.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->customerMedia::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $customerMedias = $this->customerMedia::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->customerMedia::count();
        } else {
            $search = $request->input('search.value');
            $customerMedias = $this->customerMedia::select($columns)->company()->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->customerMedia::select($columns)->company()->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }

        $columns = Helper::getTableProperty();
        $data = array();
        if ($customerMedias) {
            foreach ($customerMedias as $key => $customerMedia) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                    if ($customerMedia->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('salesSetup.customerMedia.status', [$customerMedia->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('salesSetup.customerMedia.status', [$customerMedia->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                    $nestedData['status'] = $status;
                else:
                    $nestedData[$value] = $customerMedia->$value;
                endif;
            endforeach;
            if ($ced != 0) :
                if ($edit != 0)
                $edit_data = '<a href="' . route('salesSetup.customerMedia.edit', $customerMedia->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                else
                    $edit_data = '';

                if ($delete != 0)
                if($this->checkCustomerExistsByCustomerMedia($customerMedia->id) === false):
                    $delete_data = '<a delete_route="' . route('salesSetup.customerMedia.destroy', $customerMedia->id) . '" delete_id="' . $customerMedia->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $customerMedia->id . '"><i class="fa fa-times"></i></a>';
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

    public function checkCustomerExistsByCustomerMedia($customerType){
        $customerMediaList = Customer::where('customer_type', $customerType)->count();
        if( $customerMediaList > 0){
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
        $result = $this->customerMedia::find($id);
        return $result;
    }

   

    /**
     * @param $request
     * @return mixed
     */
    public function store($request)
    {
        $customerMedia = new $this->customerMedia();
        $customerMedia->name = $request->name;
        $customerMedia->status = 'Approved';
        $customerMedia->created_by = helper::userId();
        $customerMedia->company_id = helper::companyId();
        $customerMedia->save();
        return $customerMedia;
    }

    public function update($request, $id)
    {
        $customerMedia = $this->customerMedia::findOrFail($id);
        $customerMedia->name = $request->name;
        $customerMedia->status = 'Approved';
        $customerMedia->updated_by =  helper::userId();
        $customerMedia->company_id = helper::companyId();
        $customerMedia->save();
        return $customerMedia;
    }

    public function statusUpdate($id, $status)
    {
        $customerMedia = $this->customerMedia::find($id);
        $customerMedia->status = $status;
        $customerMedia->save();
        return $customerMedia;
    }

    public function destroy($id)
    {
        $customerMedia = $this->customerMedia::find($id);
        $customerMedia->delete();
        return true;
    }
}
