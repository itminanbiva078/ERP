<?php

namespace App\Repositories\SalesTransaction;

use App\Helpers\Helper;
use App\Helpers\Journal;
use App\Models\Sales;
use App\Models\SalesDetails;
use App\Models\SalePayment;
use App\Repositories\SalesTransaction\SalesRepositories;
use DB;

class SalesPaymentRepositories
{
    
    /**
     * @var SalePayment
     */
    private $salePayment;
    /**
     * @var SalesRepositories
     */
    private $salesRepositories;
    /**
     * SalesPaymentRepositories constructor.
     * @param SalePayment $salePayment
     */
    public function __construct(SalePayment $sale, SalesRepositories $salesRepositories)
    {
        $this->salePayment = $sale;
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
        $edit = Helper::roleAccess('salesTransaction.salePayment.edit') ? 1 : 0;
        $delete = Helper::roleAccess('salesTransaction.salePayment.destroy') ? 1 : 0;
        $show = Helper::roleAccess('salesTransaction.salePayment.show') ? 1 : 0;
        $ced = $edit + $delete + $show;
        $totalData = $this->salePayment::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')] ?? 'id';
        $dir = $request->input('order.0.dir');
        if (empty($request->input('search.value'))) {
            $salesPayment = $this->salePayment::select($columns)->company()->with('sale', 'customer', 'branch')->offset($start)
                ->limit($limit)
                ->havingRaw('credit> 0')
                //->orderBy('id', 'desc')
                ->orderBy($order, $dir)
                
                ->get();
            $totalFiltered = $this->salePayment::count();
        } else {
            $search = $request->input('search.value');
            $salesPayment = $this->salePayment::select($columns)->company()->with('sale', 'customer', 'branch',)->where(function ($q) use ($columns, $search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            })
                ->offset($start)
                ->limit($limit)
                ->havingRaw('credit> 0')
                ->orderBy('id', 'desc')
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = $this->salePayment::select($columns)->company()->where(function ($q) use ($columns, $search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }

        foreach ($salesPayment as $key => $value) :
            if (!empty($value->customer_id))
                $value->customer_id = $value->customer->name ?? '';

            if (!empty($value->branch_id))
                $value->branch_id  = $value->branch->name ?? '';

            if (!empty($value->purchases))
                $value->purchases_id = $value->purchases->voucher_no ?? '';

            if (!empty($value->date))
                $value->date = helper::get_php_date($value->date) ?? '';
        endforeach;
        $columns = Helper::getTableProperty();

       

    
        $data = array();
        if ($salesPayment) {
            
            foreach ($salesPayment as $key => $eachPayment) {
                $nestedData['id'] = $key + 1;
                if ($ced != 0) :
                    if ($edit != 0) {
                        if ($eachPayment->sales_status == 'Pending' && $eachPayment->challan_status == "Pending") :
                            $edit_data = '<a href="' . route('salesTransaction.salePayment.edit', $eachPayment->id) . '" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                        else :
                            $edit_data = '';
                        endif;
                    } else {
                        $edit_data = '';
                    }

                    if ($delete != 0) {
                        if ($eachPayment->sales_status == 'Pending' && $eachPayment->challan_status == "Pending") :
                            $delete_data = '<a delete_route="' . route('salesTransaction.salePayment.destroy', $eachPayment->id) . '" delete_id="' . $eachPayment->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $eachPayment->id . '"><i class="fa fa-times"></i></a>';
                        else :
                            $delete_data = '';
                        endif;
                    } else {
                        $delete_data = '';
                    }

                    if ($show != 0) {
                        $show_data = '<a href="' . route('salesTransaction.salePayment.show', $eachPayment->id) . '" show_id="' . $eachPayment->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $eachPayment->id . '"><i class="fa fa-search-plus"></i></a>';
                    } else {
                        $show_data = '';
                    }
                    $nestedData['action'] = $edit_data . ' ' . $delete_data . ' ' . $show_data;
                else :
                    $nestedData['action'] = '';
                endif;


                foreach ($columns as $key => $value) :
                    if ($value == 'challan_status') :
                        $nestedData[$value] = helper::statusBar($eachPayment->$value);
                    elseif ($value == 'sales_status') :
                        $nestedData[$value] = helper::statusBar($eachPayment->$value);
                    elseif ($value == 'voucher_no') :
                        $nestedData[$value] = '<a target="_blank" href="' . route('salesTransaction.salePayment.show', $eachPayment->id) . '" show_id="' . $eachPayment->id . '" title="Details" class="">' . $eachPayment->voucher_no . '</a>';
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
        $result = $this->salePayment::with("sale","customer","branch")->where("id",$id)->company()->first();
        return $result;
    }


    /**
     * @param $request
     * @return mixed
     */
    public function salesDetails($salesId)
    {
        $salesPaymentInfo = Sales::with('salesDetails', 'customer')->where('id', $salesId)->company()->get();
        return $salesPaymentInfo;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function dueVoucherList($customer_id,$form_id)
    {

  

            $duePaymentList = $this->salePayment::groupBy("sale_payments.voucher_id")->groupBy('sale_returns.sale_id')
            ->leftJoin('sale_returns', function($join) {
                $join->on('sale_payments.voucher_id', '=', 'sale_returns.sale_id');
              })
          
            ->selectRaw('sum(IFNULL(sale_payments.debit,0)-(IFNULL(sale_payments.credit,0)+IFNULL(sale_returns.grand_total,0))) as finalAmount,sum(sale_returns.grand_total) as grand_total,sum(IFNULL(sale_payments.debit,0)-IFNULL(sale_payments.credit,0)) as dueAmount,sum(sale_payments.credit) as totalPayment,sum(sale_payments.debit) as salesAmount,sale_payments.id,sale_payments.voucher_id,sale_payments.voucher_no,sale_payments.branch_id,sale_payments.customer_id,sale_payments.debit,sale_payments.credit')
            ->where('sale_payments.customer_id',$customer_id)
            ->where('sale_payments.form_id',$form_id)
            //->havingRaw('sum(IFNULL(sale_payments.debit,0)-(IFNULL(sale_payments.credit,0)+IFNULL(sale_returns.grand_total,0))) > 0')
            ->company()
            ->get();

        //dd($duePaymentList);



        return $duePaymentList;
    }

    
    public function store($request)
    {
        DB::beginTransaction();
        try {

           

            $voucherList = $request->sale_voucher_id;
            $collection_type = $request->collection_type;


            if($collection_type == 'General Sale'): 

                foreach($voucherList as $key => $eachVoucher): 
               
                    if(!empty($request->credit[$key])): 
                        $request->paid_amount = $request->credit[$key];
                        if($request->payment_type == "Cash"): 
                            $moneyReceitId =   $this->salesRepositories->salesCreditPayment($eachVoucher,$request->paid_amount,$request->payment_type,null,5);
                            //sales payment journal
                            Journal::salePaymentJournal($eachVoucher,$request->credit[$key],$request->account_id,$request->date,5);
                        else: 
                            $moneyReceitId =  $this->salesRepositories->saleBankPayment($eachVoucher,$request,5);
                        endif;
                    endif;
                endforeach;

            elseif($collection_type == 'Pos Sale'): 

              

                foreach($voucherList as $key => $eachVoucher): 
                    if(!empty($request->credit[$key])): 
                        $request->paid_amount = $request->credit[$key];
                        if($request->payment_type == "Cash"): 
                            $moneyReceitId =   $this->salesRepositories->salesCreditPayment($eachVoucher,$request->paid_amount,$request->payment_type,null,17);
                            //sales payment journal
                            Journal::salePaymentJournal($eachVoucher,$request->credit[$key],$request->account_id,$request->date,17);
                        else: 
                            $moneyReceitId =  $this->salesRepositories->saleBankPayment($eachVoucher,$request,17);    
                        endif;
                    endif;
                endforeach;

        elseif($collection_type == 'Booking'): 
       
                
            foreach($voucherList as $key => $eachVoucher): 
              
                if(!empty($request->credit[$key])): 
                    $request->paid_amount = $request->credit[$key];
               
                    if($request->payment_type == "Cash"): 
                        $moneyReceitId =   $this->salesRepositories->salesCreditPayment($eachVoucher,$request->paid_amount,$request->payment_type,null,18);
                        //sales payment journal
                        Journal::salePaymentJournal($eachVoucher,$request->credit[$key],$request->account_id,$request->date,18);
                    else: 
                        $moneyReceitId =  $this->salesRepositories->saleBankPayment($eachVoucher,$request,18);   
                     
                    endif;
                endif;
            endforeach;

                    else: 
            endif;

            DB::commit();
            // all good
          
            return $moneyReceitId;
        } catch (\Exception $e) {
            DB::rollback();

            

            return $e->getMessage();
        }
    }

}