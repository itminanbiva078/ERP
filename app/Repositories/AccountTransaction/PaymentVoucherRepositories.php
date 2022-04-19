<?php

namespace App\Repositories\AccountTransaction;

use App\Helpers\Helper;
use App\Models\General;
use App\Models\GeneralLedger;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentVoucher;
use App\Models\PaymentVoucherLedger;
use App\Services\InventoryTransaction\PaymentVoucherService;
use DB;

class PaymentVoucherRepositories
{
    
    /**
     * PaymentVoucherRepositories constructor.
     * @param paymentVoucher $paymentVoucher
     */
    public function __construct(PaymentVoucher $paymentVoucher)
    {
        $this->paymentVoucher = $paymentVoucher;
      
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");  
        $edit = Helper::roleAccess('accountTransaction.paymentVoucher.edit') ? 1 : 0;
        $delete = Helper::roleAccess('accountTransaction.paymentVoucher.destroy') ? 1 : 0;
        $show = Helper::roleAccess('accountTransaction.paymentVoucher.show') ? 1 : 0;
        $ced = $edit + $delete + $show;

        $totalData = $this->paymentVoucher::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $paymentVouchers = $this->paymentVoucher::select($columns)->company()->with('accountType')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->paymentVoucher::count();
        } else {
            $search = $request->input('search.value');
            $paymentVouchers = $this->paymentVoucher::select($columns)->company()->with('accountType')->where(function ($q) use ($columns,$search) {
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
            $totalFiltered = $this->paymentVoucher::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }

        foreach($paymentVouchers as $key => $value):
            
            if(!empty($value->account_type_id))
               $value->account_type_id  = $value->accountType->name ?? '';

        endforeach;

        $columns = Helper::getQueryProperty();
        $data = array();
        if ($paymentVouchers) {
            foreach ($paymentVouchers as $key => $paymentVoucher) {
                $nestedData['id'] = $key + 1;
                foreach ($columns as $key => $value) :
                    if ($value == 'status') :
                        $nestedData['status'] = helper::statusBar($paymentVoucher->status);
                    elseif($value == 'voucher_no'):

                        $nestedData[$value] = '<a target="_blank" href="' . route('accountTransaction.paymentVoucher.show', $paymentVoucher->id) . '" show_id="' . $paymentVoucher->id . '" title="Details" class="">'.$paymentVoucher->voucher_no.'</a>';
                    else:    
                        $nestedData[$value] = $paymentVoucher->$value;
                    endif;
                endforeach;
            if ($ced != 0) :
                if ($edit != 0)
                $edit_data = '<a href="' . route('accountTransaction.paymentVoucher.edit', $paymentVoucher->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                else
                    $edit_data = '';
                    $show_data = '<a href="' . route('accountTransaction.paymentVoucher.show', $paymentVoucher->id) . '" show_id="' . $paymentVoucher->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $paymentVoucher->id . '"><i class="fa fa-search-plus"></i></a>';

                if ($delete != 0)
                $delete_data = '<a delete_route="' . route('accountTransaction.paymentVoucher.destroy', $paymentVoucher->id) . '" delete_id="' . $paymentVoucher->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $paymentVoucher->id . '"><i class="fa fa-times"></i></a>';
                else
                    $delete_data = '';
                    $nestedData['action'] = $edit_data . ' ' . $delete_data . '  '.$show_data;
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
    public function details($id)
    {

        $paymentInfo = PaymentVoucher::select("*")->with(['customer' => function($q){
            $q->select('id','name','email','phone','address');
        }, 'supplier' => function($q){
            $q->select('id','name','email','phone','address');
        },'paymentVoucherLedger' => function($q){
            $q->select('id','account_id','date','debit','credit','memo','company_id','payment_id');
        },'paymentVoucherLedger.account' => function($q){
            $q->select('id','account_code','name','is_posted','status','branch_id','parent_id','company_id');
        }])->where('id', $id)->first();


       return $paymentInfo;
    }

    public function paymentVoucherDetails($payment_id)
    {

        $paymentInfo = PaymentVoucher::with(['paymentVoucherLedger','customer','supplier'])->whereIn('id', $payment_id)->get();
        return $paymentInfo;

    }


    
    public function store($request)
    {
        DB::beginTransaction();

    try {
        $poMaster =  new $this->paymentVoucher();
        $poMaster->date = date('Y-m-d', strtotime($request->date));
        $poMaster->voucher_no  = $request->voucher_no;
        $poMaster->account_type  = $request->account_type;
        $poMaster->account_type_id  = $request->account_type_id;
        $poMaster->miscellaneous  = $request->miscellaneous;
        $poMaster->documents  = $request->documents;
        $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
        $poMaster->supplier_id  = $request->supplier_id;
        $poMaster->customer_id  = $request->customer_id;
        $poMaster->status  = 'Pending';
        $poMaster->note  = $request->note;
        $poMaster->updated_by = helper::userId();
        $poMaster->company_id = helper::companyId();
        $poMaster->save();
        if ($poMaster->id) {
        $this->masterDetails($poMaster->id, $request);
        //general table data save
        $general_id = $this->generalSave($poMaster->id);
      
        //debit ledger 
        $this->debitLedger($general_id,$request);
        //credit ledger
        $this->creditLedger($general_id,$request);
        }
            DB::commit();
            // all good
            return $poMaster->id ;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }


    public function generalSave($paymentVoucherId){
        $purchasesInfo = $this->paymentVoucher::find($paymentVoucherId);
        $general =  new General();
        $general->date = date('Y-m-d');
        $general->company_id = $purchasesInfo->company_id;//purchases info
        $general->form_id =2;//purchases info
        $general->branch_id  = $purchasesInfo->branch_id;
        $general->voucher_id  = $paymentVoucherId;
        $general->debit  = $purchasesInfo->grand_total;
        $general->status  ='Approved';
        $general->updated_by = helper::userId();
        $general->company_id = helper::companyId();
        $general->save();
        return $general->id;
        
    }



    public function debitLedger($masterId, $request)
    {
       
        $debitVoucher = $request->debit_id;
        $debitLdger = array();
        foreach ($debitVoucher as $key => $eachInfo) :
            $singleDebitLedger = array();
            $singleDebitLedger['company_id'] = helper::companyId();
            $singleDebitLedger['account_id'] = $eachInfo;
            $singleDebitLedger['debit'] = $request->debit[$key];
            $singleDebitLedger['memo'] = $request->memo[$key];
            $singleDebitLedger['date'] = helper::mysql_date($request->date);
            $singleDebitLedger['general_id'] = $masterId;
            $singleDebitLedger['form_id']  = 2;
          array_push($debitLdger, $singleDebitLedger);
        endforeach;
        $saveInfo =  GeneralLedger::insert($debitLdger);
        return $saveInfo;
    }

    public function creditLedger($masterId, $request)
    {
       
        $creditVoucher = $request->credit_id;
        $creditLedger = array();
        foreach ($creditVoucher as $key => $eachInfo) :
            $singleCreditLedger = array();
            $singleCreditLedger['company_id'] = helper::companyId();
            $singleCreditLedger['account_id'] = $eachInfo;
            $singleCreditLedger['credit'] = array_sum($request->debit);
            $singleCreditLedger['memo'] = $request->memo[$key];
            $singleCreditLedger['date'] = helper::mysql_date($request->date);
            $singleCreditLedger['general_id'] = $masterId;
            $singleCreditLedger['form_id']  = 2;
          array_push($creditLedger, $singleCreditLedger);
        endforeach;
        $saveInfo =  GeneralLedger::insert($creditLedger);
        return $saveInfo;
    }

    public function masterDetails($masterId, $request)
    {
        PaymentVoucherLedger::where('payment_id', $masterId)->company()->delete();
        /*credit voucher start*/
        $creditVoucher = $request->credit_id;
        $creditLedger = array();
        foreach ($creditVoucher as $key => $eachInfo) :
            $singleCreditLedger = array();
            $singleCreditLedger['company_id'] = helper::companyId();
            $singleCreditLedger['account_id'] = $eachInfo;
            $singleCreditLedger['credit'] = array_sum($request->debit);
            $singleCreditLedger['memo'] = $request->memo[$key] ?? 0;
            $singleCreditLedger['date'] = helper::mysql_date($request->date);
            $singleCreditLedger['payment_id'] = $masterId;
          array_push($creditLedger, $singleCreditLedger);
        endforeach;
        $saveInfo =  PaymentVoucherLedger::insert($creditLedger);
        /*credit voucher end*/

        /*credit voucher start*/
        $debitVoucher = $request->debit_id;
        $debitLdger = array();
        foreach ($debitVoucher as $key => $eachInfo) :
            $singleDebitLedger = array();
            $singleDebitLedger['company_id'] = helper::companyId();
            $singleDebitLedger['account_id'] = $eachInfo;
            $singleDebitLedger['debit'] = $request->debit[$key];
            $singleDebitLedger['memo'] = $request->memo[$key];
            $singleDebitLedger['date'] = helper::mysql_date($request->date);
            $singleDebitLedger['payment_id'] = $masterId;
          array_push($debitLdger, $singleDebitLedger);
        endforeach;
        $saveInfo =  PaymentVoucherLedger::insert($debitLdger);
        /*credit voucher end*/
        return $saveInfo;
    }


    public function update($request, $id)
    {

    DB::beginTransaction();
    try {
        $poMaster = $this->paymentVoucher::findOrFail($id);

        $poMaster->date = date('Y-m-d', strtotime($request->date));
        $poMaster->voucher_no  = $request->voucher_no;
        $poMaster->account_type  = $request->account_type;
        $poMaster->account_type_id  = $request->account_type_id;
        $poMaster->miscellaneous  = $request->miscellaneous;
        $poMaster->documents  = $request->documents;
        $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
        $poMaster->supplier_id  = $request->supplier_id;
        $poMaster->customer_id  = $request->customer_id;
        $poMaster->status  = 'Pending';
        $poMaster->note  = $request->note;
        $poMaster->updated_by = helper::userId();
        $poMaster->company_id = helper::companyId();
        $poMaster->save();
        if ($poMaster->id) {
        $this->masterDetails($poMaster->id, $request);
        //general table data save
        $general_id = $this->generalSave($poMaster->id);
      
        //debit ledger 
        $this->debitLedger($general_id,$request);
        //credit ledger
        $this->creditLedger($general_id,$request);
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
        $paymentVoucher = $this->paymentVoucher::find($id);
        $paymentVoucher->status = $status;
        $paymentVoucher->save();
        return $paymentVoucher;
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        
    try {
        $paymentVoucher = $this->paymentVoucher::find($id);
        $paymentVoucher->delete();
        PaymentVoucherLedger::where('payment_id', $id)->delete();

        DB::commit();
            // all good
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}