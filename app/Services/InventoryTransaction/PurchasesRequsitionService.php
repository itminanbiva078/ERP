<?php

namespace App\Services\InventoryTransaction;
use App\Repositories\InventoryTransaction\PurchasesRequsitionRepositories;

class PurchasesRequsitionService
{

    /**
     * @var PurchasesRequsitionRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param PurchasesRequsitionRepositories $purchasesOrderRepositories
     */
    public function __construct(PurchasesRequsitionRepositories $systemRepositories)
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
    public function approved($request, $id)
    {
        return $this->systemRepositories->approved($request, $id);
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
     * @return \App\Models\Brand
     */
    public function requisitionDetails($requisition_id)
    {
        return $this->systemRepositories->requisitionDetails($requisition_id);
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