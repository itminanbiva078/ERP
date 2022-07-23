<?php

namespace App\Repositories\SalesTransaction;

use App\Helpers\Helper;
use App\Helpers\Journal;
use App\Models\SalePendingCheque;
use App\Repositories\SalesTransaction\SalesRepositories;

use Illuminate\Support\Facades\DB;


class SalesPendingChequeRepositories
{
    
    /**
     * @var SalePendingCheque
     */
    private $pendingCheque;
    /**
     * @var SalesRepositories
     */
    private $salesRepositories;
   
    /**
     * CourseRepository constructor.
     * @param SalePendingCheque $pendingCheque
     */
    public function __construct(SalePendingCheque $pendingCheque,SalesRepositories $salesRepositories)
    {
        $this->pendingCheque = $pendingCheque;
        $this->salesRepositories = $salesRepositories;
       
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {

        $columns = Helper::getQueryProperty();
        array_push($columns, "id");
        $edit = Helper::roleAccess('salesTransaction.sales.pendingCheque.edit') ? 1 : 0;
        $delete = Helper::roleAccess('salesTransaction.sales.pendingCheque.destroy') ? 1 : 0;
        $show = Helper::roleAccess('salesTransaction.sales.pendingCheque.show') ? 1 : 0;
        $ced = $edit + $delete + $show;

        $totalData = $this->pendingCheque::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')] ?? 'id';
        $dir = $request->input('order.0.dir');
        if (empty($request->input('search.value'))) {
            $salesPendingCheque = $this->pendingCheque::select($columns)->company()->with('sale','bank','formInfo','customer')->offset($start)
                ->whereIn('form_id',[5,17,18])
                ->limit($limit)
                //->orderBy('id', 'desc')
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = $this->pendingCheque::where('form_id',5)->company()->count();
        } else {
            $search = $request->input('search.value');
            $salesPendingCheque = $this->pendingCheque::select($columns)->company()->with('sale','bank','formInfo','customer')->where(function ($q) use ($columns, $search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            })
            ->whereIn('form_id',[5,17,18])
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
            }) ->whereIn('form_id',[5,17,18])->count();
        }

        foreach ($salesPendingCheque as $key => $value) :

            if (!empty($value->sale))
                $value->voucher_id = $value->sale->voucher_no ?? '';

            if (!empty($value->customer))
                $value->customer_id = $value->customer->name ?? '';
                
            if (!empty($value->form_id))
                $value->form_id = $value->formInfo->name ?? '';
            if (!empty($value->date))
                $value->date = helper::get_php_date($value->date) ?? '';
        endforeach;
        $columns = Helper::getQueryProperty();
    
        $data = array();
        if ($salesPendingCheque) {
            foreach ($salesPendingCheque as $key => $eachPayment) {
                $nestedData['id'] = $key + 1;
                if ($ced != 0) :
                    if ($show != 0) {
                        $show_data = '<a href="' . route('salesTransaction.sales.pendingCheque.show', $eachPayment->id) . '" show_id="' . $eachPayment->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $eachPayment->id . '"><i class="fa fa-search-plus"></i></a>';
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
                        $nestedData[$value] = '<a target="_blank" href="' . route('salesTransaction.sales.pendingCheque.show', $eachPayment->id) . '" show_id="' . $eachPayment->id . '" title="Details" class="">' . $eachPayment->voucher_no . '</a>';
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

        $result = $this->pendingCheque::with(["sale" => function($q){
           $q->select("*");
        },"customer" => function($q){
            $q->select("*");
        },"bank" => function($q){
            $q->select("*");
        }
        ])->where("id",$id)->where('form_id',5)->company()->first();
        return $result;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function posDetails($id)
    {
        $result = $this->pendingCheque::with(["posDetails" => function($q){
           $q->select("*");
        },"customer" => function($q){
            $q->select("*");
        },"bank" => function($q){
            $q->select("*");
        }
        ])->where("id",$id)->whereIn('form_id',[5,17,18])->company()->first();
        return $result;
    }

  

    public function approvedCheque($checkId,$request){

        DB::beginTransaction();
        try {
                $status = $request->status;  
                $bank_id = $request->bank_id;  
                $check_date = $request->date_picker;  
                $pendingCheque = SalePendingCheque::with("bank")->where("id",$checkId)->first();
                if($pendingCheque->status  == "Pending"){
                    $pendingCheque->deposit_date = helper::mysql_date($check_date);
                    if($status == 'Approved'){
                        $pendingCheque->status = $status;
                        $pendingCheque->save();
                        Journal::salePaymentJournal($pendingCheque->voucher_id,$pendingCheque->payment,$bank_id,$check_date,$pendingCheque->form_id);
                        $this->salesRepositories->salesCreditPayment($pendingCheque->voucher_id,$pendingCheque->payment,"Cheque",$checkId,$pendingCheque->form_id);
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