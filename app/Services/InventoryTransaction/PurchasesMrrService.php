<?php

namespace App\Services\InventoryTransaction;
use App\Repositories\InventoryTransaction\PurchasesMrrRepositories;

class PurchasesMrrService
{

    /**
     * @var PurchasesMrrRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param PurchasesMrrRepositories $purchasesMrrRepositories
     */
    public function __construct(PurchasesMrrRepositories $systemRepositories)
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

    public function statusValidation($request)
    {
        return [
            'id'                   => 'required',
            'status'               => 'required',
        ];
    }
   
  

    /**
     * @param $request
     * @return \App\Models\PurchasesMrr
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    /**
     * @param $request
     * @return \App\Models\PurchasesMrr
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