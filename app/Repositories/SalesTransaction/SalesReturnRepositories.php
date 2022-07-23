<?php

namespace App\Repositories\SalesTransaction;
use App\Helpers\Helper;
use App\Models\General;
use App\Models\GeneralLedger;
use App\Models\SalePayment;
use Illuminate\Support\Facades\Auth;
use App\Models\SalesDetails;
use App\Models\Sales;
use App\Models\Stock;
use App\Models\StockSummary;
use App\Models\SaleReturn;
use App\Models\SaleReturnDetail;
use DB;

class SalesReturnRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var SaleReturn
     */
    private $salesReturn;
    /**
     * SalesRepositories constructor.
     * @param SaleReturn $sales
     */
    public function __construct(SaleReturn $saleReturn)
    {
        $this->salesReturn = $saleReturn;

    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('salesTransaction.salesReturn.edit') ? 1 : 0;
        $delete = Helper::roleAccess('salesTransaction.salesReturn.destroy') ? 1 : 0;
        $show = Helper::roleAccess('salesTransaction.salesReturn.show') ? 1 : 0;
        $ced = $edit + $delete + $show;

        $totalData = $this->salesReturn::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $salessReturn = $this->salesReturn::select($columns)->company()->with('sreturnDetails','customer','branch')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->salesReturn::count();
        } else {
            $search = $request->input('search.value');
            $salessReturn = $this->salesReturn::select($columns)->company()->with('sreturnDetails','customer','branch')->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->salesReturn::select($columns)->company()->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }

        foreach($salessReturn as $key => $value):
            if(!empty($value->customer_id))
               $value->customer_id = $value->customer->name ?? '';

            if(!empty($value->branch_id))
               $value->branch_id  = $value->branch->name ?? '';
        endforeach;

        $columns = Helper::getQueryProperty();
        $data = array();
        if ($salessReturn) {
            foreach ($salessReturn as $key => $sales) {
                $nestedData['id'] = $key + 1;
                foreach ($columns as $key => $value) :
                    if ($value == 'status') :
                        $nestedData['status'] = helper::statusBar($sales->status);
                        elseif($value == 'voucher_no'):
                            $nestedData[$value] = '<a target="_blank" href="' . route('salesTransaction.salesReturn.show', $sales->id) . '" show_id="' . $sales->id . '" title="Details" class="">'.$sales->voucher_no.'</a>';
                    else :
                        $nestedData[$value] = $sales->$value;
                    endif;
                endforeach;
                if ($ced != 0) :
                    if ($edit != 0)
                        if($sales->$value == 'Pending'):
                        $edit_data = '<a href="' . route('salesTransaction.salesReturn.edit', $sales->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                        else:
                            $edit_data = '';
                        endif;
                        else
                        $edit_data = '';
                        $show_data = '<a href="' . route('salesTransaction.salesReturn.show', $sales->id) . '" show_id="' . $sales->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $sales->id . '"><i class="fa fa-search-plus"></i></a>';
                    if ($delete != 0)
                    if($sales->$value == 'Pending'):
                        $delete_data = '<a delete_route="' . route('salesTransaction.salesReturn.destroy', $sales->id) . '" delete_id="' . $sales->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $sales->id . '"><i class="fa fa-times"></i></a>';
                    else:
                        $delete_data = '';
                    endif;
                    else
                        $delete_data = '';
                    $nestedData['action'] = $edit_data . ' ' . $delete_data . ' ' .$show_data;
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
        $result = Sales::select("*")->with([
            'salesDetails' => function($q){
              $q->select('id','sales_id','branch_id','batch_no','date','pack_size','pack_no','discount','quantity','approved_quantity','return_quantity','unit_price','total_price','company_id','product_id');
          },'salesDetails.product' => function($q){
            $q->select('id','code','name','category_id','status','brand_id','company_id');
        },'salesDetails.batch' => function($q){
            $q->select('id','name','company_id');
        },
        'customer' => function($q){
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
        $result = SaleReturn::select("*")->with([
            'sreturnDetails' => function($q){
              $q->select('id','sreturn_id','branch_id','batch_no','date','pack_size','pack_no','deduction_percent','quantity','unit_price','total_price','company_id','product_id','deduction_amount');
          },'sreturnDetails.product' => function($q){
            $q->select('id','code','name','category_id','status','brand_id','company_id');
        },'customer' => function($q){
            $q->select('id','code','contact_person','branch_id','name','email','phone','address');
        },'branch' => function($q){
            $q->select('id','name','email','phone','address');
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
        }
        ])->company()->where('id', $id)->first();
          return $result;
    }
   /**
     * @param $request
     * @return mixed
     */
    public function salesList($search)
    {
        $result = Sales::with('customer')
        ->where('voucher_no', 'like', '%' .$search . '%')
        ->orWhereHas('customer', function($q) use($search) {
            $q->where('name', 'like', '%' .$search . '%')
            ->orWhere('phone', 'like', '%' .$search . '%')
            ->orWhere('email', 'like', '%' .$search . '%');
        })
        ->company()
        ->limit(5)
        ->get();
        $response = array();
        foreach($result as $key =>  $eachVoucher){
           $voucherInfo = 'Voucher Id: '.$eachVoucher->voucher_no.' Name: '. $eachVoucher->customer->name ?? '  N/A' .' Phone '.$eachVoucher->customer->phone ?? 'N/A';
           $response[] = array("value"=>$eachVoucher->id,"label"=>$voucherInfo);
        }


          return $response;
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

                $saleInfo =  $this->details($request->sale_id);
              
                $poMaster =  new $this->salesReturn();
                $poMaster->date = date('Y-m-d');
                $poMaster->payment_type  = $request->payment_type;
                $poMaster->customer_id  = $saleInfo->customer_id;
                $poMaster->sale_id  = $request->sale_id;
                $poMaster->branch_id  = $saleInfo->branch_id;
                $poMaster->voucher_no  = helper::generateInvoiceId("sales_return_prefix","sale_returns"); // $saleInfo->voucher_no
                $poMaster->subtotal  = $request->sub_total;
                $poMaster->documents  = $request->documents;
                $poMaster->deduction_amount  = $request->deduction_amount;
                $poMaster->deduction_percen  = array_sum($request->deduction);
                $poMaster->total_qty  = array_sum($request->return_quantity);
                $poMaster->grand_total  = $request->grand_total;
                $poMaster->note  = $request->note;
                $poMaster->status  = 'Approved';
                $poMaster->created_by = Auth::user()->id;
                $poMaster->company_id = Auth::user()->company_id;
                $poMaster->save();
                if($poMaster->id){
                    $costOfGoodSold = $this->masterDetails($poMaster->id,$request);

                        if(helper::isSalesReturnApprovalAuto()):
                            //sales return credit payment
                            $this->salesReturnCreditPayment($poMaster->id,$request->grand_total);
                            //general table data save
                            $general_id = $this->generalSave($poMaster->id,$request);
                            //sales return Journal
                            $this->saleReturnJournal($general_id,$request,$costOfGoodSold);
                            //sales payment journal

                            // if payment type cash    
                            if($request->payment_type == "Cash"):
                                        
                                $this->salesReturnCashtPayment($poMaster->id,$request->paid_amount);
                                $this->saleReturnCashPaymentJournal($general_id,$request->paid_amount,$request->account_id[0],$request->date,6);
                                // if payment type cash
                            endif;

                             //main stock table data save
                             $this->stockSave($general_id,$poMaster->id);
                             //stock cashing table data save
                             $this->stockSummarySave($poMaster->id);
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
            $poMaster = $this->salesReturn::find($id);
            if($status == 'Approved'):
            //sales return credit payment
            $this->salesReturnCreditPayment($poMaster->id,$poMaster->grand_total);
            //general table data save
            $general_id = $this->generalSave($poMaster->id,$request);
            //sales return Journal
            $this->saleReturnJournal($general_id,$request);
            //sales payment journal
            $this->saleReturnPaymentJournal($general_id,$request);
            //main stock table data save
            $this->stockSave($general_id,$poMaster->id);
            //stock cashing table data save
            $this->stockSummarySave($poMaster->id);
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

    public function salesReturnCreditPayment($saleReturn_id,$payment)
    {
        $salesInfo = $this->salesReturn::find($saleReturn_id);
        $salesReturnCreditPayment =  new SalePayment();
        $salesReturnCreditPayment->date = helper::mysql_date();
        $salesReturnCreditPayment->company_id = helper::companyId(); //sales info
        $salesReturnCreditPayment->form_id  = 6;
        $salesReturnCreditPayment->customer_id  = $salesInfo->customer_id;
        $salesReturnCreditPayment->branch_id  = $salesInfo->branch_id;
        $salesReturnCreditPayment->voucher_id  = $salesInfo->id;
        $salesReturnCreditPayment->payment_type  = 'Cash';
        $salesReturnCreditPayment->voucher_no  = helper::generateInvoiceId("sales_payment_prefix","sale_payments");
        $salesReturnCreditPayment->debit  = $payment;
        $salesReturnCreditPayment->status  = 'Approved';
        $salesReturnCreditPayment->note  = 'Sale Return';
        $salesReturnCreditPayment->updated_by = Helper::userId();
        $salesReturnCreditPayment->created_by = Helper::userId();
        $salesReturnCreditPayment->save();
        return $salesReturnCreditPayment->id;
    }
    public function salesReturnCashtPayment($saleReturn_id,$payment)
    {
        $salesInfo = $this->salesReturn::find($saleReturn_id);
        $salesReturnCreditPayment =  new SalePayment();
        $salesReturnCreditPayment->date = helper::mysql_date();
        $salesReturnCreditPayment->company_id = helper::companyId(); //sales info
        $salesReturnCreditPayment->form_id  = 6;
        $salesReturnCreditPayment->customer_id  = $salesInfo->customer_id;
        $salesReturnCreditPayment->branch_id  = $salesInfo->branch_id;
        $salesReturnCreditPayment->voucher_id  = $salesInfo->id;
        $salesReturnCreditPayment->payment_type  = 'Cash';
        $salesReturnCreditPayment->voucher_no  = helper::generateInvoiceId("sales_payment_prefix","sale_payments");
        $salesReturnCreditPayment->credit  = $payment;
        $salesReturnCreditPayment->status  = 'Approved';
        $salesReturnCreditPayment->note  = 'Sale Return';
        $salesReturnCreditPayment->updated_by = Helper::userId();
        $salesReturnCreditPayment->created_by = Helper::userId();
        $salesReturnCreditPayment->save();
        return $salesReturnCreditPayment->id;
    }

    public function masterDetails($masterId,$request){
        $productInfo = $request->product_id;
        $allDetails = array();
        $costOfGoods=0;
        foreach($productInfo as $key => $value):
          $masterDetails=array();
          if(!empty($request->return_quantity[$key])):
            $saleItemInfo =  salesDetails::where('sales_id',$request->sale_id)->where('product_id',$request->product_id[$key])->company()->first();
            $masterDetails['company_id'] = helper::companyId();
            $masterDetails['date'] =date('Y-m-d');
            $masterDetails['sreturn_id'] =$masterId;
            $masterDetails['branch_id']  =$saleItemInfo->branch_id;
            $masterDetails['store_id']  =$saleItemInfo->store_id;
            $masterDetails['product_id']  =$request->product_id[$key];
            $masterDetails['batch_no']  =$saleItemInfo->batch_no;
            $masterDetails['pack_size']  =$saleItemInfo->pack_size ?? 0;
            $masterDetails['pack_no']  =$saleItemInfo->pack_no ?? 0;
            $masterDetails['quantity']  =$request->return_quantity[$key];
            $masterDetails['deduction_percent']  =$request->deduction[$key];
            $masterDetails['deduction_amount']  =$request->deduction_percen_amount[$key];
            $masterDetails['unit_price']  =$saleItemInfo->unit_price;
            $masterDetails['total_price']  =$saleItemInfo->unit_price*$request->return_quantity[$key];
            array_push($allDetails,$masterDetails);
            //update sales details table.
            $saleItemInfo->return_quantity = $saleItemInfo->return_quantity + $request->return_quantity[$key];

            $singleProductAvgPrice =helper::productAvg($masterDetails['product_id'],$masterDetails['batch_no']);
          
            $costOfGoods+=$singleProductAvgPrice*$request->return_quantity[$key];
            $saleItemInfo->save();
            
          endif;
        endforeach;
            SaleReturnDetail::insert($allDetails);
       return  $costOfGoods;
    }


    public function saleReturnJournal($masterLedgerId,$request,$costOfGoods=null){

        $generalInfo=General::find($masterLedgerId);
        //account Receiable = credit
         $accountReceiveable = new GeneralLedger();
         $accountReceiveable->company_id = helper::companyId();
         $accountReceiveable->general_id = $masterLedgerId;
         $accountReceiveable->form_id = 6;
         $accountReceiveable->account_id = 12;//account receiable come from chartOfAccount
         $accountReceiveable->date = date('Y-m-d',strtotime($request->date));
         $accountReceiveable->credit = $generalInfo->debit;
         $accountReceiveable->memo ='Account Receivable';
         $accountReceiveable->created_by =helper::userId();
         $accountReceiveable->save();
         //sales = debit
         $sales = new GeneralLedger();
         $sales->company_id = helper::companyId();
         $sales->general_id = $masterLedgerId;
         $sales->form_id =6;
         $sales->account_id = 44;//purchases stock or inventory stock
         $sales->date = date('Y-m-d',strtotime($request->date));
         $sales->debit = $generalInfo->debit;
         $sales->memo ='Sales Return';
         $sales->created_by =helper::userId();
         $sales->save();
        //sales = debit
         $purchases = new GeneralLedger();
         $purchases->company_id = helper::companyId();
         $purchases->general_id = $masterLedgerId;
         $purchases->form_id = 6;
         $purchases->account_id = 4;//account payable come from chartOfAccount
         $purchases->date = date('Y-m-d',strtotime($request->date));
         $purchases->debit = $costOfGoods;
         $purchases->memo ='Sales return';
         $purchases->created_by =helper::userId();
         $purchases->save();
         //cost of good sold = credit
         $costOfGoodSols = new GeneralLedger();
         $costOfGoodSols->company_id = helper::companyId();
         $costOfGoodSols->general_id = $masterLedgerId;
         $costOfGoodSols->form_id =6;
         $costOfGoodSols->account_id = 52;//purchases stock or inventory stock
         $costOfGoodSols->date = date('Y-m-d',strtotime($request->date));
         $costOfGoodSols->credit = $costOfGoods;
         $costOfGoodSols->memo ='Cost Of Goods Sold';
         $costOfGoodSols->created_by =helper::userId();
         $costOfGoodSols->save();
     }

     public static function saleReturnCashPaymentJournal($masterLedgerId,$paidAmount,$accountId,$date,$from_id=null)
     {
 
         //account receivable = debit
         $accountReceiveable = new GeneralLedger();
         $accountReceiveable->company_id = helper::companyId();
         $accountReceiveable->general_id = $masterLedgerId;
         $accountReceiveable->form_id = $from_id;
         $accountReceiveable->account_id = 12; //account receiable come from chartOfAccount
         $accountReceiveable->date = helper::mysql_date($date);
         $accountReceiveable->debit = $paidAmount;
         $accountReceiveable->memo = 'Account Receivable';
         $accountReceiveable->created_by = helper::userId();
         $accountReceiveable->save();
         //cash or bank = credit
         $cashOrBank = new GeneralLedger();
         $cashOrBank->company_id = helper::companyId();
         $cashOrBank->general_id = $masterLedgerId;
         $cashOrBank->form_id = $from_id;
         $cashOrBank->account_id = $accountId; //cash in hand
         $cashOrBank->date = helper::mysql_date($date);
         $cashOrBank->credit = $paidAmount;
         $cashOrBank->memo = 'Cash or bank credit';
         $cashOrBank->created_by = helper::userId();
         $cashOrBank->save();
     }
     public function saleReturnPaymentJournal($masterLedgerId,$request){
        $generalInfo=General::find($masterLedgerId);
         //account receivable = debit
         $accountReceiveable = new GeneralLedger();
         $accountReceiveable->company_id = helper::companyId();
         $accountReceiveable->general_id = $masterLedgerId;
         $accountReceiveable->form_id = 6;
         $accountReceiveable->account_id = 12;//account receiable come from chartOfAccount
         $accountReceiveable->date = date('Y-m-d',strtotime($request->date));
         $accountReceiveable->credit = $generalInfo->debit;
         $accountReceiveable->memo ='Account Payable';
         $accountReceiveable->created_by =helper::userId();
         $accountReceiveable->save();
         //cash or bank = credit
         $cashOrBank = new GeneralLedger();
         $cashOrBank->company_id = helper::companyId();
         $cashOrBank->general_id = $masterLedgerId;
         $cashOrBank->form_id = 6;
         $cashOrBank->account_id = 7;//purchases stock or inventory stock
         $cashOrBank->date = date('Y-m-d',strtotime($request->date));
         $cashOrBank->debit = $generalInfo->debit;
         $cashOrBank->memo ='return Stock';
         $cashOrBank->created_by =helper::userId();
         $cashOrBank->save();
     }


    public function generalSave($return_id){
        $salesInfo = $this->salesReturn::find($return_id);
        $general =  new General();
        $general->date = date('Y-m-d');
        $general->form_id = 6;//purchases info
        $general->branch_id  = $salesInfo->branch_id ?? helper::getDefaultBranch();
        $general->store_id  = $salesInfo->store_id ?? helper::getDefaultStore();
        $general->voucher_id  = $return_id;
        $general->debit  = $salesInfo->grand_total;
        $general->status  ='Approved';
        $general->updated_by = helper::userId();
        $general->company_id = helper::companyId();
        $general->save();
        return $general->id;

    }

    public function stockSave($general_id,$sale_id){
        $salesReturnDetails = SaleReturnDetail::where('sreturn_id',$sale_id)->get();
        $allStock = array();
        foreach($salesReturnDetails as $key => $value):
          $generalStock=array();
          $generalStock['date'] =date('Y-m-d');
          $generalStock['company_id'] =helper::companyId();
          $generalStock['general_id'] =$general_id;
          $generalStock['product_id']  =$value->product_id;
          $generalStock['branch_id']  = $value->branch_id ?? helper::getDefaultBranch();
          $generalStock['store_id']  = $value->store_id ?? helper::getDefaultStore();
          $generalStock['batch_no']  =$value->batch_no;
          $generalStock['type']  ='rin';
          $generalStock['pack_size']  =$value->pack_size;
          $generalStock['pack_no']  =$value->pack_no;
          $generalStock['quantity']  =$value->quantity;
          $generalStock['unit_price']  =$value->unit_price;
          $generalStock['total_price']  =$value->total_price;
          array_push($allStock,$generalStock);
        endforeach;
       $saveInfo =  Stock::insert($allStock);
       return $saveInfo;
    }

    public function stockSummarySave($sales_id){
        $salesReturnDetails = SaleReturnDetail::where('sreturn_id',$sales_id)->get();
        foreach($salesReturnDetails as $key => $value):
            $stockSummaryExits =  StockSummary::where('company_id',helper::companyId())->where('product_id',$value->product_id)->first();
            if(empty($stockSummaryExits)){
                //new entry row
                $stockSummary = new StockSummary();
                $stockSummary->quantity = $value->quantity;
            }else{
                //update exitsting row
                $stockSummary = $stockSummaryExits;
                $stockSummary->quantity =$stockSummary->quantity+$value->quantity;
            }
            $stockSummary->branch_id = $value->branch_id ?? helper::getDefaultBranch();
            $stockSummary->store_id = $value->store_id ?? helper::getDefaultStore();
            $stockSummary->company_id = helper::companyId();
            $stockSummary->product_id = $value->product_id;
            $stockSummary->batch_no = $value->batch_no;
            $stockSummary->pack_size = $value->pack_size;
            $stockSummary->pack_no = $value->pack_no;
            $stockSummary->save();
        endforeach;
        return true;
    }


}
