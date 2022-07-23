<?php

namespace App\Repositories\SalesTransaction;
use App\Helpers\Helper;
use App\Models\General;
use App\Models\GeneralLedger;
use App\Models\SalePayment;
use Illuminate\Support\Facades\Auth;
use App\Models\SalesLoanReturnDetails;
use App\Models\SalesLoanReturn;
use App\Models\Stock;
use App\Models\StockSummary;
use App\Models\SalesLon;
use App\Models\SalesLonDetails;
use App\Helpers\Journal;
use DB;

class SalesLoanReturnRepositories
{
   
    public function __construct(SalesLoanReturn $salesLoanReturn)
    {
        $this->salesLoanReturn = $salesLoanReturn;

    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('salesTransaction.salesLoanReturn.edit') ? 1 : 0;
        $delete = Helper::roleAccess('salesTransaction.salesLoanReturn.destroy') ? 1 : 0;
        $show = Helper::roleAccess('salesTransaction.salesLoanReturn.show') ? 1 : 0;
        $ced = $edit + $delete + $show;

        $totalData = $this->salesLoanReturn::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $salesLoansReturn = $this->salesLoanReturn::select($columns)->company()->with('slreturnDetails','customer','branch')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->salesLoanReturn::count();
        } else {
            $search = $request->input('search.value');
            $salesLoansReturn = $this->salesLoanReturn::select($columns)->company()->with('slreturnDetails','customer','branch')->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->salesLoanReturn::select($columns)->company()->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }

        foreach($salesLoansReturn as $key => $value):
            if(!empty($value->customer_id))
               $value->customer_id = $value->customer->name ?? '';

            if(!empty($value->branch_id))
               $value->branch_id  = $value->branch->name ?? '';
        endforeach;

        $columns = Helper::getQueryProperty();
        $data = array();
        if ($salesLoansReturn) {
            foreach ($salesLoansReturn as $key => $sales) {
                $nestedData['id'] = $key + 1;
                foreach ($columns as $key => $value) :
                    if ($value == 'status') :
                        $nestedData['status'] = helper::statusBar($sales->status);
                        elseif($value == 'voucher_no'):
                            $nestedData[$value] = '<a target="_blank" href="' . route('salesTransaction.salesLoanReturn.show', $sales->id) . '" show_id="' . $sales->id . '" title="Details" class="">'.$sales->voucher_no.'</a>';
                    else :
                        $nestedData[$value] = $sales->$value;
                    endif;
                endforeach;
                if ($ced != 0) :
                    if ($edit != 0)
                        if($sales->$value == 'Pending'):
                        $edit_data = '<a href="' . route('salesTransaction.salesLoanReturn.edit', $sales->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                        else:
                            $edit_data = '';
                        endif;
                        else
                        $edit_data = '';
                        $show_data = '<a href="' . route('salesTransaction.salesLoanReturn.show', $sales->id) . '" show_id="' . $sales->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $sales->id . '"><i class="fa fa-search-plus"></i></a>';
                    if ($delete != 0)
                    if($sales->$value == 'Pending'):
                        $delete_data = '<a delete_route="' . route('salesTransaction.salesLoanReturn.destroy', $sales->id) . '" delete_id="' . $sales->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $sales->id . '"><i class="fa fa-times"></i></a>';
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
        $result = SalesLon::select("*")->with([
            'salesLoanDetails' => function($q){
              $q->select('id','sales_lons_id','branch_id','batch_no','date','pack_size','pack_no','discount','quantity','approved_quantity','return_quantity','unit_price','total_price','company_id','product_id');
          },'salesLoanDetails.product' => function($q){
            $q->select('id','code','name','category_id','status','brand_id','company_id');
        },'salesLoanDetails.batch' => function($q){
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
        $result = SalesLoanReturn::select("*")->with([
            'slreturnDetails' => function($q){
              $q->select('id','slreturn_id','branch_id','batch_no','date','pack_size','pack_no','deduction_percent','quantity','unit_price','total_price','company_id','product_id','deduction_amount');
          },'slreturnDetails.product' => function($q){
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
    public function salesLoanList($search)
    {
        $result = SalesLon::with('customer')
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
    public function salesLoanDetails($salesLoanId)
    {
        $salesInfo = SalesLon::with('salesLoanDetails')->where('id', $salesLoanId)->get();
        return $salesInfo;
    }


    public function store($request)
    {
      

        DB::beginTransaction();
        try {
           
                $saleInfo =  $this->details($request->sales_lons_id);
              // dd($saleInfo);
                $poMaster =  new $this->salesLoanReturn();
                $poMaster->date = date('Y-m-d');
                $poMaster->customer_id  = $saleInfo->customer_id;
                $poMaster->sales_lons_id  = $request->sales_lons_id ?? 0;
                $poMaster->branch_id  = $saleInfo->branch_id;
                $poMaster->voucher_no  = helper::generateInvoiceId("sales_loan_return_prefix","sales_loan_returns"); // $saleInfo->voucher_no
                $poMaster->subtotal  = $request->sub_total;
                $poMaster->documents  = $request->documents;
                $poMaster->total_qty  = array_sum($request->return_quantity);
                $poMaster->note  = $request->note;
                $poMaster->status  = 'Approved';
                $poMaster->created_by = Auth::user()->id;
                $poMaster->company_id = Auth::user()->company_id;
                $poMaster->save();
                
                if($poMaster->id){
                    // $costOfGoodSold = $this->masterDetails($poMaster->id,$request);

                 
                    $totalPrice = $this->masterDetails($poMaster->id,$request);
                    $poMaster->grand_total = $totalPrice;
                    $poMaster->save();
                            //general table data save
                            $general_id = $this->generalSave($poMaster->id,$request);
                            
                            //general ledger Journal
                           Journal::salesLoanReturnLedgerSave($general_id, $poMaster->grand_total,$request->date,12);
                       
                             //main stock table data save
                             $this->stockSave($general_id,$poMaster->id);
                             //stock cashing table data save
                             $this->stockSummarySave($poMaster->id);
                             $poMaster->status  = 'Approved';
                             $poMaster->save();

                            }
                    DB::commit();
                    // all good
                    return $poMaster->id ;
                } catch (\Exception $e) {
                     dd($e->getMessage());
                    // DB::rollback();
                    return $e->getMessage();
                }
    }

    

   

    public function masterDetails($masterId,$request){
      
        $productInfo = $request->product_id;
        $allDetails = array();
        $costOfGoods=0;
        foreach($productInfo as $key => $value):

            if(!empty($request->batch_no) && count($request->batch_no) > 0): 
            
            $pbatch = $request->batch_no[$key] ?? helper::getProductBatchById($request->product_id[$key]);
            else: 
             
                $pbatch = helper::getProductBatchById($request->product_id[$key]);
               
            endif;
           
            $unitPrice =  helper::productAvg($request->product_id[$key],$pbatch);
          $masterDetails=array();
          if(!empty($request->return_quantity[$key])):
            $saleItemInfo =  SalesLonDetails::where('sales_lons_id',$request->sales_lons_id)->where('product_id',$request->product_id[$key])->company()->first();
            $masterDetails['company_id'] = helper::companyId();
            $masterDetails['date'] =date('Y-m-d');
            $masterDetails['slreturn_id'] =$masterId;
            $masterDetails['branch_id']  =$saleItemInfo->branch_id;
            $masterDetails['store_id']  =$saleItemInfo->store_id;
            $masterDetails['product_id']  =$request->product_id[$key];
            $masterDetails['batch_no']  =$saleItemInfo->batch_no ?? '';
            $masterDetails['pack_size']  =$saleItemInfo->pack_size ?? 0;
            $masterDetails['pack_no']  =$saleItemInfo->pack_no ?? 0;
            $masterDetails['quantity']  =$request->return_quantity[$key];
            $masterDetails['unit_price']  =  $unitPrice;
            $masterDetails['total_price']  =  $unitPrice*$request->quantity[$key];
            array_push($allDetails,$masterDetails);
            //update sales loan details table.
            $saleItemInfo->return_quantity = $saleItemInfo->return_quantity + $request->return_quantity[$key];

            $singleProductAvgPrice =helper::productAvg($masterDetails['product_id'],$masterDetails['batch_no']);
          
            $costOfGoods+=$singleProductAvgPrice*$request->return_quantity[$key];
            $saleItemInfo->save();

          endif;
        endforeach;
            SalesLoanReturnDetails::insert($allDetails);
       return  $costOfGoods;
    }



    public function generalSave($return_id){
        $salesInfo = $this->salesLoanReturn::find($return_id);
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
        $salesLoanReturnDetails = SalesLoanReturnDetails::where('slreturn_id',$sale_id)->get();
        $allStock = array();
        foreach($salesLoanReturnDetails as $key => $value):
          $generalStock=array();
          $generalStock['date'] =date('Y-m-d');
          $generalStock['company_id'] =helper::companyId();
          $generalStock['general_id'] =$general_id;
          $generalStock['product_id']  =$value->product_id;
          $generalStock['branch_id']  = $value->branch_id ?? helper::getDefaultBranch();
          $generalStock['store_id']  = $value->store_id ?? helper::getDefaultStore();
          $generalStock['batch_no']  = $value->batch_no;
          $generalStock['type']  ='lin';
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
        $salesLoanReturnDetails = SalesLoanReturnDetails::where('slreturn_id',$sales_id)->get();
        foreach($salesLoanReturnDetails as $key => $value):
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
