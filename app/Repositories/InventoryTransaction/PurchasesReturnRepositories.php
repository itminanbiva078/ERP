<?php

namespace App\Repositories\InventoryTransaction;

use App\Helpers\Helper;
use App\Models\General;
use App\Models\GeneralLedger;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchasesDetails;
use App\Models\Purchases;
use App\Models\PurchasesMrrDetails;
use App\Models\PurchasesPayment;
use App\Models\Stock;
use App\Models\StockSummary;
use App\Models\PurchasesReturn;
use App\Models\PurchasesReturnDetail;
use DB;

class PurchasesReturnRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var PurchasesReturn
     */
    private $purchasesReturn;
    /**
     * PurchasesReturnRepositories constructor.
     * @param PurchasesReturn $purchasesReturn
     */
    public function __construct(PurchasesReturn $purchasesReturn)
    {
        $this->purchasesReturn = $purchasesReturn;
      
    }

    /**
     * @param $request
     * @return mixed
     */
    
    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('inventoryTransaction.purchasesReturn.edit') ? 1 : 0;
        $delete = Helper::roleAccess('inventoryTransaction.purchasesReturn.destroy') ? 1 : 0;
        $show = Helper::roleAccess('inventoryTransaction.purchasesReturn.show') ? 1 : 0;
        $ced = $edit + $delete + $show;

        $totalData = $this->purchasesReturn::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $purchasesReturns = $this->purchasesReturn::select($columns)->company()->with('supplier','branch')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->purchasesReturn::count();
        
        } else {
            $search = $request->input('search.value');
            $purchasesReturns = $this->purchasesReturn::select($columns)->company()->with('supplier','branch')->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->purchasesReturn::select($columns)->company()->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }

        foreach($purchasesReturns as $key => $value):
            if(!empty($value->supplier_id))
               $value->supplier_id = $value->supplier->name ?? '';

            if(!empty($value->branch_id))
               $value->branch_id  = $value->branch->name ?? '';
        endforeach;

        $columns = Helper::getQueryProperty();
        $data = array();
        if ($purchasesReturns) {
            foreach ($purchasesReturns as $key => $purchases) {
                $nestedData['id'] = $key + 1;
               
                if ($ced != 0) :
                    if ($edit != 0)
                        if($purchases->$value == 'Pending'):
                        $edit_data = '<a href="' . route('inventoryTransaction.purchasesReturn.edit', $purchases->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                        else: 
                            $edit_data = '';
                        endif;
                        else
                        $edit_data = '';
                        $show_data = '<a href="' . route('inventoryTransaction.purchasesReturn.show', $purchases->id) . '" show_id="' . $purchases->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $purchases->id . '"><i class="fa fa-search-plus"></i></a>';                               
                    if ($delete != 0)
                    if($purchases->$value == 'Pending'):
                        $delete_data = '<a delete_route="' . route('inventoryTransaction.purchasesReturn.destroy', $purchases->id) . '" delete_id="' . $purchases->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $purchases->id . '"><i class="fa fa-times"></i></a>';
                    else: 
                        $delete_data = '';
                    endif;
                    else
                        $delete_data = '';
                    $nestedData['action'] = $edit_data . ' ' . $delete_data . ' ' .$show_data;
                else :
                    $nestedData['action'] = '';
                endif;
                foreach ($columns as $key => $value) :
                    if ($value == 'status') :
                        $nestedData['status'] = helper::statusBar($purchases->status);
                        elseif($value == 'voucher_no'):
                            $nestedData[$value] = '<a target="_blank" href="' . route('inventoryTransaction.purchasesReturn.show', $purchases->id) . '" show_id="' . $purchases->id . '" title="Details" class="">'.$purchases->voucher_no.'</a>';
                    else :
                        $nestedData[$value] = $purchases->$value;
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
        $result = Purchases::select("*")->with([
            'purchasesDetails' => function($q){
              $q->select('id','purchases_id','branch_id','date','pack_size','pack_no','discount','quantity','approved_quantity','return_quantity','unit_price','total_price','company_id','product_id');
          },'purchasesDetails.product' => function($q){
            $q->select('id','code','name','category_id','status','brand_id','company_id');
        },'supplier' => function($q){
            $q->select('id','code','contact_person','branch_id','name','email','phone','address');
        },'branch' => function($q){
            $q->select('id','name','email','phone','address');
        }])->company()->where('id', $id)->first();
          return $result;
      
    }

    /**
     * @param $request
     * @return mixed
     */
    public function invoiceDetails($id)
    {
        $result = PurchasesReturn::select("*")->with([
            'preturnDetails' => function($q){
              $q->select('id','preturn_id','branch_id','date','pack_size','pack_no','deduction_percent','quantity','unit_price','total_price','company_id','product_id','deduction_amount');
          },'preturnDetails.product' => function($q){
            $q->select('id','code','name','category_id','status','brand_id','company_id');
        },'supplier' => function($q){
            $q->select('id','code','contact_person','branch_id','name','email','phone','address');
        },'branch' => function($q){
            $q->select('id','name','email','phone','address');
        },'general' => function ($q) {
            $q->select('id', 'date', 'voucher_id', 'branch_id', 'form_id', 'debit', 'credit', 'note');
        }, 'general.journals' => function ($q) {
            $q->select('id', 'general_id', 'form_id', 'account_id', 'date', 'debit', 'credit');
        }, 'general.journals.account' => function ($q) {
            $q->select('id', 'company_id', 'branch_id', 'parent_id', 'account_code', 'name', 'is_posted');
        },'createdBy' => function ($q) {
            $q->select('id','name');
        },'updatedBy' => function ($q) {
            $q->select('id','name');
        }
        ])->company()->where('id', $id)->first();
          return $result;

    }

    /**
     * @param $request
     * @return mixed
     */
    public function purchasesList($search)
    {

        $result = Purchases::select("id","voucher_no")->with('supplier')
        ->where('voucher_no', 'like', '%' .$search . '%')
        ->orWhereHas('supplier', function($q) use($search) {
            $q->where('name', 'like', '%' .$search . '%')
            ->orWhere('phone', 'like', '%' .$search . '%')
            ->orWhere('email', 'like', '%' .$search . '%');
        })->company()
       
        ->company()
        ->limit(5)
        ->get();
        $response = array();
        foreach($result as $key =>  $eachVoucher){
           $response[] = array("value"=>$eachVoucher->id,"label"=>$eachVoucher->voucher_no);
        }
          return $response;
    }


    /**
     * @param $request
     * @return mixed
     */
    public function purchasesDetails($purchasesId)
    {
        $purchasesInfo = Purchases::with('purchasesDetails')->where('id', $purchasesId)->get();
        return $purchasesInfo;
    }


   
    public function store($request)
    {

        DB::beginTransaction();
        try {
                $purchasessInfo =  $this->details($request->purchases_id);

                $poMaster =  new $this->purchasesReturn();
                $poMaster->date = helper::mysql_date();
                $poMaster->payment_type  = $request->payment_type;
                $poMaster->purchases_id  = $request->purchases_id;
                $poMaster->supplier_id   = $purchasessInfo->supplier_id;
                $poMaster->branch_id  = $purchasessInfo->branch_id;

                if(!empty($request->account_id)):
                    $poMaster->account_id  = $request->account_id[0];
                endif;

                $poMaster->store_id  = $purchasessInfo->store_id;
                $poMaster->voucher_no  = $purchasessInfo->voucher_no;
                $poMaster->subtotal  = $request->sub_total;
                $poMaster->documents  = $request->documents;
                $poMaster->total_qty  = array_sum($request->return_quantity);
                $poMaster->deduction_amount  = $request->deduction_amount;
                $poMaster->deduction_percen  = array_sum($request->deduction);
                $poMaster->grand_total  = $request->grand_total;
                $poMaster->paid_amount  = $request->paid_amount;
                $poMaster->due_amount  = $request->grand_total;
                $poMaster->note  = $request->note;
                $poMaster->status  = 'Pending';
                $poMaster->created_by = Auth::user()->id;
                $poMaster->company_id = Auth::user()->company_id;
                $poMaster->save();
                if($poMaster->id){
                    $this->masterDetails($poMaster->id,$request);
                    if(helper::isPurchasesReturnApprovalAuto()):
                        //save supplier ledger 
                        $this->purchasesReturnCreditPayment($poMaster->id,$request->grand_total);
                        //general table data save
                        $general_id = $this->generalSave($poMaster->id,$request);
                        //purchases return Journal
                        $this->purchasesReturnJournal($general_id,$request);
                        //purchases payment journal  
                        
                        // if payment type cash    
                    if($request->payment_type == "Cash"):
            
                       $this->purchasesReturnCashPayment($poMaster->id,$request->paid_amount);
                       $this->purchasesReturnPaymentJournal($general_id,$request->paid_amount,$request->date);
                        // if payment type cash
                    endif;

                    if($request->payment_type == "Bank"):
                        //if bank
                        $this->purchasesReturnPaymentJournal($general_id,$request);
                    endif;
                    
                          //main stock table data save
                          $this->stockSave($general_id,$poMaster->id,$request->purchases_id);
                          //stock cashing table data save
                          $this->stockSummarySave($poMaster->id,$request->purchases_id);

                        $poMaster->status  = 'Approved';
                        $poMaster->save();
                    endif;             
            }
            DB::commit();
            // all good
            return $poMaster->id ;
        } catch (\Exception $e) {
       
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function approved($id, $request)
    {   

        DB::beginTransaction();
        try {

            $request->merge(['date' => $request->date_picker]);
            $status = $request->status;
            $poMaster = $this->purchasesReturn::find($id);
            if($status == 'Approved'): 
                $this->purchasesReturnCreditPayment($poMaster->id,$request->grand_total);
                //general table data save
                $general_id = $this->generalSave($poMaster->id,$request);
                //purchases return Journal
                $this->purchasesReturnJournal($general_id,$request);
                //purchases payment journal 
                       
                $this->purchasesReturnPaymentJournal($general_id,$request);
                $this->purchasesReturnPaymentJournal($general_id,$request);
                //main stock table data save
               
                //if bank
                //data process for bank
                $this->stockSave($general_id,$poMaster->id,$request->purchases_id);
                //stock cashing table data save
                $this->stockSummarySave($poMaster->id,$request->purchases_id);
                // die('ok'); 
                $poMaster->status = $request->status;
                $poMaster->approved_by = helper::userId();
                $poMaster->save();
            else: 
                $poMaster->status = $request->status;
                $poMaster->approved_by = helper::userId();
                $poMaster->save();
            endif;
        DB::commit();
        // all good
        return $poMaster->id;
    } catch (\Exception $e) {
        DB::rollback();

        return $e->getMessage();
    }
  
    }

    public function purchasesReturnCreditPayment($purchasesReturnId,$payment)
    {
        $purchasesInfo = $this->purchasesReturn::find($purchasesReturnId);
        $purchasesReturnCreditPayment =  new PurchasesPayment();
        $purchasesReturnCreditPayment->date = helper::mysql_date();
        $purchasesReturnCreditPayment->company_id = $purchasesInfo->company_id; //purchases info
        $purchasesReturnCreditPayment->supplier_id  = $purchasesInfo->supplier_id;
        $purchasesReturnCreditPayment->branch_id  = $purchasesInfo->branch_id ?? helper::getDefaultBranch();
        $purchasesReturnCreditPayment->voucher_id  = $purchasesInfo->id;
        $purchasesReturnCreditPayment->payment_type  = 'Credit';
        $purchasesReturnCreditPayment->voucher_no  = helper::generateInvoiceId("purchases_payment_prefix","purchases_payments");
        $purchasesReturnCreditPayment->credit  = $payment;
        $purchasesReturnCreditPayment->status  = 'Approved';
        $purchasesReturnCreditPayment->note  = 'Purchases Reutrn';
        $purchasesReturnCreditPayment->updated_by = Helper::userId();
        $purchasesReturnCreditPayment->created_by = Helper::userId();
        $purchasesReturnCreditPayment->save();
        return $purchasesReturnCreditPayment->id;
    }


    
    public function purchasesReturnCashPayment($purchasesReturnId,$payment)
    {

        $purchasesInfo = $this->purchasesReturn::find($purchasesReturnId);
        $purchasesReturnCreditPayment =  new PurchasesPayment();
        $purchasesReturnCreditPayment->date = helper::mysql_date();
        $purchasesReturnCreditPayment->company_id = $purchasesInfo->company_id; //purchases info
        $purchasesReturnCreditPayment->supplier_id  = $purchasesInfo->supplier_id;
        $purchasesReturnCreditPayment->branch_id  = $purchasesInfo->branch_id ?? helper::getDefaultBranch();
        $purchasesReturnCreditPayment->voucher_id  = $purchasesInfo->id;
        $purchasesReturnCreditPayment->payment_type  = 'Cash';
        $purchasesReturnCreditPayment->voucher_no  = helper::generateInvoiceId("purchases_payment_prefix","purchases_payments");
        $purchasesReturnCreditPayment->debit  = $payment;
        $purchasesReturnCreditPayment->status  = 'Approved';
        $purchasesReturnCreditPayment->note  = 'Purchases Reutrn';
        $purchasesReturnCreditPayment->updated_by = Helper::userId();
        $purchasesReturnCreditPayment->created_by = Helper::userId();
        $purchasesReturnCreditPayment->save();

        
        $dueAmount = $purchasesInfo->grand_total- ($purchasesInfo->paid_amount+$payment);
        $purchasesInfo->paid_amount = $purchasesInfo->paid_amount+$payment;
        $purchasesInfo->due_amount =$dueAmount;
        $purchasesInfo->save();
        return $purchasesReturnCreditPayment->id;
    }

    public function masterDetails($masterId,$request){
    
        $productInfo = $request->product_id;
        $allDetails = array();
        foreach($productInfo as $key => $value):
          $masterDetails=array();
          if(!empty($request->return_quantity[$key])):
            $purchasesItemInfo =  PurchasesDetails::where('purchases_id',$request->purchases_id)->where('product_id',$request->product_id[$key])->first();
            $masterDetails['date'] =helper::mysql_date();
            $masterDetails['company_id'] = helper::companyId();
            $masterDetails['preturn_id'] =$masterId;
            $masterDetails['product_id']  =$request->product_id[$key];
            $masterDetails['pack_size']  = $request->pack_size[$key] ?? $request->return_quantity[$key];
            $masterDetails['pack_no']  = $request->pack_no[$key] ?? 1;
            $masterDetails['quantity']  =$request->return_quantity[$key];
            $masterDetails['deduction_percent']  =$request->deduction[$key];
            $masterDetails['deduction_amount']  =$request->deduction_percen_amount[$key];
            $masterDetails['unit_price']  =$purchasesItemInfo->unit_price;
            $masterDetails['total_price']  =$purchasesItemInfo->unit_price*$request->return_quantity[$key];
            array_push($allDetails,$masterDetails);
            //update purchases details table.
            $purchasesItemInfo->return_quantity =$purchasesItemInfo->return_quantity + $request->return_quantity[$key];
            $purchasesItemInfo->save();
          endif;
        endforeach;
       $saveInfo =  PurchasesReturnDetail::insert($allDetails);
       return $saveInfo;
    }

    public function purchasesReturnJournal($masterLedgerId,$request){
        $generalInfo=General::find($masterLedgerId);

        //account Payable = debit
         $accountPayable = new GeneralLedger();
         $accountPayable->company_id = helper::companyId();
         $accountPayable->general_id = $masterLedgerId;
         $accountPayable->form_id = 5;
         $accountPayable->account_id = 38;//account receiable come from chartOfAccount
         $accountPayable->date = helper::mysql_date($request->date);
         $accountPayable->debit = $generalInfo->debit;
         $accountPayable->memo ='Account Payable';
         $accountPayable->created_by =helper::userId();
         $accountPayable->save();

        //purchases = credit
         $purchases = new GeneralLedger();
         $purchases->company_id = helper::companyId();
         $purchases->general_id = $masterLedgerId;
         $purchases->form_id = 5;
         $purchases->account_id = 4;//account payable come from chartOfAccount
         $purchases->date = helper::mysql_date($request->date);
         $purchases->credit = $generalInfo->debit;
         $purchases->memo ='Purchases Stock';
         $purchases->created_by =helper::userId();
         $purchases->save();


     }
 
 
     public function purchasesReturnPaymentJournal($masterLedgerId,$payment,$date){
        $generalInfo=General::find($masterLedgerId);
     
         //account Payable = debit
         $accountPayable = new GeneralLedger();
         $accountPayable->company_id = helper::companyId();
         $accountPayable->general_id = $masterLedgerId;
         $accountPayable->form_id = 5;
         $accountPayable->account_id = 38;//account receiable come from chartOfAccount
         $accountPayable->date = helper::mysql_date($date);
         $accountPayable->credit = $payment;
         $accountPayable->memo ='Account Payable';
         $accountPayable->created_by =helper::userId();
         $accountPayable->save();
         //cash or bank = credit
         $cashOrBank = new GeneralLedger();
         $cashOrBank->company_id = helper::companyId();
         $cashOrBank->general_id = $masterLedgerId;
         $cashOrBank->form_id = 5;
         $cashOrBank->account_id = 7;//purchases stock or inventory stock
         $cashOrBank->date = helper::mysql_date($date);
         $cashOrBank->debit = $payment;
         $cashOrBank->memo ='Purchases payment';
         $cashOrBank->created_by =helper::userId();
         $cashOrBank->save();
     }


    public function generalSave($return_id){
        $purchasesInfo = $this->purchasesReturn::find($return_id);
        $general =  new General();
        $general->date = helper::mysql_date();
        $general->company_id = $purchasesInfo->company_id;//purchases info
        $general->form_id = 7;//purchases return info
        $general->branch_id  = $purchasesInfo->branch_id;
        $general->store_id  = $purchasesInfo->store_id;
        $general->voucher_id  = $return_id;
        $general->debit  = $purchasesInfo->grand_total;
        $general->status  ='Approved';
        $general->updated_by = helper::userId();
        $general->company_id = helper::companyId();
        $general->save();
        return $general->id;
        
        
    }

    public function stockSave($general_id,$return_id,$purchases_id=null){
        $purchasesReturnDetails = PurchasesReturnDetail::where('preturn_id',$return_id)->get();
        $allStock = array();
        if(!empty($purchasesReturnDetails)):
            foreach($purchasesReturnDetails as $key => $value):
            $getProductInfo = PurchasesMrrDetails::where('purchases_id',$purchases_id)->where('product_id',$value->product_id)->first();
            $generalStock=array();
            $generalStock['date'] =helper::mysql_date();
            $generalStock['company_id'] = helper::companyId();
            $generalStock['branch_id']  = $value->branch_id ?? helper::getDefaultBranch();
            $generalStock['store_id']  = $value->store_id ?? helper::getDefaultStore();
            $generalStock['general_id'] =$general_id;
            $generalStock['product_id']  =$value->product_id;
            $generalStock['batch_no']  = helper::getDefaultBatch();
            $generalStock['pack_size']  =$value->pack_size;
            $generalStock['pack_no']  =$value->pack_no;
            $generalStock['type']  ='rout';
            $generalStock['quantity']  =$value->quantity;
            $generalStock['unit_price']  =$value->unit_price;
            $generalStock['total_price']  =$value->total_price;
            array_push($allStock,$generalStock);
            endforeach;
       endif;
       $saveInfo =  Stock::insert($allStock);
       return $saveInfo;
    }

    public function stockSummarySave($purchases_id){
        $salesReturnDetails = PurchasesReturnDetail::where('preturn_id',$purchases_id)->get();
        foreach($salesReturnDetails as $key => $value):
            $stockSummaryExits =  StockSummary::where('company_id',helper::companyId())->where('product_id',$value->product_id)->first();
            if(empty($stockSummaryExits)){
                //new entry row
                $stockSummary = new StockSummary();
                $stockSummary->quantity = $value->quantity;
            }else{
                //update exitsting row
                $stockSummary = $stockSummaryExits;
                $stockSummary->quantity =$stockSummary->quantity-$value->quantity;
            }
            $stockSummary->store_id = $value->store_id ?? helper::getDefaultStore();
            $stockSummary->company_id = helper::companyId();
            $stockSummary->branch_id = $value->branch_id ?? helper::getDefaultBranch();
            $stockSummary->product_id = $value->product_id;
            $stockSummary->batch_no = helper::getDefaultBatch();
            $stockSummary->pack_size = $value->pack_size;
            $stockSummary->pack_no = $value->pack_no;
            $stockSummary->save();
        endforeach;
        return true;
    }

    public function destroy($id)
    {
        DB::beginTransaction(); 
            
    try {
        $purchases = $this->purchasesReturn::find($id);
        $purchases->delete();
        purchasesDetails::where('purchases_id', $id)->delete();


            DB::commit();
            // all good
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        } 
   }
}
