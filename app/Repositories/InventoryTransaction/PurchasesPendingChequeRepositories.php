<?php

namespace App\Repositories\InventoryTransaction;

use App\Helpers\Helper;
use App\Helpers\Journal;
use App\Models\PurchasesPendingCheque;
use App\Repositories\InventoryTransaction\PurchasesRepositories;
use Illuminate\Support\Facades\DB;

class PurchasesPendingChequeRepositories
{
    
    /**
     * @var pendingCheque
     */
    private $pendingCheque;
    /**
     * @var purchasesReporsitorys
     */
    private $purchasesReporsitorys;
   
    /**
     * CourseRepository constructor.
     * @param pendingCheque $pendingCheque
     */
    public function __construct(PurchasesPendingCheque $pendingCheque,PurchasesRepositories $purchasesReporsitorys)
    {
        $this->pendingCheque = $pendingCheque;
        $this->purchasesReporsitorys = $purchasesReporsitorys;
       
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {

        $columns = Helper::getQueryProperty("inventoryTransaction.purchases.pendingCheque.index");
       
        array_push($columns, "id");
        $edit = Helper::roleAccess('inventoryTransaction.purchases.pendingCheque.edit') ? 1 : 0;
        $delete = Helper::roleAccess('inventoryTransaction.purchases.pendingCheque.destroy') ? 1 : 0;
        $show = Helper::roleAccess('inventoryTransaction.purchases.pendingCheque.show') ? 1 : 0;
        $ced = $edit + $delete + $show;

        $totalData = $this->pendingCheque::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')] ?? 'id';
        $dir = $request->input('order.0.dir');
        if (empty($request->input('search.value'))) {
            $purchasessPendingCheque = $this->pendingCheque::select($columns)->company()->with('purchases','sale','bank','formInfo','supplier')->offset($start)
                ->where('form_id',4)
                ->limit($limit)
                //->orderBy('id', 'desc')
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = $this->pendingCheque::where('form_id',4)->company()->count();
        } else {
            $search = $request->input('search.value');
            $purchasessPendingCheque = $this->pendingCheque::select($columns)->company()->with('purchases','sale','bank','formInfo','supplier')->where(function ($q) use ($columns, $search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            })
            ->where('form_id',4)
                ->offset($start)
                ->limit($limit)
              
                //->orderBy('id', 'desc')
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = $this->pendingCheque::select($columns)->company()->where(function ($q) use ($columns, $search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            })->where('form_id',4)->count();
        }

        foreach ($purchasessPendingCheque as $key => $value) :
           
            if (!empty($value->purchases))
                $value->voucher_id = $value->purchases->voucher_no ?? '';

            if (!empty($value->supplier))
                $value->supplier_id = $value->supplier->name ?? '';

            if (!empty($value->form_id))
                $value->form_id = $value->formInfo->name ?? '';

            if (!empty($value->date))
                $value->date = helper::get_php_date($value->date) ?? '';
        endforeach;
        $columns = Helper::getTableProperty("inventoryTransaction.purchases.pendingCheque.index");
    
        $data = array();
        if ($purchasessPendingCheque) {
            foreach ($purchasessPendingCheque as $key => $eachPayment) {
                $nestedData['id'] = $key + 1;
                if ($ced != 0) :
                    if ($show != 0) {
                        $show_data = '<a href="' . route('inventoryTransaction.purchases.pendingCheque.show', $eachPayment->id) . '" show_id="' . $eachPayment->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $eachPayment->id . '"><i class="fa fa-search-plus"></i></a>';
                    } else {
                        $show_data = '';
                    }
                    $nestedData['action'] =$show_data;
                else :
                    $nestedData['action'] = '';
                endif;
                foreach ($columns as $key => $value) :
                    if ($value == 'status') :
                        $nestedData[$value] = helper::statusBar($eachPayment->$value);
                    elseif ($value == 'voucher_no') :
                        $nestedData[$value] = '<a target="_blank" href="' . route('inventoryTransaction.purchases.pendingCheque.show', $eachPayment->id) . '" show_id="' . $eachPayment->id . '" title="Details" class="">' . $eachPayment->voucher_no . '</a>';
                    else :
                    $nestedData[$value] = $eachPayment->$value;
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
        $result = $this->pendingCheque::with(["purchases" => function($q){
           $q->select("*");
        },"supplier" => function($q){
            $q->select("*");
        },"bank" => function($q){
            $q->select("*");
        }
        ])->where("id",$id)->where('form_id',4)->company()->first();
        return $result;
    }

  


    public function approvedCheque($checkId,$request){
        DB::beginTransaction();
        try {
             $status = $request->status;  
                $bank_id = $request->bank_id;  
                $check_date = $request->date_picker;  

                $pendingCheque =PurchasesPendingCheque::with("bank")->where("id",$checkId)->first();
                if($pendingCheque->status  == "Pending"){
                    $pendingCheque->deposit_date = $check_date;
                    if($status == 'Approved'){
                        $pendingCheque->status = $status;
                        $pendingCheque->save();
                        Journal::purchasesPaymentJournal($pendingCheque->voucher_id,$pendingCheque->payment,$bank_id,$check_date);
                        $this->purchasesReporsitorys->purchasesCreditPayment($pendingCheque->voucher_id,$pendingCheque->payment,"Cheque",$check_date,$checkId);
                    }else{
                        $pendingCheque->status = $status;
                        $pendingCheque->approved_by = helper::userId();
                        $pendingCheque->save();
                    }
                 }
                DB::commit();
                // all good
                return $checkId;
            } catch (\Exception $e) {
                DB::rollback();
                return $e->getMessage();
            }
    }


}