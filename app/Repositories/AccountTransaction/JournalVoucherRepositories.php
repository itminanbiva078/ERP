<?php

namespace App\Repositories\AccountTransaction;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\JournalVoucherLedger;
use App\Models\JournalVoucher;
use App\Models\General;
use App\Models\GeneralLedger;
use DB;
class JournalVoucherRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var JournalVoucher
     */
    private $journalVoucher;
    /**
     * JournalVoucherRepositories constructor.
     * @param JournalVoucher $journalVoucher
     */
    public function __construct(JournalVoucher $journalVoucher)
    {
        $this->journalVoucher = $journalVoucher;
      
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {

       
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('accountTransaction.journalVoucher.edit') ? 1 : 0;
        $delete = Helper::roleAccess('accountTransaction.journalVoucher.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->journalVoucher::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $journalVouchers = $this->journalVoucher::select($columns)->company()->with('accountType')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->journalVoucher::count();
        } else {
            $search = $request->input('search.value');
            $journalVouchers = $this->journalVoucher::select($columns)->company()->with('accountType')->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->journalVoucher::select($columns)->company()->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }

        foreach($journalVouchers as $key => $value):
            
            if(!empty($value->account_type_id))
               $value->account_type_id  = $value->accountType->name ?? '';

        endforeach;

        $columns = Helper::getQueryProperty();
        $data = array();
        if ($journalVouchers) {
            foreach ($journalVouchers as $key => $journalVoucher) {
                $nestedData['id'] = $key + 1;
                foreach ($columns as $key => $value) :
                    if ($value == 'status') :
                        $nestedData['status'] = helper::statusBar($journalVoucher->status);
                    elseif($value == 'voucher_no'):

                        $nestedData[$value] = '<a target="_blank" href="' . route('accountTransaction.journalVoucher.show', $journalVoucher->id) . '" show_id="' . $journalVoucher->id . '" title="Details" class="">'.$journalVoucher->voucher_no.'</a>';
                    else:    
                        $nestedData[$value] = $journalVoucher->$value;
                    endif;
                endforeach;
            if ($ced != 0) :
                if ($edit != 0)
                $edit_data = '<a href="' . route('accountTransaction.journalVoucher.edit', $journalVoucher->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                else
                    $edit_data = '';
                    $show_data = '<a href="' . route('accountTransaction.journalVoucher.show', $journalVoucher->id) . '" show_id="' . $journalVoucher->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $journalVoucher->id . '"><i class="fa fa-search-plus"></i></a>';

                if ($delete != 0)
                $delete_data = '<a delete_route="' . route('accountTransaction.journalVoucher.destroy', $journalVoucher->id) . '" delete_id="' . $journalVoucher->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $journalVoucher->id . '"><i class="fa fa-times"></i></a>';
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

        $journaltInfo = JournalVoucher::select("*")->with(['customer' => function($q){
            $q->select('id','name','email','phone','address');
        }, 'supplier' => function($q){
            $q->select('id','name','email','phone','address');
        },'journalVoucherLedger' => function($q){
            $q->select('id','account_id','date','debit','credit','memo','company_id','journal_id');
        },'journalVoucherLedger.account' => function($q){
            $q->select('id','account_code','name','is_posted','status','branch_id','parent_id','company_id');
        }])->where('id', $id)->first();


       return $journaltInfo;
    }

    public function journalVoucherDetails($journal_id)
    {

        $journaltInfo = JournalVoucher::with(['journalVoucherLedger','customer','supplier'])->whereIn('id', $journal_id )->get();
        return $journaltInfo;

    }

    public function store($request)
    {

        DB::beginTransaction();

    try {
        $poMaster =  new $this->journalVoucher();
        $poMaster->date = date('Y-m-d', strtotime($request->date));
        $poMaster->voucher_no  = $request->voucher_no;
        $poMaster->miscellaneous  = $request->miscellaneous;
        $poMaster->account_type_id  = $request->account_type_id;
        $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
        $poMaster->documents  = $request->documents;
        $poMaster->supplier_id  = $request->supplier_id;
        $poMaster->customer_id  = $request->customer_id;
        $poMaster->status  = 'Approved';
        $poMaster->note  = $request->note;
        $poMaster->updated_by = helper::userId();
        $poMaster->company_id = helper::companyId();
        $poMaster->save();
        if ($poMaster->id) {
        $this->masterDetails($poMaster->id, $request);
        //general table data save
        $general_id = $this->generalSave($poMaster->id);
        //journal ledger 
        $this->journalLedger($general_id,$request);
        }
            DB::commit();
            // all good
            return $poMaster->id;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function generalSave($journalVoucherId){
        $purchasesInfo = $this->journalVoucher::find($journalVoucherId);
        $general =  new General();
        $general->date = date('Y-m-d');
        $general->company_id = $purchasesInfo->company_id; 
        $general->form_id =1; 
        $general->branch_id  = $purchasesInfo->branch_id;
        $general->voucher_id  = $journalVoucherId;
        $general->debit  = $purchasesInfo->grand_total;
        $general->status  ='Approved';
        $general->updated_by = helper::userId();
        $general->company_id = helper::companyId();
        $general->save();
        return $general->id;
        
    }

    public function journalLedger($masterId, $request)
    {
       
        $debitVoucher = $request->debit_id;
        $debitLdger = array();
        foreach ($debitVoucher as $key => $eachInfo) :
            $singleDebitLedger = array();
            $singleDebitLedger['company_id'] = helper::companyId();
            $singleDebitLedger['account_id'] = $eachInfo;
            $singleDebitLedger['debit'] = $request->debit[$key] ?? 0;
            $singleDebitLedger['credit'] = $request->credit[$key] ?? 0;
            $singleDebitLedger['memo'] = $request->memo[$key] ?? 0;
            $singleDebitLedger['date'] = helper::mysql_date($request->date);
            $singleDebitLedger['general_id'] = $masterId;
            $singleDebitLedger['form_id']  = 2;
          array_push($debitLdger, $singleDebitLedger);
        endforeach;

        $saveInfo =  GeneralLedger::insert($debitLdger);
        return $saveInfo;
    }

    public function masterDetails($masterId, $request)
    {
        
        JournalVoucherLedger::where('journal_id', $masterId)->delete();
        
        /*debit voucher start*/
        $debitVoucher = $request->debit_id;
        $debitLdger = array();
        foreach ($debitVoucher as $key => $eachInfo) :
            $singleDebitLedger = array();
            $singleDebitLedger['company_id'] = helper::companyId();
            $singleDebitLedger['account_id'] = $eachInfo;
            $singleDebitLedger['debit'] = $request->debit[$key] ?? 0;
            $singleDebitLedger['credit'] = $request->credit[$key] ?? 0;
            $singleDebitLedger['memo'] = $request->memo[$key] ?? 0;
            $singleDebitLedger['date'] = helper::mysql_date($request->date);
            $singleDebitLedger['journal_id'] = $masterId;
          array_push($debitLdger, $singleDebitLedger);
        endforeach;
        $saveInfo =  JournalVoucherLedger::insert($debitLdger);
        /*debit voucher end*/
        return $saveInfo;
    }



    public function update($request, $id)
    {
        
    DB::beginTransaction();
    try {
       $poMaster = $this->journalVoucher::findOrFail($id);
       $poMaster->date = date('Y-m-d', strtotime($request->date));
        $poMaster->voucher_no  = $request->voucher_no;
        $poMaster->miscellaneous  = $request->miscellaneous;
        $poMaster->account_type_id  = $request->account_type_id;
        $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
        $poMaster->documents  = $request->documents;
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
        //journal ledger 
        $this->journalLedger($general_id,$request);
        }
            DB::commit();
            // all good
            return $poMaster->id;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

   

    public function statusUpdate($id, $status)
    {
        $journalVoucher = $this->journalVoucher::find($id);
        $journalVoucher->status = $status;
        $journalVoucher->save();
        return $journalVoucher;
    }

    

    public function destroy($id)
    {
        DB::beginTransaction();
        
    try {
        $journalVoucher = $this->journalVoucher::find($id);
        $journalVoucher->delete();
        JournalVoucherLedger::where('journal_id', $id)->delete();

        DB::commit();
            // all good
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
