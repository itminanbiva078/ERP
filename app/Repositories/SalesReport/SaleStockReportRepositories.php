<?php

namespace App\Repositories\SalesReport;

use App\Models\AccountType;
use App\Models\GeneralLedger;
use App\Models\Purchases;
use App\Models\PurchasesPayment;
use App\Models\PurchasesPendingCheque;
use App\Models\Stock;
use App\Models\StockSummary;
use App\Models\Sales;
use App\Models\SalesDetails;
use DB;

class SaleStockReportRepositories
{
    
    /**
     * @var Sales
     */
    private $sales;
    /**
     * @var SalesDetails
     */
    private $salesDetails;
    /**
     * CourseRepository constructor.
     * @param StockSummary $stockSummary
     */
    public function __construct(Sales $sales, SalesDetails $salesDetails)
    {
        $this->sales = $sales;
        $this->salesDetails = $salesDetails;
       
    }

   
    /**
     * @param $request
     * @return mixed
     */
    public function getSalesedger($branch_id,$store_id,$category_id,$product_id,$customer_id,$sr_id,$batch_no,$brand_id,$from_date,$to_date)
    {

        $wsql=0;
         /*stock condition start*/

        $bndchsql='';
        if(!empty($brand_id) && $brand_id != "All"){
            $bndchsql='and p.brand_id='.$brand_id.' ';
            $wsql+=1;
        }

        $pcchsql='';
        if(!empty($category_id) && $category_id != "All"){
            $pcchsql='and p.category_id='.$category_id.' ';
            $wsql+=1;
        }

        $cussql='';
        if(!empty($customer_id) && $customer_id != "All"){
            $pcchsql='and ss.customer_id='.$customer_id.' ';
            $wsql+=1;
        }

        $pchsql='';
        if(!empty($product_id) && $product_id != "All"){
            $pchsql='and s.product_id='.$product_id.' ';
            $wsql+=1;
        }

        $bchsql='';
        if(!empty($branch_id) && $branch_id != "All"){
            $bchsql='and s.branch_id='.$branch_id.' ';
            $wsql+=1;
        }

        $btchsql='';
        if(!empty($batch_no) && $batch_no != "All"){
            $btchsql='and s.batch_no='.$batch_no.' ';
            $wsql+=1;
        }

        $shsql='';
        if(!empty($store_id) && $store_id != "All"){
            $shsql='and s.store_id='.$store_id.' ';
            $wsql+=1;
        }
        $srsql='';
        if(!empty($sr_id) && $sr_id != "All"){
            $shsql='and c.sr_id='.$sr_id.' ';
            $wsql+=1;
        }

           $scondSql='';
            if(!empty($bchsql)){
                $scondSql.=$bchsql;
            }
            if(!empty($shsql)){
                $scondSql.=$shsql;
            }
            if(!empty($btchsql)){
                $scondSql.=$btchsql;
            }
            if(!empty($bndchsql)){
                $scondSql.=$bndchsql;
            }
            if(!empty($pchsql)){
                $scondSql.=$pchsql;
            }
            if(!empty($pcchsql)){
                $scondSql.=$pcchsql;
            }
            if(!empty($cussql)){
                $scondSql.=$cussql;
            }
            if(!empty($srsql)){
                $scondSql.=$srsql;
            }
           
       /*stock condition end*/

        $fsql="SELECT s.date,s.general_id,s.branch_id,s.store_id,s.pack_size,s.pack_no,
        s.quantity,s.batch_no,bn.name as batchName,pu.supplier_id,ss.customer_id,sup.name as supplierName,
        c.name as customerName,s.company_id,p.name as productName,bch.name as branchName,st.name as storeName,
        pu.voucher_no as pvoucher,pu.id,ss.voucher_no as svoucher,ss.id,s.type,s.unit_price,s.total_price FROM stocks as s
        left JOIN products as p ON p.id=s.product_id
        left JOIN branches as bch on bch.id=s.branch_id
        left JOIN batch_numbers as bn on bn.id=s.batch_no
        left JOIN stores as st ON st.id=s.store_id
        left JOIN generals as g ON g.id=s.general_id
        left JOIN purchases as pu ON pu.id=g.voucher_id
        left JOIN suppliers as sup on sup.id=pu.supplier_id
        left JOIN sales as ss ON ss.id=g.voucher_id
        left JOIN customers as c ON c.id=ss.customer_id 
        Where s.type='out' and s.date >= '$from_date' and s.date <= '$to_date'  $scondSql
        ORDER BY s.date ASC,s.branch_id ASC,s.store_id ASC,s.product_id ASC";
    //echo $fsql;die;

        $result = DB::select($fsql);

        return $result;
       
    }

    public function getSalesedgerWithReturn($branch_id,$store_id,$category_id,$product_id,$customer_id,$sr_id,$batch_no,$brand_id,$from_date,$to_date)
    {

        $wsql=0;
         /*stock condition start*/

        $bndchsql='';
        if(!empty($brand_id) && $brand_id != "All"){
            $bndchsql='and p.brand_id='.$brand_id.' ';
            $wsql+=1;
        }

        $pcchsql='';
        if(!empty($category_id) && $category_id != "All"){
            $pcchsql='and p.category_id='.$category_id.' ';
            $wsql+=1;
        }

        $cussql='';
        if(!empty($customer_id) && $customer_id != "All"){
            $pcchsql='and ss.customer_id='.$customer_id.' ';
            $wsql+=1;
        }

        $pchsql='';
        if(!empty($product_id) && $product_id != "All"){
            $pchsql='and s.product_id='.$product_id.' ';
            $wsql+=1;
        }

        $bchsql='';
        if(!empty($branch_id) && $branch_id != "All"){
            $bchsql='and s.branch_id='.$branch_id.' ';
            $wsql+=1;
        }

        $btchsql='';
        if(!empty($batch_no) && $batch_no != "All"){
            $btchsql='and s.batch_no='.$batch_no.' ';
            $wsql+=1;
        }

        $shsql='';
        if(!empty($store_id) && $store_id != "All"){
            $shsql='and s.store_id='.$store_id.' ';
            $wsql+=1;
        }
        $srsql='';
        if(!empty($sr_id) && $sr_id != "All"){
            $shsql='and c.sr_id='.$sr_id.' ';
            $wsql+=1;
        }

           $scondSql='';
            if(!empty($bchsql)){
                $scondSql.=$bchsql;
            }
            if(!empty($shsql)){
                $scondSql.=$shsql;
            }
            if(!empty($btchsql)){
                $scondSql.=$btchsql;
            }
            if(!empty($bndchsql)){
                $scondSql.=$bndchsql;
            }
            if(!empty($pchsql)){
                $scondSql.=$pchsql;
            }
            if(!empty($pcchsql)){
                $scondSql.=$pcchsql;
            }
            if(!empty($cussql)){
                $scondSql.=$cussql;
            }
            if(!empty($srsql)){
                $scondSql.=$srsql;
            }
           
       /*stock condition end*/

        
        $fsql="SELECT s.date,s.general_id,s.branch_id,s.store_id,s.pack_size,s.pack_no,
        s.quantity,s.batch_no,bn.name as batchName,pu.supplier_id,ss.customer_id,sup.name as supplierName,
        c.name as customerName,s.company_id,p.name as productName,bch.name as branchName,st.name as storeName,
        pu.voucher_no as pvoucher,pu.id,ss.voucher_no as svoucher,ss.id,s.type,s.unit_price,s.total_price FROM stocks as s
        left JOIN products as p ON p.id=s.product_id
        left JOIN branches as bch on bch.id=s.branch_id
        left JOIN batch_numbers as bn on bn.id=s.batch_no
        left JOIN stores as st ON st.id=s.store_id
        left JOIN generals as g ON g.id=s.general_id
        left JOIN purchases as pu ON pu.id=g.voucher_id
        left JOIN suppliers as sup on sup.id=pu.supplier_id
        left JOIN sales as ss ON ss.id=g.voucher_id
        left JOIN customers as c ON c.id=ss.customer_id 
        Where  s.type in ('out','rin') and s.date >= '$from_date' and s.date <= '$to_date'  $scondSql
        ORDER BY s.date ASC,s.branch_id ASC,s.store_id ASC,s.product_id ASC";
        $result = DB::select($fsql);

        return $result;
    }


    /**
     * @param $request
     * @return mixed
     */
    public function getSaleLoansedger($branch_id,$store_id,$category_id,$product_id,$customer_id,$sr_id,$batch_no,$brand_id,$from_date,$to_date)
    {

        $wsql=0;
         /*stock condition start*/

        $bndchsql='';
        if(!empty($brand_id) && $brand_id != "All"){
            $bndchsql='and p.brand_id='.$brand_id.' ';
            $wsql+=1;
        }

        $pcchsql='';
        if(!empty($category_id) && $category_id != "All"){
            $pcchsql='and p.category_id='.$category_id.' ';
            $wsql+=1;
        }

        $cussql='';
        if(!empty($customer_id) && $customer_id != "All"){
            $pcchsql='and ss.customer_id='.$customer_id.' ';
            $wsql+=1;
        }

        $pchsql='';
        if(!empty($product_id) && $product_id != "All"){
            $pchsql='and s.product_id='.$product_id.' ';
            $wsql+=1;
        }

        $bchsql='';
        if(!empty($branch_id) && $branch_id != "All"){
            $bchsql='and s.branch_id='.$branch_id.' ';
            $wsql+=1;
        }

        $btchsql='';
        if(!empty($batch_no) && $batch_no != "All"){
            $btchsql='and s.batch_no='.$batch_no.' ';
            $wsql+=1;
        }

        $shsql='';
        if(!empty($store_id) && $store_id != "All"){
            $shsql='and s.store_id='.$store_id.' ';
            $wsql+=1;
        }
        $srsql='';
        if(!empty($sr_id) && $sr_id != "All"){
            $shsql='and c.sr_id='.$sr_id.' ';
            $wsql+=1;
        }

           $scondSql='';
            if(!empty($bchsql)){
                $scondSql.=$bchsql;
            }
            if(!empty($shsql)){
                $scondSql.=$shsql;
            }
            if(!empty($btchsql)){
                $scondSql.=$btchsql;
            }
            if(!empty($bndchsql)){
                $scondSql.=$bndchsql;
            }
            if(!empty($pchsql)){
                $scondSql.=$pchsql;
            }
            if(!empty($pcchsql)){
                $scondSql.=$pcchsql;
            }
            if(!empty($cussql)){
                $scondSql.=$cussql;
            }
            if(!empty($srsql)){
                $scondSql.=$srsql;
            }
           
       /*stock condition end*/

        $fsql="SELECT s.date,s.general_id,s.branch_id,s.store_id,s.pack_size,s.pack_no,
        s.quantity,s.batch_no,bn.name as batchName,pu.supplier_id,ss.customer_id,sup.name as supplierName,
        c.name as customerName,s.company_id,p.name as productName,bch.name as branchName,st.name as storeName,
        pu.voucher_no as pvoucher,pu.id,ss.voucher_no as svoucher,ss.id,s.type,s.unit_price,s.total_price FROM stocks as s
        left JOIN products as p ON p.id=s.product_id
        left JOIN branches as bch on bch.id=s.branch_id
        left JOIN batch_numbers as bn on bn.id=s.batch_no
        left JOIN stores as st ON st.id=s.store_id
        left JOIN generals as g ON g.id=s.general_id
        left JOIN purchases as pu ON pu.id=g.voucher_id
        left JOIN suppliers as sup on sup.id=pu.supplier_id
        left JOIN sales as ss ON ss.id=g.voucher_id
        left JOIN customers as c ON c.id=ss.customer_id 
        Where s.type='lout' and s.date >= '$from_date' and s.date <= '$to_date'  $scondSql
        ORDER BY s.date ASC,s.branch_id ASC,s.store_id ASC,s.product_id ASC";
        $result = DB::select($fsql);

        return $result;
       
    }
    /**
     * @param $request
     * @return mixed
     */
    public function getTopCustomerSale($store_id,$customer_id,$category_id,$product_id,$batchNo,$brand_id,$from_date,$to_date)
    {
        $query = $this->sales::selectRaw('sum(subtotal) as subtotal,customer_id,branch_id,store_id,id,company_id')->with([
            'customer' => function ($q) {
                $q->select('id', 'name');
            },'store' => function ($q) {
                $q->select('id', 'name');
            },'salesDetails' => function ($q) {
                $q->select('id','sales_id','branch_id','store_id','product_id','pack_size');
            },'salesDetails.product' => function ($q) {
                $q->select('id','name');
            },'salesDetails.product.category' => function ($q) {
                $q->select('id','name');
            },'salesDetails.product.brand' => function ($q) {
                $q->select('id','name');
            }
        ])->groupBy("customer_id")
        ->company()
        ->havingRaw('subtotal > 1');

        if($store_id !='All'):
            $query->when($store_id, function ($q) use($store_id) {
                return $q->where('store_id', $store_id);
            });
        endif;

        if($customer_id !='All'):
            $query->when($customer_id, function ($q) use($customer_id) {
                return $q->where('customer_id', $customer_id);
            });
        endif;

        if($category_id !='All'):
            $query->when($category_id, function ($q) use($category_id) {
                return $q->where('category_id', $category_id);
            });
        endif;

        if($product_id !='All'):
            $query->when($store_id, function ($q) use($product_id) {
                return $q->where('product_id', $product_id);
            });
        endif;
        if($brand_id !='All'):
            $query->when($brand_id, function ($q) use($brand_id) {
                return $q->where('brand_id', $brand_id);
            });
        endif;
        $query->orderBy('subtotal','DESC');
        $reports= $query->get();
       return $reports;  
    }
    /**
     * @param $request
     * @return mixed
     */
    public function getTopProductSale($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date,$customer_id)
    {
        $query = $this->salesDetails::selectRaw('sum(quantity) as quantity,sum(total_price) as total_price,sales_id,product_id,branch_id,store_id,id,company_id')->with([
            'product' => function ($q) {
                $q->select('id', 'name');
            }
        ])->groupBy("product_id")
        ->company()
        ->havingRaw('total_price > 1');

        if($store_id !='All'):
            $query->when($store_id, function ($q) use($store_id) {
                return $q->where('store_id', $store_id);
            });
        endif;

        if($customer_id !='All'):
            $query->when($customer_id, function ($q) use($customer_id) {
                return $q->where('customer_id', $customer_id);
            });
        endif;

        if($category_id !='All'):
            $query->when($category_id, function ($q) use($category_id) {
                return $q->where('category_id', $category_id);
            });
        endif;

        if($product_id !='All'):
            $query->when($product_id, function ($q) use($product_id) {
                return $q->where('product_id', $product_id);
            });
        endif;
        if($brand_id !='All'):
            $query->when($brand_id, function ($q) use($brand_id) {
                return $q->where('brand_id', $brand_id);
            });
        endif;
        $query->orderBy('quantity','DESC');
        $reports= $query->get();
       return $reports;
       
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getSalesReturnLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date)
    {

        $wsql=0;
         /*stock condition start*/

        $bndchsql='';
        if(!empty($brand_id) && $brand_id != "All"){
            $bndchsql='and p.brand_id='.$brand_id.' ';
            $wsql+=1;
        }

        $pcchsql='';
        if(!empty($category_id) && $category_id != "All"){
            $pcchsql='and p.category_id='.$category_id.' ';
            $wsql+=1;
        }

        $pchsql='';
        if(!empty($product_id) && $product_id != "All"){
            $pchsql='and s.product_id='.$product_id.' ';
            $wsql+=1;
        }

        $bchsql='';
        if(!empty($branch_id) && $branch_id != "All"){
            $bchsql='and s.branch_id='.$branch_id.' ';
            $wsql+=1;
        }

        $btchsql='';
        if(!empty($batch_no) && $batch_no != "All"){
            $btchsql='and s.batch_no='.$batch_no.' ';
            $wsql+=1;
        }

        $shsql='';
        if(!empty($store_id) && $store_id != "All"){
            $shsql='and s.store_id='.$store_id.' ';
            $wsql+=1;
        }

           $scondSql='';
            if(!empty($bchsql)){
                $scondSql.=$bchsql;
            }
            if(!empty($shsql)){
                $scondSql.=$shsql;
            }
            if(!empty($btchsql)){
                $scondSql.=$btchsql;
            }
            if(!empty($bndchsql)){
                $scondSql.=$bndchsql;
            }
            if(!empty($pchsql)){
                $scondSql.=$pchsql;
            }
            if(!empty($pcchsql)){
                $scondSql.=$pcchsql;
            }

       /*stock condition end*/

        $fsql="SELECT s.date,s.general_id,s.branch_id,s.store_id,s.pack_size,s.pack_no,
        s.quantity,s.batch_no,bn.name as batchName,
        s.company_id,p.name as productName,bch.name as branchName,st.name as storeName,cus.name as customerName,
        srn.voucher_no as tvoucher,srn.id,s.type,s.unit_price,s.total_price FROM stocks as s
        left JOIN products as p ON p.id=s.product_id
        left JOIN branches as bch on bch.id=s.branch_id
        left JOIN batch_numbers as bn on bn.id=s.batch_no
        left JOIN stores as st ON st.id=s.store_id
        left JOIN generals as g ON g.id=s.general_id
        left JOIN sale_returns as srn ON srn.id=g.voucher_id
        left join customers as cus on cus.id=srn.customer_id
        Where s.type='rin' and s.date >= '$from_date' and s.date <= '$to_date'  $scondSql
        ORDER BY s.date ASC,s.branch_id ASC,s.store_id ASC,s.product_id ASC";
        $result = DB::select($fsql);
        return $result;
       
    }

/*stock report start*/

/*stock report end*/

}