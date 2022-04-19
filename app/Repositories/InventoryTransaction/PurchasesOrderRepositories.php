<?php

namespace App\Repositories\InventoryTransaction;

use App\Helpers\Helper;
use App\Models\PurchaseRequisition;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchasesOrder;
use App\Models\PurchasesOrderDetails;
use App\Services\InventoryTransaction\PurchasesRequsitionService;
use DB;

class PurchasesOrderRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var PurchasesOrder
     */
    private $purchasesOrder;
    /**
     * CourseRepository constructor.
     * @param purchasesOrder $purchasesOrder
     */
    public function __construct(PurchasesOrder $purchasesOrder)
    {
        $this->purchasesOrder = $purchasesOrder;
       
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {

        $columns = Helper::getQueryProperty();
        array_push($columns, "id");
        $edit = Helper::roleAccess('inventoryTransaction.purchasesOrder.edit') ? 1 : 0;
        $delete = Helper::roleAccess('inventoryTransaction.purchasesOrder.destroy') ? 1 : 0;
        $show = Helper::roleAccess('inventoryTransaction.purchasesOrder.show') ? 1 : 0;
        $ced = $edit + $delete+$show;

        $totalData = $this->purchasesOrder::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $purchasesOrders = $this->purchasesOrder::select($columns)->company()->with('orderDetails', 'supplier', 'branch')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->purchasesOrder::count();
        } else {
            $search = $request->input('search.value');
            $purchasesOrders = $this->purchasesOrder::select($columns)->company()->with('orderDetails', 'supplier', 'branch')->where(function ($q) use ($columns, $search) {
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
            $totalFiltered = $this->purchasesOrder::select($columns)->company()->where(function ($q) use ($columns, $search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }

        foreach ($purchasesOrders as $key => $value) :
            if (!empty($value->supplier_id))
                $value->supplier_id = $value->supplier->name ?? '';

            if (!empty($value->branch_id))
                $value->branch_id  = $value->branch->name ?? '';
        endforeach;

        $columns = Helper::getTableProperty();
        $data = array();
        if ($purchasesOrders) {
            foreach ($purchasesOrders as $key => $purchasesOrder) {
                $nestedData['id'] = $key + 1;
               
                if ($ced != 0) :
                    if ($edit != 0)
                        if ($edit != 0 && $purchasesOrder->order_status == 'Pending'):
                        $edit_data = '<a href="' . route('inventoryTransaction.purchasesOrder.edit', $purchasesOrder->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                        else: 
                            $edit_data = '';
                        endif;
                        else
                        $edit_data = '';

                        $show_data = '<a href="' . route('inventoryTransaction.purchasesOrder.show', $purchasesOrder->id) . '" show_id="' . $purchasesOrder->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $purchasesOrder->id . '"><i class="fa fa-search-plus"></i></a>';
                     
                    if ($delete != 0 && $purchasesOrder->purchases_status == 'Pending')

                        $delete_data = '<a delete_route="' . route('inventoryTransaction.purchasesOrder.destroy', $purchasesOrder->id) . '" delete_id="' . $purchasesOrder->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $purchasesOrder->id . '"><i class="fa fa-times"></i></a>';
                    
                    else
                        $delete_data = '';
                    $nestedData['action'] = $edit_data . ' ' . $delete_data . ' ' .$show_data;
                else :
                    $nestedData['action'] = '';
                endif;

                foreach ($columns as $key => $value) :
                    if ($value == 'purchases_status') :
                        $nestedData['purchases_status'] = helper::statusBar($purchasesOrder->purchases_status);
                    elseif ($value == 'order_status') :
                        $nestedData['order_status'] = helper::statusBar($purchasesOrder->order_status);
                    elseif($value == 'voucher_no'):
                        $nestedData[$value] = '<a target="_blank" href="' . route('inventoryTransaction.purchasesOrder.show', $purchasesOrder->id) . '" show_id="' . $purchasesOrder->id . '" title="Details" class="">'.$purchasesOrder->voucher_no.'</a>';
                    else :
                        $nestedData[$value] = $purchasesOrder->$value;
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
       $result = PurchasesOrder::select("*")->with([
            'orderDetails' => function($q){
              $q->select('id','order_id','date','pack_size','pack_no','quantity','unit_price','total_price','company_id','product_id');
          },'orderDetails.product' => function($q){
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

    /**
     * @param $request
     * @return mixed
     */
    public function purchasesOrderDetails($purchasesOrderId)
    {
        $purchasesOrderInfo = PurchasesOrder::with('orderDetails','supplier')->whereIn('id', $purchasesOrderId)->get();
        return $purchasesOrderInfo;
    }


    public function store($request)
    {

        DB::beginTransaction();
        try {
            $poMaster =  new $this->purchasesOrder();
            $poMaster->date = helper::mysql_date($request->date);
            $poMaster->supplier_id  = $request->supplier_id;
            $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
            $poMaster->voucher_no  = $request->voucher_no;
            $poMaster->total_qty  = array_sum($request->quantity);
            $poMaster->subtotal  = $request->sub_total;
            if (!empty($request->requisition_id))
            $poMaster->requisition_id  = implode(",", $request->requisition_id ?? '');
            $poMaster->grand_total  = array_sum($request->total_price);
            $poMaster->note  = $request->note;
            $poMaster->purchases_status  = 'Pending';
            $poMaster->created_by = helper::userId();
            $poMaster->company_id = Helper::companyId();
            $poMaster->save();
            if ($poMaster->id) {
                if(!empty($request->documents))
                    $poMaster->documents = helper::upload($request->documents,500,500,'purchasesRequisition',$poMaster->id);
                    $poMaster->save();
                $this->masterDetails($poMaster->id, $request);
                $this->requisitionUpdate($request->requisition_id);
            }
           
            DB::commit();
            // all good
            return $poMaster->id ;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function checkPendingRequisition($request){
        if(!empty($request->requisition_id)){
            $totalFalse=0;
            foreach($request->requisition_id as $eachrequisitionId):
               $pendingRequsitionList = PurchaseRequisition::where('id', $eachrequisitionId)->where('purchases_order_status','Pending')->count();
                if(empty($pendingRequsitionList)){
                    $totalFalse+=1;
                }
            endforeach;
            return $totalFalse;
        }
    }        


    public function masterDetails($masterId, $request)
    {
        PurchasesOrderDetails::where('order_id', $masterId)->delete();
        $productInfo = $request->product_id;
        $allDetails = array();
        foreach ($productInfo as $key => $value) :
            $masterDetails = array();
            $masterDetails['company_id'] = helper::companyId();
            $masterDetails['date'] = helper::mysql_date();
            $masterDetails['order_id'] = $masterId;
            $masterDetails['product_id']  = $request->product_id[$key];
            $masterDetails['pack_size']  = $request->pack_size[$key] ?? $request->quantity[$key];
            $masterDetails['pack_no']  = $request->pack_no[$key] ?? 1;
            $masterDetails['quantity']  = $request->quantity[$key];
            $masterDetails['unit_price']  = $request->unit_price[$key];
            $masterDetails['total_price']  = $request->total_price[$key];
            array_push($allDetails, $masterDetails);
        endforeach;
        $saveInfo =  PurchasesOrderDetails::insert($allDetails);
        return $saveInfo;
    }


    public function update($request, $id)
    {
        DB::beginTransaction();
        
    try {
        $poMaster = $this->purchasesOrder::findOrFail($id);
        $poMaster->date = helper::mysql_date($request->date);
        $poMaster->supplier_id  = $request->supplier_id;
        $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
        $poMaster->voucher_no  = $request->voucher_no;
        $poMaster->subtotal  = $request->sub_total;
        $poMaster->grand_total  = array_sum($request->total_price);
        $poMaster->note  = $request->note;
        $poMaster->purchases_status  = 'Pending';
        $poMaster->updated_by = helper::userId();
        $poMaster->company_id = helper::companyId();
        $poMaster->save();
        if ($poMaster->id) {
            if(!empty($request->documents))
                    $poMaster->documents = helper::upload($request->documents,500,500,'purchasesRequisition',$poMaster->id);
                    $poMaster->save();
        $this->masterDetails($poMaster->id, $request);
            $this->requisitionUpdate($request->requisition_id);
        }
            DB::commit();
            // all good
            return $poMaster->id ;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function requisitionUpdate($requisitionId)
    {
        if (!empty($requisitionId)) {
            foreach ($requisitionId as $key => $value) :
                $purchasesRequistion =  PurchaseRequisition::findOrFail($value);
                $purchasesRequistion->purchases_order_status = 'Approved';
                $purchasesRequistion->save();
            endforeach;
        }
        return true;
    }

    public function approved($id, $request)
    {
        $purchasesOrder = $this->purchasesOrder::find($id);
        $purchasesOrder->order_status = $request->status;
        $purchasesOrder->approved_by = helper::userId();
        $purchasesOrder->save();
        return $purchasesOrder;
    }
    
    public function statusUpdate($id, $status)
    {
        $purchasesOrder = $this->purchasesOrder::find($id);
        $purchasesOrder->purchases_status = $status;
        $purchasesOrder->save();
        return $purchasesOrder;
    }

    public function destroy($id)
    {
        DB::beginTransaction(); 
            
    try {
        $purchasesOrder = $this->purchasesOrder::find($id);
        if( $purchasesOrder->purchases_order_status == 'Pending'):
        $purchasesOrder->delete();
        PurchasesOrderDetails::where('order_id', $id)->delete();
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