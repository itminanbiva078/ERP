<?php

namespace App\Repositories\SalesTransaction;

use App\Helpers\Helper;
use App\Helpers\Journal;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\DeliveryChallan;
use App\Models\DeliveryChallanDetails;
use App\Models\General;
use App\Models\Pos;
use App\Models\PosDetails;
use App\Models\SalePayment;
use App\Models\SalePendingCheque;
use Illuminate\Support\Facades\Auth;
use App\Models\SalesDetails;
use App\Models\Sales;
use App\Models\Stock;
use App\Models\StockSummary;
use App\Models\SalesQuatation;
use App\Models\TemporaryPendingCheck;
use DB;

class SalesRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Sales
     */
    private $sales;
    /**
     * SalesRepositories constructor.
     * @param Sales $sales
     */
    public function __construct(Sales $sales)
    {
        $this->sales = $sales;

    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns, "id");
        $edit = Helper::roleAccess('salesTransaction.sales.edit') ? 1 : 0;
        $delete = Helper::roleAccess('salesTransaction.sales.destroy') ? 1 : 0;
        $show = Helper::roleAccess('salesTransaction.sales.show') ? 1 : 0;
        $ced = $edit + $delete + $show;

        $totalData = $this->sales::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $saless = $this->sales::select($columns)->company()->with('salesDetails', 'customer', 'branch','store')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->sales::count();
        } else {
            $search = $request->input('search.value');
            $saless = $this->sales::select($columns)->company()->with('salesDetails', 'customer', 'branch','store')->where(function ($q) use ($columns, $search) {
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
            $totalFiltered = $this->sales::select($columns)->company()->where(function ($q) use ($columns, $search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }

        foreach ($saless as $key => $value) :
            if (!empty($value->customer_id))
                $value->customer_id = $value->customer->name ?? '';

            if (!empty($value->branch_id))
                $value->branch_id  = $value->branch->name ?? '';

            if (!empty($value->store_id))
                $value->store_id  = $value->store->name ?? '';
        endforeach;

        $columns = Helper::getQueryProperty();
        $data = array();
        if ($saless) {
            foreach ($saless as $key => $sales) {
                $nestedData['id'] = $key + 1;

                if ($ced != 0) :
                    if ($edit != 0)
                        if ($sales->sales_status == 'Pending' && $sales->challan_status == "Pending") :

                            $edit_data = '<a href="' . route('salesTransaction.sales.edit', $sales->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                        else :
                            $edit_data = '';
                        endif;
                    else
                        $edit_data = '';

                    $show_data = '<a href="' . route('salesTransaction.sales.show', $sales->id) . '" show_id="' . $sales->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $sales->id . '"><i class="fa fa-search-plus"></i></a>';


                    if ($delete != 0)

                        if ($sales->sales_status == 'Pending' && $sales->challan_status == "Pending") :
                            $delete_data = '<a delete_route="' . route('salesTransaction.sales.destroy', $sales->id) . '" delete_id="' . $sales->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $sales->id . '"><i class="fa fa-times"></i></a>';
                        else :
                            $delete_data = '';
                        endif;


                    else
                        $delete_data = '';
                    $nestedData['action'] = $edit_data . ' ' . $delete_data . ' ' . $show_data;
                else :
                    $nestedData['action'] = '';
                endif;
                foreach ($columns as $key => $value) :
                    if ($value == 'sales_status') :
                        $nestedData['sales_status'] = helper::statusBar($sales->sales_status);
                    elseif ($value == 'challan_status') :
                            $nestedData['challan_status'] = helper::statusBar($sales->challan_status);
                    elseif ($value == 'voucher_no') :
                        $nestedData[$value] = '<a target="_blank" href="' . route('salesTransaction.sales.show', $sales->id) . '" show_id="' . $sales->id . '" title="Details" class="">' . $sales->voucher_no . '</a>';
                    else :
                        $nestedData[$value] = $sales->$value;
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
        $result = Sales::select("*")->with([
            'salesDetails' => function ($q) {
                $q->select('id', 'sales_id', 'branch_id', 'batch_no', 'date', 'pack_size', 'pack_no', 'discount', 'quantity', 'unit_price', 'total_price', 'company_id', 'product_id');
            }, 'salesDetails.product' => function ($q) {
                $q->select('id', 'code', 'name', 'category_id', 'status', 'brand_id', 'company_id');
            }, 'salesDetails.batch' => function ($q) {
                $q->select('id','name');
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
        ])->where('id', $id)->first();
        return $result;
    }



    /**
     * @param $request
     * @return mixed
     */
    public function salesDetails($salesId)
    {
        $salesInfo = Sales::with('salesDetails')->where('id', $salesId)->get();
        return $salesInfo;
    }


    public function store($request)
    {
        DB::beginTransaction();
        try {
            $poMaster =  new $this->sales();
            $poMaster->date = date('Y-m-d', strtotime($request->date));
            $poMaster->payment_type  = $request->payment_type;
            $poMaster->customer_id  = $request->customer_id;
            $poMaster->store_id  = $request->store_id ?? helper::getDefaultStore();
            $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
            if (!empty($request->sales_quatation_id))
            $poMaster->sales_quatation_id  = implode(",", $request->sales_quatation_id ?? '');
            if(!empty($request->account_id)):
                $poMaster->account_id  = $request->account_id[0];
            endif;
            $poMaster->due_amount  = $request->grand_total;
            $poMaster->voucher_no  = helper::generateInvoiceId("sales_prefix","sales");// $request->voucher_no;
            $poMaster->subtotal  = $request->sub_total;
            $poMaster->discount  = $request->discount;
            $poMaster->grand_total  = $request->grand_total;
            $poMaster->total_qty  = array_sum($request->quantity);
            $poMaster->note  = $request->note;
            $poMaster->sales_status  = 'Pending';
            $poMaster->challan_status  = 'Pending';
            $poMaster->created_by = Auth::user()->id;
            $poMaster->company_id = Auth::user()->company_id;
            $poMaster->save();
            if ($poMaster->id) {
                if(!empty($request->documents))
                $poMaster->documents = helper::upload($request->documents,500,500,'sales',$poMaster->id);
                $poMaster->save();
               $costOfGoodSold = $this->masterDetails($poMaster->id, $request);

                //set logic  for purchases if auto approval
                if(helper::isSaleApprovalAuto()){

                    $this->salesDebitPayment($poMaster->id, $request->grand_total,5);
                    //general table data save
                    $general_id = $this->generalSave($poMaster->id,5);
                    //sales credit journal
                    Journal::saleCreditJournal($general_id,$costOfGoodSold);
                        //if payment type cash then
                    if($request->payment_type == "Cash"):
                        $this->salesCreditPayment($poMaster->id,$request->paid_amount,$request->payment_type,null,5);
                        //sales payment journal
                        Journal::salePaymentJournal($general_id,$request->paid_amount,$request->account_id[0],$request->date,5);
                        $poMaster->sales_status =  'Approved';
                    endif;
                    //if payment type bank
                    if($request->payment_type == "Bank"):
                        $this->saleBankPayment($poMaster->id,$request);
                    endif;
                    //if  delivery chalan active and chalan auto approval
                    if(helper::isDeliveryChallanActive() && helper::isDeliveryChallanApprovalAuto()){
                        //1.master challan
                        //2.details challan
                        $challan_id =  $this->deliveryChallan($poMaster->id,$request->date);
                        //main stock table data save
                        $this->stockSave($general_id, $poMaster->id);
                        //stock cashing table data save
                        $this->stockSummarySave($poMaster->id);
                        //sales order
                        $poMaster->challan_status =  'Approved';

                    }else if(helper::isDeliveryChallanActive() === false){
                            $challan_id =  $this->deliveryChallan($poMaster->id,$request->date);
                            //main stock table data save
                            $this->stockSave($general_id, $poMaster->id,$challan_id);
                            //stock cashing table data save
                            $this->stockSummarySave($poMaster->id);
                            //sales order
                            $poMaster->challan_status =  'Approved';
                    }
                    $poMaster->sales_status = 'Approved';
                    $poMaster->approved_by = helper::userId();

                    $poMaster->save();
                }else{

                    if($request->payment_type == "Bank"):
                        $this->temporaryBankPayment($poMaster->id,$request);
                    endif;
                    if($request->payment_type == "Cash"):
                        $poMaster->paid_amount = $request->paid_amount;//paid amount for pending
                    endif;
                    $poMaster->sales_status = 'Pending';
                    $poMaster->save();
                }
                if (!empty($request->sales_quatation_id)) :
                    $this->salesQuatationUpdate($request->sales_quatation_id);
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

    public function checkPendingQuatation($request){
        if(!empty($request->sales_quatation_id)){
            $totalFalse=0;
            foreach($request->sales_quatation_id as $eachrequisitionId):
               $pendingRequsitionList = SalesQuatation::where('id', $eachrequisitionId)->where('sales_status','Pending')->count();
                if(empty($pendingRequsitionList)){
                    $totalFalse+=1;
                }
            endforeach;
            return $totalFalse;
        }
    }

    public function temporaryBankPayment($purchases_id,$request){
        $pendingCheck =  new TemporaryPendingCheck();
        $pendingCheck->company_id = helper::companyId();
        $pendingCheck->branch_id = $request->bank_id ?? helper::getDefaultBranch();
        $pendingCheck->voucher_id = $purchases_id;
        $pendingCheck->form_id =5;//sales
        $pendingCheck->bank_id =$request->bank_id;
        $pendingCheck->customer_supplier_id = $request->customer_id;
        $pendingCheck->cheque_date = helper::mysql_date($request->cheque_date);
        $pendingCheck->receive_date = helper::mysql_date($request->receive_date);
        $pendingCheck->deposit_date = helper::mysql_date($request->deposit_date);
        $pendingCheck->cheque_number =$request->cheque_number;
        $pendingCheck->payment =$request->paid_amount;
        $pendingCheck->note ="Cheque Payment";//sales
        $pendingCheck->status ="Pending";//cheque approved sales
        $pendingCheck->save();
        return $pendingCheck;

     }
    public function accountApproved($sales_id,$request){

        DB::beginTransaction();
        try {
            $date=helper::mysql_date($request->date_picker);
            $status=$request->status;
            $poMaster = Sales::where("id",$sales_id)->company()->first();
            $costOfGoods = $this->getCostOfGoods($sales_id);
            if($poMaster->sales_status == "Pending" && $status == "Approved"):
                //general table data save
                $general_id = $this->generalSave($poMaster->id,5);
                    //sales credit journal
                Journal::saleCreditJournal($general_id,$costOfGoods);

                if(helper::isDeliveryChallanActive() && helper::isDeliveryChallanApprovalAuto()){
                    //1.master mrr
                    //2.details mrr
                    $chalan_id =  $this->deliveryChallan($poMaster->id);

                    //main stock table data save
                    $this->stockSave($general_id, $poMaster->id,5);

                    //stock cashing table data save
                    $this->stockSummarySave($poMaster->id);
                    //sale order
                    $poMaster->challan_status =  'Approved';
                }
                 //if delivery challan active and challan auto approval
                if(helper::isDeliveryChallanActive() === false){
                    //main stock table data save
                    $this->stockSave($general_id, $poMaster->id);
                    //stock cashing table data save
                    $this->stockSummarySave($poMaster->id);
                    //sales order
                }

                if($poMaster->payment_type == "Bank"):
                    $this->saleBankPayment($poMaster->id,$request);
                endif;
                //if payment type cash
                if($poMaster->payment_type == "Cash"):
                    $cashAmount = $poMaster->paid_amount;
                    $poMaster->paid_amount = 0;
                    $poMaster->save();
                    $this->salesCreditPayment($poMaster->id,$cashAmount,$poMaster->payment_type,$poMaster->date);
                    //purchases payment journal
                    Journal::salePaymentJournal($general_id,$cashAmount,$poMaster->account_id,$poMaster->date,17);
                    // Journal::salePaymentJournal($poMaster->id,$request->paid_amount,$request->account_id[0],$request->date);
                    $poMaster->sales_status =  'Approved';
                endif;

                $poMaster->sales_status = 'Approved';
                $poMaster->approved_by = helper::userId();
                $poMaster->save();
            else:

                $poMaster->sales_status =$status;
                $poMaster->approved_by = helper::userId();
                $poMaster->save();
            endif;

            // $poMaster->sales_status = 'Approved';
                // $poMaster->save();
             DB::commit();
            // all good
            return $poMaster->id;
        } catch (\Exception $e) {

            DB::rollback();
            return $e->getMessage();
        }

    }



    public function deliveryChallan($sale_id){

        $saleInfo = $this->sales::where('id',$sale_id)->company()->first();
        $customerInfo = Customer::where('id',$saleInfo->customer_id)->first();
        $poMaster =  new DeliveryChallan();
        $poMaster->date = date('Y-m-d');
        $poMaster->customer_id  = $customerInfo->id;
        $poMaster->voucher_no  =  helper::generateInvoiceId("delivery_challans_prefix","delivery_challans");
        $poMaster->branch_id  = $saleInfo->branch_id;
        $poMaster->sales_id   = $saleInfo->id ;
        $poMaster->delivery_location  = $customerInfo->address;
        $poMaster->total_qty  = $saleInfo->total_qty;
        $poMaster->note  = $saleInfo->note;
        $poMaster->receive_status  = 'Approved';
        $poMaster->updated_by = helper::userId();
        $poMaster->company_id = helper::companyId();
        $poMaster->save();

        if($poMaster->id){
       return  $this->deliveryChallanDetails($poMaster->id,$sale_id);
       }


    }


    public function deliveryChallanDetails($masterId,$sale_id){
        DeliveryChallanDetails::where('delivery_challan_id',$masterId)->delete();
       $salesProduct =  SalesDetails::where('sales_id',$sale_id)->company()->get();
        $allDetails = array();
        foreach($salesProduct as $key => $value):
          $masterDetails=array();
          $masterMrrDetails['company_id'] =helper::companyId();
          $masterDetails['delivery_challan_id'] =$masterId;
          $masterDetails['product_id']  =$value->product_id;
          $masterDetails['batch_no']  =$value->batch_no;
          $masterDetails['pack_size']  =$value->pack_size;
          $masterDetails['pack_no']  =$value->pack_no;
          $masterDetails['quantity']  =$value->quantity;
          array_push($allDetails,$masterDetails);
        endforeach;
       $saveInfo =  DeliveryChallanDetails::insert($allDetails);
       return $saveInfo;
    }


    public function saleBankPayment($sale_id,$request){

        $pendingCheque = TemporaryPendingCheck::where('voucher_id',$sale_id)->where('form_id',5)->company()->first();

        if(!empty($pendingCheque)):
            $pendingCheck =  new SalePendingCheque();
            $pendingCheck->company_id = helper::companyId();
            $pendingCheck->voucher_id = $sale_id;
            $pendingCheck->voucher_no = helper::generateInvoiceId("sales_pending_cheque_prefix","sale_pending_cheques");
            $pendingCheck->form_id = 5;//sales
            $pendingCheck->bank_id = $pendingCheque->bank_id;
            $pendingCheck->customer_id = $pendingCheque->customer_supplier_id ?? '';
            $pendingCheck->cheque_date = helper::mysql_date($pendingCheque->cheque_date);
            $pendingCheck->receive_date = helper::mysql_date($pendingCheque->receive_date);
            $pendingCheck->deposit_date =  helper::mysql_date($pendingCheque->deposit_date);
            $pendingCheck->cheque_number =$pendingCheque->cheque_number;
            $pendingCheck->payment = $pendingCheque->payment;
            $pendingCheck->note ="Cheque Payment";//sales
            $pendingCheck->status ="Pending";//cheque approved sales
            $pendingCheck->save();
            TemporaryPendingCheck::where('voucher_id',$sale_id)->delete();
            return $pendingCheck;

        else:

        $pendingCheck =  new SalePendingCheque();
        $pendingCheck->company_id = helper::companyId();
        $pendingCheck->voucher_id = $sale_id;
        $pendingCheck->form_id = 5;//sales
        $pendingCheck->voucher_no = helper::generateInvoiceId("sales_pending_cheque_prefix","sale_pending_cheques");
        $pendingCheck->bank_id =$request->bank_id;
        $pendingCheck->customer_id =$request->customer_id;
        $pendingCheck->receive_date = date('Y-m-d');
        $pendingCheck->deposit_date = $request->deposit_date;
        $pendingCheck->cheque_date = $request->cheque_date;
        $pendingCheck->cheque_number =$request->cheque_number;
        $pendingCheck->payment =$request->paid_amount;
        $pendingCheck->note ="Cheque Payment";//sales
        $pendingCheck->status ="Pending";//cheque approved sales
        $pendingCheck->save();
        return $pendingCheck;

    endif;

     }

    public function salesDebitPayment($sale_id,$payment,$form_id=null)
    {
        if($form_id == 5):
            $saleInfo = $this->sales::find($sale_id);

        elseif($form_id == 17):
            $saleInfo = Pos::find($sale_id);
        else:

        endif;

        $saleDebitPayment =  new SalePayment();
        $saleDebitPayment->date = helper::mysql_date();
        $saleDebitPayment->company_id = helper::companyId(); //sales info
        $saleDebitPayment->form_id  = $form_id;
        $saleDebitPayment->customer_id  = $saleInfo->customer_id;
        $saleDebitPayment->branch_id  = $saleInfo->branch_id;
        $saleDebitPayment->voucher_id  = $saleInfo->id;
        $saleDebitPayment->voucher_no  = helper::generateInvoiceId("sales_payment_prefix","sale_payments");
        $saleDebitPayment->debit  = $payment;
        $saleDebitPayment->note  = 'Sales voucher amount';
        $saleDebitPayment->status  = 'Approved';
        $saleDebitPayment->updated_by = Helper::userId();
        $saleDebitPayment->created_by = Helper::userId();
        $saleDebitPayment->save();
        return $saleDebitPayment->id;
    }


    public function salesCreditPayment($sale_id,$payment,$payment_type,$pendingChequeId=null,$form=null)
    {
      
        if($form == 17):
            $salesInfo = Pos::find($sale_id);
            $dueAmount = $salesInfo->grand_total - ($salesInfo->paid_amount+$payment);
            $salesInfo->paid_amount= $salesInfo->paid_amount+$payment;
            $salesInfo->due_amount= $dueAmount;
            $salesInfo->save();
        elseif($form == 18):
            $salesInfo = Booking::find($sale_id);
            $dueAmount = $salesInfo->grand_total - ($salesInfo->paid_amount+$payment);
            $salesInfo->paid_amount= $salesInfo->paid_amount+$payment;
            $salesInfo->due_amount= $dueAmount;
            if($salesInfo->due_amount <= 0){
            $salesInfo->payment_status = "Approved";
            }
            $salesInfo->save();
        else:
            $salesInfo = $this->sales::find($sale_id);
            $dueAmount = $salesInfo->grand_total - ($salesInfo->paid_amount+$payment);
            $salesInfo->paid_amount= $salesInfo->paid_amount+$payment;
            $salesInfo->due_amount= $dueAmount;
            $salesInfo->save();
        endif;

        if(!empty($pendingChequeId)):
            $chequeInfo =  SalePendingCheque::find($pendingChequeId);
        endif;

        $salesCreditPayment =  new SalePayment();
        $salesCreditPayment->date = helper::mysql_date();
        $salesCreditPayment->company_id = helper::companyId(); //sales info
        $salesCreditPayment->form_id  = $form ?? 0;
        $salesCreditPayment->customer_id  = $salesInfo->customer_id;
        $salesCreditPayment->branch_id  = $salesInfo->branch_id;
        $salesCreditPayment->voucher_id  = $salesInfo->id;
        $salesCreditPayment->payment_type  = $payment_type;
        $salesCreditPayment->voucher_no  = helper::generateInvoiceId("sales_payment_prefix","sale_payments");
        $salesCreditPayment->credit  = $payment;
        $salesCreditPayment->status  = 'Approved';
        if($payment_type == "Cash"):
            $salesCreditPayment->note  = 'Cash sale payment';
         else:
             if(!empty($chequeInfo)):
                 $salesCreditPayment->bank_id  = $chequeInfo->bank_id ?? '';
                 $salesCreditPayment->cheque_number  = $chequeInfo->cheque_number ?? '';
                 $salesCreditPayment->cheque_date  =  $chequeInfo->cheque_date ?? '';
                 $salesCreditPayment->note  = 'Cheque sale payment';
             endif;
         endif;
        $salesCreditPayment->updated_by = Helper::userId();
        $salesCreditPayment->created_by = Helper::userId();
        $salesCreditPayment->save();
        return $salesCreditPayment->id;
    }

    public function masterDetails($masterId, $request)
    {
        salesDetails::where('sales_id', $masterId)->company()->delete();
        $productInfo = $request->product_id;
        $allDetails = array();
        $costOfGoods=0;
        foreach ($productInfo as $key => $value) :
            $masterDetails = array();
            $masterDetails['sales_id'] = $masterId;
            $masterDetails['company_id'] = helper::companyId();
            $masterDetails['date'] = helper::mysql_date($request->date);
            $masterDetails['branch_id']  = $request->branch_id ?? helper::getDefaultBranch();
            $masterDetails['store_id']  = $request->store_id ?? helper::getDefaultStore();
            $masterDetails['product_id']  = $request->product_id[$key];
            $masterDetails['batch_no']  = $request->batch_no[$key] ?? helper::getProductBatchById($request->product_id[$key]);
            $masterDetails['pack_size']  = $request->pack_size[$key] ?? $request->quantity[$key];
            $masterDetails['pack_no']  = $request->pack_no[$key] ?? 1;
            $masterDetails['quantity']  = $request->quantity[$key];
            $masterDetails['unit_price']  = $request->unit_price[$key];
            $masterDetails['total_price']  = $request->total_price[$key];
            array_push($allDetails, $masterDetails);
            $singleProductAvgPrice =helper::productAvg($masterDetails['product_id'],$masterDetails['batch_no']);
            $costOfGoods+=$singleProductAvgPrice*$request->quantity[$key];
        endforeach;
           salesDetails::insert($allDetails);
        return $costOfGoods;
    }


    public function generalSave($sale_id,$form_id)
    {
        if($form_id == 5):
            $salesInfo = $this->sales::find($sale_id);
        else:
            $salesInfo = Pos::find($sale_id);
        endif;

        $general =  new General();
        $general->date = helper::mysql_date($salesInfo->date);
        $general->form_id = $form_id; //purchases info
        $general->branch_id  = $salesInfo->branch_id ?? helper::getDefaultBranch();
        $general->store_id  = $salesInfo->store_id ?? helper::getDefaultStore();
        $general->voucher_id  = $sale_id;
        $general->debit  = $salesInfo->grand_total;
        $general->status  = 'Approved';
        $general->updated_by = helper::userId();
        $general->company_id = helper::companyId();
        $general->save();
        return $general->id;
    }

    public function stockSave($general_id, $sale_id,$form_id=null,$challan_id=null)
    {

        if($form_id == 17):
            $salesDetails = PosDetails::where('pos_id', $sale_id)->company()->get();
            // dd($salesDetails);
        else:
            $salesDetails = SalesDetails::where('sales_id', $sale_id)->company()->get();
        endif;

        
        $allStock = array();
        foreach ($salesDetails as $key => $value) :
            $generalStock = array();
            $generalStock['date'] = helper::mysql_date($value->date);
            $generalStock['company_id'] = helper::companyId();
            $generalStock['general_id'] = $general_id;
            $generalStock['delivery_challan_id'] = $challan_id ?? 0;
            $generalStock['branch_id']  = $value->branch_id ?? helper::getDefaultBranch();
            $generalStock['store_id']  = $value->store_id ?? helper::getDefaultStore();
            $generalStock['product_id']  = $value->product_id;
            $generalStock['type']  = "out";
            $generalStock['batch_no']  = $value->batch_no;
            $generalStock['pack_size']  = $value->pack_size;
            $generalStock['pack_no']  = $value->pack_no;
            $generalStock['quantity']  = $value->quantity;
            $generalStock['unit_price']  = $value->unit_price;
            $generalStock['total_price']  = $value->total_price;
            array_push($allStock, $generalStock);
        endforeach;
          $stockInfo = Stock::insert($allStock);

        return $stockInfo;
    }


    public function getCostOfGoods($sale_id)
    {

        $salesDetails = SalesDetails::where('sales_id', $sale_id)->company()->get();
        $costOfGoods=0;
        foreach ($salesDetails as $key => $value) :
            $singleProductAvgPrice = helper::productAvg($value->product_id,$value->batch_no);
            $costOfGoods+=$singleProductAvgPrice*$value->quantity;
        endforeach;
        return $costOfGoods;
    }


    public function stockSummarySave($sales_id,$form_id = null)
    {
        if($form_id == 17):
            $salesDetails = PosDetails::where('pos_id', $sales_id)->company()->get();
        else:
            $salesDetails = SalesDetails::where('sales_id', $sales_id)->company()->get();
        endif;
        foreach ($salesDetails as $key => $value) :
            $stockSummaryExits =  StockSummary::where('company_id', helper::companyId())->where('product_id', $value->product_id)->first();
            if (empty($stockSummaryExits)) {
                $stockSummary = new StockSummary();
                $stockSummary->quantity = $value->quantity;
            } else {
                $stockSummary = $stockSummaryExits;
                $stockSummary->quantity = $stockSummary->quantity - $value->quantity;
            }
            $stockSummary->company_id = helper::companyId();
            $stockSummary->branch_id = $value->branch_id ?? helper::getDefaultBranch();
            $stockSummary->store_id = $value->store_id ?? helper::getDefaultStore();
            $stockSummary->product_id = $value->product_id;
            $stockSummary->category_id = helper::getRow('products','id',$value->product_id,'category_id');
            $stockSummary->brand_id = helper::getRow('products','id',$value->product_id,'brand_id');
            $stockSummary->batch_no = $value->batch_no;
            $stockSummary->pack_size = $value->pack_size;
            $stockSummary->pack_no = $value->pack_no;
            $stockSummary->save();
        endforeach;
        return true;
    }




    public function update($request, $id)
    {
        DB::beginTransaction();

        try {
            $poMaster = $this->sales::findOrFail($id);
            $poMaster->date = date('Y-m-d', strtotime($request->date));
            $poMaster->payment_type  = $request->payment_type;
            $poMaster->customer_id  = $request->customer_id;
            $poMaster->branch_id  = $request->branch_id;
            $poMaster->voucher_no  = $request->voucher_no;
            $poMaster->grand_total  = array_sum($request->total_price);
            $poMaster->note  = $request->note;
            $poMaster->sales_status  = 'Pending';
            $poMaster->updated_by = helper::userId();
            $poMaster->company_id = helper::companyId();
            $poMaster->save();
            if ($poMaster->id) {
                if(!empty($request->documents))
                $poMaster->documents = helper::upload($request->documents,500,500,'sales',$poMaster->id);
                $poMaster->save();
                $this->masterDetails($poMaster->id, $request);
                $this->salesQuatationUpdate($request->sales_quatation_id);
                //general table data save
                $general_id = $this->generalSave($poMaster->id, $request);
                //main stock table data save
                $this->stockSave($general_id, $poMaster->id);
                //stock cashing table data save
                $this->stockSummarySave($poMaster->id);
            }
            DB::commit();
            // all good
            return $poMaster->id;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }


    public function salesQuatationUpdate($salesQuatationId)
    {

        if (!empty($salesQuatationId)) {
            foreach ($salesQuatationId as $key => $value) :
                $salesQuatation =  SalesQuatation::findOrFail($value);
                $salesQuatation->sales_status = 'Approved';
                $salesQuatation->save();
            endforeach;
        }
        return true;
    }


    public function statusUpdate($id, $status)
    {
        $sales = $this->sales::find($id);
        $sales->status = $status;
        $sales->save();
        return $sales;
    }


    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $sales = $this->sales::find($id);

            if($sales->sales_status == 'Pending'):
            $sales->delete();
            SalesDetails::where('sales_id', $id)->delete();
            endif;

            DB::commit();
            // all good
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }


    public function getActiveBatch(){
      $batch =  StockSummary::with("batch")->company()->groupBy("product_id")->groupBy("batch_no")->havingRaw('quantity > 0')->get();
      return $batch;

    }


}
