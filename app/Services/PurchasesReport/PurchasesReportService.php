<?php

namespace App\Services\PurchasesReport;
use App\Repositories\PurchasesReport\PurchasesReportRepositories;


class PurchasesReportService
{

    /**
     * @var PurchasesReportRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param PurchasesReportRepositories $purchasesReportRepositories
     */
    public function __construct(PurchasesReportRepositories $systemRepositories)
    {
        $this->systemRepositories = $systemRepositories;
    }

  
    /**
     * @param $request
     * @return mixed
     */
    public function getSupplierLedger($supplier_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getSupplierLedger($supplier_id,$from_date,$to_date);
    }
    
    
    
    public function getSupplierPayment($supplier_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getSupplierPayment($supplier_id,$from_date,$to_date);
    }


    public function getSupplierCashPayment($supplier_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getSupplierCashPayment($supplier_id,$from_date,$to_date);
    }
     
    public function getSupplierChequePayment($supplier_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getSupplierChequePayment($supplier_id,$from_date,$to_date);
    }
    public function getSupplierPendingChequePayment($supplier_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getSupplierPendingChequePayment($supplier_id,$from_date,$to_date);
    }
    public function getSupplierPurchasesVoucher($supplier_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getSupplierPurchasesVoucher($supplier_id,$from_date,$to_date);
    }

    public function getSupplierDuePurchasesVoucher($supplier_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getSupplierDuePurchasesVoucher($supplier_id,$from_date,$to_date);
    }
     

   
 

}