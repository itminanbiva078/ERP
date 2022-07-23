<?php

namespace App\Repositories\SalesTransaction;

use App\Helpers\Helper;
use App\Helpers\Journal;
use App\Models\Customer;
use App\Models\DeliveryChallan;
use App\Models\DeliveryChallanDetails;
use App\Models\General;
use App\Models\GeneralLedger;
use App\Models\SalePayment;
use App\Models\SalePendingCheque;
use Illuminate\Support\Facades\Auth;
use App\Models\SalesLonDetails;
use App\Models\SalesLon;
use App\Models\Stock;
use App\Models\StockSummary;
use App\Models\SalesQuatation;
use DB;

class SalesLoanRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var SalesLon
     */
    private $salesLon;
    /**
     * SalesRepositories constructor.
     * @param Sales $sales
     */
    public function __construct(SalesLon $salesLon)
    {
        $this->salesLon = $salesLon;

    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns, "id");
        $edit = Helper::roleAccess('salesTransaction.salesLoan.edit') ? 1 : 0;
        $delete = Helper::roleAccess('salesTransaction.salesLoan.destroy') ? 1 : 0;
        $show = Helper::roleAccess('salesTransaction.salesLoan.show') ? 1 : 0;
        $ced = $edit + $delete + $show;

        $totalData = $this->salesLon::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $salesLons = $this->salesLon::select($columns)->company()->with('salesLoanDetails', 'customer', 'branch','store')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->salesLon::count();
        } else {
            $search = $request->input('search.value');
            $salesLons = $this->salesLon::select($columns)->company()->with('salesLoanDetails', 'customer', 'branch','store')->where(function ($q) use ($columns, $search) {
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
            $totalFiltered = $this->salesLon::select($columns)->company()->where(function ($q) use ($columns, $search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }

        foreach ($salesLons as $key => $value) :
            if (!empty($value->customer_id))
                $value->customer_id = $value->customer->name ?? '';

            if (!empty($value->branch_id))
                $value->branch_id  = $value->branch->name ?? '';

            if (!empty($value->store_id))
                $value->store_id  = $value->store->name ?? '';
        endforeach;

        $columns = Helper::getQueryProperty();
        $data = array();
        if ($salesLons) {
            foreach ($salesLons as $key => $salesLon) {
                $nestedData['id'] = $key + 1;

                if ($ced != 0) :
                    if ($edit != 0)
                        if ($salesLon->status == 'Pending') :

                            $edit_data = '<a href="' . route('salesTransaction.salesLoan.edit', $salesLon->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                        else :
                            $edit_data = '';
                        endif;
                    else
                        $edit_data = '';

                    $show_data = '<a href="' . route('salesTransaction.salesLoan.show', $salesLon->id) . '" show_id="' . $salesLon->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $salesLon->id . '"><i class="fa fa-search-plus"></i></a>';


                    if ($delete != 0)

                        if ($salesLon->status == 'Pending') :
                            $delete_data = '<a delete_route="' . route('salesTransaction.salesLoan.destroy', $salesLon->id) . '" delete_id="' . $salesLon->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $salesLon->id . '"><i class="fa fa-times"></i></a>';
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
                        $nestedData['sales_status'] = helper::statusBar($salesLon->sales_status);
                    elseif ($value == 'challan_status') :
                            $nestedData['challan_status'] = helper::statusBar($salesLon->challan_status);
                    elseif ($value == 'voucher_no') :
                        $nestedData[$value] = '<a target="_blank" href="' . route('salesTransaction.salesLoan.show', $salesLon->id) . '" show_id="' . $salesLon->id . '" title="Details" class="">' . $salesLon->voucher_no . '</a>';
                    else :
                        $nestedData[$value] = $salesLon->$value;
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
        $result = SalesLon::select("*")->with([
            'salesLoanDetails' => function ($q) {
                $q->select('id', 'sales_lons_id', 'branch_id', 'batch_no', 'date', 'pack_size', 'pack_no', 'discount', 'quantity', 'unit_price', 'total_price', 'company_id', 'product_id');
            }, 'salesLoanDetails.product' => function ($q) {
                $q->select('id', 'code', 'name', 'category_id', 'status', 'brand_id', 'company_id');
            }, 'salesLoanDetails.batch' => function ($q) {
                $q->select('id','name');
            }, 'general' => function ($q) {
                $q->select('id', 'date', 'voucher_id', 'branch_id', 'form_id', 'debit', 'credit', 'note');
            }, 'general.journals' => function ($q) {
                $q->select('id', 'general_id', 'form_id', 'account_id', 'date', 'debit', 'credit');
            }, 'general.journals.account' => function ($q) {
                $q->select('id', 'company_id', 'branch_id', 'parent_id', 'account_code', 'name', 'is_posted');
            }
        ])->where('id', $id)->first();
        return $result;
    }



    /**
     * @param $request
     * @return mixed
     */
    public function salesLoanDetails($salesId)
    {
        $salesLoanInfo = SalesLon::with('salesLoanDetails')->where('id', $salesId)->get();
        return $salesLoanInfo;
    }


    public function store($request)
    {

        DB::beginTransaction();
        try {
            $poMaster =  new $this->salesLon();
            $poMaster->date = date('Y-m-d', strtotime($request->date));
            $poMaster->customer_id  = $request->customer_id;
            $poMaster->store_id  = $request->store_id ?? helper::getDefaultStore();
            $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
            if (!empty($request->sales_quatation_id))
            $poMaster->sales_quatation_id  = implode(",", $request->sales_quatation_id ?? '');
            $poMaster->voucher_no  = helper::generateInvoiceId("sales_loan_prefix","sales_lons");
            $poMaster->subtotal  = $request->sub_total;
            $poMaster->discount  = $request->discount;
            $poMaster->note  = $request->note;
            $poMaster->status  = 'Approved';
            $poMaster->updated_by = Auth::user()->id;
            $poMaster->company_id = Auth::user()->company_id;
            $poMaster->save();
            if($poMaster->id){
                if(!empty($request->documents))
                $poMaster->documents = helper::upload($request->documents,500,500,'salesLoan',$poMaster->id);
                $poMaster->save();
                $totalPrice = $this->masterDetails($poMaster->id,$request);
                $poMaster->grand_total = $totalPrice;
                $poMaster->save();
                //general table data save
                $general_id = $this->generalSave($poMaster->id,$request);
                //general ledger table data save
                Journal::salesLoanLedgerSave($general_id, $poMaster->grand_total,$request->account_id[0],$request->date,12);
            
                //main stock table data save
                $this->stockSave($general_id,$poMaster->id);
                //stock cashing table data save
                $this->stockSummarySave($poMaster->id);
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



    public function masterDetails($masterId, $request)
    {

        $totalPrice=0;
        SalesLonDetails::where('sales_lons_id', $masterId)->company()->delete();
        $productInfo = $request->product_id;
        $allDetails = array();
        foreach ($productInfo as $key => $value) :
            $pbatch = $request->batch_no[$key] ?? helper::getProductBatchById($request->product_id[$key]);
            $unitPrice =  helper::productAvg($request->product_id[$key],$pbatch);

            $masterDetails = array();
            $masterDetails['sales_lons_id'] = $masterId;
            $masterDetails['company_id'] = helper::companyId();
            $masterDetails['date'] = helper::mysql_date($request->date);
            $masterDetails['branch_id']  = $request->branch_id ?? helper::getDefaultBranch();
            $masterDetails['store_id']  = $request->store_id ?? helper::getDefaultStore();
            $masterDetails['product_id']  = $request->product_id[$key];
            $masterDetails['batch_no']  =$pbatch;
            $masterDetails['pack_size']  = $request->pack_size[$key] ?? $request->quantity[$key];
            $masterDetails['pack_no']  = $request->pack_no[$key] ?? 1;
            $masterDetails['quantity']  = $request->quantity[$key];
            $masterDetails['unit_price']  =  $unitPrice;
            $masterDetails['total_price']  =  $unitPrice*$request->quantity[$key];
            array_push($allDetails, $masterDetails);
            $totalPrice+= $masterDetails['total_price'];
        endforeach;
           $saveInfo =  SalesLonDetails::insert($allDetails);

        return $totalPrice;
    }


    public function generalSave($sales_lons_id)
    {
        $salesLoanInfo = $this->salesLon::find($sales_lons_id);
        $general =  new General();
        $general->date = helper::mysql_date($salesLoanInfo->date);
        $general->form_id = 12; //sales loan info
        $general->branch_id  = $salesLoanInfo->branch_id ?? helper::getDefaultBranch();
        $general->store_id  = $salesLoanInfo->store_id ?? helper::getDefaultStore();
        $general->voucher_id  = $sales_lons_id;
        $general->debit  = $salesLoanInfo->grand_total;
        $general->status  = 'Approved';
        $general->updated_by = helper::userId();
        $general->company_id = helper::companyId();
        $general->save();
        return $general->id;
    }



    public function stockSave($general_id, $sales_lons_id)
    {
        $salesLoanDetails = SalesLonDetails::where('sales_lons_id', $sales_lons_id)->company()->get();
        $allStock = array();
        foreach ($salesLoanDetails as $key => $value) :
            $generalStock = array();
            $generalStock['date'] = helper::mysql_date($value->date);
            $generalStock['company_id'] = helper::companyId();
            $generalStock['general_id'] = $general_id;
            $generalStock['branch_id']  = $value->branch_id ?? helper::getDefaultBranch();
            $generalStock['store_id']  = $value->store_id ?? helper::getDefaultStore();
            $generalStock['product_id']  = $value->product_id;
            $generalStock['type']  = "lout";
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



    public function stockSummarySave($salesLoan_id)
    {
        $salesLoanDetails = SalesLonDetails::where('sales_lons_id', $salesLoan_id)->company()->get();
        foreach ($salesLoanDetails as $key => $value) :
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
            $poMaster = $this->salesLon::findOrFail($id);
            $poMaster->date = date('Y-m-d', strtotime($request->date));
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
                $poMaster->documents = helper::upload($request->documents,500,500,'salesLoan',$poMaster->id);
                $poMaster->save();
                $this->masterDetails($poMaster->id, $request);
                //general table data save
                $general_id = $this->generalSave($poMaster->id, $request);
                //general Ledger table data save
             Journal::salesLoanLedgerSave($general_id,$request->grand_total,$request->account_id[0],$request->date,12);

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
            $sales->delete();
            SalesLonDetails::where('sales_lons_id', $id)->delete();
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
