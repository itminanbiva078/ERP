<?php

namespace App\Services\InventoryTransaction;

use App\Repositories\InventoryTransaction\PurchasesOrderRepositories;

class PurchasesOrderService
{

    /**
     * @var PurchasesOrderRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param PurchasesOrderRepositories $purchasesOrderRepositories
     */
    public function __construct(PurchasesOrderRepositories $systemRepositories)
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
    public function approved($request, $id)
    {
        return $this->systemRepositories->approved($request, $id);
    }
    /**
     * @param $request
     * @return mixed
     */
    public function purchasesOrderDetails($request)
    {
        return $this->systemRepositories->purchasesOrderDetails($request);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function statusUpdate($request, $id)
    {
        return $this->systemRepositories->statusUpdate($request, $id);
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
    public function checkPendingRequisition($request)
    {
        return $this->systemRepositories->checkPendingRequisition($request);
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