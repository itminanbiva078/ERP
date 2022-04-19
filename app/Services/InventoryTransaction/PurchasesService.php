<?php

namespace App\Services\InventoryTransaction;
use App\Repositories\InventoryTransaction\PurchasesRepositories;

class PurchasesService
{

    /**
     * @var PurchasesOrderRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param PurchasesOrderRepositories $purchasesOrderRepositories
     */
    public function __construct(PurchasesRepositories $systemRepositories)
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
    public function statusUpdate($request, $id)
    {
        return $this->systemRepositories->statusUpdate($request, $id);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function accountApproved($id, $request)
    {
        return $this->systemRepositories->accountApproved($id, $request);
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
    public function checkPendingOrder($request)
    {
        return $this->systemRepositories->checkPendingOrder($request);
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
    public function update($request, $id)
    {
        return $this->systemRepositories->update($request, $id);
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