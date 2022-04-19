<?php

namespace App\Repositories\Opening;

use App\Exports\BrandExport;
use App\Helpers\Helper;
use App\Helpers\Journal;
use App\Models\Brand;
use App\Models\General;
use App\Models\GeneralLedger;
use App\Models\InventoryOpening;
use App\Models\InventoryOpeningDetails;
use App\Models\PaymentVoucher;
use App\Models\Product;
use App\Models\Purchases;
use App\Models\PurchasesMrr;
use App\Models\PurchasesMrrDetails;
use App\Models\Sales;
use App\Models\Stock;
use App\Models\StockSummary;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class InventoryOpeningRepositories
{
   
    /**
     * @var inventoryOpening
     */
    private $inventoryOpening;
    /**
     * CourseRepository constructor.
     * @param inventoryOpening $inventoryOpening
     */
    public function __construct(InventoryOpening $inventoryOpening)
    {
        $this->inventoryOpening = $inventoryOpening;
      
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('openingSetup.inventory.edit') ? 1 : 0;
        $show = Helper::roleAccess('openingSetup.inventory.show') ? 1 : 0;
        $delete = Helper::roleAccess('openingSetup.inventory.destroy') ? 1 : 0;
        $ced = $edit + $delete + $show;

        $totalData = $this->inventoryOpening::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $opInventory = $this->inventoryOpening::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->inventoryOpening::count();
        } else {
            $search = $request->input('search.value');
            $opInventory = $this->inventoryOpening::select($columns)->company()->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->inventoryOpening::select($columns)->company()->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }

        $columns = Helper::getTableProperty();
        $data = array();
        if ($opInventory) {
            foreach ($opInventory as $key => $opInventory) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                    if ($opInventory->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('openingSetup.inventory.status', [$opInventory->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('openingSetup.inventory.status', [$opInventory->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                    $nestedData['status'] = $status;
                else:
                    $nestedData[$value] = $opInventory->$value;
                endif;
            endforeach;
            if ($ced != 0) :
                if ($edit != 0)

                    if($this->checkBrandByExistsProduct($opInventory->id) === false):
                        $edit_data = '<a href="' . route('openingSetup.inventory.edit', $opInventory->id) . '" class="btn btn-xs btn-default" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    else:
                    $edit_data = '';
                    endif;
                else
                    $edit_data = '';
                if ($show != 0)

                     $show_data = '<a href="' . route('openingSetup.inventory.show', $opInventory->id) . '" class="btn btn-xs btn-default" title="Details show"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                else
                    $show_data = '';

                if ($delete != 0)
                    if($this->checkBrandByExistsProduct($opInventory->id) === false):
                        $delete_data = '<a delete_route="' . route('openingSetup.inventory.destroy', $opInventory->id) . '" delete_id="' . $opInventory->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $opInventory->id . '"><i class="fa fa-times"></i></a>';
                    else:
                    $delete_data = '';
                    endif;
                else
                    $delete_data = '';

                 $nestedData['action'] = $show_data . ' ' . $edit_data . ' ' . $delete_data;
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
    public function checkBrandByExistsProduct(){
        $purchases = Purchases::company()->count();
      
        $sales = Sales::company()->count();
        $ledger = GeneralLedger::company()->count();
        if($purchases > 0 && $sales > 0 && $ledger > 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    public function details($id)
    {
        $result = $this->inventoryOpening::with('inventoryDetails')->find($id);
        return $result;
    }
    /**
     * @param $request
     * @return mixed
     */
   

    /**
     * @param $request
     * @return mixed
     */
    public function getActiveProduct()
    {
        $result = Product::where('status', 'Approved')->company()->get();
        return $result;
    }

   

    public function store($request)
    {
        DB::beginTransaction();
        try {


            $poMaster =  new $this->inventoryOpening();
            $poMaster->date = helper::mysql_date($request->date); 
            $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
            $poMaster->voucher_no  = helper::generateInvoiceId("inventory_opening_prefix","inventory_openings");
            $poMaster->documents  = $request->documents;
            $poMaster->grand_total  = array_sum($request->total_price);
            $poMaster->updated_by =helper::userId();
            $poMaster->company_id = Helper::companyId();
            $poMaster->save();
            if ($poMaster->id) {
                $this->masterDetails($poMaster->id,$request);
                $this->stockSave($poMaster->id,$request->date);
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






public function stockSummarySave($inventory_id)
{
 
    $purchasesDetails = InventoryOpeningDetails::where('inventory_id', $inventory_id)->company()->get();
    $stockSummaryId=array();
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
        $stockSummary->branch_id = helper::getDefaultBranch();
        $stockSummary->store_id = helper::getDefaultStore();
        $stockSummary->category_id = helper::getRow('products','id',$value->product_id,'category_id');
        $stockSummary->brand_id = helper::getRow('products','id',$value->product_id,'brand_id');
        $stockSummary->product_id = $value->product_id;
        $stockSummary->batch_no = helper::getDefaultBatch();
        $stockSummary->pack_size = $value->pack_size;
        $stockSummary->pack_no = $value->pack_no;
        $stockSummary->save();
        array_push($stockSummaryId,$stockSummary->id);
    endforeach;


    $openingInfo =   InventoryOpening::find($inventory_id);
    $openingInfo->stock_summary_id= implode(",",$stockSummaryId);
    $openingInfo->save();
    return true;
}


public function masterDetails($masterId, $request)
{
    InventoryOpeningDetails::where('inventory_id', $masterId)->company()->delete();
    $productInfo = $request->product_id;
    $allDetails = array();
    foreach ($productInfo as $key => $value) :
        $masterDetails = array();
        $masterDetails['date'] = helper::mysql_date($request->date);
        $masterDetails['company_id'] = helper::companyId();
        $masterDetails['inventory_id'] = $masterId;
        $masterDetails['branch_id']  = $request->branch_id ?? helper::getDefaultBranch();
        $masterDetails['store_id']  = $request->store_id ?? helper::getDefaultStore();
        $masterDetails['product_id']  = $request->product_id[$key];
        $masterDetails['batch_no']  = helper::getDefaultBatch();// $value->batch_no;
        $masterDetails['pack_size']  = $request->pack_size[$key];
        $masterDetails['pack_no']  = $request->pack_no[$key];
        $masterDetails['quantity']  = $request->quantity[$key];
        $masterDetails['unit_price']  = $request->unit_price[$key];
        $masterDetails['total_price']  = $request->total_price[$key];
        array_push($allDetails, $masterDetails);
    endforeach;
    $saveInfo =  InventoryOpeningDetails::insert($allDetails);
    return $saveInfo;
}





public function stockSave($inventory_id,$date)
{

    Stock::where('general_id', $inventory_id)->company()->delete();
    $openingInventoryDetails = InventoryOpeningDetails::where('inventory_id', $inventory_id)->company()->get();
    $allStock = array();
    foreach ($openingInventoryDetails as $key => $value) :
        $generalStock = array();
        $generalStock['date'] = helper::mysql_date($date);
        $generalStock['company_id'] = $value->company_id;
        $generalStock['mrr_id'] = $mrr_id ?? 0;
        $generalStock['general_id'] = $inventory_id;
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


    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $poMaster =   $this->inventoryOpening::findOrFail($id);
            $poMaster->date = helper::mysql_date($request->date); 
            $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
            $poMaster->voucher_no  = $request->voucher_no;// helper::generateInvoiceId("inventory_opening_prefix","inventory_openings");
            $poMaster->documents  = $request->documents;
            $poMaster->grand_total  = array_sum($request->total_price);
            $poMaster->updated_by =helper::userId();
            $poMaster->company_id = Helper::companyId();
            $poMaster->save();
            if ($poMaster->id) {
                $this->masterDetails($poMaster->id,$request);
                $this->stockSave($poMaster->id,$request->date);
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

  


    public function destroy($id)
    {

        DB::beginTransaction();
        try {
        //master table
        $inventoryOpening = $this->inventoryOpening::find($id);
        $summaryId = $inventoryOpening->stock_summary_id;
        $inventoryOpening->delete();
        //master details table
        $inventoryDetails = InventoryOpeningDetails::where('inventory_id',$id)->company();
        $inventoryDetails->delete();
        //master details table
        $inventoryDetails = Stock::where('general_id',$id)->company();
        $inventoryDetails->delete();
        //master details table
        $inventoryDetails = StockSummary::whereIn('id',explode(",",$summaryId))->company();
        $inventoryDetails->delete();
        

        DB::commit();
        // all good
        return true;
    } catch (\Exception $e) {
        DB::rollback();
        return $e->getMessage();
    }


    }
}
