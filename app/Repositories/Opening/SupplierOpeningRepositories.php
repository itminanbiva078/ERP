<?php

namespace App\Repositories\Opening;

use App\Helpers\Helper;
use App\Models\PurchasesPayment;
use Illuminate\Support\Facades\Auth;
use App\Models\SupplierOpeningDetails;
use App\Models\SupplierOpening;
use DB;

class SupplierOpeningRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var SupplierOpening
     */
    private $supplierOpening;
    /**
     * SupplierOpeningRepositories constructor.
     * @param SupplierOpeningRepositories $supplierOpeningRepositories
     */
    public function __construct(SupplierOpening $supplierOpening)
    {
        $this->supplierOpening = $supplierOpening;
       
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns, "id");
        $edit = Helper::roleAccess('openingSetup.supplierOpening.edit') ? 1 : 0;
        $delete = Helper::roleAccess('openingSetup.supplierOpening.destroy') ? 1 : 0;
        $show = Helper::roleAccess('openingSetup.supplierOpening.show') ? 1 : 0;
        $ced = $edit + $delete + $show;

        $totalData = $this->supplierOpening::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $supplierOpenings = $this->supplierOpening::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->supplierOpening::count();
        } else {
            $search = $request->input('search.value');
            $supplierOpenings = $this->supplierOpening::select($columns)->company()->where(function ($q) use ($columns, $search) {
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
            $totalFiltered = $this->supplierOpening::select($columns)->company()->where(function ($q) use ($columns, $search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }

        $columns = Helper::getQueryProperty();
        $data = array();

        if ($supplierOpenings) {
            foreach ($supplierOpenings as $key => $supplierOpening) {
                $nestedData['id'] = $key + 1;
               
                if ($ced != 0) :
                    if ($edit != 0)
                    $edit_data = '<a href="' . route('openingSetup.supplierOpening.edit', $supplierOpening->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    else
                    $edit_data = '';
                        $show_data = '<a href="' . route('openingSetup.supplierOpening.show', $supplierOpening->id) . '" show_id="' . $supplierOpening->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $supplierOpening->id . '"><i class="fa fa-search-plus"></i></a>';
                    if ($delete != 0)
                        $delete_data = '<a delete_route="' . route('openingSetup.supplierOpening.destroy', $supplierOpening->id) . '" delete_id="' . $supplierOpening->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $supplierOpening->id . '"><i class="fa fa-times"></i></a>';
                    else
                        $delete_data = '';

                    $nestedData['action'] = $edit_data . ' ' . $delete_data . '  '.$show_data;
                else :
                    $nestedData['action'] = '';
                endif;
              


                foreach($columns as $key => $value ):
                    if($value == 'status'):
                if ($supplierOpening->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('openingSetup.supplierOpening.status', [$supplierOpening->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('openingSetup.supplierOpening.status', [$supplierOpening->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                    $nestedData['status'] = $status;
                else:
                    $nestedData[$value] = $supplierOpening->$value;
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
        $result = supplierOpening::select("*")->with([
            'supplierOpeningDetails' => function($q){
              $q->select('id','supplier_openings_id','date','opening_balance','supplier_id');
          },'supplierOpeningDetails.supplier' => function($q){
              $q->select('id','code','name','status','company_id');
          }])->where('id', $id)->first();
          return $result;

    }


    public function store($request)
    {
        DB::beginTransaction();
    try {
       
            $poMaster =  new $this->supplierOpening();
            $poMaster->date = helper::mysql_date($request->date);
            $poMaster->voucher_no  = $request->voucher_no;
            $poMaster->total_balance  = $request->sub_total;
            $poMaster->status  = 'Approved';
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

    public function masterDetails($masterId, $request)
    {

        SupplierOpeningDetails::where('supplier_openings_id', $masterId)->company()->delete();
        PurchasesPayment::where('voucher_id', $masterId)->company()->delete();
        $supplierInfo = $request->supplier_id;
        $allDetails = array();
        foreach ($supplierInfo as $key => $value) :
            $masterDetails = array();
            $masterDetails['company_id'] = helper::companyId();
            $masterDetails['date'] = helper::mysql_date($request->date);
            $masterDetails['supplier_openings_id'] = $masterId;
            $masterDetails['supplier_id'] = $request->supplier_id[$key];
            $masterDetails['opening_balance'] = $request->opening_balance[$key];
            array_push($allDetails, $masterDetails);
            $this->purchasesDebitPayment($masterId,$request->supplier_id[$key],$request->opening_balance[$key],$request->date);
        endforeach;
        $saveInfo =  SupplierOpeningDetails::insert($allDetails);
        return $saveInfo;
    }

  
    public function update($request, $id)
    {

        DB::beginTransaction();
            try {
            $poMaster = $this->supplierOpening::findOrFail($id);
            $poMaster->date = helper::mysql_date($request->date);
            $poMaster->voucher_no  = $request->voucher_no;
            $poMaster->total_balance  = $request->sub_total;
            $poMaster->status  = 'Approved';
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

   
    public function purchasesDebitPayment($purchases_id,$supplier_id,$payment,$date)
    {
       
        $purchasesDebitPayment =  new PurchasesPayment();
        $purchasesDebitPayment->date = helper::mysql_date($date);
        $purchasesDebitPayment->company_id =helper::companyId();
        $purchasesDebitPayment->supplier_id  =$supplier_id;
        $purchasesDebitPayment->branch_id  = helper::getDefaultBatch();
        $purchasesDebitPayment->voucher_id  = $purchases_id;
        $purchasesDebitPayment->voucher_no  = helper::generateInvoiceId("purchases_payment_prefix","purchases_payments");
        $purchasesDebitPayment->debit  = $payment;
        $purchasesDebitPayment->note  = 'Opening Balance';
        $purchasesDebitPayment->payment_type  = 'Opening Balance';
        $purchasesDebitPayment->status  = 'Approved';
        $purchasesDebitPayment->updated_by = Helper::userId();
        $purchasesDebitPayment->created_by = Helper::userId();
        $purchasesDebitPayment->save();
        return $purchasesDebitPayment->id;
    }


    public function destroy($id)
    {
        DB::beginTransaction();
        
    try {
        $supplierOpening = $this->supplierOpening::find($id);
        $supplierOpening->delete();
        SupplierOpeningDetails::where('supplier_openings_id', $id)->delete();

        DB::commit();
            // all good
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
