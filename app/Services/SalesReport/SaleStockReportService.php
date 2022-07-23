<?php

namespace App\Services\SalesReport;
use App\Repositories\SalesReport\SaleStockReportRepositories;


class SaleStockReportService
{

    /**
     * @var SaleStockReportRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param SaleStockReportRepositories $stockReportRepositories
     */
    public function __construct(SaleStockReportRepositories $systemRepositories)
    {
        $this->systemRepositories = $systemRepositories;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getSalesedger($branch_id,$store_id,$category_id,$product_id,$customer_id,$sr_id,$batch_no,$brand_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getSalesedger($branch_id,$store_id,$category_id,$product_id,$customer_id,$sr_id,$batch_no,$brand_id,$from_date,$to_date);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getSalesedgerWithReturn($branch_id,$store_id,$category_id,$product_id,$customer_id,$sr_id,$batch_no,$brand_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getSalesedgerWithReturn($branch_id,$store_id,$category_id,$product_id,$customer_id,$sr_id,$batch_no,$brand_id,$from_date,$to_date);
    }
    /**
     * @param $request
     * @return mixed
     */
    public function getSaleLoansedger($branch_id,$store_id,$category_id,$product_id,$customer_id,$sr_id,$batch_no,$brand_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getSaleLoansedger($branch_id,$store_id,$category_id,$product_id,$customer_id,$sr_id,$batch_no,$brand_id,$from_date,$to_date);
    }
    
    /**
     * @param $request
     * @return mixed
     */
    public function getTopCustomerSale($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date,$customer_id)
    {
        return $this->systemRepositories->getTopCustomerSale($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date,$customer_id);
    }
    /**
     * @param $request
     * @return mixed
     */
    public function getTopProductSale($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date,$customer_id)
    {
        return $this->systemRepositories->getTopProductSale($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date,$customer_id);
    }
    
   
    /**
     * @param $request
     * @return mixed
     */
    public function getSalesReturnLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getSalesReturnLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date);
    }
    
    
    
   
 

}