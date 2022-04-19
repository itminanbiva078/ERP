<?php

namespace App\Repositories\Settings;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\GeneralSetup;
use phpDocumentor\Reflection\PseudoTypes\False_;
class CompanyRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Company
     */
    private $company;
    /**
     * CourseRepository constructor.
     * @param Company $company
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
        
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('settings.company.edit') ? 1 : 0;
        $delete = Helper::roleAccess('settings.company.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->company::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $companies = $this->company::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->company::count();
        } else {
            $search = $request->input('search.value');
            $companies = $this->company::select($columns)->company()->where(function ($q) use ($columns,$search) {
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
            $totalFiltered = $this->company::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }

        $columns = Helper::getTableProperty();
         $data = array();
        if ($companies) {
            foreach ($companies as $key => $company) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
               
                if ($company->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('settings.company.status', [$company->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('settings.company.status', [$company->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                $nestedData['status'] = $status;
            else:
                $nestedData[$value] = $company->$value;
            endif;
        endforeach;
        if ($ced != 0) :
            if ($edit != 0)
                $edit_data = '<a href="' . route('settings.company.edit', $company->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
            else
                $edit_data = '';
           
           
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
        $result = $this->company::find($id);
        return $result;
    }

    public function store($request)
    {
        
        $company = new $this->company();
        $company->name = $request->name;
        $company->logo = $request->logo;
        $company->invoice_logo = $request->invoice_logo;
        $company->favicon = $request->favicon;
        $company->website = $request->website;
        $company->phone = $request->phone;
        $company->email = $request->email;
        $company->address	 = $request->address	;
        $company->tax_identification_number = $request->tax_identification_number;
        $company->status = 'Approved';
        $company->updated_by = helper::userId();
        $company->company_id = helper::companyId();
        if($company->save()){
            $this->generalSetup($company->id);
            return true;
        }
       
        
    }

    public function update($request, $id)
    {
        $company = $this->company::findOrFail($id);
        $company->name = $request->company_name;
        if(!empty($request->file('logo'))):
          $company->logo = helper::upload($request->file('logo'),140,50,'logo');
        endif;
        if(!empty($request->file('invoice_logo'))):
          $company->invoice_logo = helper::upload($request->file('invoice_logo'),140,50,'invoice');
        endif;
        if(!empty($request->file('favicon'))):
          $company->favicon = helper::upload($request->file('favicon'),45,45,'favicon');
        endif;
        $company->website = $request->website;
        $company->phone = $request->phone;
        $company->email = $request->email;
        $company->address = $request->address	;
        $company->task_identification_number = $request->task_identification_number;
        $company->status = 'Approved';
        $company->updated_by = helper::userId();
        $company->company_id = helper::companyId();
        if($company->save()){
            $this->generalSetup($company->id);
            return true;
        }
    }

    public function generalSetup($companyid){
        $generalSetUp = new GeneralSetup();
        $generalSetUp->company_id =$companyid;
        $generalSetUp->general_table_id = rand(1, 10);
        $generalSetUp->currencie_id = rand(1,10);
        $generalSetUp->currency_position = 2;
        $generalSetUp->language_id = rand(1,10);
        $generalSetUp->timezone =  'America/New_York';
        $generalSetUp->dateformat = 1;
        $generalSetUp->is_store = 1;
        $generalSetUp->is_branch = 1;
        $generalSetUp->default_datatable_list_number = 10;
        $generalSetUp->transaction_edit_days = 10;
        $generalSetUp->decimal_separate = "-";
        $generalSetUp->thousand_separate = "-";
        $generalSetUp->discount_type = "%";
        $generalSetUp->voucher_length = 8;
        $generalSetUp->product_prefix = "PRID";
        $generalSetUp->supplier_prefix = "SUID";
        $generalSetUp->customer_prefix = "CUID";
        $generalSetUp->purchases_order_prefix = "POID";
        $generalSetUp->purchases_prefix = "PUID";
        $generalSetUp->purchases_requisition_prefix = "PRID";
        $generalSetUp->sales_prefix = "SAID";
        $generalSetUp->payment_voucher_prefix = 'PVID';
        $generalSetUp->receive_voucher_prefix = 'RVID';
        $generalSetUp->journal_voucher_prefix = 'JVID';
        $generalSetUp->purchases_mrr_prefix = 'PMID';
        $generalSetUp->transfer_prefix = 'TRID';
        $generalSetUp->invoice_approval = 1;
        $generalSetUp->account_approval = 1;
        $generalSetUp->updated_by = 1;
        $generalSetUp->created_by = 1;
        $generalSetUp->deleted_by = 1;
        // $generalSetUp->deleted_at = $faker->dateTime($unixTimestamp);
        $generalSetUp->save();
    }
}