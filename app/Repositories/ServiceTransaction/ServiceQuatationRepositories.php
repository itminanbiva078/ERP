<?php

namespace App\Repositories\ServiceTransaction;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceQuatationDetails;
use App\Models\ServiceQuatation;
use DB;

class ServiceQuatationRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var ServiceQuatation
     */
    private $serviceQuatation;
    /**
     * ServiceQuatationRepositories constructor.
     * @param ServiceQuatation $serviceQuatation
     */
    public function __construct(ServiceQuatation $serviceQuatation)
    {
        $this->serviceQuatation = $serviceQuatation;
       
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('serviceTransaction.serviceQuatation.edit') ? 1 : 0;
        $delete = Helper::roleAccess('serviceTransaction.serviceQuatation.destroy') ? 1 : 0;
        $show = Helper::roleAccess('serviceTransaction.serviceQuatation.show') ? 1 : 0;
        $ced = $edit + $delete + $show;

        $totalData = $this->serviceQuatation::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $serviceQuatations = $this->serviceQuatation::select($columns)->company()->with('serviceQuatationDetails','customer','branch')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->serviceQuatation::count();
        } else {
            $search = $request->input('search.value');
            $serviceQuatations = $this->serviceQuatation::select($columns)->company()->with('serviceQuatationDetails','customer','branch')->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->serviceQuatation::select($columns)->company()->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }

        foreach($serviceQuatations as $key => $value):
            if(!empty($value->customer_id))
               $value->customer_id = $value->customer->name ?? '';

            if(!empty($value->branch_id))
               $value->branch_id  = $value->branch->name ?? '';
        endforeach;

        $columns = Helper::getTableProperty();
        $data = array();


        if ($serviceQuatations) {
            foreach ($serviceQuatations as $key => $serviceQuatation) {
                $nestedData['id'] = $key + 1;
               
                if ($ced != 0) :
                    if ($edit != 0 && $serviceQuatation->quatation_status == 'Pending')
                        $edit_data = '<a href="' . route('serviceTransaction.serviceQuatation.edit', $serviceQuatation->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    else
                        $edit_data = '';
                        $show_data = '<a href="' . route('serviceTransaction.serviceQuatation.show', $serviceQuatation->id) . '" show_id="' . $serviceQuatation->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $serviceQuatation->id . '"><i class="fa fa-search-plus"></i></a>';
                     if ($delete != 0 && $serviceQuatation->quatation_status == 'Pending')
                        $delete_data = '<a delete_route="' . route('serviceTransaction.serviceQuatation.destroy', $serviceQuatation->id) . '" delete_id="' . $serviceQuatation->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $serviceQuatation->id . '"><i class="fa fa-times"></i></a>';
                    else
                        $delete_data = '';

             $nestedData['action'] = $edit_data . ' ' . $delete_data . '  '.$show_data;
                else :
                    $nestedData['action'] = '';
                endif;
                foreach ($columns as $key => $value) :
                    if ($value == 'quatation_status') :
                        $nestedData['quatation_status'] =  helper::statusBar($serviceQuatation->quatation_status);
                    elseif ($value == 'service_status') :
                        $nestedData['service_status'] =  helper::statusBar($serviceQuatation->service_status);
                    elseif($value == 'voucher_no'):

                        $nestedData[$value] = '<a target="_blank" href="' . route('serviceTransaction.serviceQuatation.show', $serviceQuatation->id) . '" show_id="' . $serviceQuatation->id . '" title="Details" class="">'.$serviceQuatation->voucher_no.'</a>';
                    else:    
                        $nestedData[$value] = $serviceQuatation->$value;
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
         $result = ServiceQuatation::select("*")->with([
            'serviceQuatationDetails' => function($q){
              $q->select('id','service_quatation_id','branch_id','service_id','date','discount','quantity','unit_price','total_price','company_id');
          },'serviceQuatationDetails.sevice' => function($q){
              $q->select('id','code','name','service_id','status','price','company_id');
          }])->where('id', $id)->first();
          return $result;
    }

    public function serviceQuatationDetails($serviceQuatation_id)
    {
        $serviceQuatationInfo = ServiceQuatation::with('serviceQuatationDetails')->whereIn('id', $serviceQuatation_id)->get();
        return $serviceQuatationInfo;
    }



    public function store($request)
    {
        DB::beginTransaction();
        try {
            $poMaster =  new $this->serviceQuatation();
            $poMaster->date =  helper::mysql_date($request->date);
            $poMaster->customer_id  = $request->customer_id;
            $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
            $poMaster->voucher_no  = $request->voucher_no;
            $poMaster->subtotal  =  array_sum($request->total_price);
            $poMaster->note  = $request->note;
            $poMaster->quatation_status  = 'Pending';
            $poMaster->created_by = helper::userId();
            $poMaster->company_id = helper::companyId();
            $poMaster->save();
            if($poMaster->id){
            $this->masterDetails($poMaster->id,$request);
        }

            DB::commit();
            // all good
            return $poMaster->id ;
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $e->getMessage();
        }
    }

  

    public function masterDetails($masterId,$request){
        ServiceQuatationDetails::where('service_quatation_id',$masterId)->delete();
        $productInfo = $request->service_id;
        $allDetails = array();
        foreach($productInfo as $key => $value):
          $masterDetails=array();
          $masterDetails['service_quatation_id'] =$masterId;
          $masterDetails['company_id'] = helper::companyId();
          $masterDetails['date'] = helper::mysql_date();
          $masterDetails['service_id']  =$request->service_id[$key];
          $masterDetails['quantity']  =$request->quantity[$key];
          $masterDetails['unit_price']  =$request->unit_price[$key];
          $masterDetails['total_price']  =$request->total_price[$key];
          array_push($allDetails,$masterDetails);
        endforeach;
       $saveInfo =  ServiceQuatationDetails::insert($allDetails);
       return $saveInfo;
    }

  


    public function update($request, $id)
    {
        DB::beginTransaction(); 
            
        try {
        $poMaster = $this->serviceQuatation::findOrFail($id);
        $poMaster->date = date('Y-m-d',strtotime($request->date));
        $poMaster->customer_id  = $request->customer_id;
        $poMaster->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
        $poMaster->voucher_no  = $request->voucher_no;
        $poMaster->documents  = $request->documents;
        $poMaster->grand_total  = array_sum($request->total_price);
        $poMaster->note  = $request->note;
        $poMaster->quatation_status  = 'Pending';
        $poMaster->updated_by = helper::userId();
        $poMaster->company_id = helper::companyId();
        $poMaster->save();
            if($poMaster->id){
            $this->masterDetails($poMaster->id,$request);
          
          
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

   

    public function statusUpdate($id, $status)
    {
        $serviceQuatation = $this->serviceQuatation::find($id);
        $serviceQuatation->service_status = $status;
        $serviceQuatation->save();
        return $serviceQuatation;
    }


    public function approved($id, $request)
    {
        $serviceQuatation = $this->serviceQuatation::find($id);
        $serviceQuatation->quatation_status = $request->status;
        $serviceQuatation->approved_by = helper::userId();
        $serviceQuatation->save();
        return $serviceQuatation;
    }

    public function destroy($id)
    {
        DB::beginTransaction(); 
            
    try {
        $serviceQuatation = $this->serviceQuatation::find($id);
        $serviceQuatation->delete();
        if (!empty($serviceQuatation->sales_id)) :
            $salesInfo = serviceQuatationDetails::find($serviceQuatation->sales_id);
            $salesInfo->status = 'Pending';
            $salesInfo->save();
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
