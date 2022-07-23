<?php

namespace App\Repositories\InventoryTransaction;

use App\Helpers\Helper;
use App\Models\General;
use App\Helpers\Journal;
use Illuminate\Support\Facades\Auth;
use App\Models\InventoryAdjustmentDetails;
use App\Models\InventoryAdjustment;
use App\Models\StockSummary;
use App\Models\Stock;
use DB;

class InventoryAdjustmentRepositories
{
    
    public function __construct(InventoryAdjustment $inventoryAdjustment)
    {
        $this->inventoryAdjustment = $inventoryAdjustment;
      
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns, "id");
        $edit = Helper::roleAccess('inventoryTransaction.inventoryAdjustment.edit') ? 1 : 0;
        $delete = Helper::roleAccess('inventoryTransaction.inventoryAdjustment.destroy') ? 1 : 0;
        $show = Helper::roleAccess('inventoryTransaction.inventoryAdjustment.show') ? 1 : 0;
        $ced = $edit + $delete + $show;

        $totalData = $this->inventoryAdjustment::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $inventoryAdjustments = $this->inventoryAdjustment::select($columns)->company()->with('inventoryAdjustmentDetails', 'branch','store')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->inventoryAdjustment::count();
        } else {
            $search = $request->input('search.value');
            $inventoryAdjustments = $this->inventoryAdjustment::select($columns)->company()->with('inventoryAdjustmentDetails', 'branch','store')->where(function ($q) use ($columns, $search) {
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
            $totalFiltered = $this->inventoryAdjustment::select($columns)->company()->where(function ($q) use ($columns, $search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }

        foreach ($inventoryAdjustments as $key => $value) :

            if (!empty($value->branch_id))
                $value->branch_id  = $value->branch->name ?? '';

            if (!empty($value->store_id))
                $value->store_id  = $value->store->name ?? '';
        endforeach;

        $columns = Helper::getQueryProperty();
        $data = array();
        if ($inventoryAdjustments) {
            foreach ($inventoryAdjustments as $key => $inventoryAdjustment) {
                $nestedData['id'] = $key + 1;
               
                if ($ced != 0) :
                    if ($edit != 0)
                        if ($inventoryAdjustment->status == 'Pending') :

                            $edit_data = '<a href="' . route('inventoryTransaction.inventoryAdjustment.edit', $inventoryAdjustment->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                        else :
                            $edit_data = '';
                        endif;
                    else
                        $edit_data = '';

                    $show_data = '<a href="' . route('inventoryTransaction.inventoryAdjustment.show', $inventoryAdjustment->id) . '" show_id="' . $inventoryAdjustment->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $inventoryAdjustment->id . '"><i class="fa fa-search-plus"></i></a>';

                    if ($delete != 0)
                        if ($inventoryAdjustment->status == 'Pending') :
                            $delete_data = '<a delete_route="' . route('inventoryTransaction.inventoryAdjustment.destroy', $inventoryAdjustment->id) . '" delete_id="' . $inventoryAdjustment->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $inventoryAdjustment->id . '"><i class="fa fa-times"></i></a>';
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
                    if ($value == 'status') :
                        $nestedData['status'] = helper::statusBar($inventoryAdjustment->status);
                    elseif ($value == 'voucher_no') :
                        $nestedData[$value] = '<a target="_blank" href="' . route('inventoryTransaction.inventoryAdjustment.show', $inventoryAdjustment->id) . '" show_id="' . $inventoryAdjustment->id . '" title="Details" class="">' . $inventoryAdjustment->voucher_no . '</a>';
                    else :
                        $nestedData[$value] = $inventoryAdjustment->$value;
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
        $result = inventoryAdjustment::select("*")->with([
            'inventoryAdjustmentDetails' => function ($q) {
                $q->select('id', 'inven_ad_id', 'branch_id', 'batch_no', 'date', 'pack_size', 'pack_no',  'quantity', 'unit_price', 'total_price', 'company_id', 'product_id');
            }, 'inventoryAdjustmentDetails.product' => function ($q) {
                $q->select('id', 'code', 'name', 'category_id', 'status', 'brand_id', 'company_id');
            }, 'inventoryAdjustmentDetails.batch' => function ($q) {
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
    public function inventoryAdjustmentDetails($adjustmentId)
    {
        $inventoryAdjustmentInfo = InventoryAdjustment::with('inventoryAdjustmentDetails')->where('id', $adjustmentId)->get();
        return $inventoryAdjustmentInfo;
    }


    public function store($request)
    {

        DB::beginTransaction();
        try {
            $poMaster =  new $this->inventoryAdjustment();
            $poMaster->date = date('Y-m-d', strtotime($request->date));
            $poMaster->store_id  = $request->store_id ?? helper::getDefaultStore();
            $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
            $poMaster->voucher_no  = helper::generateInvoiceId("inventory_adjust_prefix","inventory_adjustments");
            $poMaster->subtotal  = $request->sub_total;
            $poMaster->adjustment_type  = $request->adjustment_type;
            $poMaster->grand_total  = array_sum($request->total_price);
            $poMaster->note  = $request->note;
            $poMaster->status  = 'Pending';
            $poMaster->created_by = helper::userId();
            $poMaster->company_id = Auth::user()->company_id;
            $poMaster->save();
            if($poMaster->id){
                if(!empty($request->documents))
                $poMaster->documents = helper::upload($request->documents,500,500,'adjustment',$poMaster->id);
                $poMaster->save();
                $this->masterDetails($poMaster->id,$request);
                if(helper::isInventoryAdjustAuto()): 
                    //general table data save
                    $general_id = $this->generalSave($poMaster->id);
                    //main stock table data save
                    Journal::inventoryAdjustmentJournal($general_id,$request->date);
                    $this->stockSave($general_id,$poMaster->id);
                    //stock cashing table data save
                    $this->stockSummarySave($poMaster->id);
                    $poMaster->status  = 'Approved';
                    $poMaster->save();
                 endif;  
                 }
            DB::commit();
            // all good
            return $poMaster->id;
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function generalSave($adjustmentId)
    {
        $adjustmentDetails = $this->inventoryAdjustment::find($adjustmentId);
        $general =  new General();
        $general->date = helper::mysql_date($adjustmentDetails->date);
        $general->form_id = 16; //inventory adjustment id
        $general->branch_id  = $adjustmentDetails->branch_id ?? helper::getDefaultBranch();
        $general->store_id  = $adjustmentDetails->store_id ?? helper::getDefaultStore();
        $general->voucher_id  = $adjustmentId;
        $general->debit  = $adjustmentDetails->grand_total;
        $general->status  = 'Approved';
        $general->updated_by = helper::userId();
        $general->company_id = helper::companyId();
        $general->save();
        return $general->id;
    }


    public function stockSave($general_id, $adjustmentId)
    {
       
        $adjustmentInfo = InventoryAdjustmentDetails::where('inven_ad_id', $adjustmentId)->company()->get();
        $allStock = array();
        foreach ($adjustmentInfo as $key => $value) :
            $generalStock = array();
            $generalStock['date'] = helper::mysql_date($value->date);
            $generalStock['company_id'] = helper::companyId();
            $generalStock['general_id'] = $general_id;
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
            //update budget table
        endforeach;
          $stockInfo = Stock::insert($allStock);  
        return $stockInfo;
    }


    

 
    public function stockSummarySave($adjustmentId)
    {
        $materialIssueDetails = InventoryAdjustmentDetails::where('inven_ad_id', $adjustmentId)->company()->get();
        foreach ($materialIssueDetails as $key => $value) :
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


    public function masterDetails($masterId, $request)
    {
        InventoryAdjustmentDetails::where('inven_ad_id', $masterId)->company()->delete();
        $productInfo = $request->product_id;
        $allDetails = array();
        foreach ($productInfo as $key => $value) :
            $masterDetails = array();
            $masterDetails['inven_ad_id'] = $masterId;
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
        endforeach;
           $saveInfo =  InventoryAdjustmentDetails::insert($allDetails);

        return $saveInfo;
    }


  

    public function update($request, $id)
    {
        DB::beginTransaction();

        try {
            $poMaster = $this->inventoryAdjustment::findOrFail($id);
            $poMaster->date = date('Y-m-d', strtotime($request->date));
            $poMaster->store_id  = $request->store_id ?? helper::getDefaultStore();
            $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
            $poMaster->voucher_no  = helper::generateInvoiceId("inventory_adjust_prefix","inventory_adjustments");
            $poMaster->subtotal  = $request->sub_total;
            $poMaster->grand_total  = array_sum($request->total_price);
            $poMaster->discount  = $request->discount;
            $poMaster->grand_total  = array_sum($request->total_price);
            $poMaster->note  = $request->note;
            $poMaster->status  = 'Pending';
            $poMaster->created_by = helper::userId();
            $poMaster->company_id = Auth::user()->company_id;
            $poMaster->save();
            if ($poMaster->id) {
                if(!empty($request->documents))
                $poMaster->documents = helper::upload($request->documents,500,500,'adjustment',$poMaster->id);
                $poMaster->save();
                $this->masterDetails($poMaster->id, $request);
               
            }
            DB::commit();
            // all good
            return $poMaster->id;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }





    public function statusUpdate($id, $status)
    {
        $purchasesMrr = $this->purchasesMrr::find($id);
        $purchasesMrr->status = $status;
        $purchasesMrr->save();
        return $purchasesMrr;
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $inventoryAdjustment = $this->inventoryAdjustment::find($id);
            $inventoryAdjustment->delete();
            inventoryAdjustmentDetails::where('inven_ad_id', $id)->delete();
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