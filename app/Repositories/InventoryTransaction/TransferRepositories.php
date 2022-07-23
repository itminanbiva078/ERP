<?php

namespace App\Repositories\InventoryTransaction;

use App\Helpers\Helper;
use App\Models\General;
use App\Models\Stock;
use App\Models\StockSummary;
use Illuminate\Support\Facades\Auth;
use App\Models\Transpfer;
use App\Models\TransferDetails;
use DB;

class TransferRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Transpfer
     */
    private $transpfer;
    /**
     * CourseRepository constructor.
     * @param TransferRepositories $transferRepositories
     */
    public function __construct(Transpfer $transpfer)
    {
        $this->transpfer = $transpfer;
      
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns, "id");
        $edit = Helper::roleAccess('inventoryTransaction.transfer.edit') ? 1 : 0;
        $delete = Helper::roleAccess('inventoryTransaction.transfer.destroy') ? 1 : 0;
        $show = Helper::roleAccess('inventoryTransaction.transfer.show') ? 1 : 0;
        $ced = $edit + $delete + $show;

        $totalData = $this->transpfer::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $transpfers = $this->transpfer::select($columns)->company()->with('transferDetails','fStore','tStore')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->transpfer::count();
        } else {
            $search = $request->input('search.value');
            $transpfers = $this->transpfer::select($columns)->company()->with('transferDetails','fStore','tStore')->where(function ($q) use ($columns, $search) {
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
            $totalFiltered = $this->transpfer::select($columns)->company()->where(function ($q) use ($columns, $search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }

        foreach ($transpfers as $key => $value) :
            if (!empty($value->from_store_id))
                $value->from_store_id = $value->fStore->name ?? '';

            if (!empty($value->to_store_id))
                $value->to_store_id  = $value->tStore->name ?? '';
        endforeach;

        $columns = Helper::getQueryProperty();
        $data = array();

        if ($transpfers) {
            foreach ($transpfers as $key => $transpfer) {
                $nestedData['id'] = $key + 1;
               
                if ($ced != 0) :
                    if ($edit != 0 && $transpfer->status == 'Pending')
                        $edit_data = '<a href="' . route('inventoryTransaction.transfer.edit', $transpfer->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    else
                        $edit_data = '';

                   
                        $show_data = '<a href="' . route('inventoryTransaction.transfer.show', $transpfer->id) . '" show_id="' . $transpfer->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $transpfer->id . '"><i class="fa fa-search-plus"></i></a>';
                    


                    if ($delete != 0 && $transpfer->status == 'Pending')
                        $delete_data = '<a delete_route="' . route('inventoryTransaction.transfer.destroy', $transpfer->id) . '" delete_id="' . $transpfer->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $transpfer->id . '"><i class="fa fa-times"></i></a>';
                    else
                        $delete_data = '';

                    $nestedData['action'] = $edit_data . ' ' . $delete_data . '  '.$show_data;
                else :
                    $nestedData['action'] = '';
                endif;
                foreach ($columns as $key => $value) :
                    if ($value == 'status') :
                        $nestedData['status'] = helper::statusBar($transpfer->status);
                    elseif($value == 'voucher_no'):

                        $nestedData[$value] = '<a target="_blank" href="' . route('inventoryTransaction.transfer.show', $transpfer->id) . '" show_id="' . $transpfer->id . '" title="Details" class="">'.$transpfer->voucher_no.'</a>';
                    else:    
                        $nestedData[$value] = $transpfer->$value;
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
         $result = Transpfer::select("*")->with([
          'transferDetails' => function($q){
            $q->select('id','transfer_id','branch_id','batch_no','store_id','pack_size','pack_no','date','quantity','unit_price','total_price','company_id','product_id');
        },'transferDetails.product' => function($q){
            $q->select('id','code','name','category_id','status','brand_id','company_id');
        },'transferDetails.batch' => function($q){
            $q->select('id','name');
        }, 'fBranch' => function($q){
            $q->select('id','name','email','phone','address');
        }, 'tBranch' => function($q){
            $q->select('id','name','email','phone','address');
        },'fStore' => function($q){
            $q->select('id','name','email','phone','address');
        },'tStore' => function($q){
            $q->select('id','name','email','phone','address');
        }])->where('id', $id)->first();
        return $result;

    }


    public function store($request)
    {
        DB::beginTransaction();
    try {

            $poMaster =  new $this->transpfer();
            $poMaster->date = helper::mysql_date($request->date);
            $poMaster->from_branch_id  = $request->from_branch_id;
            $poMaster->from_store_id  = $request->from_store_id;
            $poMaster->to_branch_id  = $request->to_branch_id;
            $poMaster->to_store_id  = $request->to_store_id;
            $poMaster->voucher_no  = $request->voucher_no;
            $poMaster->total_quantity  = array_sum($request->quantity);
            $poMaster->note  = $request->note;
            // $poMaster->grand_total  = array_sum($request->total_price);
            $poMaster->status  = 'Approved';
            $poMaster->updated_by = helper::userId();
            $poMaster->company_id = helper::companyId();
            $poMaster->save();

            if ($poMaster->id) {
                if(!empty($request->documents))
                $poMaster->documents = helper::upload($request->documents,500,500,'transfer',$poMaster->id);
                $poMaster->save();
                $this->masterDetails($poMaster->id, $request);


                 /* stock out start*/
                 $general_id_out =  $this->generalSaveTransferOut($poMaster->id,$request->date);
                 $this->stockSaveTransferOut($general_id_out, $poMaster->id,$request->date,$request->from_branch_id,$request->from_store_id);
                 $this->stockSummarySaveOut($poMaster->id,$request->from_branch_id,$request->from_store_id);
                 /* stock out end*/


                /* stock in start */
                $general_id_in = $this->generalSaveTransferIn($poMaster->id,$request->date);
                $this->stockSaveTransferIn($general_id_in, $poMaster->id,$request->date,$request->to_branch_id,$request->to_store_id);
                $this->stockSummarySaveIn($poMaster->id,$request->to_branch_id,$request->to_store_id);
                 /* stock in end */
                
            }
                DB::commit();
                // all good
                return $poMaster->id ;
            } catch (\Exception $e) {
                DB::rollback();

                return $e->getMessage();
            }
    }

    public function masterDetails($masterId, $request)
    {

        TransferDetails::where('transfer_id', $masterId)->delete();
        $productInfo = $request->product_id;
        $allDetails = array();
        foreach ($productInfo as $key => $value) :
            $unitPrice =  helper::productAvg($request->product_id[$key],$request->batch_no[$key]);
            $masterDetails = array();
            $masterDetails['company_id'] = helper::companyId();
            $masterDetails['date'] = helper::mysql_date($request->date);
            $masterDetails['transfer_id'] = $masterId;
            $masterDetails['branch_id'] = $request->to_branch_id;
            $masterDetails['store_id'] = $request->to_store_id;
            $masterDetails['product_id']  = $request->product_id[$key];
            $masterDetails['batch_no']  =$request->batch_no[$key];
            $masterDetails['pack_size']  =$request->pack_size[$key];
            $masterDetails['pack_no']  =$request->pack_no[$key];
            $masterDetails['quantity']  = $request->quantity[$key];
            $masterDetails['unit_price']  =$unitPrice;
            $masterDetails['total_price']  =$unitPrice * $request->quantity[$key];
            array_push($allDetails, $masterDetails);
        endforeach;
        $saveInfo =  TransferDetails::insert($allDetails);
        return $saveInfo;
    }

    public function generalSaveTransferIn($transfer_id,$date)
    {
        
        $transferInfo = $this->transpfer::find($transfer_id);
        $general =  new General();
        $general->date = helper::mysql_date($date);
        $general->company_id = $transferInfo->company_id; //transfer info
        $general->form_id = 10; //transfer In
        $general->branch_id  = $transferInfo->to_branch_id ?? helper::getDefaultBranch();
        $general->store_id  = $transferInfo->to_store_id ?? helper::getDefaultStore();
        $general->voucher_id  = $transferInfo->id;
        $general->debit  = $transferInfo->grand_total;
        $general->status  = 'Approved';
        $general->updated_by = Helper::userId();
        $general->company_id = helper::companyId();
        $general->save();
        return $general->id;
    }
    public function generalSaveTransferOut($transfer_id,$date)
    {
        $transferInfo = $this->transpfer::find($transfer_id);
        $general =  new General();
        $general->date = helper::mysql_date($date);
        $general->company_id = $transferInfo->company_id; //transfer info
        $general->form_id = 11; //transfer Out
        $general->branch_id  = $transferInfo->from_branch_id ?? helper::getDefaultBranch();
        $general->store_id  = $transferInfo->from_store_id ?? helper::getDefaultStore();
        $general->voucher_id  = $transferInfo->id;
        $general->debit  = $transferInfo->grand_total;
        $general->status  = 'Approved';
        $general->updated_by = Helper::userId();
        $general->company_id = helper::companyId();
        $general->save();
        return $general->id;
    }

    public function stockSaveTransferIn($general_id, $transfer_id,$date,$branch_id,$store_id)
    {
        $transferDetails = TransferDetails::where('transfer_id', $transfer_id)->company()->get();
        $allStock = array();
        foreach ($transferDetails as $key => $value) :
            $generalStock = array();
            $unitPrice =  helper::productAvg($value->product_id,$value->batch_no);
            $generalStock['date'] = helper::mysql_date($date);
            $generalStock['company_id'] = $value->company_id;
            $generalStock['type'] = 'tin';
            $generalStock['mrr_id'] = $mrr_id ?? 0;
            $generalStock['general_id'] = $general_id;
            $generalStock['product_id']  = $value->product_id;
            $generalStock['branch_id']  =$branch_id; 
            $generalStock['store_id']  = $store_id;
            $generalStock['batch_no']  = $value->batch_no;
            $generalStock['pack_size']  = $value->pack_size;
            $generalStock['pack_no']  = $value->pack_no;
            $generalStock['quantity']  = $value->quantity;
            $generalStock['unit_price']  =$unitPrice;
            $generalStock['total_price']  = $unitPrice * $value->quantity;
            array_push($allStock, $generalStock);
        endforeach;
        $saveInfo =  Stock::insert($allStock);
        return $saveInfo;
    }

    public function stockSaveTransferOut($general_id, $transfer_id,$date,$branch_id,$store_id)
    {
        $transferDetails = TransferDetails::where('transfer_id', $transfer_id)->company()->get();
        $allStock = array();
        foreach ($transferDetails as $key => $value) :
            $unitPrice =  helper::productAvg($value->product_id,$value->batch_no);
            $generalStock = array();
            $generalStock['date'] = helper::mysql_date($date);
            $generalStock['company_id'] = $value->company_id;
            $generalStock['type'] = 'tout';
            $generalStock['mrr_id'] = $mrr_id ?? 0;
            $generalStock['general_id'] = $general_id;
            $generalStock['product_id']  = $value->product_id;
            $generalStock['branch_id']  =$branch_id; //$value->branch_id ?? helper::getDefaultBranch();
            $generalStock['store_id']  = $store_id;//$value->store_id ?? helper::getDefaultStore();
            $generalStock['batch_no']  = $value->batch_no;
            $generalStock['pack_size']  = $value->pack_size;
            $generalStock['pack_no']  = $value->pack_no;
            $generalStock['quantity']  = $value->quantity;
            $generalStock['unit_price']  =$unitPrice;
            $generalStock['total_price']  = $unitPrice * $value->quantity;
            array_push($allStock, $generalStock);
        endforeach;
        $saveInfo =  Stock::insert($allStock);
        return $saveInfo;
    }



    public function stockSummarySaveIn($transfer_id,$branch_id,$store_id)
    {
        $transferDetails = TransferDetails::where('transfer_id', $transfer_id)->company()->get();
        foreach ($transferDetails as $key => $value) :
            $stockSummaryExits =  StockSummary::where('product_id', $value->product_id)->where('batch_no',$value->batch_no)->where("store_id",$store_id)->where("branch_id",$branch_id)->company()->first();
            if (empty($stockSummaryExits)) {
                $stockSummary = new StockSummary();
                $stockSummary->quantity = $value->quantity;
            } else {
                $stockSummary = $stockSummaryExits;
                $stockSummary->quantity = $stockSummary->quantity + $value->quantity;
            }
            $stockSummary->company_id = $value->company_id;
            $stockSummary->branch_id = $branch_id;
            $stockSummary->store_id = $store_id;
            $stockSummary->product_id = $value->product_id;
            $stockSummary->category_id = helper::getRow('products','id',$value->product_id,'category_id');
            $stockSummary->brand_id =    helper::getRow('products','id',$value->product_id,'brand_id');
            $stockSummary->batch_no = $value->batch_no;
            $stockSummary->pack_size = $value->pack_size;
            $stockSummary->pack_no = $value->pack_no;
            $stockSummary->save();
        endforeach;
    }

    public function stockSummarySaveOut($transfer_id,$branch_id,$store_id)
    {
     
        $transferDetails = TransferDetails::where('transfer_id', $transfer_id)->company()->get();
        foreach ($transferDetails as $key => $value) :
            $stockSummaryExits =  StockSummary::where('product_id', $value->product_id)->where('batch_no',$value->batch_no)->where("store_id",$store_id)->where("branch_id",$branch_id)->company()->first();
            if (empty($stockSummaryExits)) {
                $stockSummary = new StockSummary();
                $stockSummary->quantity = $value->quantity;
            } else {
                $stockSummary = $stockSummaryExits;
                $stockSummary->quantity = $stockSummary->quantity - $value->quantity;
            }
            $stockSummary->company_id = $value->company_id;
            $stockSummary->branch_id = $branch_id;
            $stockSummary->store_id = $store_id;
            $stockSummary->product_id = $value->product_id;
            $stockSummary->category_id = helper::getRow('products','id',$value->product_id,'category_id');
            $stockSummary->brand_id = helper::getRow('products','id',$value->product_id,'brand_id');
            $stockSummary->batch_no = $value->batch_no;
            $stockSummary->pack_size = $value->pack_size;
            $stockSummary->pack_no = $value->pack_no;
            $stockSummary->save();
        endforeach;
    }


    public function update($request, $id)
    {

        DB::beginTransaction();
            try {


            $poMaster = $this->transpfer::findOrFail($id);
            $poMaster->date = helper::mysql_date($request->date);
            $poMaster->from_branch_id  = $request->from_branch_id;
            $poMaster->from_store_id  = $request->from_store_id;
            $poMaster->to_branch_id  = $request->to_branch_id;
            $poMaster->to_store_id  = $request->to_store_id;
            $poMaster->documents  = $request->documents;
            $poMaster->voucher_no  = $request->voucher_no;
            $poMaster->subtotal  = $request->sub_total;
            $poMaster->note  = $request->note;
            $poMaster->grand_total  = array_sum($request->total_price);
            $poMaster->status  = 'Pending';
            $poMaster->updated_by = helper::userId();
            $poMaster->company_id = helper::companyId();
            $poMaster->save();
            
            if ($poMaster->id) {
                if(!empty($request->documents))
                $poMaster->documents = helper::upload($request->documents,500,500,'transfer',$poMaster->id);
                $poMaster->save();
            $this->masterDetails($poMaster->id, $request);
            
            }
                DB::commit();
                // all good
                return $poMaster->id ;
            } catch (\Exception $e) {
                DB::rollback();
                return $e->getMessage();
            }
    }

    public function statusUpdate($id, $status)
    {
        $transpfer = $this->transpfer::find($id);
        $transpfer->status = $status;
        $transpfer->save();
        return $transpfer;
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        
    try {
        $transpfer = $this->transpfer::find($id);
        $transpfer->delete();
        TransferDetails::where('transfer_id', $id)->delete();

        DB::commit();
            // all good
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
