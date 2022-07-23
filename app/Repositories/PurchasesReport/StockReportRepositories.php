<?php

namespace App\Repositories\PurchasesReport;

use App\Models\AccountType;
use App\Models\GeneralLedger;
use App\Models\Purchases;
use App\Models\PurchasesPayment;
use App\Models\PurchasesPendingCheque;
use App\Models\Stock;
use App\Models\StockSummary;
use DB;

class StockReportRepositories
{
    
    /**
     * @var StockSummary
     */
    private $stockSummary;
    /**
     * CourseRepository constructor.
     * @param StockSummary $stockSummary
     */
    public function __construct(StockSummary $stockSummary)
    {
        $this->stockSummary = $stockSummary;
       
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getStockSummary($branch_id,$store_id,$category_id,$product_id,$batchNo,$brand_id,$from_date,$to_date)
    {

        $query = $this->stockSummary::selectRaw('sum(quantity) as quantity,product_id,branch_id,store_id,id,company_id,category_id,brand_id,batch_no')->with([
            'product' => function ($q) {
                $q->select('id', 'name','brand_id', 'category_id','company_id');
            },'branch' => function ($q) {
                $q->select('id', 'name');
            },'store' => function ($q) {
                $q->select('id', 'name');
            },'batch' => function ($q) {
                $q->select('id', 'name');
            }, 'product.category' => function ($q) {
                $q->select('id', 'name');
            }, 'product.brand' => function ($q) {
                $q->select('id', 'name');
            }
        ])->groupBy("product_id")
        ->groupBy("batch_no")
        ->groupBy("store_id")
        //->groupBy("branch_id")
        ->company()
        ->havingRaw('quantity > 1');



        if($store_id !='All'):
            $query->when($store_id, function ($q) use($store_id) {
                return $q->where('store_id', $store_id);
            });
        endif;

        if($category_id !='All'):
            $query->when($category_id, function ($q) use($category_id) {
                return $q->where('category_id', $category_id);
            });
        endif;

        if($brand_id !='All'):
            $query->when($brand_id, function ($q) use($brand_id) {
                return $q->where('brand_id', $brand_id);
            });
        endif;
        if($batchNo !='All'):
            $query->when($batchNo, function ($q) use($batchNo) {
                return $q->where('batch_no', $batchNo);
            });
        endif;

        if($product_id !='All'):
            $query->when($store_id, function ($q) use($product_id) {
                return $q->where('product_id', $product_id);
            });
        endif;


        if($branch_id !='All'):
            $query->when($branch_id, function ($q) use($branch_id) {
                return $q->where('branch_id', $branch_id);
            });
        endif;
        $query->orderBy('product_id','ASC');
        $query->orderBy('store_id','ASC');
        $query->orderBy('batch_no','ASC');
        $reports= $query->get();


       return $reports;

    }

    
    /**
     * @param $request
     * @return mixed
     */
    public function getStockLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date)
    {

        $wsql=0;
       
        $csql='';
        if($category_id != "All"){
            $csql='and p.category_id='.$category_id.' ';
            $wsql+=1;
        }
        
        $bsql='';
        if($brand_id != "All"){
            $bsql='and p.brand_id='.$brand_id.' ';
            $wsql+=1;
        }

        $psql='';
        if($product_id != "All"){
            $psql='and p.id='.$product_id.' ';
            $wsql+=1;
        }

        /*stock condition start*/

        $bchsql='';
        if(!empty($branch_id) && $branch_id != "All"){
            $bchsql='and s.branch_id='.$branch_id.' ';
           
        }

        $btchsql='';
        if(!empty($batch_no) && $batch_no != "All"){
            $btchsql='and s.batch_no='.$batch_no.' ';
           
        }

        $shsql='';
        if(!empty($store_id) && $store_id != "All"){
            $shsql='and s.store_id='.$store_id.' ';
           
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
          
        // echo $scondSql;die;

        /*stock condition end*/



        $wcondSql='';
        if($wsql > 0){
            $wcondSql='WHERE ';
            if(!empty($csql)){
                $wcondSql.=$csql;
            }
            if(!empty($bsql)){
                $wcondSql.=$bsql;
            }
            // if(!empty($bchsql)){
            //     $wcondSql.=$bchsql;
            // }
            if(!empty($psql)){
                $wcondSql.=$psql;
            }
            $wcondSql = str_replace("WHERE and","where ",$wcondSql);
        }

        $fsql="SELECT 
        p.id,
        p.name as pname,

        /* opening  start*/
        sop.totalQty as sopQty,
        sop.totalPrice as sopPrice,
        sop.unitPrice as sopUnitPrice,
        /* opening  end*/

        /* stock in start*/
        sin.totalQty as sinQty,
        sin.totalPrice as sinPrice,
        sin.unitPrice as sinUnitPrice,
        /* stock in end*/

        /* stock out start*/
        sout.totalQty as soutQty,
        sout.totalPrice as soutPrice,
        sout.unitPrice as soutUnitPrice,
        /* stock out end*/
  
         /* transfer in start*/
         tin.totalQty as tinQty,
         tin.totalPrice as tinPrice,
         tin.unitPrice as tinUnitPrice,
        /* transfer in end*/

         /* transfer out start*/
         tout.totalQty as toutQty,
         tout.totalPrice as toutPrice,
         tout.unitPrice as toutUnitPrice,
        /* transfer out end*/

         /* return in start*/
         rin.totalQty as rinQty,
         rin.totalPrice as rinPrice,
         rin.unitPrice as rinUnitPrice,
        /* return in end*/


         /* return out start*/
         rout.totalQty as routQty,
         rout.totalPrice as routPrice,
         rout.unitPrice as routUnitPrice,
        /* return out end*/

         /* sales loan out start*/
         lout.totalQty as loutQty,
         lout.totalPrice as loutPrice,
         lout.unitPrice as loutUnitPrice,
        /* sales loan out end*/

         /* sales loan in start*/
         lin.totalQty as linQty,
         lin.totalPrice as linPrice,
         lin.unitPrice as linUnitPrice,
        /* sales loan in end*/


        savg.unitPrice as avgPrice,
        c.name as categoryName,
        b.name as brandName,
        (ifnull(sin.totalQty,0)+ifnull(sop.totalQty,0)+ifnull(tin.totalQty,0)+ifnull(rin.totalQty,0)+ifnull(lin.totalQty,0))-(ifnull(sout.totalQty,0)+ifnull(tout.totalQty,0)+ifnull(rout.totalQty,0)+ifnull(lout.totalQty,0)) as currentStock,
        (ifnull(sin.totalQty,0)+ifnull(sop.totalQty,0)+ifnull(tin.totalQty,0)+ifnull(rin.totalQty,0)+ifnull(lin.totalQty,0))+(ifnull(sout.totalQty,0)+ifnull(tout.totalQty,0)+ifnull(rout.totalQty,0)+ifnull(lout.totalQty,0)) as transactionStock,
        (ifnull(sin.totalQty,0)+ifnull(tin.totalQty,0)+ifnull(rin.totalQty,0)+ifnull(lin.totalQty,0)) as stockIn,
        (ifnull(sout.totalQty,0)+ifnull(tout.totalQty,0)+ifnull(rout.totalQty,0)+ifnull(lout.totalQty,0)) as stockOut

        FROM products as p
         /*get opening stock start*/
        left JOIN(SELECT sum(s.quantity) as totalQty,sum(s.total_price) as totalPrice,(sum(s.total_price)/sum(s.quantity)) as unitPrice,s.product_id,s.branch_id FROM stocks as s 
        where s.type='in' and s.date < '$from_date' $scondSql
        GROUP BY s.product_id) as sop ON sop.product_id=p.id
        /*get opening stock end*/

         /*get stock in start*/
        left JOIN(SELECT sum(s.quantity) as totalQty,sum(s.total_price) as totalPrice,(sum(s.total_price)/sum(s.quantity)) as unitPrice,s.product_id,s.branch_id FROM stocks as s 
        where s.type='in'  and s.date >= '$from_date' and s.date <='$to_date' $scondSql
        GROUP BY s.product_id) as sin ON sin.product_id=p.id
         /*get stock in end*/

         /*get sale loan in start*/
        left JOIN(SELECT sum(s.quantity) as totalQty,sum(s.total_price) as totalPrice,(sum(s.total_price)/sum(s.quantity)) as unitPrice,s.product_id,s.branch_id FROM stocks as s 
        where s.type='lin'  and s.date >= '$from_date' and s.date <='$to_date' $scondSql
        GROUP BY s.product_id) as lin ON lin.product_id=p.id
         /*get sale loan end*/

          /*get stock out start*/
        left JOIN(SELECT sum(s.quantity) as totalQty,sum(s.total_price) as totalPrice,(sum(s.total_price)/sum(s.quantity)) as unitPrice,s.product_id,s.branch_id FROM stocks as s
        where s.type='out' and s.date >= '$from_date' and s.date <='$to_date' $scondSql
        GROUP BY s.product_id) as sout ON sout.product_id=p.id
       /*get stock out end*/

          /*get sales loan  start*/
        left JOIN(SELECT sum(s.quantity) as totalQty,sum(s.total_price) as totalPrice,(sum(s.total_price)/sum(s.quantity)) as unitPrice,s.product_id,s.branch_id FROM stocks as s
        where s.type='lout' and s.date >= '$from_date' and s.date <='$to_date' $scondSql
        GROUP BY s.product_id) as lout ON lout.product_id=p.id
       /*get sales loan  end*/

         /*get transfer in start*/
        left JOIN(SELECT sum(s.quantity) as totalQty,sum(s.total_price) as totalPrice,(sum(s.total_price)/sum(s.quantity)) as unitPrice,s.product_id,s.branch_id FROM stocks as s 
        where s.type='tin'  and s.date >= '$from_date' and s.date <='$to_date' $scondSql
        GROUP BY s.product_id) as tin ON tin.product_id=p.id
         /*get transfer in end*/

          /*get transfer out start*/
        left JOIN(SELECT sum(s.quantity) as totalQty,sum(s.total_price) as totalPrice,(sum(s.total_price)/sum(s.quantity)) as unitPrice,s.product_id,s.branch_id FROM stocks as s
        where s.type='tout' and s.date >= '$from_date' and s.date <='$to_date' $scondSql
        GROUP BY s.product_id) as tout ON tout.product_id=p.id
       /*get transfer out end*/

         /*get transfer in start*/
        left JOIN(SELECT sum(s.quantity) as totalQty,sum(s.total_price) as totalPrice,(sum(s.total_price)/sum(s.quantity)) as unitPrice,s.product_id,s.branch_id FROM stocks as s 
        where s.type='rin'  and s.date >= '$from_date' and s.date <='$to_date' $scondSql
        GROUP BY s.product_id) as rin ON rin.product_id=p.id
         /*get transfer in end*/

          /*get transfer out start*/
        left JOIN(SELECT sum(s.quantity) as totalQty,sum(s.total_price) as totalPrice,(sum(s.total_price)/sum(s.quantity)) as unitPrice,s.product_id,s.branch_id FROM stocks as s
        where s.type='rout' and s.date >= '$from_date' and s.date <='$to_date' $scondSql
        GROUP BY s.product_id) as rout ON rout.product_id=p.id
       /*get transfer out end*/


        /*get avg stock start*/
        left JOIN(SELECT sum(s.quantity) as totalQty,sum(s.total_price) as totalPrice,(sum(s.total_price)/sum(s.quantity)) as unitPrice,s.product_id,s.branch_id FROM stocks as s
        where s.type='in'  $scondSql
        GROUP BY s.product_id) as savg ON savg.product_id=p.id
        
      /*get avg stock eng*/



        left JOIN categories as c ON c.id=p.category_id
        left JOIN brands as b ON b.id=p.brand_id
        
        $wcondSql
        GROUP BY p.id 
        having transactionStock > 0";
        $result = DB::select($fsql);

        return $result;
       
    }



    /**
     * @param $request
     * @return mixed
     */
    public function getProductLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date)
    {

    
         /*stock condition start*/

        $bndchsql='';
        if(!empty($brand_id) && $brand_id != "All"){
            $bndchsql='and p.brand_id='.$brand_id.' ';
           
        }

        $pcchsql='';
        if(!empty($category_id) && $category_id != "All"){
            $pcchsql='and p.category_id='.$category_id.' ';
          
        }

        $pchsql='';
        if(!empty($product_id) && $product_id != "All"){
            $pchsql='and s.product_id='.$product_id.' ';    
        }

        $bchsql='';
        if(!empty($branch_id) && $branch_id != "All"){
            $bchsql='and s.branch_id='.$branch_id.' ';
          
        }

        $btchsql='';
        if(!empty($batch_no) && $batch_no != "All"){
            $btchsql='and s.batch_no='.$batch_no.' ';
        }

        $shsql='';
        if(!empty($store_id) && $store_id != "All"){
            $shsql='and s.store_id='.$store_id.' ';
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
        s.quantity,s.batch_no,bn.name as batchName,pu.supplier_id,ss.customer_id,sup.name as supplierName,
        c.name as customerName,s.company_id,p.name as productName,bch.name as branchName,st.name as storeName,
        pu.voucher_no as pvoucher,pu.id,ss.voucher_no as svoucher,ss.id,s.type,s.unit_price,s.total_price,s.product_id FROM stocks as s
        left JOIN products as p ON p.id=s.product_id
        left JOIN branches as bch on bch.id=s.branch_id
        left JOIN batch_numbers as bn on bn.id=s.batch_no
        left JOIN stores as st ON st.id=s.store_id
        left JOIN generals as g ON g.id=s.general_id
        left JOIN purchases as pu ON pu.id=g.voucher_id
        left JOIN suppliers as sup on sup.id=pu.supplier_id
        left JOIN sales as ss ON ss.id=g.voucher_id
        left JOIN customers as c ON c.id=ss.customer_id
        Where s.date >= '$from_date' and s.date <= '$to_date'  $scondSql
        ORDER BY s.date ASC,s.branch_id ASC,s.store_id ASC,s.product_id ASC";
        $result = DB::select($fsql);

        return $result;
       
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getPurchasesedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date)
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
        Where s.type='in' and s.date >= '$from_date' and s.date <= '$to_date'  $scondSql
        ORDER BY s.date ASC,s.branch_id ASC,s.store_id ASC,s.product_id ASC";
      // echo $fsql;die;
        $result = DB::select($fsql);

        return $result;
       
    }


    /**
     * @param $request
     * @return mixed
     */
    public function getSalesedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date)
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
        $result = DB::select($fsql);

        return $result;
       
    }



    /**
     * @param $request
     * @return mixed
     */
    public function getTransferSendLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date)
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
        s.quantity,s.batch_no,bn.name as batchName,tbnch.name as sendBranch,tst.name sendStore,
        s.company_id,p.name as productName,bch.name as branchName,st.name as storeName,
        ts.voucher_no as tvoucher,ts.id,s.type,s.unit_price,s.total_price FROM stocks as s
        left JOIN products as p ON p.id=s.product_id
        left JOIN branches as bch on bch.id=s.branch_id
        left JOIN batch_numbers as bn on bn.id=s.batch_no
        left JOIN stores as st ON st.id=s.store_id
        left JOIN generals as g ON g.id=s.general_id
        left JOIN transpfers as ts ON ts.id=g.voucher_id
        left join branches as tbnch on tbnch.id=ts.to_branch_id
        left join stores as tst on tst.id=ts.to_store_id

        Where s.type='tout' and s.date >= '$from_date' and s.date <= '$to_date'  $scondSql
        ORDER BY s.date ASC,s.branch_id ASC,s.store_id ASC,s.product_id ASC";
        $result = DB::select($fsql);
        return $result;
       
    }





    /**
     * @param $request
     * @return mixed
     */
    public function getTransferReceivedLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date)
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
        s.quantity,s.batch_no,bn.name as batchName,tbnch.name as sendBranch,tst.name sendStore,
        s.company_id,p.name as productName,bch.name as branchName,st.name as storeName,
        ts.voucher_no as tvoucher,ts.id,s.type,s.unit_price,s.total_price FROM stocks as s
        left JOIN products as p ON p.id=s.product_id
        left JOIN branches as bch on bch.id=s.branch_id
        left JOIN batch_numbers as bn on bn.id=s.batch_no
        left JOIN stores as st ON st.id=s.store_id
        left JOIN generals as g ON g.id=s.general_id
        left JOIN transpfers as ts ON ts.id=g.voucher_id
        left join branches as tbnch on tbnch.id=ts.to_branch_id
        left join stores as tst on tst.id=ts.to_store_id

        Where s.type='tin' and s.date >= '$from_date' and s.date <= '$to_date'  $scondSql
        ORDER BY s.date ASC,s.branch_id ASC,s.store_id ASC,s.product_id ASC";
        $result = DB::select($fsql);
        return $result;
       
    }


    /**
     * @param $request
     * @return mixed
     */
    public function getPurchasesReturnLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date)
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
        s.company_id,p.name as productName,bch.name as branchName,st.name as storeName,sup.name as supplierName,
        prn.voucher_no as tvoucher,prn.id,s.type,s.unit_price,s.total_price FROM stocks as s
        left JOIN products as p ON p.id=s.product_id
        left JOIN branches as bch on bch.id=s.branch_id
        left JOIN batch_numbers as bn on bn.id=s.batch_no
        left JOIN stores as st ON st.id=s.store_id
        left JOIN generals as g ON g.id=s.general_id
        left JOIN purchases_returns as prn ON prn.id=g.voucher_id
        left join suppliers as sup on sup.id=prn.supplier_id
        Where s.type='rout' and s.date >= '$from_date' and s.date <= '$to_date'  $scondSql
        ORDER BY s.date ASC,s.branch_id ASC,s.store_id ASC,s.product_id ASC";
        $result = DB::select($fsql);
        return $result;
       
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