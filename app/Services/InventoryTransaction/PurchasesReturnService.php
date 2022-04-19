<?php

namespace App\Services\InventoryTransaction;
use App\Repositories\InventoryTransaction\PurchasesReturnRepositories;

class PurchasesReturnService
{

    /**
     * @var PurchasesReturnRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param PurchasesReturnRepositories $purchasesReturnRepositories
     */
    public function __construct(PurchasesReturnRepositories $systemRepositories)
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
    /**
     * @param $request
     * @return mixed
     */
    public function purchasesList($request)
    {
        return $this->systemRepositories->purchasesList($request);
    }
    

     /**
     * @param $request
     * @return mixed
     */
    public function purchasesDetails($request)
    {
        return $this->systemRepositories->purchasesDetails($request);
    }

     /**
     * @param $request
     * @return mixed
     */
    public function approved($id,$request)
    {
        return $this->systemRepositories->approved($id,$request);
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
     * @return \App\Models\Sales
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    /**
     * @param $request
     * @return \App\Models\Sales
     */
    public function details($id)
    {

        return $this->systemRepositories->details($id);
    }
    /**
     * @param $request
     * @return \App\Models\Sales
     */
    public function invoiceDetails($id)
    {

        return $this->systemRepositories->invoiceDetails($id);
    }


}