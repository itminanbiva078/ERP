<?php

namespace App\Repositories\AccountTransaction;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\ReceiveVoucherLedger;
use App\Models\ReceiveVoucher;
use App\Models\General;
use App\Models\GeneralLedger;
use App\Models\PurchasesPayment;
use App\Models\SalePayment;
use DB;

class ReceiveVoucherRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var ReceiveVoucher
     */
    private $receiveVoucher;
    /**
     * ReceiveVoucherRepositories constructor.
     * @param ReceiveVoucher $receiveVoucher
     */
    public function __construct(ReceiveVoucher $receiveVoucher)
    {
        $this->receiveVoucher = $receiveVoucher;
       
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {

       
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('accountTransaction.receiveVoucher.edit') ? 1 : 0;
        $delete = Helper::roleAccess('accountTransaction.receiveVoucher.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->receiveVoucher::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $receiveVouchers = $this->receiveVoucher::select($columns)->with('accountType')->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->receiveVoucher::count();
        } else {
            $search = $request->input('search.value');
            $receiveVouchers = $this->receiveVoucher::select($columns)->with('accountType')->company()->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->receiveVoucher::select($columns)->company()->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }
        foreach($receiveVouchers as $key => $value):
            
            if(!empty($value->account_type_id))
               $value->account_type_id  = $value->accountType->name ?? '';

        endforeach;

        $columns = Helper::getQueryProperty();
        $data = array();
        if ($receiveVouchers) {
            foreach ($receiveVouchers as $key => $receiveVoucher) {
                $nestedData['id'] = $key + 1;
                foreach ($columns as $key => $value) :
                    if ($value == 'status') :
                        $nestedData['status'] = helper::statusBar($receiveVoucher->status);
                    elseif($value == 'voucher_no'):

                        $nestedData[$value] = '<a target="_blank" href="' . route('accountTransaction.receiveVoucher.show', $receiveVoucher->id) . '" show_id="' . $receiveVoucher->id . '" title="Details" class="">'.$receiveVoucher->voucher_no.'</a>';
                    else:    
                        $nestedData[$value] = $receiveVoucher->$value;
                    endif;
                endforeach;
            if ($ced != 0) :
                if ($edit != 0)
                
                $edit_data = '<a href="' . route('accountTransaction.receiveVoucher.edit', $receiveVoucher->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                else
                    $edit_data = '';
                    $show_data = '<a href="' . route('accountTransaction.receiveVoucher.show', $receiveVoucher->id) . '" show_id="' . $receiveVoucher->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $receiveVoucher->id . '"><i class="fa fa-search-plus"></i></a>';

                if ($delete != 0)
                $delete_data = '<a delete_route="' . route('accountTransaction.receiveVoucher.destroy', $receiveVoucher->id) . '" delete_id="' . $receiveVoucher->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $receiveVoucher->id . '"><i class="fa fa-times"></i></a>';
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
        $receiveInfo = ReceiveVoucher::select("*")->with(['customer' => function($q){
            $q->select('id','name','email','phone','address');
        }, 'supplier' => function($q){
            $q->select('id','name','email','phone','address');
        },'receiveVoucherLedger' => function($q){
            $q->select('id','account_id','date','debit','credit','memo','company_id','receive_id');
        },'receiveVoucherLedger.account' => function($q){
            $q->select('id','account_code','name','is_posted','status','branch_id','parent_id','company_id');
        }])->where('id', $id)->first();
       return $receiveInfo;
    }


    public function receiveVoucherDetails($receive_id)
    {
        $receiveInfo = ReceiveVoucher::with(['receiveVoucherLedger','customer','supplier'])->whereIn('id', $receive_id)->get();
        return $receiveInfo;

    }

   
    public function store($request)
    {
      
        DB::beginTransaction();

            try {
                $poMaster =  new $this->receiveVoucher();
                $poMaster->date = date('Y-m-d', strtotime($request->date));
                $poMaster->voucher_no  = $request->voucher_no;
                $poMaster->account_type_id  = $request->account_type_id;
                $poMaster->miscellaneous  = $request->miscellaneous;
                $poMaster->documents  = $request->documents;
                $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
                $poMaster->supplier_id  = $request->supplier_id;
                $poMaster->customer_id  = $request->customer_id;
                $poMaster->credit  = array_sum($request->debit);
                $poMaster->status  = 'Pending';
                $poMaster->note  = $request->note;
                $poMaster->updated_by = Auth::user()->id;
                $poMaster->approved_by = helper::userId();
                $poMaster->company_id = Auth::user()->company_id;
                $poMaster->save();
                if ($poMaster->id) {
                    $this->masterDetails($poMaster->id, $request);

                    if(helper::isReceiveVoucherAuto()):

                    //purchasesPayment table data save
                    if($request->account_type_id == 5): 
                        $this->purchasesPayment($poMaster->id);
                    endif;
                        //salesPayment table data save
                        if($request->account_type_id == 4): 
                            $this->salesPayment($poMaster->id);
                    endif;

                    //general table data save
                    $general_id = $this->generalSave($poMaster->id);

                    //debit ledger 
                    $this->debitLedger($general_id,$request);
                    //credit ledger
                    $this->creditLedger($general_id,$request);

                    $poMaster->status = 'Approved';
                    $poMaster->approved_by = helper::userId();
                    $poMaster->save();

                    else:
                        $poMaster->status = 'Pending';
                        $poMaster->save();
                    endif;
                    }
                    DB::commit();
                    // all good
                    
                    return $poMaster->id ;

                } catch (\Exception $e) {
                    DB::rollback();
                    return $e->getMessage();
                }
            }

            public function accountApproved($receive_voucher_id,$request){
                
                DB::beginTransaction();
                try {
                       $poMaster = ReceiveVoucher::where("id",$receive_voucher_id)->company()->first();
                  
                       if($poMaster->status == 'Pending'):
                       //purchasesPayment table data save
                            if($poMaster->account_type_id == 5): 
                                $this->purchasesPayment($poMaster->id);
                            endif;
                                //salesPayment table data save
                                if($poMaster->account_type_id == 4): 
                                    $this->salesPayment($poMaster->id);
                            endif;
                              //general table data save
                                $general_id = $this->generalSave($poMaster->id);
                                //general ledger table data save
                                $this->generalLedgerSave($poMaster->id,$general_id);
                            
                                $poMaster->status = 'Approved';
                                $poMaster->save();
                        endif;
        
                     DB::commit();
                    // all good
                    return $poMaster->id;
                } catch (\Exception $e) {
                    DB::rollback();

                    dd($e->getMessage());
                    return $e->getMessage();
                }
        
            }

            public function generalLedgerSave($receiveVoucherLedgerId,$general_id)
            {
                $receiveVoucherLedgerInfo = ReceiveVoucherLedger::where('receive_id', $receiveVoucherLedgerId)->company()->get();
                $debitLdger = array();
               
                foreach ($receiveVoucherLedgerInfo as $key => $eachInfo) :

                    $generalLedger = array();
                    $generalLedger['company_id'] = helper::companyId();
                    $generalLedger['account_id'] = $eachInfo->account_id;
                    $generalLedger['debit'] = $eachInfo->debit ?? 0;
                    $generalLedger['credit'] = $eachInfo->credit ?? 0;
                    $generalLedger['memo'] = $eachInfo->memo;
                    $generalLedger['date'] = helper::mysql_date($eachInfo->date);
                    $generalLedger['general_id'] = $general_id;
                    $generalLedger['form_id']  = 3;
                   
                array_push($debitLdger, $generalLedger);
                endforeach;
                $saveInfo =  GeneralLedger::insert($debitLdger);
              
                return $saveInfo;
            }

            public function purchasesPayment($receiveVoucherId){

                $purchasesPaymentInfo = $this->receiveVoucher::find($receiveVoucherId); 
                $purchasesPayment =  new PurchasesPayment();
                $purchasesPayment->date = date('Y-m-d');
                $purchasesPayment->form_id =3;//purchases payment info
                $purchasesPayment->branch_id  = $purchasesPaymentInfo->branch_id ?? 0;
                $purchasesPayment->supplier_id  = $purchasesPaymentInfo->supplier_id;
                $purchasesPayment->voucher_id  = $receiveVoucherId;
                $purchasesPayment->voucher_no  = helper::generateInvoiceId("payment_voucher_prefix","purchases_payments");
                $purchasesPayment->credit  = $purchasesPaymentInfo->credit;
                $purchasesPayment->debit  = $purchasesPaymentInfo->credit;
                $purchasesPayment->status  ='Approved';
                $purchasesPayment->updated_by = helper::userId();
                $purchasesPayment->company_id = helper::companyId();
                $purchasesPayment->save();
                return $purchasesPayment->id;
            }


            public function salesPayment($receiveVoucherId){

                $salesPaymentInfo = $this->receiveVoucher::find($receiveVoucherId);
                $salePayment =  new SalePayment();
                $salePayment->date = date('Y-m-d');
                $salePayment->form_id =3;//sales payment info
                $salePayment->branch_id  = $salesPaymentInfo->branch_id ?? 0;
                $salePayment->customer_id  = $salesPaymentInfo->customer_id;
                $salePayment->voucher_id  = $receiveVoucherId;
                $salePayment->voucher_no  = helper::generateInvoiceId("payment_voucher_prefix","sale_payments");
                $salePayment->credit  = $salesPaymentInfo->credit;
                $salePayment->debit  = $salesPaymentInfo->credit;
                $salePayment->status  ='Approved';
                $salePayment->updated_by = helper::userId();
                $salePayment->company_id = helper::companyId();
                $salePayment->save();
                return $salePayment->id;
            }

                

            public function generalSave($receiveVoucherId){
                $purchasesInfo = $this->receiveVoucher::find($receiveVoucherId);
                $general =  new General();
                $general->date = date('Y-m-d');
                $general->company_id = $purchasesInfo->company_id;//purchases info
                $general->form_id =3;//purchases info
                $general->branch_id  = $purchasesInfo->branch_id;
                $general->voucher_id  = $receiveVoucherId;
                $general->debit  = $purchasesInfo->grand_total;
                $general->status  ='Approved';
                $general->updated_by = helper::userId();
                $general->company_id = helper::companyId();
                $general->save();
                return $general->id;
                
            }

            public function debitLedger($masterId, $request)
            {
            
                $debitVoucher = $request->credit_id;
                $debitLdger = array();
                foreach ($debitVoucher as $key => $eachInfo) :
                    $singleDebitLedger = array();
                    $singleDebitLedger['company_id'] =helper::companyId();
                    $singleDebitLedger['account_id'] = $eachInfo;
                    $singleDebitLedger['debit'] = $request->debit[$key];
                    $singleDebitLedger['memo'] = $request->memo[$key];
                    $singleDebitLedger['date'] = helper::mysql_date($request->date);
                    $singleDebitLedger['general_id'] = $masterId;
                    $singleDebitLedger['form_id']  = 3;
                array_push($debitLdger, $singleDebitLedger);
                endforeach;
                $saveInfo =  GeneralLedger::insert($debitLdger);
                return $saveInfo;
            }

            public function creditLedger($masterId, $request)
            {
                $creditVoucher = $request->debit_id;
                $creditLedger = array();
                foreach ($creditVoucher as $key => $eachInfo) :
                    $singleCreditLedger = array();
                    $singleCreditLedger['company_id'] = helper::companyId();
                    $singleCreditLedger['account_id'] = $eachInfo;
                    $singleCreditLedger['credit'] = array_sum($request->debit);
                    $singleCreditLedger['memo'] = $request->memo[$key];
                    $singleCreditLedger['date'] = helper::mysql_date($request->date);
                    $singleCreditLedger['general_id'] = $masterId;
                    $singleCreditLedger['form_id']  = 3;
                array_push($creditLedger, $singleCreditLedger);
                endforeach;
                $saveInfo =  GeneralLedger::insert($creditLedger);
                return $saveInfo;
            }


            public function masterDetails($masterId, $request)
            {
               
                ReceiveVoucherLedger::where('receive_id', $masterId)->delete();
                /*credit voucher start*/
                $creditVoucher = $request->credit_id;
                $creditLedger = array();
                foreach ($creditVoucher as $key => $eachInfo) :
                    $singleCreditLedger = array();
                    $singleCreditLedger['company_id'] = helper::companyId();//$eachInfo;
                    $singleCreditLedger['account_id'] = $eachInfo;
                    $singleCreditLedger['debit'] = array_sum($request->debit);
                    $singleCreditLedger['memo'] = $request->memo[$key];
                    $singleCreditLedger['date'] = helper::mysql_date($request->date);
                    $singleCreditLedger['receive_id'] = $masterId;
                array_push($creditLedger, $singleCreditLedger);
                endforeach;
                $saveInfo =  ReceiveVoucherLedger::insert($creditLedger);
                /*credit voucher end*/

                /*debit voucher start*/
                $debitVoucher = $request->debit_id;
                $debitLdger = array();
                foreach ($debitVoucher as $key => $eachInfo) :
                    $singleDebitLedger = array();
                    $singleDebitLedger['company_id'] =helper::companyId();// $eachInfo;
                    $singleDebitLedger['account_id'] = $eachInfo;
                    $singleDebitLedger['credit'] = $request->debit[$key];
                    $singleDebitLedger['memo'] = $request->memo[$key];
                    $singleDebitLedger['date'] = helper::mysql_date($request->date);
                    $singleDebitLedger['receive_id'] = $masterId;
                array_push($debitLdger, $singleDebitLedger);
                endforeach;
                $saveInfo =  ReceiveVoucherLedger::insert($debitLdger);
                /*debit voucher end*/
                return $saveInfo;
            }

            public function update($request, $id)
                {

                    DB::beginTransaction();
                        try {
                            $poMaster = $this->receiveVoucher::findOrFail($id);
                            $poMaster->date = date('Y-m-d', strtotime($request->date));
                            $poMaster->voucher_no  = $request->voucher_no;
                            $poMaster->account_type_id  = $request->account_type_id;
                            $poMaster->miscellaneous  = $request->miscellaneous;
                            $poMaster->documents  = $request->documents;
                            $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
                            $poMaster->supplier_id  = $request->supplier_id;
                            $poMaster->customer_id  = $request->customer_id;
                            $poMaster->status  = 'Pending';
                            $poMaster->note  = $request->note;
                            $poMaster->updated_by = Auth::user()->id;
                            $poMaster->company_id = Auth::user()->company_id;
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
                $receiveVoucher = $this->receiveVoucher::find($id);
                $receiveVoucher->status = $status;
                $receiveVoucher->save();
                return $receiveVoucher;
            }


            public function destroy($id)
            {
                DB::beginTransaction();
                
            try {
                $receiveVoucher = $this->receiveVoucher::find($id);
                $receiveVoucher->delete();
                ReceiveVoucherLedger::where('receive_id', $id)->delete();

                DB::commit();
                    // all good
                    return true;
                } catch (\Exception $e) {
                    DB::rollback();
                    return $e->getMessage();
                }
            }
        }
