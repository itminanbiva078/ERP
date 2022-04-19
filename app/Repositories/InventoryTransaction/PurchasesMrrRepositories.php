<?php

namespace App\Repositories\InventoryTransaction;

use App\Helpers\Helper;
use App\Models\BatchNumber;
use App\Models\General;
use App\Models\Purchases;
use App\Models\PurchasesDetails;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchasesMrr;
use App\Models\PurchasesMrrDetails;
use App\Models\Stock;
use App\Models\StockSummary;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class PurchasesMrrRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var PurchasesMrr
     */
    private $purchasesMrr;
    /**
     * CourseRepository constructor.
     * @param purchasesMrr $purchasesMrr
     */
    public function __construct(PurchasesMrr $purchasesMrr)
    {
        $this->purchasesMrr = $purchasesMrr;
       
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {

        $columns = Helper::getQueryProperty();
        array_push($columns, "id");
        $edit = Helper::roleAccess('inventoryTransaction.purchasesMRR.edit') ? 1 : 0;
        $delete = Helper::roleAccess('inventoryTransaction.purchasesMRR.destroy') ? 1 : 0;
        $show = Helper::roleAccess('inventoryTransaction.purchasesMRR.show') ? 1 : 0;
        $ced = $edit + $delete + $show;
        $totalData = $this->purchasesMrr::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $purchasesMrrs = $this->purchasesMrr::select($columns)->company()->with('purchasesMrrDetails', 'branch','purchases','store')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->purchasesMrr::count();
        } else {
            $search = $request->input('search.value');
            $purchasesMrrs = $this->purchasesMrr::select($columns)->company()->with('purchasesMrrDetails', 'branch','purchases','store')->where(function ($q) use ($columns, $search) {
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
            $totalFiltered = $this->purchasesMrr::select($columns)->company()->where(function ($q) use ($columns, $search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }
        foreach ($purchasesMrrs as $key => $value) :
            if (!empty($value->branch_id))
                $value->branch_id  = $value->branch->name ?? '';
                $value->purchases_id  = $value->purchases->voucher_no ?? '';
                $value->pid  = $value->purchases->id ?? '';

                // if (!empty($value->purchases_id))
                // $value->purchases_id  = $value->purchases->voucher_no ?? '';

                if (!empty($value->store_id))
                $value->store_id = $value->store->name ?? '';

        endforeach;

        $columns = Helper::getTableProperty();
        $data = array();
        if ($purchasesMrrs) {
            foreach ($purchasesMrrs as $key => $purchasesMrr) {
                $nestedData['id'] = $key + 1;             
                if ($ced != 0) :
                    if ($edit != 0)
                        if($purchasesMrr->$value == 'Pending'):
                        $edit_data = '<a href="' . route('inventoryTransaction.purchasesMRR.edit', $purchasesMrr->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                        else: 
                            $edit_data = '';
                        endif;
                        else
                        $edit_data = '';

                        $show_data = '<a href="' . route('inventoryTransaction.purchasesMRR.show', $purchasesMrr->id) . '" show_id="' . $purchasesMrr->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $purchasesMrr->id . '"><i class="fa fa-search-plus"></i></a>';

                               
                    if ($delete != 0)

                    if($purchasesMrr->$value == 'Pending'):
                        $delete_data = '<a delete_route="' . route('inventoryTransaction.purchasesMRR.destroy', $purchasesMrr->id) . '" delete_id="' . $purchasesMrr->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $purchasesMrr->id . '"><i class="fa fa-times"></i></a>';
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
                        $nestedData['status'] = helper::statusBar($purchasesMrr->status);
                    elseif($value == 'voucher_no'):
                            $nestedData[$value] = '<a target="_blank" href="' . route('inventoryTransaction.purchasesMRR.show', $purchasesMrr->id) . '" show_id="' . $purchasesMrr->id . '" title="Details" class="">'.$purchasesMrr->voucher_no.'</a>';
                    elseif($value == "purchases_id"):
                        $nestedData[$value] = '<a target="_blank" href="' . route('inventoryTransaction.purchases.show', $purchasesMrr->pid) . '" show_id="' . $purchasesMrr->purchases_id . '" title="Details" class="">'.$purchasesMrr->purchases_id.'</a>';
                   
                    else :
                        $nestedData[$value] = $purchasesMrr->$value;
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
       $result = PurchasesMrr::select("*")->with([
            'purchasesMrrDetails' => function($q){
              $q->select('id','mrr_id','store_id','batch_no','date','pack_size','pack_no','quantity','company_id','product_id','approved_quantity');
          },'purchasesMrrDetails.product' => function($q){
              $q->select('id','code','name','category_id','status','brand_id','company_id');   
          },'purchasesMrrDetails.batchNumber' => function($q){
            $q->select('id','name','status','company_id');   
        
        }])->where('id', $id)->company()->first();
         
          return $result;
    }
    

    public function store($request)
    {

    
        DB::beginTransaction();
        try {
            $poMaster =  new $this->purchasesMrr();
            $poMaster->date = helper::mysql_date($request->date);
            $poMaster->company_id  = helper::companyId();
            $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
            $poMaster->store_id  = $request->store_id ?? helper::getDefaultStore();
            $poMaster->voucher_no  = $request->voucher_no;
            $poMaster->total_qty  = array_sum($request->approved_quantity);
            if (!empty($request->purchases_id))
            $poMaster->purchases_id  = $request->purchases_id;
            $poMaster->note  = $request->note;
            $poMaster->status  = 'Approved';
            $poMaster->updated_by = helper::userId();
            $poMaster->save();
            if ($poMaster->id) {
                if(!empty($request->documents))
                $poMaster->documents = helper::upload($request->documents,500,500,'purchasesMrr',$poMaster->id);
                $poMaster->save();
                $this->masterDetails($poMaster->id, $request);
                $this->purchasesQtyUpdate($request);
                $this->stockSave($request,$poMaster->id);
                $this->stockSummarySave($request);
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
        PurchasesMrrDetails::where('mrr_id', $masterId)->company()->delete();
        $productInfo = $request->product_id;
        $allDetails = array();
        foreach ($productInfo as $key => $value) :

            if(!empty($request->approved_quantity[$key])):
                $masterDetails = array();
                $masterDetails['mrr_id'] = $masterId;
                $masterDetails['purchases_id'] = $request->purchases_id;
                $masterDetails['company_id'] = helper::companyId();
                $masterDetails['date']  = helper::mysql_date($request->date);
                $masterDetails['branch_id']  = $request->branch_id ?? helper::getDefaultBranch();
                $masterDetails['store_id']  = $request->store_id ?? helper::getDefaultStore();
                $masterDetails['product_id']  = $request->product_id[$key];
                $masterDetails['batch_no']  =helper::productBatch($request->batch_no[$key]);
                $masterDetails['pack_size']  = $request->pack_size[$key] ?? $request->quantity[$key];
                $masterDetails['pack_no']  = $request->pack_no[$key] ?? 1;
                $masterDetails['quantity']  =$request->quantity[$key];
                $masterDetails['approved_quantity']  =$request->approved_quantity[$key];
                array_push($allDetails, $masterDetails);
            endif;
        endforeach;
        $saveInfo =  PurchasesMrrDetails::insert($allDetails);
        return $saveInfo;
    }

    public function stockSave($request,$mrrId)
    {
        $general_id = General::where('voucher_id', $request->purchases_id)->where('form_id',4)->company()->first();
        if(!empty($general_id)):
            $productId = $request->product_id;
            $remaining_quantity = $request->remaining_quantity;
            $allStock = array();
            foreach ($productId as $key => $value) :
                $purchasesExist = PurchasesDetails::where('purchases_id', $request->purchases_id)->where('product_id',$value)->company()->first();
                $prqty = $purchasesExist->quantity - $purchasesExist->approved_quantity;

                // if(!empty($purchasesExist) && !empty($remaining_quantity[$key]) && $prqty <= $remaining_quantity[$key]):

                    if(!empty($request->approved_quantity[$key])):
                        $generalStock = array();
                        $generalStock['date'] = helper::mysql_date($request->date);
                        $generalStock['company_id'] = helper::companyId();
                        $generalStock['mrr_id'] = $mrrId;
                        $generalStock['general_id'] = $general_id->id;
                        $generalStock['branch_id']  =$request->branch_id ?? helper::getDefaultBranch();
                        $generalStock['store_id']  = $request->store_id  ?? helper::getDefaultStore();
                        $generalStock['product_id']  = $value;
                        $generalStock['batch_no']  = helper::productBatch($request->batch_no[$key]);
                        $generalStock['pack_size']  = $request->pack_size[$key];
                        $generalStock['pack_no']  = $request->pack_no[$key];
                        $generalStock['quantity']  = $request->approved_quantity[$key];
                        $generalStock['unit_price']  = $purchasesExist->unit_price;
                        $generalStock['total_price']  = $purchasesExist->unit_price*$request->approved_quantity[$key];
                        array_push($allStock, $generalStock);
                    endif;
                // endif;
            endforeach;
            $saveInfo =  Stock::insert($allStock);
         endif;
        return $saveInfo;
    }

    public function stockSummarySave($request)
    {
       $product_id =  $request->product_id;
        foreach ($product_id as $key => $value) :
            if(!empty($request->approved_quantity[$key])):
            

                if(!empty($request->pack_size[$key])):

                    $batchId =  helper::productBatch($request->batch_no[$key]);
                    $stockSummaryExits =  StockSummary::where('product_id', $request->product_id[$key])->where('batch_no',$batchId)->where("store_id",$request->store_id)->where("branch_id",$request->branch_id)->company()->first();
                        if (empty($stockSummaryExits)) {
                            $stockSummary = new StockSummary();
                            $stockSummary->quantity = $request->approved_quantity[$key];
                        } else {
                            $stockSummary = $stockSummaryExits;
                            $stockSummary->quantity = $stockSummary->quantity + $request->approved_quantity[$key];
                        }
                        $stockSummary->company_id = helper::companyId();
                        $stockSummary->branch_id = $request->branch_id ?? helper::getDefaultBranch();
                        $stockSummary->store_id = $request->store_id  ?? helper::getDefaultStore();
                        $stockSummary->product_id = $request->product_id[$key];
                        $stockSummary->category_id = helper::getRow('products','id',$request->product_id[$key],'category_id');
                        $stockSummary->brand_id = helper::getRow('products','id',$request->product_id[$key],'brand_id');//  $value->brand_id;
                        $stockSummary->batch_no =$batchId;
                        $stockSummary->pack_size = $request->pack_size[$key];
                        $stockSummary->pack_no = $request->pack_no[$key];
                        $stockSummary->save();
                endif;
            endif;
        endforeach;
        return true;
    }



    public function update($request, $id)
    {
        DB::beginTransaction();
    try {
        $poMaster = $this->purchasesMrr::findOrFail($id);
        $poMaster->date = helper::mysql_date($request->date);
        $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
        $poMaster->store_id  = $request->store_id ?? helper::getDefaultStore();
        $poMaster->voucher_no  = $request->voucher_no;
        $poMaster->subtotal  = $request->sub_total;
        $poMaster->grand_total  = array_sum($request->total_price);
        $poMaster->note  = $request->note;
        $poMaster->status  = 'Pending';
        $poMaster->updated_by = helper::userId();
        $poMaster->company_id = helper::companyId();
        $poMaster->save();
        if ($poMaster->id) {
            if(!empty($request->documents))
            $poMaster->documents = helper::upload($request->documents,500,500,'purchasesMrr',$poMaster->id);
            $poMaster->save();
            $this->masterDetails($poMaster->id, $request);
            $this->purchasesQtyUpdate($request);
            
        }
            DB::commit();
            // all good
            return $poMaster->id ;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function purchasesUpdate($purchasesId)
    {


        
        $pendingQtyCheck = PurchasesDetails::select(DB::raw('sum(quantity - approved_quantity) as currentBalance'))->first();
        if($pendingQtyCheck->currentBalance <= 0 ){
            $status = "Approved";
        }else{
            $status = "Partial Received";
        }
        $purchases =  Purchases::findOrFail($purchasesId);
        $purchases->mrr_status = $status;
        $purchases->save();
       
        return true;
    }


    public function purchasesQtyUpdate($request)
    {
        $aprovedQtyRemaining = 0;
        $purchases_id = $request->purchases_id;
        $product_id = $request->product_id;
        foreach($product_id as $key => $eachProduct):
            if(!empty($request->approved_quantity[$key])): 
                $purchasesDetailsInfo =   PurchasesDetails::where('purchases_id',$purchases_id)->where('product_id',$eachProduct)->first();
                if(!empty($purchasesDetailsInfo) && !empty($request->approved_quantity[$key])):
                    $purchasesDetailsUpdate = PurchasesDetails::findOrFail($purchasesDetailsInfo->id);
                    $purchasesDetailsUpdate->approved_quantity = $purchasesDetailsInfo->approved_quantity+$request->approved_quantity[$key];
                    $purchasesDetailsUpdate->save();
                    $aprovedQtyRemaining =$aprovedQtyRemaining+ ($purchasesDetailsUpdate->quantity - $purchasesDetailsUpdate->approved_quantity);
                endif;
            endif;    
        endforeach;
        $this->purchasesUpdate($purchases_id);
        return true;
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
            $purchasesMrr = $this->purchasesMrr::find($id);
            $purchasesMrr->delete();
            PurchasesMrrDetails::where('mrr_id', $id)->delete();

                DB::commit();
                // all good
                return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        } 
   }
}