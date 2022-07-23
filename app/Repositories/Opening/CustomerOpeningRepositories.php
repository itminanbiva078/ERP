<?php

namespace App\Repositories\Opening;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerOpening;
use App\Models\CustomerOpeningDetails;
use App\Models\SalePayment;
use DB;

class CustomerOpeningRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var CustomerOpening
     */
    private $customerOpening;
    /**
     * CustomerOpeningRepositories constructor.
     * @param CustomerOpeningRepositories $customerOpeningRepositories
     */
    public function __construct(CustomerOpening $customerOpening)
    {
        $this->customerOpening = $customerOpening;
       
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns, "id");
        $edit = Helper::roleAccess('openingSetup.customerOpening.edit') ? 1 : 0;
        $delete = Helper::roleAccess('openingSetup.customerOpening.destroy') ? 1 : 0;
        $show = Helper::roleAccess('openingSetup.customerOpening.show') ? 1 : 0;
        $ced = $edit + $delete + $show;

        $totalData = $this->customerOpening::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $customerOpenings = $this->customerOpening::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->customerOpening::count();
        } else {
            $search = $request->input('search.value');
            $customerOpenings = $this->customerOpening::select($columns)->company()->where(function ($q) use ($columns, $search) {
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
            $totalFiltered = $this->customerOpening::select($columns)->company()->where(function ($q) use ($columns, $search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }

        $columns = Helper::getQueryProperty();
        $data = array();

        if ($customerOpenings) {
            foreach ($customerOpenings as $key => $customerOpening) {
                $nestedData['id'] = $key + 1;
               
                if ($ced != 0) :
                    if ($edit != 0)
                    $edit_data = '<a href="' . route('openingSetup.customerOpening.edit', $customerOpening->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    else
                    $edit_data = '';
                        $show_data = '<a href="' . route('openingSetup.customerOpening.show', $customerOpening->id) . '" show_id="' . $customerOpening->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $customerOpening->id . '"><i class="fa fa-search-plus"></i></a>';
                    if ($delete != 0)
                        $delete_data = '<a delete_route="' . route('openingSetup.customerOpening.destroy', $customerOpening->id) . '" delete_id="' . $customerOpening->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $customerOpening->id . '"><i class="fa fa-times"></i></a>';
                    else
                        $delete_data = '';

                    $nestedData['action'] = $edit_data . ' ' . $delete_data . '  '.$show_data;
                else :
                    $nestedData['action'] = '';
                endif;
              
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                if ($customerOpening->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('openingSetup.customerOpening.status', [$customerOpening->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('openingSetup.customerOpening.status', [$customerOpening->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                    $nestedData['status'] = $status;
                else:
                    $nestedData[$value] = $customerOpening->$value;
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
        $result = CustomerOpening::select("*")->with([
            'customerOpeningDetails' => function($q){
              $q->select('id','customer_openings_id','date','opening_balance','customer_id');
          },'customerOpeningDetails.customer' => function($q){
              $q->select('id','code','name','status','company_id');
          }])->where('id', $id)->first();
          return $result;

    }


    public function store($request)
    {
        DB::beginTransaction();
    try {

            $poMaster =  new $this->customerOpening();
            $poMaster->date = helper::mysql_date($request->date);
            $poMaster->voucher_no  = $request->voucher_no;
            $poMaster->total_balance  = $request->sub_total;
            $poMaster->status  = 'Pending';
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

    public function customerOpeningDebit($masterId,$customerId,$payment,$date)
    {

        $saleDebitPayment =  new SalePayment();
        $saleDebitPayment->date = helper::mysql_date($date);
        $saleDebitPayment->company_id = helper::companyId(); //sales info
        $saleDebitPayment->customer_id  = $customerId;
        $saleDebitPayment->branch_id  =  helper::getDefaultBatch();
        $saleDebitPayment->payment_type  ='Opening Balance';
        $saleDebitPayment->voucher_id  =$masterId;
        $saleDebitPayment->voucher_no  = helper::generateInvoiceId("sales_payment_prefix","sale_payments");
        $saleDebitPayment->debit  = $payment;
        $saleDebitPayment->note  = 'Opening';
        $saleDebitPayment->status  = 'Approved';
        $saleDebitPayment->updated_by = Helper::userId();
        $saleDebitPayment->created_by = Helper::userId();
        $saleDebitPayment->save();
        return $saleDebitPayment->id;
    }





    public function masterDetails($masterId, $request)
    {

        CustomerOpeningDetails::where('customer_openings_id', $masterId)->company()->delete();
        SalePayment::where('voucher_id',$masterId)->company()->delete();
        $productInfo = $request->customer_id;
        $allDetails = array();
        foreach ($productInfo as $key => $value) :
            $masterDetails = array();
            $masterDetails['company_id'] = helper::companyId();
            $masterDetails['date'] = helper::mysql_date($request->date);
            $masterDetails['customer_openings_id'] = $masterId;
            $masterDetails['customer_id'] = $request->customer_id[$key];
            $masterDetails['opening_balance'] = $request->opening_balance[$key];
            array_push($allDetails, $masterDetails);
            $this->customerOpeningDebit($masterId,$request->customer_id[$key],$request->opening_balance[$key],$request->date);
        endforeach;
        $saveInfo =  CustomerOpeningDetails::insert($allDetails);
        return $saveInfo;
    }

  
    public function update($request, $id)
    {

        DB::beginTransaction();
            try {
            $poMaster = $this->customerOpening::findOrFail($id);
            $poMaster->date = helper::mysql_date($request->date);
            $poMaster->voucher_no  = $request->voucher_no;
            $poMaster->total_balance  = $request->sub_total;
            $poMaster->status  = 'Pending';
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

   

    public function destroy($id)
    {
        DB::beginTransaction();
        
    try {
        $customerOpening = $this->customerOpening::find($id);
        $customerOpening->delete();
        CustomerOpeningDetails::where('customer_openings_id', $id)->delete();

        DB::commit();
            // all good
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
