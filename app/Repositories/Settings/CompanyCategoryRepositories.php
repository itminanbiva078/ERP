<?php

namespace App\Repositories\Settings;
use App\Helpers\Helper;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use App\Models\CompanyCategory;
use App\Models\CompanyResource;
use App\Models\FormInput;
use App\Models\GeneralSetup;
use App\Models\Navigation;
use App\Models\RoleAccess;
use App\Models\Store;
use App\Models\User;
use App\Models\UserRole;
use DB;
use Hash;

class CompanyCategoryRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var CompanyCategory
     */
    private $companyCategory;
    /**
     * CompanyCategoryRepositories constructor.
     * @param Vehicle $companyCategory
     */
    public function __construct(CompanyCategory $companyCategory)
    {
        $this->companyCategory = $companyCategory;
      
    }
    
    /**
     * @param $request
     * @return mixed
     */
    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('settings.companyCategory.edit') ? 1 : 0;
        $delete = Helper::roleAccess('settings.companyCategory.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->companyCategory::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $companyCategories = $this->companyCategory::select($columns)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->companyCategory::count();
        } else {
            $search = $request->input('search.value');
            $companyCategories = $this->companyCategory::select($columns)->where(function ($q) use ($columns,$search) {
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
            $totalFiltered = $this->companyCategory::select($columns)->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }

        $class=array(
            'badge badge-warning float-center badge-md display-1 text-capitalize',
            'badge badge-info float-center display-1 text-capitalize',
            'badge badge-default float-center display-1 text-capitalize',
            'badge badge-primary float-center display-1 text-capitalize',
            'badge badge-success float-center display-1 text-capitalize',
            'badge badge-danger float-center display-1 text-capitalize',
            'badge badge-secondary float-center display-1 text-capitalize',
            'badge badge-dark float-center display-1 text-capitalize',
            'badge badge-light float-center display-1 text-capitalize',
        );
        $number = 0;
        foreach($companyCategories as $key => $eachInfo): 
            $htmlText='';
            $allModule =   Navigation::select('label')->whereIn('id',explode(",",$eachInfo->module))->get();
            foreach($allModule as $key => $eachModule):
                $number++;
                if($number == 10):
                    $number=0;
                    $htmlText.='<span class="'.$class[rand(0,5)].'">'.$eachModule->label.'</span> &nbsp;&nbsp;&nbsp;';
                    $htmlText.='<br>';
                else:
                    $htmlText.='<span class="'.$class[rand(0,5)].'">'.$eachModule->label.'</span>&nbsp;&nbsp;&nbsp;';
                endif;
            endforeach;
            $eachInfo->module = $htmlText;
        endforeach;

        $columns = Helper::getTableProperty();
        $data = array();
        if ($companyCategories) {
            foreach ($companyCategories as $key => $companyCategory) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                        if ($companyCategory->status == 'Approved') :
                            $status = '<input class="status_row" status_route="' . route('settings.companyCategory.status', [$companyCategory->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                        else :
                            $status = '<input  class="status_row" status_route="' . route('settings.companyCategory.status', [$companyCategory->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                        endif;
                        $nestedData['status'] = $status;
                    elseif($value == 'is_branch'):

                            if($companyCategory->is_branch == 1){
                                $nestedData['is_branch'] = "Branch Enable";
                            }else{
                                $nestedData['is_branch'] = "Branch Disabled";
                            }

                    elseif($value == 'is_store'):

                        if($companyCategory->is_store == 1){
                            $nestedData['is_store'] = "Store Enable";
                        }else{
                            $nestedData['is_store'] = "Store Disabled";
                        }        

                    else:    
                        $nestedData[$value] = $companyCategory->$value;
                    endif;
        endforeach;


                if ($ced != 0) :
                    if ($edit != 0)
                        $edit_data = '<a href="' . route('settings.companyCategory.edit', $companyCategory->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    else
                        $edit_data = '';
                   
                    $nestedData['action'] = $edit_data;
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
        $result = $this->companyCategory::find($id);
        return $result;
    }
 /**
     * @param $request
     * @return mixed
     */
    public function getNavigation()
    {
        $result = Navigation::where('parent_id', 0)->get();
       
        $allMenuList = array();
        foreach ($result as $key => $each_parent):  
                $menuList['label'] = $each_parent->label;
                $menuList['sub_menu'] =  Navigation::where('parent_id', $each_parent->id)->where('show_status',1)->get();
                array_push($allMenuList, $menuList);
        endforeach;
        return $allMenuList;
    }

    public function store($request)
    {


        DB::beginTransaction();
        try {
            $moduel=array();
            $subModuel=array();
            foreach($request->module_details as $eachDetails):
            $detailsInfo = explode("-",$eachDetails);
            array_push($subModuel,$detailsInfo[0]);
            array_push($moduel,$detailsInfo[1]);
            endforeach;
            $companyCategory = new $this->companyCategory();
            $companyCategory->name = $request->name;
            $companyCategory->email = $request->email;
            $companyCategory->password = $request->password;
             if($request->is_branch == 'on')
                $companyCategory->is_branch =1;
                else 
                $companyCategory->is_branch =0;
             if($request->is_store == 'on')
                $companyCategory->is_store =1;
                else 
                $companyCategory->is_store =0;

            $companyCategory->module = implode(",",array_unique($moduel));
            $companyCategory->module_details = implode(",",$subModuel);
            $companyCategory->status = 'Approved';
            $companyCategory->created_by = helper::userId();
            $companyCategory->company_id = helper::companyId();
            $companyCategory->save();
            //company role create
            $roleInfo =  $this->companyRoleCreateOrUpdate($companyCategory,'create');
            //company resource
            $this->companyResourceCreateOrUpdate($companyCategory,'create');
            //company user 
            $this->companyUserCreateOrUpdate($companyCategory,$roleInfo->id,'create');
            //company general setup
            $this->companyGeneralSetupCreateOrUpdate($companyCategory,'create');
            //company default branch create
            $branch_id = $this->companyDefaultBranchCreate($companyCategory,'create');
            //company default store create
            $this->companyDefaultStoreCreate($companyCategory,$branch_id,'create');
            DB::commit();
            // all good
            return $companyCategory->id;
        } catch (\Exception $e) {
            DB::rollback();
  
            return $e->getMessage();
        }

    }


    public function companyDefaultBranchCreate($companyCategory,$mode){

        if(!empty($companyCategory)){

            $branch = new Branch();
            $branch->name = $companyCategory->name;
            $branch->email = $companyCategory->email;
            $branch->phone = '01710000000';
            $branch->address = 'Default Address';
            $branch->status = 'Approved';
            $branch->is_default = 'Yes';
            $branch->created_by = helper::userId();
            $branch->company_id =$companyCategory->id;
            $branch->save();
            return $branch->id;

        }
    }
    public function companyDefaultStoreCreate($companyCategory,$branch_id,$mode){

        if(!empty($companyCategory)){

            $store = new Store();
            $store->branch_id = $branch_id;
            $store->name = $companyCategory->name;
            $store->email = $companyCategory->email;
            $store->phone ="01710000000";
            $store->address = "Default Store";
            $store->is_default = "Yes";
            $store->status = 'Approved';
            $store->created_by = helper::userId();
            $store->company_id = $companyCategory->id;
            $store->save();
            return $store;
        }
    }


    public function companyResourceCreateOrUpdate($companyCategory,$mode){


        if($companyCategory){
            $allModules = explode(",",$companyCategory->module_details);
            CompanyResource::where('company_category_id',$companyCategory->id)->delete();
            foreach($allModules as $key => $value):
                $formResource =  FormInput::where('navigation_id',$value)->first();
                if(!empty($formResource)):
                    $companyResouce =  new CompanyResource();
                    $companyResouce->company_category_id =$companyCategory->id;
                    $companyResouce->navigation_id =$value;
                    $companyResouce->form_input =$formResource->input ?? '';
                    $companyResouce->table =$formResource->table ?? '';
                    $companyResouce->save();
                endif;
            endforeach;
       }

       return  $companyResouce;


    }

    public function companyRoleCreateOrUpdate($companyCategory,$mode){

        $childInfo = array();
        $subModuel = explode(",",$companyCategory->module_details);
        foreach ($subModuel as $key => $value) :
            $child_List = $this->getAllChild($value);
            foreach($child_List as $key => $eachChild):
                array_push($childInfo, $eachChild->id);
            endforeach;
        endforeach;
        if($mode == 'create'):
            $userRole =  new UserRole();
        else:
            $userRole = UserRole::where('company_id',$companyCategory->id)->first();
        endif;
        $userRole->name = $companyCategory->name;
        $userRole->parent_id =$companyCategory->module_details;
        $userRole->navigation_id = implode(",", $childInfo);
        $userRole->company_id = $companyCategory->id;
        $userRole->status = 'Approved';
        $userRole->created_by = Auth::user()->id;
        $userRole->save();
        return $userRole;
    }



    public function companyGeneralSetupCreateOrUpdate($companyCategories,$mode){

        if($mode == 'create'):
            $generalSetUp =  new GeneralSetup();
        else:
            $generalSetUp = GeneralSetup::where('company_id',$companyCategories->id)->first();
        endif;
        $generalSetUp->company_id =$companyCategories->id;
        $generalSetUp->general_table_id = rand(1, 10);
        $generalSetUp->currencie_id = rand(1, 10);
        $generalSetUp->currency_position = "Left";
        $generalSetUp->language_id = rand(1, 10);
        $generalSetUp->input_display_type = 'Horizontal';
        $generalSetUp->stock_account_method = 'Lifo';
        $generalSetUp->timezone ="Asia/Dhaka";// $faker->timezone();
        $generalSetUp->dateformat = "YYYY-MM-DD";
        $generalSetUp->price_calculate_type = 'Round';
        $generalSetUp->is_store = 1;
        $generalSetUp->is_branch = "Single Branch";
        $generalSetUp->default_datatable_list_number = 10;
        $generalSetUp->transaction_edit_days = 10;
        $generalSetUp->decimal_separate = "-";
        $generalSetUp->thousand_separate = "-";
        $generalSetUp->discount_type = "%";
        $generalSetUp->voucher_length = 8;
        $generalSetUp->product_prefix = "PRID";
        $generalSetUp->account_prefix = "ACID";
        $generalSetUp->service_prefix = "SEID";
        $generalSetUp->supplier_prefix = "SUID";
        $generalSetUp->customer_prefix = "CUID";
        $generalSetUp->delivery_challan = 'Yes';
        $generalSetUp->delivery_challans_prefix = "DCID";
        $generalSetUp->purchases_order_prefix = "POID";
        $generalSetUp->purchases_prefix = "PUID";
        $generalSetUp->purchases_requisition_prefix = "PRID";
        $generalSetUp->sales_prefix = "SAID";
        $generalSetUp->sales_payment_prefix = "SAIP";
        $generalSetUp->service_invoice_prefix = "SIID";
        $generalSetUp->purchases_payment_prefix = "PAID";
        $generalSetUp->service_quatation_prefix = "SQID";
        $generalSetUp->sales_quatation_prefix = "SQID";
        $generalSetUp->payment_voucher_prefix = 'PVID';
        $generalSetUp->receive_voucher_prefix = 'RVID';
        $generalSetUp->journal_voucher_prefix = 'JVID';
        $generalSetUp->purchases_mrr = 'Yes';
        $generalSetUp->purchases_mrr_prefix = 'PMID';
        $generalSetUp->transfer_prefix = 'TRID';
        $generalSetUp->transfer_prefix = 'TRID';
        $generalSetUp->sales_approval = 'Auto Approval';
        $generalSetUp->invoice_approval = 'Auto Approbal';
        $generalSetUp->account_approval = 'Auto Approbal';
        $generalSetUp->challan_approval = 'Auto Approbal';
        $generalSetUp->inventory_approval = 'Auto Approbal';
        $generalSetUp->head_prefix = 'ACID';
        $generalSetUp->mrr_approval = 'Auto Approval';
        $generalSetUp->sales_loan_return_prefix =  'SLRID';
        $generalSetUp->pos_prefix =  'POSID';
        $generalSetUp->sales_pending_cheque_prefix =  'SEID';
        $generalSetUp->purchases_pending_cheque_prefix =  'PEID';
        $generalSetUp->customer_opening_prefix =  'COID';
        $generalSetUp->supplier_opening_prefix =  'SOID';
        $generalSetUp->inventory_opening_prefix =  'IOID';
        $generalSetUp->purchases_sms =  'No';
        $generalSetUp->purchases_email =  'No';
        $generalSetUp->purchases_download =  'No';
        $generalSetUp->sales_sms =  'No';
        $generalSetUp->sales_email =  'No';
        $generalSetUp->sales_download =  'No';
        $generalSetUp->account_sms =  'No';
        $generalSetUp->account_email =  'No';
        $generalSetUp->account_download =  'No';
        $generalSetUp->service_download =  'No';
        $generalSetUp->service_sms =  'No';
        $generalSetUp->service_email =  'No';
        $generalSetUp->updated_by = 1;
        $generalSetUp->created_by = 1;
        $generalSetUp->deleted_by = 1;
        $generalSetUp->save();
    
    }


    public function companyUserCreateOrUpdate($companyCategory,$roleId,$mode){

        if($mode == 'create'):
          $user = new User();
        else: 
          $user = User::where('company_id',$companyCategory->id)->first();
        endif;
        $user->company_id   = $companyCategory->id;
        $user->name         = $companyCategory->name;
        $user->email        = $companyCategory->email;
        $user->password     = Hash::make($companyCategory->password);
        $user->phone        = '0171000000'.$roleId;
        $user->role_id      = $roleId;
        $user->status       = 'Approved';
        $user->created_by   = Auth::user()->id;
        $user->save();
        if($user):
            if($mode == 'create'):
                $roleAccess = new RoleAccess();
                $roleAccess->user_id = $user->id;
                $roleAccess->role_id = $roleId;
                $roleAccess->company_id =$companyCategory->id;
                $roleAccess->save();
            endif;
        endif;
        return $user;


    }

    public function getAllChild($parent_id){
       $allChild =  Navigation::select('id')->where('parent_id',$parent_id)->get();
       return $allChild;
      
    }

    public function update($request, $id)
    {

        DB::beginTransaction();
            try {
                $moduel=array();
                $subModuel=array();
                foreach($request->module_details as $eachDetails):
                $detailsInfo = explode("-",$eachDetails);
                array_push($subModuel,$detailsInfo[0]);
                array_push($moduel,$detailsInfo[1]);
                endforeach;

                $companyCategory = $this->companyCategory::find($id);               
                $companyCategory->name = $request->name;
                $companyCategory->email = $request->email;
                $companyCategory->password = $request->password;
                    if($request->is_branch == 'on')
                    $companyCategory->is_branch =1;
                    else 
                    $companyCategory->is_branch =0;
                    if($request->is_store == 'on')
                    $companyCategory->is_store =1;
                    else 
                    $companyCategory->is_store =0;
                $companyCategory->module = implode(",",array_unique($moduel));
                $companyCategory->module_details = implode(",",$subModuel);
              
                $companyCategory->status = 'Approved';
                $companyCategory->updated_by = Auth::user()->id;
                if($companyCategory->save()){
                    //company role create
                $roleInfo =  $this->companyRoleCreateOrUpdate($companyCategory,'update');
                //company resource
                $this->companyResourceCreateOrUpdate($companyCategory,'update');
                //company user 
                $this->companyUserCreateOrUpdate($companyCategory,$roleInfo->id,'update');
                //company general setup
                $this->companyGeneralSetupCreateOrUpdate($companyCategory,'update');             
                }

            DB::commit();
            // all good
            return $companyCategory->id;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }

    }

    public function statusUpdate($id, $status)
    {
        $companyCategory = $this->companyCategory::find($id);
        $companyCategory->status = $status;
        $companyCategory->save();
        return $companyCategory;
    }

    public function destroy($id)
    {
        $companyCategory = $this->companyCategory::find($id);
        $companyCategory->delete();
        return true;
    }
}