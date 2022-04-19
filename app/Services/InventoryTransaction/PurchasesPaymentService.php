<?php

namespace App\Services\InventoryTransaction;
use App\Repositories\InventoryTransaction\PurchasesPaymnetRepositories;

class PurchasesPaymentService
{

    /**
     * @var PurchasesPaymnetRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param PurchasesPaymnetRepositories $PurchasesPaymnetRepositories
     */
    public function __construct(PurchasesPaymnetRepositories $systemRepositories)
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
    public function dueVoucherList($supplier_id)
    {
        return $this->systemRepositories->dueVoucherList($supplier_id);
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
    public function store($request)
    {
        return $this->systemRepositories->store($request);
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
    public function purchasesDetails($request)
    {
        return $this->systemRepositories->purchasesDetails($request);
    }

   



    /**
     * @param $request
     * @param $id
     */
    public function destroy($id)
    {
        return $this->systemRepositories->destroy($id);
    }
}