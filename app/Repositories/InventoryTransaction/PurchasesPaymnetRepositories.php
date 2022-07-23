<?php

namespace App\Repositories\InventoryTransaction;

use App\Helpers\Helper;
use App\Helpers\Journal;
use App\Models\Purchases;
use App\Models\PurchasesDetails;
use App\Models\PurchasesPayment;
use App\Repositories\InventoryTransaction\PurchasesRepositories;
use DB;

class PurchasesPaymnetRepositories
{
    
    /**
     * @var PurchasesPayment
     */
    private $purchasesPayment;
    /**
     * @var purchasesRepository
     */
    private $purchasesRepository;
    /**
     * CourseRepository constructor.
     * @param purchasesPayment $purchasesPayment
     */
    public function __construct(PurchasesPayment $purchases, PurchasesRepositories $purchasesRepository)
    {
        $this->purchasesPayment = $purchases;
        $this->purchasesRepository = $purchasesRepository;
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {

        $columns = Helper::getQueryProperty();
        array_push($columns, "id");
        $edit = Helper::roleAccess('inventoryTransaction.purchasesPayment.edit') ? 1 : 0;
        $delete = Helper::roleAccess('inventoryTransaction.purchasesPayment.destroy') ? 1 : 0;
        $show = Helper::roleAccess('inventoryTransaction.purchasesPayment.show') ? 1 : 0;
        $ced = $edit + $delete + $show;

        $totalData = $this->purchasesPayment::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')] ?? 'id';
        $dir = $request->input('order.0.dir');
        if (empty($request->input('search.value'))) {
            $purchasessPayment = $this->purchasesPayment::select($columns)->company()->with('purchases', 'supplier', 'branch')->offset($start)
                ->limit($limit)
                ->havingRaw('credit> 0')
                //->orderBy('id', 'desc')
                ->orderBy($order, $dir)
                
                ->get();
            $totalFiltered = $this->purchasesPayment::count();
        } else {
            $search = $request->input('search.value');
            $purchasessPayment = $this->purchasesPayment::select($columns)->company()->with('purchases', 'supplier', 'branch',)->where(function ($q) use ($columns, $search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            })
                ->offset($start)
                ->limit($limit)
                ->havingRaw('credit> 0')
                //->orderBy('id', 'desc')
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = $this->purchasesPayment::select($columns)->company()->where(function ($q) use ($columns, $search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }

        foreach ($purchasessPayment as $key => $value) :
            if (!empty($value->supplier_id))
                $value->supplier_id = $value->supplier->name ?? '';

            if (!empty($value->branch_id))
                $value->branch_id  = $value->branch->name ?? '';

            if (!empty($value->purchases))
                $value->purchases_id = $value->purchases->voucher_no ?? '';

            if (!empty($value->date))
                $value->date = helper::get_php_date($value->date) ?? '';
        endforeach;
        $columns = Helper::getQueryProperty();
    
        $data = array();
        if ($purchasessPayment) {
            
            foreach ($purchasessPayment as $key => $eachPayment) {
                $nestedData['id'] = $key + 1;
                if ($ced != 0) :
                    if ($edit != 0) {
                        if ($eachPayment->purchases_status == 'Pending' && $eachPayment->mrr_status == "Pending") :
                            $edit_data = '<a href="' . route('inventoryTransaction.purchasesPayment.edit', $eachPayment->id) . '" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                        else :
                            $edit_data = '';
                        endif;
                    } else {
                        $edit_data = '';
                    }

                    if ($delete != 0) {
                        if ($eachPayment->purchases_status == 'Pending' && $eachPayment->mrr_status == "Pending") :
                            $delete_data = '<a delete_route="' . route('inventoryTransaction.purchasesPayment.destroy', $eachPayment->id) . '" delete_id="' . $eachPayment->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $eachPayment->id . '"><i class="fa fa-times"></i></a>';
                        else :
                            $delete_data = '';
                        endif;
                    } else {
                        $delete_data = '';
                    }

                    if ($show != 0) {
                        $show_data = '<a href="' . route('inventoryTransaction.purchasesPayment.show', $eachPayment->id) . '" show_id="' . $eachPayment->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $eachPayment->id . '"><i class="fa fa-search-plus"></i></a>';
                    } else {
                        $show_data = '';
                    }
                    $nestedData['action'] = $edit_data . ' ' . $delete_data . ' ' . $show_data;
                else :
                    $nestedData['action'] = '';
                endif;


                foreach ($columns as $key => $value) :
                    if ($value == 'mrr_status') :
                        $nestedData[$value] = helper::statusBar($eachPayment->$value);
                    elseif ($value == 'purchases_status') :
                        $nestedData[$value] = helper::statusBar($eachPayment->$value);
                    elseif ($value == 'voucher_no') :
                        $nestedData[$value] = '<a target="_blank" href="' . route('inventoryTransaction.purchasesPayment.show', $eachPayment->id) . '" show_id="' . $eachPayment->id . '" title="Details" class="">' . $eachPayment->voucher_no . '</a>';
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
        $result = $this->purchasesPayment::with("purchases","supplier","branch")->where("id",$id)->company()->first();
        return $result;
    }


    /**
     * @param $request
     * @return mixed
     */
    public function purchasesDetails($purchasesId)
    {
        $purchasesOrderInfo = Purchases::with('purchasesDetails', 'supplier')->where('id', $purchasesId)->company()->get();
        return $purchasesOrderInfo;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function dueVoucherList($purchasesId)
    {
        $duePaymentList = PurchasesPayment::groupBy("voucher_id")
        ->selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as dueAmount,sum(credit) as totalPayment,sum(debit) as purchasesAmount,id,voucher_id,voucher_no,branch_id,supplier_id,debit,credit,date')
        ->where('supplier_id',$purchasesId)
        ->havingRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) > 0')
        ->company()
        ->get();
        //dd( $duePaymentList );
        return $duePaymentList;

    }

    
    public function store($request)
    {
       // dd($request->all());
        DB::beginTransaction();
        try {
            $voucherList = $request->purchases_voucher_id;
            foreach($voucherList as $key => $eachVoucher): 
                if(!empty($request->credit[$key])): 
                    $request->paid_amount = $request->credit[$key];
                    if($request->payment_type == "Cash"): 
                        $request->request->add(['account_id' => 7]);
                        $moneyReceitId =  $this->purchasesRepository->purchasesCreditPayment($eachVoucher,$request->paid_amount,$request->payment_type,$request->date);
                       
                        Journal::purchasesPaymentJournal($eachVoucher,$request->credit[$key],$request->account_id,$request->date);

                       // $this->purchasesRepository->paidAmountUpdate($eachVoucher,$request->credit[$key]);
                    else:  
                        $moneyReceitId = $this->purchasesRepository->purchasesBankPayment($eachVoucher,$request);
                    endif;
                endif;
            endforeach;
            DB::commit();
            // all good
            return  $moneyReceitId;
        }catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $purchases = $this->purchasesPayment::find($id);
            $purchases->delete();
            PurchasesDetails::where('purchases_id', $id)->delete();
            DB::commit();
            // all good
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}