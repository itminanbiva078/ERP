<?php

namespace App\Repositories\SalesTransaction;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\DeliveryChallanDetails;
use App\Models\DeliveryChallan;
use App\Models\Sales;
use App\Models\SalesDetails;
use DB;
use App\Models\Stock;
use App\Models\StockSummary;
use App\Models\General;
use App\Models\PosDetails;

class DeliveryChallanRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var DeliveryChallan
     */
    private $deliveryChallan;
    /**
     * DeliveryChallanRepositories constructor.
     * @param DeliveryChallan $deliveryChallan
     */
    public function __construct(DeliveryChallan $deliveryChallan)
    {
        $this->deliveryChallan = $deliveryChallan;

    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('salesTransaction.deliveryChallan.edit') ? 1 : 0;
        $delete = Helper::roleAccess('salesTransaction.deliveryChallan.destroy') ? 1 : 0;
        $show = Helper::roleAccess('salesTransaction.deliveryChallan.show') ? 1 : 0;
        $ced = $edit + $delete + $show;

        $totalData = $this->deliveryChallan::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $deliveryChallans = $this->deliveryChallan::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->deliveryChallan::count();
        } else {
            $search = $request->input('search.value');
            $deliveryChallans = $this->deliveryChallan::select($columns)->company()->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->deliveryChallan::select($columns)->company()->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }



        $columns = Helper::getQueryProperty();
        $data = array();


        if ($deliveryChallans) {
            foreach ($deliveryChallans as $key => $deliveryChallan) {
                $nestedData['id'] = $key + 1;

                if ($ced != 0) :
                    if ($edit != 0 && $deliveryChallan->receive_status == 'Pending')
                        $edit_data = '<a href="' . route('salesTransaction.deliveryChallan.edit', $deliveryChallan->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    else
                        $edit_data = '';
                        $show_data = '<a href="' . route('salesTransaction.deliveryChallan.show', $deliveryChallan->id) . '" show_id="' . $deliveryChallan->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $deliveryChallan->id . '"><i class="fa fa-search-plus"></i></a>';
                     if ($delete != 0 && $deliveryChallan->receive_status == 'Pending')
                        $delete_data = '<a delete_route="' . route('salesTransaction.deliveryChallan.destroy', $deliveryChallan->id) . '" delete_id="' . $deliveryChallan->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $deliveryChallan->id . '"><i class="fa fa-times"></i></a>';
                    else
                        $delete_data = '';

             $nestedData['action'] = $edit_data . ' ' . $delete_data . '  '.$show_data;
                else :
                    $nestedData['action'] = '';
                endif;
                foreach ($columns as $key => $value) :
                    if ($value == 'receive_status') :
                        $nestedData['receive_status'] = helper::statusBar($deliveryChallan->receive_status);
                    elseif($value == 'voucher_no'):
                        $nestedData[$value] = '<a target="_blank" href="' . route('salesTransaction.deliveryChallan.show', $deliveryChallan->id) . '" show_id="' . $deliveryChallan->id . '" title="Details" class="">'.$deliveryChallan->voucher_no.'</a>';
                    else:
                        $nestedData[$value] = $deliveryChallan->$value;
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

        $result = DeliveryChallan::select("*")->with([
            'deliveryChallanDetails' => function($q){
              $q->select('id','delivery_challan_id','branch_id','batch_no','date','pack_size','pack_no','discount','quantity','approved_quantity','company_id','product_id');
          },'deliveryChallanDetails.product' => function($q){
              $q->select('id','code','name','category_id','status','brand_id','company_id');
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


    public function store($request)
    {
        $coustomerId = Sales::where('id', $request->sales_id)->company()->first();
        DB::beginTransaction();
        try {
            $poMaster =  new $this->deliveryChallan();
            $poMaster->date = helper::mysql_date($request->date);
            $poMaster->company_id  = helper::companyId();

            $poMaster->customer_id  = $coustomerId->customer_id;

            $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
            $poMaster->voucher_no  = $request->voucher_no;
            $poMaster->delivery_location  = $request->delivery_location;
            $poMaster->total_qty  = array_sum($request->approved_quantity);
            if (!empty($request->sales_id)):
               $poMaster->sales_id  =  $request->sales_id;//implode(",", $request->sales_id ?? '');
            endif;
            $poMaster->note  = $request->note;
            $poMaster->receive_status  = 'Approved';
            $poMaster->created_by = helper::userId();
            $poMaster->save();
            if ($poMaster->id) {
                $this->masterDetails($poMaster->id, $request);
                $this->salesQtyUpdate($request);
                $this->stockSave($request,$poMaster->id);
                $this->stockSummarySave($request);
            }
            DB::commit();
            // all good
            return $poMaster->id ;
        } catch (\Exception $e) {
        dd($e->getMessage());
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function stockSave($request,$chalanId)
    {
        $general_id = General::where('voucher_id', $request->sales_id)->where('form_id',5)->company()->first();
        if(!empty($general_id)):
            $productId = $request->product_id;
            $allStock = array();
            foreach ($productId as $key => $value) :
                $purchasesExist = SalesDetails::where('sales_id', $request->sales_id)->where('product_id',$value)->company()->first();


                    if(!empty($request->approved_quantity[$key])):
                        $generalStock = array();
                        $generalStock['date'] = helper::mysql_date($request->date);
                        $generalStock['company_id'] = helper::companyId();
                        $generalStock['delivery_challan_id'] = $chalanId;
                        $generalStock['general_id'] = $general_id->id;
                        $generalStock['branch_id']  =$request->branch_id ?? helper::getDefaultBranch();
                        $generalStock['store_id']  = $request->store_id  ?? helper::getDefaultStore();
                        $generalStock['product_id']  = $value;
                        $generalStock['type']  = "out";
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
        $salesDetails = SalesDetails::where('sales_id', $request->sales_id)->company()->get();
            // dd(  $salesDetails );
             foreach ($salesDetails as $key => $value) :
            $stockSummaryExits =  StockSummary::where('company_id', helper::companyId())->where('product_id', $value->product_id)->where("store_id",$value->store_id)->where("branch_id",$value->branch_id)->company()->first();
            if (empty($stockSummaryExits)) {
                $stockSummary = new StockSummary();
                $stockSummary->quantity = $value->approved_quantity;
            } else {
                $stockSummary = $stockSummaryExits;
                $stockSummary->quantity = $stockSummary->quantity - $value->approved_quantity;
            }
            $stockSummary->company_id = helper::companyId();
            $stockSummary->branch_id = $value->branch_id;
            $stockSummary->store_id = $value->store_id;
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

    public function masterDetails($masterId,$request){

        DeliveryChallanDetails::where('delivery_challan_id', $masterId)->company()->delete();
       $productInfo = $request->product_id;
       $allDetails = array();
       foreach ($productInfo as $key => $value) :

           if(!empty($request->approved_quantity[$key])):
               $masterDetails = array();
               $masterDetails['delivery_challan_id'] = $masterId;
               $masterDetails['company_id'] = helper::companyId();
               $masterDetails['branch_id']  = $request->branch_id ?? helper::getDefaultBranch();
               $masterDetails['date']  = helper::mysql_date($request->date);
               $masterDetails['product_id']  = $request->product_id[$key];
               $masterDetails['batch_no']  =helper::productBatch($request->batch_no[$key]);
               $masterDetails['pack_size']  =$request->pack_size[$key];
               $masterDetails['pack_no']  =$request->pack_no[$key];
               $masterDetails['quantity']  =$request->quantity[$key];
               $masterDetails['approved_quantity']  =$request->approved_quantity[$key];
               array_push($allDetails, $masterDetails);
           endif;
       endforeach;
       $saveInfo =  DeliveryChallanDetails::insert($allDetails);
       return $saveInfo;
    }




    public function update($request, $id)
    {
        DB::beginTransaction();

        try {
        $poMaster = $this->deliveryChallan::findOrFail($id);
        $poMaster->date = date('Y-m-d',strtotime($request->date));
        $poMaster->customer_id  = $request->customer_id;
        $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
        $poMaster->sales_id   = $request->sales_id ;
        $poMaster->delivery_location  = $request->delivery_location;
        $poMaster->total_qty  = $request->total_qty;
        $poMaster->note  = $request->note;
        $poMaster->receive_status  = 'Pending';
        $poMaster->updated_by = helper::userId();
        $poMaster->company_id = helper::companyId();
        $poMaster->save();
            if($poMaster->id){
            $this->masterDetails($poMaster->id,$request);
            $this->salesQtyUpdate($request);
            $this->stockSave($request,$poMaster->id);
            $this->stockSummarySave($request);



            }
            DB::commit();
            // all good
            return $poMaster->id;
        }
        catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
     }



     public function salesQtyUpdate($request)
     {
         $aprovedQtyRemaining = 0;
         $sales_id = $request->sales_id;
         $product_id = $request->product_id;
         foreach($product_id as $key => $eachProduct):
           $salesDetailsInfo =   SalesDetails::where('sales_id',$sales_id)->where('product_id',$eachProduct)->first();
           if(!empty($salesDetailsInfo) && !empty($request->approved_quantity[$key])):
              $salesDetailsUpdate = SalesDetails::findOrFail($salesDetailsInfo->id);
              $salesDetailsUpdate->approved_quantity = $salesDetailsInfo->approved_quantity+$request->approved_quantity[$key];
              $salesDetailsUpdate->save();
             $aprovedQtyRemaining =$aprovedQtyRemaining+ ($salesDetailsUpdate->quantity - $salesDetailsUpdate->approved_quantity);
           endif;
         endforeach;
         if($aprovedQtyRemaining <= 0 ){
             $this->salesUpdate($request->sales_id);
         }
         return true;
     }


     public function salesUpdate($salesId)
    {
        if (!empty($salesId)) {
                $sales =  Sales::findOrFail($salesId);
                $sales->challan_status = 'Approved';
                $sales->save();
        }
        return true;
    }


    public function statusUpdate($id, $status)
    {
        $deliveryChallan = $this->deliveryChallan::find($id);
        $deliveryChallan->receive_status = $status;
        $deliveryChallan->save();
        return $deliveryChallan;
    }


    public function destroy($id)
    {
        DB::beginTransaction();

    try {
        $deliveryChallan = $this->deliveryChallan::find($id);
        $deliveryChallan->delete();
        deliveryChallanDetails::where('delivery_challan_id', $id)->delete();
            DB::commit();
            // all good
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
   }
}
