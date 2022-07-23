<?php

namespace App\Repositories\InventoryTransaction;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionDetails;
use DB;

class PurchasesRequsitionRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var PurchaseRequisition
     */
    private $purchaseRequisition;
    /**
     * CourseRepository constructor.
     * @param purchaseRequisition $purchaseRequisition
     */
    public function __construct(PurchaseRequisition $purchaseRequisition)
    {
        $this->purchaseRequisition = $purchaseRequisition;
       
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();

       
        array_push($columns, "id");
        $edit = Helper::roleAccess('inventoryTransaction.purchasesRequisition.edit') ? 1 : 0;
        $delete = Helper::roleAccess('inventoryTransaction.purchasesRequisition.destroy') ? 1 : 0;
        $show = Helper::roleAccess('inventoryTransaction.purchasesRequisition.show') ? 1 : 0;
        $ced = $edit + $delete + $show;

        $totalData = $this->purchaseRequisition::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $purchaseRequisitions = $this->purchaseRequisition::select($columns)->company()->with('requisitionDetails', 'branch','department')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->purchaseRequisition::count();
        } else {
            $search = $request->input('search.value');
            $purchaseRequisitions = $this->purchaseRequisition::select($columns)->company()->with('requisitionDetails', 'branch','department')->where(function ($q) use ($columns, $search) {
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
            $totalFiltered = $this->purchaseRequisition::select($columns)->company()->where(function ($q) use ($columns, $search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }

        foreach ($purchaseRequisitions as $key => $value) :
            if (!empty($value->department_id))
                $value->department_id = $value->department->name ?? '';

            if (!empty($value->branch_id))
                $value->branch_id  = $value->branch->name ?? '';
        endforeach;

        $columns = Helper::getQueryProperty();
        $data = array();


        if ($purchaseRequisitions) {
            foreach ($purchaseRequisitions as $key => $purchaseRequisition) {
                $nestedData['id'] = $key + 1;
                
                if ($ced != 0) :
                    if ($edit != 0 && $purchaseRequisition->requisition_status == 'Pending')
                        $edit_data = '<a href="' . route('inventoryTransaction.purchasesRequisition.edit', $purchaseRequisition->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    else
                        $edit_data = '';
                        $show_data = '<a href="' . route('inventoryTransaction.purchasesRequisition.show', $purchaseRequisition->id) . '" show_id="' . $purchaseRequisition->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $purchaseRequisition->id . '"><i class="fa fa-search-plus"></i></a>';
                     if ($delete != 0 && $purchaseRequisition->purchases_order_status == 'Pending')
                        $delete_data = '<a delete_route="' . route('inventoryTransaction.purchasesRequisition.destroy', $purchaseRequisition->id) . '" delete_id="' . $purchaseRequisition->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $purchaseRequisition->id . '"><i class="fa fa-times"></i></a>';
                    else
                        $delete_data = '';

                $nestedData['action'] = $edit_data . ' ' . $delete_data . '  '.$show_data;
                else :
                    $nestedData['action'] = '';
                endif;
                foreach ($columns as $key => $value) :
                    if ($value == 'purchases_order_status') :
                        $nestedData['purchases_order_status'] = helper::statusBar($purchaseRequisition->purchases_order_status);
                    elseif ($value == 'requisition_status') :
                        $nestedData['requisition_status'] = helper::statusBar($purchaseRequisition->requisition_status);
                    elseif($value == 'voucher_no'):
                        $nestedData[$value] = '<a target="_blank" href="' . route('inventoryTransaction.purchasesRequisition.show', $purchaseRequisition->id) . '" show_id="' . $purchaseRequisition->id . '" title="Details" class="">'.$purchaseRequisition->voucher_no.'</a>';
                    else:    
                        $nestedData[$value] = $purchaseRequisition->$value;
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
         $result = PurchaseRequisition::select("*")->with([
            'requisitionDetails' => function($q){
              $q->select('id','requisition_id','date','pack_size','pack_no','quantity','company_id','product_id');
          },'requisitionDetails.product' => function($q){
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

    public function requisitionDetails($requisition_id)
    {
        $requisitionInfo = PurchaseRequisition::with('requisitionDetails','department')->company()->whereIn('id', $requisition_id)->get();
        return $requisitionInfo;
    }


    public function store($request)
    {
        DB::beginTransaction();

    try {
        $poMaster =  new $this->purchaseRequisition();
        $poMaster->date = helper::mysql_date($request->date);
        $poMaster->department_id  = $request->department_id;
        $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
        $poMaster->voucher_no  = $request->voucher_no;
        $poMaster->total_qty  = array_sum($request->quantity);
        $poMaster->purchases_order_status  = 'Pending';
        $poMaster->note  = $request->note;
        $poMaster->created_by = helper::userId();
        $poMaster->company_id = helper::companyId();
        $poMaster->save();
        if ($poMaster->id) {
            
            $this->masterDetails($poMaster->id, $request);
           
        }
            DB::commit();
            // all good
            return $poMaster->id ;
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return $e->getMessage();
        }
    }

    
    public function masterDetails($masterId, $request)
    {
        PurchaseRequisitionDetails::where('requisition_id', $masterId)->delete();
        $productInfo = $request->product_id;
        $allDetails = array();
        foreach ($productInfo as $key => $value) :
            $masterDetails = array();
            $masterDetails['company_id'] = helper::companyId();
            $masterDetails['date'] = helper::mysql_date();
            $masterDetails['requisition_id'] = $masterId;
            $masterDetails['product_id']  = $request->product_id[$key];
            $masterDetails['pack_size']  = $request->pack_size[$key] ?? $request->quantity[$key];
            $masterDetails['pack_no']  = $request->pack_no[$key] ?? 1;
            $masterDetails['quantity']  = $request->quantity[$key] ?? 0;
            array_push($allDetails, $masterDetails);
        endforeach;
        $saveInfo =  PurchaseRequisitionDetails::insert($allDetails);
        return $saveInfo;
    }


    public function update($request, $id)
    {

     DB::beginTransaction();
        try {
        $poMaster = $this->purchaseRequisition::findOrFail($id);
        $poMaster->date = helper::mysql_date($request->date);
        $poMaster->department_id  = $request->department_id;
        $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
        $poMaster->voucher_no  = $request->voucher_no;
        $poMaster->documents  = $request->documents;
        $poMaster->note  = $request->note;
        $poMaster->purchases_order_status  = 'Pending';
        $poMaster->updated_by = helper::userId();
        $poMaster->company_id = helper::companyId();
        $poMaster->save();
        if ($poMaster->id) {
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
        $purchaseRequisition = $this->purchaseRequisition::find($id);
        $purchaseRequisition->purchases_order_status = $status;
        $purchaseRequisition->save();
        return $purchaseRequisition;
    }

    public function approved($id, $request)
    {
        $purchaseRequisition = $this->purchaseRequisition::find($id);
        $purchaseRequisition->requisition_status = $request->status;
        $purchaseRequisition->approved_by = helper::userId();
        $purchaseRequisition->save();
        return $purchaseRequisition;
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        
    try {
        
        $purchaseRequisition = $this->purchaseRequisition::find($id);
        if($purchaseRequisition->requisition_status == 'Pending'):
        $purchaseRequisition->delete();
        PurchaseRequisitionDetails::where('requisition_id', $id)->delete();
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