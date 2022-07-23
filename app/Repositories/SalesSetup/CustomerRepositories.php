<?php

namespace App\Repositories\SalesSetup;
use App\Helpers\Helper;
use Illuminate\support\Facades\Auth;
use App\Models\Customer;
use App\Models\Sales;
use App\Exports\CustomersExports;
use App\Imports\CustomersImports;
use Maatwebsite\Excel\Facades\Excel;
use DB;
class CustomerRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Customer
     */
    private $customer;
    /**
     * CourseRepository constructor.
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
       
    }

   
    /**
     * @param $request
     * @return mixed
     */
    
    public function getList($request)
    {
        
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");    
        $edit = Helper::roleAccess('salesSetup.customer.edit') ? 1 : 0;
        $delete = Helper::roleAccess('salesSetup.customer.destroy') ? 1 : 0;
        $view = Helper::roleAccess('salesSetup.customer.show') ? 1 : 0;
        $ced = $edit + $delete + $view;

        $totalData = $this->customer::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $customers = $this->customer::select($columns)->company()->with('customerType')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->customer::count();
        } else {
            $search = $request->input('search.value');
            $customers = $this->customer::select($columns)->company()->with('customerType')->where(function ($q) use ($columns,$search) {
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
            $totalFiltered = $this->customer::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }
        foreach($customers as $key => $value):
            if(!empty($value->customer_type))
               $value->customer_type = $value->customerType->name ?? '';
        endforeach;

        $columns = Helper::getQueryProperty();
        $data = array();
        if ($customers) {
            foreach ($customers as $key => $customer) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                if ($customer->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('salesSetup.customer.status', [$customer->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('salesSetup.customer.status', [$customer->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                    $nestedData['status'] = $status;
                else:
                    $nestedData[$value] = $customer->$value;
                endif;
            endforeach;
            if ($ced != 0) :
                if ($edit != 0)
                $edit_data = '<a href="' . route('salesSetup.customer.edit', $customer->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                else
                    $edit_data = '';
                if ($delete != 0)
                if($this->checkCustomerByExistsSales($customer->id) === false):
                    $delete_data = '<a delete_route="' . route('salesSetup.customer.destroy', $customer->id) . '" delete_id="' . $customer->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $customer->id . '"><i class="fa fa-times"></i></a>';
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
        $result = $this->customer::find($id);
        return $result;
    }
    /**
     * @param $request
     * @return mixed
     */
    public function customerList($request)
    {
        $result = $this->customer::where('status','Approved')->company()
        ->where(function ($query) use ($request){
            $query->where('name', 'LIKE', "%$request->term%")
                  ->orWhere('name', 'LIKE', "%$request->term%")
                  ->orWhere('name', 'LIKE', "%$request->term%")
                  ->orWhere('name', 'LIKE', "%$request->term%")
                  ->orWhere('name', 'LIKE', "%$request->term%");
        })
        ->get();


        $response = array();
        foreach($result as $customer){
           $response[] = array("value"=>$customer->id,"label"=>$customer->name);
        }
  
        return $response;
    }
  /**
     * @param $request
     * @return mixed
     */
    public function getActiveCustomer()
    {
        $result = $this->customer::where('status', 'Approved')->get();
        return $result;
    }
  /**
     * @param $request
     * @return mixed
     */
    public function checkCustomerByExistsSales($customerId)
    {
        $customerList = Sales::where('customer_id',$customerId)->count();
        if($customerList > 0){
            return true;
        }else{
            return false;

       }     
    }

    /**
     * @param $request
     * @return mixed
     */
    public function customerCode()
    {
        $code = $this->customer::select('id')->latest()->first();
        $code =  "SID" . date("y") . date("m"). str_pad($code->id ?? 0 +1, 5, "0", STR_PAD_LEFT);
        return $code;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function implodeCustomer(){
        DB::beginTransaction();
        try {
            Excel::import(new CustomersImports,request()->file('importFile'));
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
    public function explodeCustomer()
    {
        return Excel::download(new CustomersExports, 'customer-list.xlsx');
    }

    /**
     * @param $request
     * @return mixed
     */
    
    public function store($request)
    {
        $customer = new $this->customer();
        $customer->code = $request->code;
        $customer->contact_person = $request->contact_person;
        $customer->customer_type = $request->customer_type;
        $customer->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
        $customer->division_id  = $request->division_id ;
        $customer->district_id  = $request->district_id ;
        $customer->upazila_id  = $request->upazila_id ;
        $customer->union_id  = $request->union_id ;
        $customer->media_id  = $request->media_id ;
        $customer->sr_id  = $request->sr_id ;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->phone = $request->phone;
        $customer->pay_term = $request->pay_term;
        $customer->pay_term_type = $request->pay_term_type;
        $customer->status = 'Approved';
        $customer->created_by = helper::userId();
        $customer->company_id = helper::companyId();
        $customer->save();
        return $customer;
    }

    public function update($request, $id)
    {
        $customer = $this->customer::findOrFail($id);
        $customer->code = $request->code;
        $customer->contact_person = $request->contact_person;
        $customer->customer_type = $request->customer_type;
        $customer->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
        $customer->division_id  = $request->division_id ;
        $customer->district_id  = $request->district_id ;
        $customer->upazila_id  = $request->upazila_id ;
        $customer->union_id  = $request->union_id ;
        $customer->media_id  = $request->media_id ;
        $customer->sr_id  = $request->sr_id ;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->phone = $request->phone;
        $customer->pay_term = $request->pay_term;
        $customer->pay_term_type = $request->pay_term_type;
        $customer->status = 'Approved';
        $customer->updated_by = helper::userId();
        $customer->company_id = helper::companyId();
        $customer->save();
        return $customer;
    }

    public function statusUpdate($id, $status)
    {
        $customer = $this->customer::find($id);
        $customer->status = $status;
        $customer->save();
        return $customer;
    }

    public function destroy($id)
    {
        $customer = $this->customer::find($id);
        $customer->delete();
        return true;
    }
}