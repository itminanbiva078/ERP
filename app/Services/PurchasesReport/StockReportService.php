<?php

namespace App\Services\PurchasesReport;
use App\Repositories\PurchasesReport\StockReportRepositories;


class StockReportService
{

    /**
     * @var StockReportRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param StockReportRepositories $stockReportRepositories
     */
    public function __construct(StockReportRepositories $systemRepositories)
    {
        $this->systemRepositories = $systemRepositories;
    }

  
    /**
     * @param $request
     * @return mixed
     */
    public function getStockSummary($branch_id,$store_id,$category_id,$product_id,$batch_id,$brand_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getStockSummary($branch_id,$store_id,$category_id,$product_id,$batch_id,$brand_id,$from_date,$to_date);
    }
    
    /**
     * @param $request
     * @return mixed
     */
    public function getStockLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getStockLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date);
    }


    /**
     * @param $request
     * @return mixed
     */
    public function getProductLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getProductLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date);
    }
    
    /**
     * @param $request
     * @return mixed
     */
    public function getPurchasesedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getPurchasesedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date);
    }
    
    /**
     * @param $request
     * @return mixed
     */
    public function getSalesedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getSalesedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date);
    }
    
    /**
     * @param $request
     * @return mixed
     */
    public function getTransferSendLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getTransferSendLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date);
    }
    
    /**
     * @param $request
     * @return mixed
     */
    public function getTransferReceivedLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getTransferReceivedLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date);
    }
    
    /**
     * @param $request
     * @return mixed
     */
    public function getPurchasesReturnLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getPurchasesReturnLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date);
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