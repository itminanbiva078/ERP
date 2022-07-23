<?php

namespace App\Repositories\SalesTransaction;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\SalesQuatationDetails;
use App\Models\SalesQuatation;
use DB;

class SalesQuatationRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var SalesQuatation
     */
    private $salesQuatation;
    /**
     * SalesQuatationRepositories constructor.
     * @param salesQuatation $salesQuatation
     */
    public function __construct(SalesQuatation $salesQuatation)
    {
        $this->salesQuatation = $salesQuatation;

    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('salesTransaction.salesQuatation.edit') ? 1 : 0;
        $delete = Helper::roleAccess('salesTransaction.salesQuatation.destroy') ? 1 : 0;
        $show = Helper::roleAccess('salesTransaction.salesQuatation.show') ? 1 : 0;
        $ced = $edit + $delete + $show;

        $totalData = $this->salesQuatation::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $salesQuatations = $this->salesQuatation::select($columns)->company()->with('salesQuatationDetails','customer','branch')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->salesQuatation::count();
        } else {
            $search = $request->input('search.value');
            $salesQuatations = $this->salesQuatation::select($columns)->company()->with('salesQuatationDetails','customer','branch')->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->salesQuatation::select($columns)->company()->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }

        foreach($salesQuatations as $key => $value):
            if(!empty($value->customer_id))
               $value->customer_id = $value->customer->name ?? '';

            if(!empty($value->branch_id))
               $value->branch_id  = $value->branch->name ?? '';
        endforeach;

        $columns = Helper::getQueryProperty();
        $data = array();


        if ($salesQuatations) {
            foreach ($salesQuatations as $key => $salesQuatation) {
                $nestedData['id'] = $key + 1;
               if ($ced != 0) :
                    if ($edit != 0 && $salesQuatation->quatation_status == 'Pending')
                        $edit_data = '<a href="' . route('salesTransaction.salesQuatation.edit', $salesQuatation->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    else
                        $edit_data = '';
                        $show_data = '<a href="' . route('salesTransaction.salesQuatation.show', $salesQuatation->id) . '" show_id="' . $salesQuatation->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $salesQuatation->id . '"><i class="fa fa-search-plus"></i></a>';
                     if ($delete != 0 && $salesQuatation->sales_status == 'Pending')
                        $delete_data = '<a delete_route="' . route('salesTransaction.salesQuatation.destroy', $salesQuatation->id) . '" delete_id="' . $salesQuatation->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $salesQuatation->id . '"><i class="fa fa-times"></i></a>';
                    else
                        $delete_data = '';

             $nestedData['action'] = $edit_data . ' ' . $delete_data . '  '.$show_data;
                else :
                    $nestedData['action'] = '';
                endif;

                foreach ($columns as $key => $value) :
                    if ($value == 'sales_status') :
                        $nestedData['sales_status'] = helper::statusBar($salesQuatation->sales_status);
                    elseif ($value == 'quatation_status') :
                        $nestedData['quatation_status'] = helper::statusBar($salesQuatation->quatation_status);
                    elseif($value == 'voucher_no'):
                        $nestedData[$value] = '<a target="_blank" href="' . route('salesTransaction.salesQuatation.show', $salesQuatation->id) . '" show_id="' . $salesQuatation->id . '" title="Details" class="">'.$salesQuatation->voucher_no.'</a>';
                    else:
                        $nestedData[$value] = $salesQuatation->$value;
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

        $result = SalesQuatation::select("*")->with([
            'salesQuatationDetails' => function($q){
              $q->select('id','sales_quatation_id','branch_id','date','pack_size','pack_no','quantity','unit_price','total_price','company_id','product_id');
          },'salesQuatationDetails.product' => function($q){
              $q->select('id','code','name','category_id','status','brand_id','company_id');
          }])->where('id', $id)->first();
          return $result;
    }
/**
     * @param $request
     * @return mixed
     */
    public function salesQuatations($saleQuatationId)
    {
        $saleQuatationInfo = SalesQuatation::with('salesQuatationDetails')->whereIn('id', $saleQuatationId)->get();
        return $saleQuatationInfo;
    }



    public function store($request)
    {

        DB::beginTransaction();
        try {
            $poMaster =  new $this->salesQuatation();
            $poMaster->date = helper::mysql_date();
            $poMaster->customer_id  = $request->customer_id;
            if (!empty($request->sales_quatation_id))
            $poMaster->sales_quatation_id  =implode("," ,$request->sales_quatation_id ?? '');
            $poMaster->branch_id  = $request->branch_id;
            $poMaster->voucher_no  =helper::generateInvoiceId("sales_quatation_prefix","sales_quatations");
            $poMaster->subtotal  = $request->sub_total;
            $poMaster->discount  = $request->discount;
            $poMaster->grand_total  = array_sum($request->total_price);
            $poMaster->note  = $request->note;
            $poMaster->sales_status  = 'Pending';
            $poMaster->created_by = helper::userId();
            $poMaster->company_id = helper::companyId();
            $poMaster->save();
            if($poMaster->id){
                if(!empty($request->documents))
                $poMaster->documents = helper::upload($request->documents,500,500,'salesQuatation',$poMaster->id);
                $poMaster->save();
            $this->masterDetails($poMaster->id,$request);
           }

            DB::commit();
            // all good
            return $poMaster->id ;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }



    public function masterDetails($masterId,$request){
        SalesQuatationDetails::where('sales_quatation_id',$masterId)->delete();
        $productInfo = $request->product_id;
        $allDetails = array();
        foreach($productInfo as $key => $value):
          $masterDetails=array();
          $masterDetails['company_id'] = helper::companyId();
          $masterDetails['date'] = helper::mysql_date();
          $masterDetails['sales_quatation_id'] =$masterId;
          $masterDetails['product_id']  =$request->product_id[$key];
          $masterDetails['pack_size']  = $request->pack_size[$key] ?? $request->quantity[$key];
          $masterDetails['pack_no']  = $request->pack_no[$key] ?? 1;
          $masterDetails['quantity']  =$request->quantity[$key];
          $masterDetails['unit_price']  =$request->unit_price[$key];
          $masterDetails['total_price']  =$request->total_price[$key];
          array_push($allDetails,$masterDetails);
        endforeach;
       $saveInfo =  SalesQuatationDetails::insert($allDetails);
       return $saveInfo;
    }




    public function update($request, $id)
    {
        DB::beginTransaction();

        try {
        $poMaster = $this->salesQuatation::findOrFail($id);
        $poMaster->date = date('Y-m-d',strtotime($request->date));
        $poMaster->customer_id  = $request->customer_id;
        $poMaster->branch_id  = $request->branch_id;
        $poMaster->voucher_no  = $request->voucher_no;
        $poMaster->documents  = $request->documents;
        $poMaster->grand_total  = array_sum($request->total_price);
        $poMaster->note  = $request->note;
        $poMaster->sales_status  = 'Pending';
        $poMaster->updated_by = helper::userId();
        $poMaster->company_id = helper::companyId();
        $poMaster->save();
            if($poMaster->id){
                if(!empty($request->documents))
                $poMaster->documents = helper::upload($request->documents,500,500,'salesQuatation',$poMaster->id);
                $poMaster->save();
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
        $salesQuatation = $this->salesQuatation::find($id);
        $salesQuatation->sales_status = $status;
        $salesQuatation->save();
        return $salesQuatation;
    }

    public function approved($id, $request)
    {
        $salesQuatation = $this->salesQuatation::find($id);
        $salesQuatation->quatation_status = $request->status;
        $salesQuatation->approved_by = helper::userId();
        $salesQuatation->save();
        return $salesQuatation;
    }
    public function destroy($id)
    {
        DB::beginTransaction();

    try {
        $salesQuatation = $this->salesQuatation::find($id);
        if($salesQuatation->quatation_status == 'Pending'):
        $salesQuatation->delete();
        SalesQuatationDetails::where('sales_quatation_id', $id)->delete();
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
