<?php

namespace App\Repositories\ServiceTransaction;
use App\Helpers\Helper;

use Illuminate\Support\Facades\Auth;
use App\Models\ServiceInvoiceDetails;
use App\Models\ServiceInvoice;
use App\Models\ServiceQuatation;

use DB;

class ServiceInvoiceRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var ServiceInvoice
     */
    private $serviceInvoice;
    /**
     * ServiceInvoiceRepositories constructor.
     * @param serviceInvoice $serviceInvoice
     */
    public function __construct(ServiceInvoice $serviceInvoice)
    {
        $this->serviceInvoice = $serviceInvoice;
       
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('serviceTransaction.serviceInvoice.edit') ? 1 : 0;
        $delete = Helper::roleAccess('serviceTransaction.serviceInvoice.destroy') ? 1 : 0;
        $show = Helper::roleAccess('serviceTransaction.serviceInvoice.show') ? 1 : 0;
        $ced = $edit + $delete + $show;

        $totalData = $this->serviceInvoice::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $serviceInvoices = $this->serviceInvoice::select($columns)->company()->with('serviceInvoiceDetails','customer','branch')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->serviceInvoice::count();
        } else {
            $search = $request->input('search.value');
            $serviceInvoices = $this->serviceInvoice::select($columns)->company()->with('serviceInvoiceDetails','customer','branch')->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->serviceInvoice::select($columns)->company()->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }

        foreach($serviceInvoices as $key => $value):
            if(!empty($value->customer_id))
               $value->customer_id = $value->customer->name ?? '';

            if(!empty($value->branch_id))
               $value->branch_id  = $value->branch->name ?? '';
        endforeach;

        $columns = Helper::getTableProperty();
        $data = array();
        if ($serviceInvoices) {
            foreach ($serviceInvoices as $key => $serviceInvoice) {
                $nestedData['id'] = $key + 1;
               
                if ($ced != 0) :
                    if ($edit != 0)
                        if($serviceInvoice->service_status == 'Pending'):
                        $edit_data = '<a href="' . route('serviceTransaction.serviceInvoice.edit', $serviceInvoice->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                        else: 
                            $edit_data = '';
                        endif;
                        else
                        $edit_data = '';

                        $show_data = '<a href="' . route('serviceTransaction.serviceInvoice.show', $serviceInvoice->id) . '" show_id="' . $serviceInvoice->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $serviceInvoice->id . '"><i class="fa fa-search-plus"></i></a>';

                               
                    if ($delete != 0)

                    if($serviceInvoice->$value == 'Pending'):
                        $delete_data = '<a delete_route="' . route('serviceTransaction.serviceInvoice.destroy', $serviceInvoice->id) . '" delete_id="' . $serviceInvoice->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $serviceInvoice->id . '"><i class="fa fa-times"></i></a>';
                    else: 
                        $delete_data = '';
                    endif;
                    else
                        $delete_data = '';
                    $nestedData['action'] = $edit_data . ' ' . $delete_data . ' ' .$show_data;
                else :
                    $nestedData['action'] = '';
                endif;
                foreach ($columns as $key => $value) :
                    if ($value == 'service_status') :
                        $nestedData['service_status'] = helper::statusBar($serviceInvoice->service_status);
                        elseif($value == 'voucher_no'):

                            $nestedData[$value] = '<a target="_blank" href="' . route('serviceTransaction.serviceInvoice.show', $serviceInvoice->id) . '" show_id="' . $serviceInvoice->id . '" title="Details" class="">'.$serviceInvoice->voucher_no.'</a>';
                    else :
                        $nestedData[$value] = $serviceInvoice->$value;
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
        
        $result = ServiceInvoice::select("*")->with([
            'serviceInvoiceDetails' => function($q){
              $q->select('id','service_invoice_id','date','quantity','unit_price','total_price','company_id','service_id');
          },'serviceInvoiceDetails.sevice' => function($q){
              $q->select('id','code','name','service_id','status','company_id');
          }])->where('id', $id)->first();
          return $result;
    }



    public function store($request)
    {
        DB::beginTransaction();
        try {
            $poMaster =  new $this->serviceInvoice();
            $poMaster->date =  helper::mysql_date($request->date);
            $poMaster->payment_type  = $request->payment_type;
            $poMaster->customer_id  = $request->customer_id;
            if(!empty( $request->service_invoice_id))
            $poMaster->service_invoice_id  =implode("," ,  $request->service_invoice_id ?? '');
            $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
            $poMaster->voucher_no  = $request->voucher_no;
            $poMaster->subtotal  = array_sum($request->total_price);
            $poMaster->documents  = $request->documents;
            $poMaster->discount  = $request->discount;
            $poMaster->grand_total  =  $request->grand_total;
            $poMaster->note  = $request->note;
            $poMaster->service_status  = 'Pending';
            $poMaster->updated_by = helper::userId();
            $poMaster->company_id = helper::companyId();
            $poMaster->save();
            if($poMaster->id){
            $this->masterDetails($poMaster->id,$request);
            $this->serviceQuatationUpdate($request->service_quatation_id);
            }

            DB::commit();
            // all good
            return $poMaster->id ;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function checkPendingRequisition($request){
        if(!empty($request->service_quatation_id)){
            $totalFalse = 0;
            foreach($request->service_quatation_id as $eachrequisitionId):
               $pendingRequsitionList = ServiceQuatation::where('id', $eachrequisitionId)->where('status','Pending')->count();
                if(empty($pendingRequsitionList)){
                    $totalFalse += 1;
                }
            endforeach;
            return $totalFalse;
        }
    } 

    public function masterDetails($masterId,$request){
        ServiceInvoiceDetails::where('service_invoice_id',$masterId)->delete();
        $serviceInfo = $request->service_id;
        $allDetails = array();
        foreach($serviceInfo as $key => $value):
            $masterDetails=array();
          $masterDetails['service_invoice_id'] =$masterId;
          $masterDetails['company_id'] = helper::companyId();
          $masterDetails['date'] = helper::mysql_date();
          $masterDetails['service_id']  =$request->service_id[$key];
          $masterDetails['quantity']  =$request->quantity[$key];
          $masterDetails['unit_price']  =$request->unit_price[$key];
          $masterDetails['total_price']  =$request->total_price[$key];
          array_push($allDetails,$masterDetails);
        endforeach;
       $saveInfo =  ServiceInvoiceDetails::insert($allDetails);
       return $saveInfo;
    }


    public function update($request, $id)
    {
        DB::beginTransaction(); 
            
        try {
        $poMaster = $this->serviceInvoice::findOrFail($id);
        $poMaster->date = date('Y-m-d',strtotime($request->date));
        $poMaster->payment_type  = $request->payment_type;
        $poMaster->customer_id  = $request->customer_id;
        $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
        $poMaster->voucher_no  = $request->voucher_no;
        $poMaster->documents  = $request->documents;
        $poMaster->grand_total  = array_sum($request->total_price);
        $poMaster->note  = $request->note;
        $poMaster->service_status  = 'Pending';
        $poMaster->updated_by = helper::userId();
        $poMaster->company_id = helper::companyId();
        $poMaster->save();
            if($poMaster->id){
            $this->masterDetails($poMaster->id,$request);

            $this->serviceQuatationUpdate($request->service_quatation_id);

            }
            DB::commit();
            // all good
            return $poMaster->id;
        } 
        catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        } 
     }


     public function serviceQuatationUpdate($serviceQuatationId)
     {
 
         if (!empty($serviceQuatationId)) {
             foreach ($serviceQuatationId as $key => $value) :
                 $serviceQuatation =  ServiceQuatation::findOrFail($value);
                 $serviceQuatation->service_status = 'Approved';
                 $serviceQuatation->save();
             endforeach;
         }
         return true;
     }

     public function approved($id, $status)
     {
         $serviceInvoice = $this->serviceInvoice::find($id);
         $serviceInvoice->service_status = $status;
         $serviceInvoice->save();
         return $serviceInvoice;
     }

    public function destroy($id)
    {
        DB::beginTransaction(); 
            
    try {
        $serviceInvoice = $this->serviceInvoice::find($id);
        $serviceInvoice->delete();
        if (!empty($serviceInvoice->service_invoice_id)) :
            $serviceInvoiceInfo = ServiceInvoiceDetails::find($serviceInvoice->service_invoice_id);
            $serviceInvoiceInfo->status = 'Pending';
            $serviceInvoiceInfo->save();
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
