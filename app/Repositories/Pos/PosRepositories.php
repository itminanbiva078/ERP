<?php

namespace App\Repositories\Pos;
use App\Helpers\Helper;
use App\Helpers\Journal;
use Illuminate\Support\Facades\Auth;
use App\Models\Pos;
use App\Models\PosDetails;
use App\Models\Product;
use App\Models\StockSummary;
use App\Repositories\SalesTransaction\SalesRepositories;
use DB;

class PosRepositories
{
    /**
     * @var Pos
     */
    private $pos;
    /**
     * @var salesPayment
     */
    private $salesPayment;
    /**
     * PosRepositories constructor.
     * @param pos $pos
     */
    public function __construct(Pos $pos,SalesRepositories $salesPayment)
    {
        $this->pos = $pos;     
        $this->salesPayment = $salesPayment;     
    }

    /**
     * @param $request
     * @return mixed
     */

   /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $show = Helper::roleAccess('inventoryTransaction.purchases.show') ? 1 : 0;
        $delete = Helper::roleAccess('pos.pos.destroy') ? 1 : 0;
        $ced = $delete +  $show;

        $totalData = $this->pos::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $poss = $this->pos::select($columns)->with('customer','branch','store')->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->pos::count();
        } else {
            $search = $request->input('search.value');
            $poss = $this->pos::select($columns)->with('customer','branch','store')->company()->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->pos::select($columns)->company()->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }
        foreach ($poss as $key => $value) :
            if (!empty($value->customer_id))
                $value->customer_id = $value->customer->name ?? '';

            if (!empty($value->branch_id))
                $value->branch_id  = $value->branch->name ?? '';

            if (!empty($value->store_id))
                $value->store_id  = $value->store->name ?? '';
        endforeach;
        $columns = Helper::getQueryProperty();
        $data = array();
        if ($poss) {
            foreach ($poss as $key => $pos) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    
                    if($value == 'status'):
                        if ($pos->status == 'Approved') :
                        $status = '<input class="status_row" status_route="' . route('pos.pos.status', [$pos->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                    else :
                        $status = '<input  class="status_row" status_route="' . route('pos.pos.status', [$pos->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                    endif;
                        $nestedData['status'] = $status;
                    else:
                        $nestedData[$value] = $pos->$value;
                    endif;
              
            endforeach;
            if ($ced != 0) :
                $show_data = '<a href="' . route('pos.pos.show', $pos->id) . '" show_id="' . $pos->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $pos->id . '"><i class="fa fa-search-plus"></i></a>';

                if ($delete != 0)

                    if ($pos->status == 'Approved'):
                        $delete_data = '<a delete_route="' . route('pos.pos.destroy', $pos->id) . '" delete_id="' . $pos->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $pos->id . '"><i class="fa fa-times"></i></a>';
                        else :
                            $delete_data = '';
                        endif;


                    $delete_data = '';

                 $nestedData['action'] =  $delete_data . ' ' . $show_data;
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
        $result = Pos::select("*")->with([
            'posDetails' => function ($q) {
                $q->select('id', 'pos_id', 'branch_id', 'batch_no', 'date', 'pack_size', 'pack_no', 'discount', 'quantity', 'unit_price', 'total_price', 'company_id', 'product_id');
            }, 'posDetails.product' => function ($q) {
                $q->select('id', 'code', 'name', 'category_id', 'status', 'brand_id', 'company_id');
            }
        ])->where('id', $id)->first();
        return $result;
    }

   
    /**
     * @param $request
     * @return mixed
     */
    public function getProductList($request)
    {

        $category_id = $request->category_id;
        $product_name = $request->product_name;
        if(!empty($request->products)):
            $allProducts = $request->products;
            $flipProducts = array_flip($request->products);
            $allQuantitys = $request->quantitys;
        endif;

         $stockProductId = $this->getStockProduct();

        $products =  Product::where('status','Approved')->whereIn('id',$stockProductId)->company();
        $products->when(!empty($request->category_id) && $request->category_id !='All', function ($q) use($category_id) {
            return $q->where('category_id', $category_id);
        });
        $products->when(!empty($request->product_name), function ($q) use($product_name) {
            return $q->where('name', 'like', '%' . $product_name . '%');
        });
       $products =  $products->get();


       if(!empty($request->products)):
            $products->map(function($q) use ($allProducts,$allQuantitys,$flipProducts) {
                if(!empty($allProducts) && in_array($q->id,$allProducts)){
                    $q['appendQty']=$allQuantitys[$flipProducts[$q->id]];
                    $q['productStock']=$this->getStockProduct($q->id);
                    return $q;
                }
            });
       endif;
       return $products;
    }


    public function getStockProduct($productId=null){

        if(empty($productId)): 
            $result =   StockSummary::select('product_id','id','quantity')
                ->where("branch_id",helper::getDefaultBatch())
                ->where("store_id",helper::getDefaultStore())
                ->having(DB::raw('quantity'), '>', 0)
                ->company()->get();
                $allProductsId = array();
                foreach($result as $key => $eachValue): 
                    array_push($allProductsId,$eachValue->product_id);
                endforeach;
                return $allProductsId ?? [];

        else: 
            $result =   StockSummary::select('product_id','id','quantity')
                        ->where("product_id",$productId)
                        ->where("branch_id",helper::getDefaultBatch())
                        ->where("store_id",helper::getDefaultStore())
                        ->having(DB::raw('sum(quantity)'), '>', 0)
                        ->company()->first();

                       return $result->quantity ?? 0;

            endif;

    }


    public function store($request)
    {
        //dd($request->all());

        DB::beginTransaction();
        try 
        { 
            $pos = new $this->pos();
            $pos->date = helper::mysql_date();
            $pos->customer_id  = $request->customer_id;
            $pos->branch_id  = $request->branch_id ?? helper::getDefaultBranch();
            $pos->store_id  = $request->store_id ?? helper::getDefaultStore();
            $pos->account_id = $request->account_id;
            $pos->bank_id = $request->bank_id;
            $pos->voucher_no = $request->voucher_no;
            $pos->payment_type = $request->payment_type ?? 'Cash';
            $pos->grand_total = $request->grand_total;
            $pos->discount = $request->discount;
            $pos->others_charge = $request->others_charge;
            $pos->documents = $request->documents;
            $pos->total_qty  = array_sum($request->quantity);
            $pos->subtotal  = array_sum($request->total_price);
            $pos->status = 'Pending';
            $pos->created_by = helper::userId();
            $pos->company_id = helper::companyId();
            $pos->save();

            if ($pos->id) {
                 $this->masterDetails($pos->id, $request);
                //if(helper::isPosAutoApprobal()): 
                    $this->approved($pos->id,$request);
                    $pos->status = 'Approved';
                    $pos->save();
               // endif;
            }
            DB::commit();
            // all good
            return $pos;
        } 
        catch (\Exception $e) 
        {
            DB::rollback();

            dd($e->getMessage());
            return $e->getMessage();

        }   
    }


    public function approved($pos_id,$request){
        
        $costOfGoodSold =  $this->getCostOfGoods($pos_id);
        $pos =  $this->pos::findOrFail($pos_id);
        $this->salesPayment->salesDebitPayment($pos->id, $pos->grand_total,17);
        //general table data save
        $general_id = $this->salesPayment->generalSave($pos->id,17);
        //sales credit journal
        Journal::saleCreditJournal($general_id,$costOfGoodSold);
        //if payment type cash then
        $this->salesPayment->salesCreditPayment($pos->id,$pos->grand_total,$pos->payment_type,null,17);
        //sales payment journal
        $accountId =  helper::posDepositAccount();
        Journal::salePaymentJournal($pos->id,$pos->grand_total,$accountId,$pos->date,17);
        $pos->status =  'Approved';
        $this->salesPayment->stockSave($general_id, $pos->id,17);
        //stock cashing table data save
        $this->salesPayment->stockSummarySave($pos->id,17);
        //sales order
       return true;


    }


    // Pos Details 
    public function masterDetails($masterId, $request)
    {
        
        PosDetails::where('pos_id', $masterId)->delete();
        $productInfo = $request->product_id;
        $allDetails = array();
        $costOfGoods=0;
        foreach ($productInfo as $key => $value) :
            $masterDetails = array();
            $masterDetails['company_id'] = helper::companyId();
            $masterDetails['date'] = helper::mysql_date();
            $masterDetails['pos_id'] = $masterId;
            $masterDetails['branch_id']  = $request->branch_id ?? helper::getDefaultBranch();
            $masterDetails['store_id']  = $request->store_id ?? helper::getDefaultStore();
            $masterDetails['product_id']  = $request->product_id[$key];
            $masterDetails['batch_no']  = 1;
            $masterDetails['pack_size']  = 1;
            $masterDetails['pack_no']  =1;
            $masterDetails['quantity']  = $request->quantity[$key];
            $masterDetails['unit_price']  = $request->unit_price[$key];
            $masterDetails['total_price']  = $request->total_price[$key];
            array_push($allDetails, $masterDetails);
            $costOfGoods+=helper::productAvg($masterDetails['product_id'],$masterDetails['batch_no']);
        endforeach;
         PosDetails::insert($allDetails);
        return $costOfGoods;
    }
   

    public function getCostOfGoods($pos_id){

       $posDetails =  PosDetails::where('pos_id', $pos_id)->get();
       $costOfGoods=0;
       foreach($posDetails as $key => $eachDetails): 
        $costOfGoods+=helper::productAvg($eachDetails->product_id,$eachDetails->batch_no);
       endforeach;
       return $costOfGoods;

    }

    public function statusUpdate($id, $status)
    {
        $pos = $this->pos::find($id);
        $pos->status = $status;
        $pos->save();
        return $pos;
    }
   
}
