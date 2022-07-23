<?php

namespace App\Repositories\InventoryTransaction;

use App\Helpers\Helper;
use App\Helpers\Journal;
use App\Models\General;
use App\Models\GeneralLedger;
use App\Models\PendingCheck;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchases;
use App\Models\PurchasesDetails;
use App\Models\PurchasesMrr;
use App\Models\PurchasesMrrDetails;
use App\Models\PurchasesOrder;
use App\Models\PurchasesPayment;
use App\Models\PurchasesPendingCheque;
use App\Models\TemporaryPendingCheck;
use App\Models\Stock;
use App\Models\StockSummary;
use DB;


class PurchasesRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Purchases
     */
    private $purchases;
    /**
     * CourseRepository constructor.
     * @param purchases $purchases
     */
    public function __construct(Purchases $purchases)
    {
        $this->purchases = $purchases;
      
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns, "id");
        $edit = Helper::roleAccess('inventoryTransaction.purchases.edit') ? 1 : 0;
        $delete = Helper::roleAccess('inventoryTransaction.purchases.destroy') ? 1 : 0;
        $show = Helper::roleAccess('inventoryTransaction.purchases.show') ? 1 : 0;
        $ced = $edit + $delete + $show;

        $totalData = $this->purchases::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')] ?? 'id';
        $dir = $request->input('order.0.dir');
        if (empty($request->input('search.value'))) {
            $purchasess = $this->purchases::select($columns)->company()->with('purchasesDetails', 'supplier', 'branch', 'purchasesOrder')->offset($start)
                ->limit($limit)
                //->orderBy('id', 'desc')
                ->orderBy($order, $dir)
                
                ->get();
            $totalFiltered = $this->purchases::count();
        } else {
            $search = $request->input('search.value');
            $purchasess = $this->purchases::select($columns)->company()->with('purchasesDetails', 'supplier', 'branch', 'purchasesOrder')->where(function ($q) use ($columns, $search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            })
                ->offset($start)
                ->limit($limit)
                //->orderBy('id', 'desc')
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = $this->purchases::select($columns)->company()->where(function ($q) use ($columns, $search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }

        foreach ($purchasess as $key => $value) :
          if (!empty($value->supplier_id))
                $value->supplier_id = $value->supplier->name ?? '';

            if (!empty($value->branch_id))
                $value->branch_id  = $value->branch->name ?? '';

            if (!empty($value->purchases_order_id))
                $value->purchases_order_id = $value->purchasesOrder->voucher_no ?? '';

            if (!empty($value->due_amount))
                $value->due_amount = $value->grand_total - $value->paid_amount;

            if (!empty($value->date))
                $value->date = helper::get_php_date($value->date) ?? '';
        endforeach;

        $columns = Helper::getQueryProperty();

        $data = array();
        if ($purchasess) {
            
            foreach ($purchasess as $key => $purchases) {
                $nestedData['id'] = $key + 1;
                if ($ced != 0) :
                    if ($edit != 0) {
                        if ($purchases->purchases_status == 'Pending' && $purchases->mrr_status == "Pending") :
                            $edit_data = '<a href="' . route('inventoryTransaction.purchases.edit', $purchases->id) . '" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                        else :
                            $edit_data = '';
                        endif;
                    } else {
                        $edit_data = '';
                    }

                    if ($delete != 0) {
                        if ($purchases->purchases_status == 'Pending' && $purchases->mrr_status == "Pending") :
                            $delete_data = '<a delete_route="' . route('inventoryTransaction.purchases.destroy', $purchases->id) . '" delete_id="' . $purchases->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $purchases->id . '"><i class="fa fa-times"></i></a>';
                        else :
                            $delete_data = '';
                        endif;
                    } else {
                        $delete_data = '';
                    }

                    if ($show != 0) {
                        $show_data = '<a href="' . route('inventoryTransaction.purchases.show', $purchases->id) . '" show_id="' . $purchases->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $purchases->id . '"><i class="fa fa-search-plus"></i></a>';
                    } else {
                        $show_data = '';
                    }
                    $nestedData['action'] = $edit_data . ' ' . $delete_data . ' ' . $show_data;
                else :
                    $nestedData['action'] = '';
                endif;
                
                foreach ($columns as $key => $value) :
                    if ($value == 'mrr_status') :
                        if(helper::mrrIsActive()):
                           $nestedData[$value] = helper::statusBar($purchases->$value);
                        endif;
                    elseif ($value == 'purchases_status') :
                        $nestedData[$value] = helper::statusBar($purchases->$value);
                    elseif ($value == 'voucher_no') :
                        $nestedData[$value] = '<a target="_blank" href="' . route('inventoryTransaction.purchases.show', $purchases->id) . '" show_id="' . $purchases->id . '" title="Details" class="">' . $purchases->voucher_no . '</a>';
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
            'purchasesDetails' => function ($q) {
                $q->select('id', 'purchases_id', 'branch_id',  'date', 'pack_size', 'approved_quantity','pack_no', 'discount', 'quantity', 'unit_price', 'total_price', 'company_id', 'product_id');
            }, 'purchasesDetails.product' => function ($q) {
                $q->select('id', 'code', 'name', 'category_id', 'status', 'brand_id', 'company_id');
            }, 'general' => function ($q) {
                $q->select('id', 'date', 'voucher_id', 'branch_id', 'form_id', 'debit', 'credit', 'note');
            }, 'general.journals' => function ($q) {
                $q->select('id', 'general_id', 'form_id', 'account_id', 'date', 'debit', 'credit');
            }, 'general.journals.account' => function ($q) {
                $q->select('id', 'company_id', 'branch_id', 'parent_id', 'account_code', 'name', 'is_posted');
            },'createdBy' => function ($q) {
                $q->select('id','name');
            },'updatedBy' => function ($q) {
                $q->select('id','name');
            },'approvedBy' => function ($q) {
                $q->select('id','name');
            }
        ])->where('id', $id)->company()->first();
        return $result;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function purchasesDetails($purchasesId)
    {
        $purchasesOrderInfo = Purchases::with('purchasesDetails', 'supplier')->where('id', $purchasesId)->company()->get();
        return $purchasesOrderInfo;
    }


    
    public function store($request)
    {
        DB::beginTransaction();
        try {
            $poMaster =  new $this->purchases();
            $poMaster->date = helper::mysql_date($request->date); 
            $poMaster->supplier_id  = $request->supplier_id;
            $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
            $poMaster->store_id  = $request->store_id ?? helper::getDefaultStore();
            if (!empty($request->purchases_order_id))
                $poMaster->purchases_order_id  = implode(",", $request->purchases_order_id);
            if(!empty($request->account_id)):
                $poMaster->account_id  = $request->account_id[0];
            endif;
            $poMaster->voucher_no  = helper::generateInvoiceId("purchases_prefix","purchases");
            $poMaster->discount  = $request->discount;
            $poMaster->subtotal  = $request->sub_total;
            $poMaster->grand_total  = $request->grand_total;
            $poMaster->due_amount  = $request->grand_total;
            $poMaster->total_qty  = array_sum($request->quantity);
            $poMaster->voucher_reference  = $request->voucher_reference;
            $poMaster->purchases_status  = 'Pending';
            $poMaster->mrr_status  = 'Pending';
            $poMaster->payment_type  = $request->payment_type;
            $poMaster->created_by =helper::userId();
            $poMaster->company_id = Helper::companyId();
            $poMaster->save();
            
            if ($poMaster->id) {
                if(!empty($request->documents))
                $poMaster->documents = helper::upload($request->documents,500,500,'purchases',$poMaster->id);
                $poMaster->save();
                $this->masterDetails($poMaster->id, $request);
                //set logic  for purchases if auto approval
                if(helper::isPurchasesApprovalAuto()){
                    $this->purchasesDebitPayment($poMaster->id, $request->grand_total,$request->date);
                    //general table data save
                    $general_id = $this->generalSave($poMaster->id,$request->date);
                        //purchases credit journal
                        Journal::purchasesCreditJournal($general_id,$request->date);
                        //if payment type cash then
                    if($request->payment_type == "Cash"):
                        $this->purchasesCreditPayment($poMaster->id,$request->paid_amount,$request->payment_type,$request->date);
                        //purchases payment journal
                        Journal::purchasesPaymentJournal($poMaster->id,$request->paid_amount,$request->account_id[0],$request->date);
                        $poMaster->purchases_status =  'Approved';
                       // $this->paidAmountUpdate($poMaster->id,$request->paid_amount);
                    endif;
                    //if payment type bank
                    if($request->payment_type == "Bank"):
                        $this->purchasesBankPayment($poMaster->id,$request);
                    endif;
                    //if purchases mrr active and mrr auto approval
                    if(helper::mrrIsActive() && helper::isMrrApprovalAuto()){
                        //1.master mrr
                        //2.details mrr
                        $mrr_id =  $this->purchasesMrrMaster($poMaster->id,$request->date);
                        //main stock table data save
                        $this->stockSave($general_id, $poMaster->id,$request->date,$mrr_id);
                        //stock cashing table data save
                        $this->stockSummarySave($poMaster->id);
                        //purchases order
                        $poMaster->mrr_status =  'Approved';
                    }else if(helper::mrrIsActive() === false){
                        $mrr_id =  $this->purchasesMrrMaster($poMaster->id,$request->date);
                        //main stock table data save
                        $this->stockSave($general_id, $poMaster->id,$request->date,$mrr_id);
                        //stock cashing table data save
                        $this->stockSummarySave($poMaster->id);
                        //purchases order
                        $poMaster->mrr_status =  'Approved';
                    }else{
                        //logic implement here
                    }
                    $poMaster->purchases_status = 'Approved';
                    $poMaster->approved_by = helper::userId();
                    $poMaster->save();
                }else{

                    if($request->payment_type == "Bank"):
                        $this->temporaryBankPayment($poMaster->id,$request);
                    endif;
                    if($request->payment_type == "Cash"):
                        $poMaster->paid_amount = $request->paid_amount;//paid amount for pending
                    endif;
                    $poMaster->purchases_status = 'Pending';
                    $poMaster->save();
                }
                if (!empty($request->purchases_order_id)) :
                    $this->purchasesOrderUpdate($request->purchases_order_id);
                endif;  
            }
            DB::commit();
            // all good

            return $poMaster->id;
        } catch (\Exception $e) {
            DB::rollback();
           
            return $e->getMessage();
        }
    }
   

    public function checkPendingOrder($request){

        if(!empty($request->purchases_order_id)){
            $totalFalse=0;
            foreach($request->purchases_order_id as $eachOderId):
               $pendingOrderList = PurchasesOrder::where( 'id', $eachOderId)->where('purchases_status','Pending')->count();
                if(empty($pendingOrderList)){
                    $totalFalse+=1;
                }
            endforeach;
            return $totalFalse;
        }
    }
    public function paidAmountUpdate($purchases_id,$paidAmount){
        $purchasesInfo = Purchases::find($purchases_id);
        $purchasesInfo->paid_amount = $purchasesInfo->paid_amount + $paidAmount;
        $purchasesInfo->save();
        return true;
    }


    public function accountApproved($purchases_id,$request){
       

        DB::beginTransaction();
        try {

            
            $date=helper::mysql_date($request->date_picker);
            $status=$request->status;
            $poMaster = Purchases::where("id",$purchases_id)->company()->first();
            if($poMaster->purchases_status == "Pending" && $status == "Approved"):
                //general table data save
                $this->purchasesDebitPayment($poMaster->id, $poMaster->grand_total,$poMaster->date);
                $general_id = $this->generalSave($poMaster->id,$date);
                    //purchases credit journal
                    Journal::purchasesCreditJournal($general_id,$date);
                if(helper::mrrIsActive() && helper::isMrrApprovalAuto()){
                    //1.master mrr
                    //2.details mrr
                    $mrr_id =  $this->purchasesMrrMaster($poMaster->id,$date);
                    //main stock table data save
                    $this->stockSave($general_id, $poMaster->id,$date,$mrr_id);
                    //stock cashing table data save
                    $this->stockSummarySave($poMaster->id);
                    //purchases order
                    $poMaster->mrr_status =  'Approved';
                }else if(helper::mrrIsActive() === false){
                    $mrr_id =  $this->purchasesMrrMaster($poMaster->id,$date);
                    //main stock table data save
                    $this->stockSave($general_id, $poMaster->id,$date,$mrr_id);
                    //stock cashing table data save
                    $this->stockSummarySave($poMaster->id);
                    //purchases order
                    $poMaster->mrr_status =  'Approved';
                  
                }else{
                    //logic implement here
                }
                //if payment type bank
                if($poMaster->payment_type == "Bank"):
                    $this->purchasesBankPayment($poMaster->id,$request);
                endif;
                if($poMaster->payment_type == "Cash"):
                    $cashAmount = $poMaster->paid_amount;
                    $poMaster->paid_amount = 0;
                    $poMaster->save();
                    $this->purchasesCreditPayment($poMaster->id,$cashAmount,$poMaster->payment_type,$poMaster->date);
                    //purchases payment journal
                    Journal::purchasesPaymentJournal($poMaster->id,$cashAmount,$poMaster->account_id,$poMaster->date);
                    $poMaster->purchases_status =  'Approved';
                endif;

                $poMaster->purchases_status = 'Approved';
                $poMaster->approved_by = helper::userId();
                $poMaster->save();
            else: 

                $poMaster->purchases_status =$status;
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



    
    public function purchasesBankPayment($purchases_id,$request){

        $pendingCheque = TemporaryPendingCheck::where('voucher_id',$purchases_id)->where('form_id',4)->company()->first();

        if(!empty($pendingCheque)): 
            $pendingCheck =  new PurchasesPendingCheque();
            $pendingCheck->company_id = helper::companyId();
            $pendingCheck->voucher_id = $purchases_id;
            $pendingCheck->voucher_no = helper::generateInvoiceId("purchases_pending_cheque_prefix","purchases_pending_cheques");
            $pendingCheck->form_id =4;//purchases
            $pendingCheck->bank_id = $pendingCheque->bank_id;
            $pendingCheck->supplier_id = $pendingCheque->customer_supplier_id ?? '';
            $pendingCheck->cheque_date = helper::mysql_date($pendingCheque->cheque_date);
            $pendingCheck->receive_date = helper::mysql_date($pendingCheque->receive_date);
            $pendingCheck->deposit_date =  helper::mysql_date($pendingCheque->deposit_date);
            $pendingCheck->cheque_number =$pendingCheque->cheque_number;
            $pendingCheck->payment = $pendingCheque->payment;
            $pendingCheck->note ="Cheque Payment";//purchases
            $pendingCheck->status ="Pending";//cheque approved purchases
            $pendingCheck->save();
            TemporaryPendingCheck::where('voucher_id',$purchases_id)->delete();
            return $pendingCheck;
        else: 

            $pendingCheck =  new PurchasesPendingCheque();
            $pendingCheck->company_id = helper::companyId();
            $pendingCheck->voucher_id = $purchases_id;
            $pendingCheck->voucher_no = helper::generateInvoiceId("purchases_pending_cheque_prefix","purchases_pending_cheques");
            $pendingCheck->form_id =4;//purchases
            $pendingCheck->bank_id =$request->bank_id;
            $pendingCheck->supplier_id =$request->supplier_id;
            $pendingCheck->cheque_date = helper::mysql_date($request->cheque_date);
            $pendingCheck->receive_date = helper::mysql_date($request->receive_date);
            $pendingCheck->deposit_date = helper::mysql_date($request->deposit_date);
            $pendingCheck->cheque_number =$request->cheque_number;
            $pendingCheck->payment =$request->paid_amount;
            $pendingCheck->note ="Cheque Payment";//purchases
            $pendingCheck->status ="Pending";//cheque approved purchases
            $pendingCheck->save();
            return $pendingCheck;

        endif;

    }

    public function purchasesMrrMaster($purchases_id,$date){

            $purchasesInfo = Purchases::where('id',$purchases_id)->company()->first();
            $poMrrMaster =  new PurchasesMrr();
            $poMrrMaster->date = helper::mysql_date($date);
            $poMrrMaster->company_id  = helper::companyId();
            $poMrrMaster->branch_id  = $purchasesInfo->branch_id ?? helper::getDefaultBranch();
            $poMrrMaster->store_id  = $purchasesInfo->store_id ?? helper::getDefaultStore();
            $poMrrMaster->voucher_no  = helper::generateInvoiceId("purchases_mrr_prefix","purchases_mrrs");
            $poMrrMaster->documents  = $purchasesInfo->documents ?? 0;
            $poMrrMaster->purchases_id  = $purchases_id;
            $poMrrMaster->note  = "Mrr apprved";
            $poMrrMaster->status  = 'Approved';
            $poMrrMaster->updated_by = helper::userId();
            $poMrrMaster->save();
            if ($poMrrMaster->id) {
                $this->purchasesMrrDetails($poMrrMaster->id, $purchases_id,$date);
            }
            return $poMrrMaster->id;
    }

    public function temporaryBankPayment($purchases_id,$request){

        $pendingCheck =  new TemporaryPendingCheck();
        $pendingCheck->company_id = helper::companyId();
        $pendingCheck->branch_id = $request->bank_id ?? helper::getDefaultBranch();
        $pendingCheck->voucher_id = $purchases_id;
        $pendingCheck->form_id =4;//purchases
        $pendingCheck->bank_id =$request->bank_id;
        $pendingCheck->customer_supplier_id = $request->supplier_id;
        $pendingCheck->cheque_date = helper::mysql_date($request->cheque_date);
        $pendingCheck->receive_date = helper::mysql_date($request->receive_date);
        $pendingCheck->deposit_date = helper::mysql_date($request->deposit_date);
        $pendingCheck->cheque_number =$request->cheque_number;
        $pendingCheck->payment =$request->paid_amount;
        $pendingCheck->note ="Cheque Payment";//purchases
        $pendingCheck->status ="Pending";//cheque approved purchases
        $pendingCheck->save();
        return $pendingCheck;
 
     }
    public function purchasesMrrDetails($masterId, $purchases_id,$date)
    {
        PurchasesMrrDetails::where('mrr_id', $masterId)->company()->delete();
        $purchasesDetails = PurchasesDetails::where('purchases_id',$purchases_id)->company()->get();
        $allDetails = array();
        foreach ($purchasesDetails as $key => $value) :
            $spdetails = PurchasesDetails::where('purchases_id',$purchases_id)->where('product_id',$value->product_id)->company()->first();
            $masterMrrDetails = array();
            $masterMrrDetails['company_id'] =helper::companyId();
            $masterMrrDetails['date'] = helper::mysql_date($date);
            $masterMrrDetails['purchases_id'] = $purchases_id;
            $masterMrrDetails['mrr_id'] = $masterId;
            $masterMrrDetails['product_id']  =$value->product_id;
            $masterMrrDetails['branch_id']  = helper::getDefaultBranch();
            $masterMrrDetails['store_id']  = helper::getDefaultStore();
            $masterMrrDetails['batch_no']  = helper::getDefaultBatch();
            $masterMrrDetails['pack_size']  =$value->pack_size;
            $masterMrrDetails['pack_no']  =$value->pack_no;
            $masterMrrDetails['quantity']  =$value->quantity;
            $masterMrrDetails['approved_quantity']  =$value->quantity;
            array_push($allDetails, $masterMrrDetails);
            $spdetails->approved_quantity = $spdetails->approved_quantity+$value->quantity;//update purchases details table with approved qty.
            $spdetails->save();
        endforeach;
        $saveInfo =  PurchasesMrrDetails::insert($allDetails);
        return $saveInfo;
    }



    public function stockSummarySave($purchases_id)
    {
     
        $purchasesDetails = PurchasesDetails::where('purchases_id', $purchases_id)->company()->get();
        foreach ($purchasesDetails as $key => $value) :
            if(helper::mrrIsActive() === true){
                $stockSummaryExits =  StockSummary::where('product_id', $value->product_id)->where('batch_no',helper::getDefaultBatch())->where("store_id",helper::getDefaultStore())->where("branch_id",helper::getDefaultBranch())->company()->first();
            }else{
                $stockSummaryExits =  StockSummary::where('product_id', $value->product_id)->company()->first();          
            }

            if (empty($stockSummaryExits)) {
                $stockSummary = new StockSummary();
                $stockSummary->quantity = $value->quantity;
            } else {
                $stockSummary = $stockSummaryExits;
                $stockSummary->quantity = $stockSummary->quantity + $value->quantity;
            }
            $stockSummary->company_id = $value->company_id;
            $stockSummary->branch_id = $value->branch_id ?? helper::getDefaultBranch();
            $stockSummary->store_id = $value->store_id ?? helper::getDefaultStore();
            $stockSummary->category_id = helper::getRow('products','id',$value->product_id,'category_id');
            $stockSummary->brand_id = helper::getRow('products','id',$value->product_id,'brand_id');
            $stockSummary->product_id = $value->product_id;
            $stockSummary->batch_no = helper::getDefaultBatch();
            $stockSummary->pack_size = $value->pack_size;
            $stockSummary->pack_no = $value->pack_no;
            $stockSummary->save();
        endforeach;
    }


    public function masterDetails($masterId, $request)
    {
        PurchasesDetails::where('purchases_id', $masterId)->company()->delete();
        $productInfo = $request->product_id;
        $allDetails = array();
        foreach ($productInfo as $key => $value) :
            $masterDetails = array();
            $masterDetails['date'] = helper::mysql_date($request->date);
            $masterDetails['company_id'] = helper::companyId();
            $masterDetails['purchases_id'] = $masterId;
            $masterDetails['branch_id']  = $request->branch_id ?? helper::getDefaultBranch();
            $masterDetails['store_id']  = $request->store_id ?? helper::getDefaultStore();
            $masterDetails['product_id']  = $request->product_id[$key];
            $masterDetails['pack_size']  = $request->pack_size[$key] ?? $request->quantity[$key];
            $masterDetails['pack_no']  = $request->pack_no[$key] ?? 1;
            $masterDetails['quantity']  = $request->quantity[$key];
            $masterDetails['unit_price']  = $request->unit_price[$key];
            $masterDetails['total_price']  = $request->total_price[$key];
            array_push($allDetails, $masterDetails);
        endforeach;
        $saveInfo =  PurchasesDetails::insert($allDetails);
        return $saveInfo;
    }


    public function generalSave($purchases_id,$date)
    {
        $purchasesInfo = $this->purchases::find($purchases_id);
        $general =  new General();
        $general->date = helper::mysql_date($date);
        $general->company_id = $purchasesInfo->company_id; //purchases info
        $general->form_id = 4; //purchases info
        $general->branch_id  = $purchasesInfo->branch_id ?? helper::getDefaultBranch();
        $general->store_id  = $purchasesInfo->store_id ?? helper::getDefaultStore();
        $general->voucher_id  = $purchasesInfo->id;
        $general->debit  = $purchasesInfo->grand_total;
        $general->status  = 'Approved';
        $general->updated_by = Helper::userId();
        $general->company_id = helper::companyId();
        $general->save();
        return $general->id;
    }
    

    public function purchasesCreditPayment($purchases_id,$payment,$payment_type,$date,$pendingChequeId=null)
    {
        $purchasesInfo = $this->purchases::find($purchases_id);
        if(!empty($pendingChequeId)): 
           $chequeInfo =  PurchasesPendingCheque::find($pendingChequeId)->first();
        endif;
        $purchasesCreditPayment =  new PurchasesPayment();
        $purchasesCreditPayment->date = helper::mysql_date($date);

        $purchasesCreditPayment->company_id = $purchasesInfo->company_id; //purchases info
        $purchasesCreditPayment->supplier_id  = $purchasesInfo->supplier_id;
        $purchasesCreditPayment->branch_id  = $purchasesInfo->branch_id ?? helper::getDefaultBranch();
        $purchasesCreditPayment->voucher_id  = $purchasesInfo->id;
        $purchasesCreditPayment->payment_type  = $payment_type;
        $purchasesCreditPayment->voucher_no  = helper::generateInvoiceId("purchases_payment_prefix","purchases_payments");
        $purchasesCreditPayment->credit  = $payment;
        $purchasesCreditPayment->status  = 'Approved';
        if($payment_type == "Cash"):
           $purchasesCreditPayment->note  = 'Cash purchases payment';
        else:
            if(!empty($chequeInfo)): 
                $purchasesCreditPayment->bank_id  = $chequeInfo->bank_id ?? '';
                $purchasesCreditPayment->cheque_number  = $chequeInfo->cheque_number ?? '';
                $purchasesCreditPayment->cheque_date  =  $chequeInfo->cheque_date ?? '';
                $purchasesCreditPayment->note  = 'Cheque purchases payment';
            endif;
        endif;
        $purchasesCreditPayment->updated_by = Helper::userId();
        $purchasesCreditPayment->created_by = Helper::userId();
        $purchasesCreditPayment->save();

        $dueAmount = $purchasesInfo->grand_total- ($purchasesInfo->paid_amount+$payment);
        $purchasesInfo->paid_amount = $purchasesInfo->paid_amount+$payment;
        $purchasesInfo->due_amount =$dueAmount;
        $purchasesInfo->save();

        return $purchasesCreditPayment->id;
    }

    public function purchasesDebitPayment($purchases_id,$payment,$date)
    {
        $purchasesInfo = $this->purchases::find($purchases_id);
        $purchasesDebitPayment =  new PurchasesPayment();
        $purchasesDebitPayment->date = helper::mysql_date($date);
        $purchasesDebitPayment->company_id = $purchasesInfo->company_id; //purchases info
        $purchasesDebitPayment->supplier_id  = $purchasesInfo->supplier_id;
        $purchasesDebitPayment->branch_id  = $purchasesInfo->branch_id ?? helper::getDefaultBranch();
        $purchasesDebitPayment->form_id  = 4;
        $purchasesDebitPayment->voucher_id  = $purchasesInfo->id;
        $purchasesDebitPayment->voucher_no  = helper::generateInvoiceId("purchases_payment_prefix","purchases_payments");
        $purchasesDebitPayment->debit  = $payment;
        $purchasesDebitPayment->note  = 'purchases voucher amount';
        $purchasesDebitPayment->status  = 'Approved';
        $purchasesDebitPayment->updated_by = Helper::userId();
        $purchasesDebitPayment->created_by = Helper::userId();
        $purchasesDebitPayment->save();
        return $purchasesDebitPayment->id;
    }


    public function generalUpdate($purchases_id)
    {
        $purchasesInfo = $this->purchases::find($purchases_id);
        // $general = General::where('voucher_id',$purchases_id)->where('form_id',4)->where('company_id',helper::companyId())->first();
        $general = General::where('voucher_id', $purchases_id)->where('form_id', 4)->company()->first();
        $general->date = helper::mysql_date();
        $general->company_id = helper::companyId();
        $general->form_id = 4; //purchases info
        $general->branch_id  = $purchasesInfo->branch_id ?? helper::getDefaultBranch();
        $general->voucher_id  = $purchases_id;
        $general->debit  = $purchasesInfo->grand_total;
        $general->status  = 'Approved';
        $general->updated_by = helper::userId();
        $general->company_id = helper::companyId();
        $general->save();
        return $general->id;
    }

    public function stockSave($general_id, $purchases_id,$date,$mrr_id=null)
    {
        $purchasesDetails = PurchasesDetails::where('purchases_id', $purchases_id)->company()->get();
        $allStock = array();
        foreach ($purchasesDetails as $key => $value) :
            $generalStock = array();
            $generalStock['date'] = helper::mysql_date($date);
            $generalStock['company_id'] = $value->company_id;
            $generalStock['mrr_id'] = $mrr_id ?? 0;
            $generalStock['general_id'] = $general_id;
            $generalStock['product_id']  = $value->product_id;
            $generalStock['branch_id']  = $value->branch_id ?? helper::getDefaultBranch();
            $generalStock['store_id']  = $value->store_id ?? helper::getDefaultStore();
            $generalStock['batch_no']  = helper::getDefaultBatch();// $value->batch_no;
            $generalStock['pack_size']  = $value->pack_size;
            $generalStock['pack_no']  = $value->pack_no;
            $generalStock['quantity']  = $value->quantity;
            $generalStock['unit_price']  = $value->unit_price;
            $generalStock['total_price']  = $value->total_price;
            array_push($allStock, $generalStock);
        endforeach;
        $saveInfo =  Stock::insert($allStock);
        return $saveInfo;
    }


    public function purchasesOrderUpdate($purchasesOrderId)
    {
        if (!empty($purchasesOrderId)) {
            foreach ($purchasesOrderId as $key => $value) :
                $purchasesOrder =  PurchasesOrder::findOrFail($value);
                $purchasesOrder->purchases_status = 'Approved';
                $purchasesOrder->save();
            endforeach;
        }
        return true;

    }

    public function update($request, $id)
    {

        DB::beginTransaction();
        try {

            $poMaster = $this->purchases::findOrFail($id);
            $poMaster->date = helper::mysql_date($request->date);
            $poMaster->supplier_id  = $request->supplier_id;
            $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
            $poMaster->store_id  = $request->store_id ?? helper::getDefaultStore();
            $poMaster->voucher_no  = $request->voucher_no;
            $poMaster->discount  = $request->discount;
            $poMaster->subtotal  = $request->sub_total;
            $poMaster->grand_total  = $request->grand_total;
            $poMaster->note  = $request->note;
            $poMaster->purchases_status  = 'Pending';
            $poMaster->mrr_status  = 'Pending';
            $poMaster->payment_type  = $request->payment_type;
            $poMaster->paid_amount  = $request->paid_amount;
            $poMaster->updated_by =helper::userId();
            $poMaster->company_id = Helper::companyId();
            $poMaster->save();
            if ($poMaster->id) {
                if(!empty($request->documents))
                $poMaster->documents = helper::upload($request->documents,500,500,'purchases',$poMaster->id);
                $poMaster->save();
                $this->masterDetails($poMaster->id, $request);
                //set logic  for purchases if auto approval
               
                if (!empty($request->purchases_order_id)) :
                    $this->purchasesOrderUpdate($request->purchases_order_id);
                endif;  
            }
            DB::commit();
            // all good
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function statusUpdate($id, $status)
    {
        $purchases = $this->purchases::find($id);
        $purchases->status = $status;
        $purchases->save();
        return $purchases;
    }


   
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $purchases = $this->purchases::find($id);
            if($purchases->purchases_status == 'Pending'):
            $purchases->delete();
            PurchasesDetails::where('purchases_id', $id)->delete();
            endif;
            DB::commit();
            // all good
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}