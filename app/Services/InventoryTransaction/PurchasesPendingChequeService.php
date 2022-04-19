<?php

namespace App\Services\InventoryTransaction;
use App\Repositories\InventoryTransaction\PurchasesPendingChequeRepositories;

class PurchasesPendingChequeService
{

    /**
     * @var PurchasesPendingChequeRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param PurchasesPendingChequeRepositories $PurchasesPaymnetRepositories
     */
    public function __construct(PurchasesPendingChequeRepositories $systemRepositories)
    {
        $this->systemRepositories = $systemRepositories;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getList($request)
    {
        return $this->systemRepositories->getList($request);
    }
   
     
   

    public function statusValidation($request)
    {
        return [
            'id'                   => 'required',
            'status'               => 'required',
        ];
    }
   
  
    /**
     * @param $request
     * @return \App\Models\Brand
     */
    public function details($id)
    {

        return $this->systemRepositories->details($id);
    }

  /**
     * @param $request
     * @return mixed
     */
    public function approvedCheque($id,$status)
    {
        return $this->systemRepositories->approvedCheque($id,$status);
    }

   
}