<?php

namespace App\Repositories\Settings;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\GeneralSetup;
use App\Models\Navigation;
use phpDocumentor\Reflection\PseudoTypes\False_;

class GeneralSettingRepository
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var GeneralSetup
     */
    private $generalSetup;
    /**
     * GeneralSettingRepository constructor.
     * @param generalSetup $generalSetup
     */
    public function __construct(GeneralSetup $generalSetup)
    {
        $this->generalSetup = $generalSetup;
       
    }
 /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('settings.generalSetup.edit') ? 1 : 0;
        $delete = Helper::roleAccess('settings.generalSetup.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->generalSetup::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $generalSetups = $this->generalSetup::select($columns)->with('language','currencie','company')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->generalSetup::count();
        } else {
            $search = $request->input('search.value');
            $generalSetups = $this->generalSetup::select($columns)->with('language','currencie','company')->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->generalSetup::select($columns)->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }

        foreach($generalSetups as $key => $value):
            
            if(!empty($value->language_id))
               $value->language_id = $value->language->name ?? '';

            if(!empty($value->currencie_id))
               $value->currencie_id  = $value->currencie->name ?? '';

            if(!empty($value->company_id))
               $value->company_id  = $value->company->name ?? '';
        endforeach;

        $columns = Helper::getTableProperty();
      
        $data = array();
        if ($generalSetups) {
            foreach ($generalSetups as $key => $generalSetup) {
                $nestedData['id'] = $key + 1;
                if ($ced != 0) :
                    if ($edit != 0)
                    $edit_data = '<a href="' . route('settings.generalSetup.edit', $generalSetup->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    else
                        $edit_data = '';
                   
                    $nestedData['action'] = $edit_data ;
                else :
                    $nestedData['action'] = '';
                endif;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                        if ($generalSetup->status == 'Approved') :
                            $status = '<input class="status_row" status_route="' . route('settings.generalSetup.status', [$generalSetup->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                        else :
                            $status = '<input  class="status_row" status_route="' . route('settings.generalSetup.status', [$generalSetup->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                        endif;
                        $nestedData['status'] = $status;
                    else:
                        $nestedData[$value] = $generalSetup->$value;
                    endif;
                endforeach;
                
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
        $result = $this->generalSetup::find($id);
        return $result;
    }

    public function store($request)
    {
        $generalSetup = new $this->generalSetup();
        $generalSetup->general_table_id = $request->general_table_id;
        $generalSetup->currencie_id = $request->currencie_id;
        $generalSetup->language_id = $request->language_id;
        $generalSetup->currency_position = $request->currency_position;
        $generalSetup->timezone = $request->timezone;
        $generalSetup->dateformat = $request->dateformat;
        $generalSetup->decimal_separate = $request->decimal_separate;
        $generalSetup->thousand_separate = $request->thousand_separate;
        $generalSetup->discount_type = $request->discount_type;
        $generalSetup->default_datatable_list_number = $request->default_datatable_list_number;
        $generalSetup->transaction_edit_days = $request->transaction_edit_days;
        $generalSetup->is_branch = $request->is_branch;
        $generalSetup->is_store = $request->is_store;
        $generalSetup->price_calculate_type = $request->price_calculate_type;
        $generalSetup->voucher_length = $request->voucher_length;
        $generalSetup->product_prefix = $request->product_prefix;
        $generalSetup->supplier_prefix = $request->supplier_prefix;
        $generalSetup->customer_prefix = $request->customer_prefix;
        $generalSetup->purchases_order_prefix = $request->purchases_order_prefix;
        $generalSetup->purchases_requisition_prefix = $request->purchases_requisition_prefix;
        $generalSetup->purchases_prefix = $request->purchases_prefix;
        $generalSetup->sales_prefix = $request->sales_prefix;
        $generalSetup->delivery_challans_prefix = $request->delivery_challans_prefix;
        $generalSetup->payment_voucher_prefix = $request->payment_voucher_prefix;
        $generalSetup->receive_voucher_prefix = $request->receive_voucher_prefix;
        $generalSetup->journal_voucher_prefix = $request->journal_voucher_prefix;
        $generalSetup->contra_voucher_prefix = $request->contra_voucher_prefix;
        $generalSetup->invoice_approval = $request->invoice_approval;
        $generalSetup->account_approval = $request->account_approval;
        $generalSetup->deposit_account_id = $request->deposit_account_id;
        $generalSetup->inventory_adjust_approval = $request->inventory_adjust_approval;
        $generalSetup->inventory_adjust_prefix = $request->inventory_adjust_prefix;
        $generalSetup->status = 'Approved';
        $generalSetup->updated_by = helper::userId();
        $generalSetup->company_id = helper::companyId();
        $generalSetup->save();
        return $generalSetup;
    }

    public function update($request, $id)

    { 

        if($request->form_name == "general"): 

            $generalSetup = $this->generalSetup::findOrFail($id);
            $generalSetup->company_id = helper::companyId();
             //branch 
             if(!empty($request->is_branch) && $request->is_branch != 'No'):
                $generalSetup->is_branch =$request->is_branch;
                $this->updateNavigationTable('branches',1);
            else: 
                $generalSetup->is_branch =0;
                $this->updateNavigationTable('branches',null);
                $this->updateNavigationTable('stores',null);
            endif;

            if(!empty($request->is_store) && !empty($request->is_branch) && $request->is_branch != 'No'):
                $generalSetup->is_store =1;// $request->is_store;
                $this->updateNavigationTable('stores',1);
                $this->updateNavigationTable('branches',1);
            else: 
                $generalSetup->is_store =0;
                $this->updateNavigationTable('stores',null);
            endif;


            if(!empty($request->general_table_id)):
                $generalSetup->general_table_id = $request->general_table_id;
            endif;
    
    
            if(!empty($request->input_display_type)):
                $generalSetup->input_display_type = $request->input_display_type;
            endif;
    
            if(!empty($request->stock_account_method)):
                $generalSetup->stock_account_method = $request->stock_account_method;
            endif;
    
            if(!empty($request->currencie_id)):
                $generalSetup->currencie_id = $request->currencie_id;
            endif;
    
            if(!empty($request->language_id)):
                $generalSetup->language_id = $request->language_id;
            endif;
    
            if(!empty($request->currency_position)):
                $generalSetup->currency_position = $request->currency_position;
            endif;
    
            if(!empty($request->timezone)):
                $generalSetup->timezone = $request->timezone;
            endif;
    
            if(!empty($request->dateformat)):
                $generalSetup->dateformat = $request->dateformat;
            endif;
    
    
            if(!empty($request->decimal_separate)):
                $generalSetup->decimal_separate = $request->decimal_separate;
            endif;
    
            if(!empty($request->price_calculate_type)):
                $generalSetup->price_calculate_type = $request->price_calculate_type;
            endif;
    
            if(!empty($request->thousand_separate)):
                $generalSetup->thousand_separate = $request->thousand_separate;
            endif;
    
            if(!empty($request->discount_type)):
                $generalSetup->discount_type = $request->discount_type;
            endif;

            if(!empty($request->default_datatable_list_number)):
                $generalSetup->default_datatable_list_number = $request->default_datatable_list_number;
            endif;

            if(!empty($request->transaction_edit_days)):
                $generalSetup->transaction_edit_days = $request->transaction_edit_days;
            endif;
            if(!empty($request->voucher_length)):
                $generalSetup->voucher_length = $request->voucher_length;
            endif;
            $generalSetup->status = 'Approved';
            $generalSetup->updated_by = Auth::user()->id;
            $generalSetup->company_id = Auth::user()->company_id;
            $generalSetup->save();


        elseif($request->form_name == "purchases"):

            $generalSetup = $this->generalSetup::findOrFail($id);
            $generalSetup->company_id = helper::companyId();

            if(!empty($request->product_prefix)):
                $generalSetup->product_prefix = $request->product_prefix;
            endif;
            //purchase mrr
            if(!empty($request->purchases_mrr)):
                $generalSetup->purchases_mrr =$request->purchases_mrr;
                $generalSetup->mrr_approval =$request->mrr_approval;
                $this->updateNavigationTable('purchases_mrrs',1);
            else: 
                $generalSetup->purchases_mrr ='';
                $generalSetup->mrr_approval ='';
                $this->updateNavigationTable('purchases_mrrs',null);
                //$this->updateNavigationTable('purchases_mrrs',null);
            endif;

            if(!empty($request->purchases_sms)):
                $generalSetup->purchases_sms = $request->purchases_sms;
            endif;
            if(!empty($request->purchases_email)):
                $generalSetup->purchases_email = $request->purchases_email;
            endif;
            if(!empty($request->purchases_download)):
                $generalSetup->purchases_download = $request->purchases_download;
            endif;
           
            if(!empty($request->supplier_prefix)):
                $generalSetup->supplier_prefix = $request->supplier_prefix;
            endif;
            
            if(!empty($request->purchases_pending_cheque_prefix)):
                $generalSetup->purchases_pending_cheque_prefix = $request->purchases_pending_cheque_prefix;
            endif;
            if(!empty($request->purchases_payment_prefix)):
                $generalSetup->purchases_payment_prefix = $request->purchases_payment_prefix;
            endif;
            
            if(!empty($request->purchases_order_prefix)):
                $generalSetup->purchases_order_prefix = $request->purchases_order_prefix;
            endif;

            

            if(!empty($request->purchases_requisition_prefix)):
                $generalSetup->purchases_requisition_prefix = $request->purchases_requisition_prefix;
            endif;
            if(!empty($request->purchases_prefix)):
                $generalSetup->purchases_prefix = $request->purchases_prefix;
            endif;
            
            if(!empty($request->inventory_approval)):
                $generalSetup->inventory_approval = $request->inventory_approval;
            endif;
            if(!empty($request->purchases_return_approval)):
                $generalSetup->purchases_return_approval = $request->purchases_return_approval;
            endif;

            $generalSetup->status = 'Approved';
            $generalSetup->updated_by = Auth::user()->id;
            $generalSetup->company_id = Auth::user()->company_id;
            $generalSetup->save();


        elseif($request->form_name == "sales"):

            $generalSetup = $this->generalSetup::findOrFail($id);

            if(!empty($request->customer_prefix)):
                $generalSetup->customer_prefix = $request->customer_prefix;
            endif;   
            if(!empty($request->sales_approval)):
                $generalSetup->sales_approval = $request->sales_approval;
            endif;

            if(!empty($request->sales_prefix)):
                $generalSetup->sales_prefix = $request->sales_prefix;
            endif;

            if(!empty($request->delivery_challans_prefix)):
                $generalSetup->delivery_challans_prefix = $request->delivery_challans_prefix;
            endif;
        
            if(!empty($request->sales_quatation_prefix)):
                $generalSetup->sales_quatation_prefix = $request->sales_quatation_prefix;
            endif;

            if(!empty($request->sales_pending_cheque_prefix)):
                $generalSetup->sales_pending_cheque_prefix = $request->sales_pending_cheque_prefix;
            endif;

            if(!empty($request->sales_payment_prefix)):
                $generalSetup->sales_payment_prefix = $request->sales_payment_prefix;
            endif;


              //delivery challan 
             if(!empty($request->delivery_challan)):
                $generalSetup->delivery_challan =$request->delivery_challan;
                $generalSetup->challan_approval =$request->challan_approval;
                $this->updateNavigationTable('delivery_challans',1);
            else: 
                $generalSetup->delivery_challan ='';
                $generalSetup->challan_approval ='';
                $this->updateNavigationTable('delivery_challans',null);
                //$this->updateNavigationTable('delivery_challans',null);
            endif;

            if(!empty($request->sales_return_approval)):
                $generalSetup->sales_return_approval = $request->sales_return_approval;
            endif;
            if(!empty($request->delivery_challan)):
                $generalSetup->delivery_challan = $request->delivery_challan;
            endif;

            if(!empty($request->sales_sms)):
                $generalSetup->sales_sms = $request->sales_sms;
            endif;
            if(!empty($request->sales_email)):
                $generalSetup->sales_email = $request->sales_email;
            endif;
            if(!empty($request->sales_download)):
                $generalSetup->sales_download = $request->sales_download;
            endif;

        $generalSetup->status = 'Approved';
        $generalSetup->updated_by = Auth::user()->id;
        $generalSetup->company_id = Auth::user()->company_id;
        $generalSetup->save();


        elseif($request->form_name == "inventory_Adjustment"):
           

            $generalSetup = $this->generalSetup::findOrFail($id);
            if(!empty($request->inventory_adjust_approval)):
                $generalSetup->inventory_adjust_approval = $request->inventory_adjust_approval;
            endif;
            if(!empty($request->inventory_adjust_prefix)):
                $generalSetup->inventory_adjust_prefix = $request->inventory_adjust_prefix;
            endif;
            $generalSetup->status = 'Approved';
            $generalSetup->updated_by = helper::userId();
            $generalSetup->company_id = helper::companyId();
            $generalSetup->save();

        elseif($request->form_name == "account"):

            $generalSetup = $this->generalSetup::findOrFail($id);

            if(!empty($request->account_sms)):
                $generalSetup->account_sms = $request->account_sms;
            endif;
            if(!empty($request->account_email)):
                $generalSetup->account_email = $request->account_email;
            endif;
            if(!empty($request->account_download)):
                $generalSetup->account_download = $request->account_download;
            endif;
            if(!empty($request->payment_voucher_prefix)):
                $generalSetup->payment_voucher_prefix = $request->payment_voucher_prefix;
            endif;
            if(!empty($request->head_prefix)):
                $generalSetup->head_prefix = $request->head_prefix;
            endif;
            if(!empty($request->receive_voucher_prefix)):
                $generalSetup->receive_voucher_prefix = $request->receive_voucher_prefix;
            endif;
            if(!empty($request->journal_voucher_prefix)):
                $generalSetup->journal_voucher_prefix = $request->journal_voucher_prefix;
            endif;
            if(!empty($request->account_approval)):
                $generalSetup->account_approval = $request->account_approval;
            endif;
            if(!empty($request->contra_voucher_prefix)):
                $generalSetup->contra_voucher_prefix = $request->contra_voucher_prefix;
            endif;

            $generalSetup->status = 'Approved';
            $generalSetup->updated_by = Auth::user()->id;
            $generalSetup->company_id = Auth::user()->company_id;
            $generalSetup->save();


        elseif($request->form_name == "service"):
            $generalSetup = $this->generalSetup::findOrFail($id);


            if(!empty($request->service_sms)):
                $generalSetup->service_sms = $request->service_sms;
            endif;
            if(!empty($request->service_email)):
                $generalSetup->service_email = $request->service_email;
            endif;
            if(!empty($request->service_download)):
                $generalSetup->service_download = $request->service_download;
            endif;
            if(!empty($request->service_prefix)):
                $generalSetup->service_prefix = $request->service_prefix;
            endif;
            if(!empty($request->service_invoice_prefix)):
                $generalSetup->service_invoice_prefix = $request->service_invoice_prefix;
            endif;
            if(!empty($request->service_quatation_prefix)):
                $generalSetup->service_quatation_prefix = $request->service_quatation_prefix;
            endif;
            if(!empty($request->service_invoice_approbal)):
                $generalSetup->service_invoice_approbal = $request->service_invoice_approbal;
            endif;

            $generalSetup->status = 'Approved';
            $generalSetup->updated_by = Auth::user()->id;
            $generalSetup->company_id = Auth::user()->company_id;
            $generalSetup->save();

            elseif($request->form_name == "opening"):
                $generalSetup = $this->generalSetup::findOrFail($id);
    
    
                if(!empty($request->customer_opening_prefix)):
                    $generalSetup->customer_opening_prefix = $request->customer_opening_prefix;
                endif;

                if(!empty($request->supplier_opening_prefix)):
                    $generalSetup->supplier_opening_prefix = $request->supplier_opening_prefix;
                endif;

                if(!empty($request->inventory_opening_prefix)):
                    $generalSetup->inventory_opening_prefix = $request->inventory_opening_prefix;
                endif;
              
                $generalSetup->status = 'Approved';
                $generalSetup->updated_by = Auth::user()->id;
                $generalSetup->company_id = Auth::user()->company_id;
                $generalSetup->save();
            elseif($request->form_name == "pos"):

                $generalSetup = $this->generalSetup::findOrFail($id);
                if(!empty($request->deposit_account_id)):
                    $generalSetup->deposit_account_id = $request->deposit_account_id;
                endif;

                if(!empty($request->pos_approval)):
                    $generalSetup->pos_approval = $request->pos_approval;
                endif;
                $generalSetup->status = 'Approved';
                $generalSetup->updated_by = Auth::user()->id;
                $generalSetup->company_id = Auth::user()->company_id;
                $generalSetup->save();

              

        endif;
        session()->flash('success', 'Data successfully updated!!');
        return redirect()->back();

    }
  

    public function updateNavigationTable($table,$value){
        $affected = Navigation::where('table',$table)->first();
        $affected->active = $value;
        $affected->save();
              if($affected)
                return true;
    }

    public function statusUpdate($id, $status)
    {
        $generalSetup = $this->generalSetup::find($id);
        $generalSetup->status = $status;
        $generalSetup->save();
        return $generalSetup;
    }

    public function destroy($id)
    {
        $generalSetup = $this->generalSetup::find($id);
        $generalSetup->delete();
        return true;
    }
}