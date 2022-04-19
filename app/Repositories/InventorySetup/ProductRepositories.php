<?php

namespace App\Repositories\InventorySetup;

use DB;
use Image;
use App\Helpers\Helper;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\StockSummary;
use App\Models\ProductDetails;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use App\Models\ProductAttribute;
use App\Models\PurchasesDetails;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PurchasesOrderDetails;
use Illuminate\Support\Facades\Storage;
use App\Models\PurchaseRequisitionDetails;
use App\Models\Review;

class ProductRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Product
     */
    private $product;
    /**
     * CourseRepository constructor.
     * @param product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;

    }
    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns, "id");
        $edit = Helper::roleAccess('inventorySetup.product.edit') ? 1 : 0;
        $delete = Helper::roleAccess('inventorySetup.product.destroy') ? 1 : 0;
        $ced = $edit + $delete;

        $totalData = $this->product::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $products = $this->product::select($columns)->company()->with('brand','productUnit','category')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->product::count();
        } else {
            $search = $request->input('search.value');
            $products = $this->product::select($columns)->company()->with('brand','productUnit','category')->where(function ($q) use ($columns, $search) {
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
            $totalFiltered = $this->product::select($columns)->company()->where(function ($q) use ($columns, $search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }
        foreach($products as $key => $value):
            if(!empty($value->brand_id))
               $value->brand_id = $value->brand->name ?? '';

            if(!empty($value->unit_id))
               $value->unit_id  = $value->productUnit->name ?? '';

            if(!empty($value->category_id))
            $value->category_id = $value->category->name ?? '';
        endforeach;

        $columns = Helper::getTableProperty();
        $data = array();
        if ($products) {
            foreach ($products as $key => $product) {
                $nestedData['id'] = $key + 1;
                foreach ($columns as $key => $value) :
                    if ($value == 'status') :

                        if ($product->status == 'Approved') :
                            $status = '<input class="status_row" status_route="' . route('inventorySetup.product.status', [$product->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                        else :
                            $status = '<input  class="status_row" status_route="' . route('inventorySetup.product.status', [$product->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                        endif;
                        $nestedData['status'] = $status;
                    else :
                        $nestedData[$value] = $product->$value;
                    endif;
                endforeach;
                if ($ced != 0) :
                    if ($edit != 0)
                        $edit_data = '<a href="' . route('inventorySetup.product.edit', $product->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    else
                        $edit_data = '';
                    if ($delete != 0)
                    if($this->checkProductByExistsPurchasesOrder($product->id) === false && $this->checkProductByExistsPurchases($product->id) === false && $this->checkProductByExistsPurchasesRequisition($product->id) === false):
                        $delete_data = '<a delete_route="' . route('inventorySetup.product.destroy', $product->id) . '" delete_id="' . $product->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $product->id . '"><i class="fa fa-times"></i></a>';
                    else:
                        $delete_data = '';
                        endif;
                    else
                        $delete_data = '';
                    $nestedData['action'] = $edit_data . ' ' . $delete_data;
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
    public function details($product_id)
    {
       $productInfo = Product::with('ProductDetails','productImages','brand','productUnit','category')->find($product_id);
       $productInfo->presentStock=$this->getStockProduct($product_id);


       return $productInfo;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function productStock($product_id,$branch_id=null,$store_id=null,$batchNo=null)
    {

        if(helper::mrrIsActive()):
            $query = StockSummary::select('id','product_id','quantity','batch_no','branch_id','store_id','pack_size')->with('product','batch')->company();
            $query->when($product_id, function ($q) use($product_id) {
                return $q->where('product_id', $product_id);
            });
            $query->when($branch_id, function ($q) use($branch_id) {
                return $q->where('branch_id', $branch_id);
            });

            $query->when($store_id, function ($q) use($store_id) {
                return $q->where('store_id', $store_id);
            });

            $query->when($batchNo, function ($q) use($batchNo) {
                return $q->where('batch_no', $batchNo);
            });
            $query->groupBy('product_id');
            if(!empty($product_id)):
            $query->groupBy('batch_no');
            endif;
            $query->havingRaw('quantity > 1');
            $result = $query->get();
            $result->map(function ($product) {
                if ($product->product->name):
                   $product->pname=$product->product->name;
                   $product->sprice=$product->product->sale_price;
                   $product->puprice=$product->product->purchases_price;
                endif;

                if($product->batch->name):
                  $product->bname=$product->batch->name . ' - Stock - ' .$product->quantity;
                endif;
                return  $product;
            });
         else:
            $result = StockSummary::select('id','product_id','quantity','batch_no','branch_id','store_id','pack_size')->with('product','batch')->where('product_id',$product_id)->havingRaw('quantity > 1')->company()->first();
                if ($result->product->name):
                   $result->presentStock=$result->quantity;
                   $result->pname=$result->product->name;
                   $result->sprice=$result->product->sale_price;
                   $result->puprice=$result->product->purchases_price;
                endif;
                if($result->batch->name):
                  $result->bname=$result->batch->name . ' - Stock - ' .$result->quantity;
                endif;
                return  $result;
        endif;
       return $result;
    }





    public function getStockProduct($productId=null){


            $result =   StockSummary::select('product_id','id','quantity')
                        ->where("product_id",$productId)
                        ->where("branch_id",helper::getDefaultBatch())
                        ->where("store_id",helper::getDefaultStore())
                        ->having(DB::raw('sum(quantity)'), '>', 0)
                        ->company()->first();
                        return $result->quantity ?? 0;

  }

    /**
     * @param $request
     * @return mixed
     */
    public function getActiveProduct()
    {
        $result = $this->product::with('productDetails')->where('type_id','POS Product')->where('status', 'Approved')->company()->get();
        return $result;
    }
    public function implodeProduct(){
        DB::beginTransaction();
        try {
            Excel::import(new ProductsImport,request()->file('importFile'));
            DB::commit();
            // all good
            return 1;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
    /**
     * @param $request
     * @return mixed
     */
    public function exploadProduct()
    {
        return Excel::download(new ProductsExport, 'product-list.xlsx');
    }
    /**
     * @param $request
     * @return mixed
     */
    public function checkProductByExistsPurchasesRequisition($requisitionId){
        $purchasesRequisitionList = PurchaseRequisitionDetails::where('product_id', $requisitionId)->count();
        if($purchasesRequisitionList > 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    public function checkProductByExistsPurchasesOrder($orderId){
        $purchasesOrderList = PurchasesOrderDetails::where('product_id', $orderId)->count();
        if($purchasesOrderList > 0){
            return true;
        }else{
            return false;
        }
    }
    /**
     * @param $request
     * @return mixed
     */
    public function checkProductByExistsPurchases($purchasesId){
        $purchasesList = PurchasesDetails::where('product_id', $purchasesId)->count();
        if($purchasesList > 0){
            return true;
        }else{
            return false;
        }
    }
    /**
     * @param $request
     * @return mixed
     */
    public function productCode()
    {
        $code = $this->product::select('id')->latest()->first();
        $code =  "PID" . date("y") . date("m") . str_pad($code->id ?? 0 + 1, 5, "0", STR_PAD_LEFT);
        return $code;
    }
    public function store($request)
    {

      


        DB::beginTransaction();
        try
        {
            $product = new $this->product();
            $product->code = $this->productCode();
            $product->code = $request->code;
            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->description = $request->description;
            $product->unit_id = $request->unit_id;
            $product->type_id = $request->type_id;
            $product->floor_id = $request->floor_id ?? 0;
            $product->purchases_price = $request->purchases_price;
            $product->sale_price = $request->sale_price;
            $product->low_stock = $request->low_stock;
            $product->status = 'Approved';
            $product->created_by = helper::userId();
            $product->company_id = helper::companyId();
            $product->save();
            if ($product->type_id=="Rooms") {
                $this->masterDetails($product->id, $request);
            }
            if ($product->type_id=="Rooms") {
                $this->productAttributes($product->id, $request);
            }
            if(!empty($request->attached_files) && count($request->attached_files) > 0){
                $allAttached = array_unique($request->attached_files);
                foreach($allAttached as $key => $eachImage):
                    $image = $this->productImageUpload($eachImage,800,500,'product',$product->id);
                   $productImage =  new ProductImage();
                   $productImage->product_id = $product->id;
                   $productImage->company_id = helper::companyId();
                   $productImage->image = $image;
                   $productImage->save();
                endforeach;
                $product->image = $image;
                $product->save();
            }
            DB::commit();
            // all good
            return $product;
        }
        catch (\Exception $e)
        {
            dd($e->getMessage());
            DB::rollback();
            return $e->getMessage();
        }
    }
    // Product Details
    public function masterDetails($masterId, $request)
    {

       

        $productDetails = ProductDetails::where('product_id', $masterId)->first();

        if(empty($productDetails)){


            $productDetails = new ProductDetails;
        }

        $productDetails->product_id = $masterId;
        $productDetails->number_of_bed  = $request->number_of_bed ?? '';
        $productDetails->number_of_room  = $request->number_of_room ?? '';
        $productDetails->advance_percentage  = $request->advance_percentage ?? '';
        $productDetails->room_no  = $request->room_no ?? '';
        $productDetails->floor_id  = $request->floor_id ?? '';
        $productDetails->product_attributes  = implode(",",$request->product_attributes) ?? '';
        $productDetails->save();
        return $productDetails;
    }
    // Product Attributes
    public function productAttributes($masterId, $request)
    {
        if(!empty($request->product_attributes)){
            ProductAttribute::where('product_id', $masterId)->delete();
            foreach($request->product_attributes as $attribute)
            {

                $productAttribute = new ProductAttribute();
                $productAttribute->product_id = $masterId;
                $productAttribute->name = $attribute;
                $productAttribute->save();
            }
            return $productAttribute;
        }
    }
    public function productImage($masterId, $request)
    {
        $deatils = ProductDetails::where('product_id', $masterId)->get();
        if(!empty($deatils))
        {
            ProductDetails::where('product_id', $masterId)->delete();
        }
        $product_attributes = implode(",",$request->product_attributes);
        $productDetails = new ProductDetails;
        $productDetails->product_id = $masterId;
        $productDetails->number_of_bed  = $request->number_of_bed ?? '';
        $productDetails->number_of_room  = $request->number_of_room ?? '';
        $productDetails->advance_percentage  = $request->advance_percentage ?? '';
        $productDetails->room_no  = $request->room_no ?? '';
        $productDetails->product_attributes  = $product_attributes ?? '';
        $productDetails->save();
        return $productDetails;
    }
    public function update($request, $id)
    {

       
        DB::beginTransaction();
        
        try
        {
            $product = $this->product::findOrFail($id);
            $product->code = $request->code;
            $product->name = $request->name;
            $product->image = $request->image;
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->description = $request->description;
            $product->unit_id = $request->unit_id;
            $product->type_id = $request->type_id;
            $product->floor_id = $request->floor_id ?? 0;
            $product->purchases_price = $request->purchases_price;
            $product->sale_price = $request->sale_price;
            $product->low_stock = $request->low_stock;
            $product->status = 'Approved';
            $product->updated_by = Auth::user()->id;
            $product->company_id = Auth::user()->company_id;
            $product->save();
            if ($product->type_id == "Rooms") {
                $this->masterDetails($product->id, $request);
            }
            if ($product->type_id=="Rooms") {
                $this->productAttributes($product->id, $request);
            }

           
            if(!empty($request->attached_files) && count($request->attached_files) > 0){
                
                $allAttached = array_unique($request->attached_files);
                ProductImage::where('product_id',$product->id)->delete();
                foreach($allAttached as $key => $eachImage):
                    if(!empty($eachImage)):
                        if(!str_contains($eachImage,'image-not-found.png')):
                            if(str_contains($eachImage,'storage')):
                                $image = str_replace("storage","public",$eachImage); //     $this->productImageUpload($eachImage,800,500,'product',$product->id);
                            else:
                                $image = $this->productImageUpload($eachImage,800,500,'product',$product->id);
                            endif;
                            $productImage =  new ProductImage();
                            $productImage->product_id = $product->id;
                            $productImage->company_id = helper::companyId();
                            $productImage->image = $image;
                            $productImage->save();
                        endif;
                    endif;
                endforeach;
              
                $product->image = $image;
                $product->save();
            }
            DB::commit();
            // all good
          
            return $product;
        }
        catch (\Exception $e)
        {
           
            DB::rollback();
            return $e->getMessage();
        }
    }
    private function productImageUpload($image, $width,$height,$folder,$id=null)
    {
        if ($image && !empty($image)) {
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];
            $fileName = rand(100,1000).time() . "." . $ext;
            $img = Image::make($image)->resize($width, $height);
            $img->stream();
            if(is_null($id)){
                $upload_path = 'public/uploads/'.$folder .'/';
            }else{
                $upload_path = 'public/uploads/'.$folder .'/'.$id.'/';
            }
            if (!Storage::exists($upload_path)) {
                Storage::makeDirectory($upload_path, 0775, true, true);
            }
            $upload_path = $upload_path.$fileName;
            Storage::disk('local')->put($upload_path, $img, 'public');
            return $upload_path;
        }
    }
    public function statusUpdate($id, $status)
    {
        $product = $this->product::find($id);
        $product->status = $status;
        $product->save();
        return $product;
    }


    public function destroy($id)
    {
        $product = $this->product::find($id);
        $product->delete();
        ProductDetails::where('product_id',$id)->delete();
        ProductAttribute::where('product_id',$id)->delete();
        ProductImage::where('product_id',$id)->delete();
        return true;
    }
}
