<?php

namespace App\Services\InventorySetup;
use App\Repositories\InventorySetup\SupplierRepositories;
class SupplierService
{

    /**
     * @var SupplierRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param SupplierRepositories $supplierRepositories
     */
    public function __construct(SupplierRepositories $systemRepositories)
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
    public function supplierCode()
    {
        return $this->systemRepositories->supplierCode();
    }
    /**
     /**
     * @param $request
     * @return mixed
     */
    public function implodeSupplier($request)
    {
        return $this->systemRepositories->implodeSupplier($request);
    }
    /**
     * @param $request
     * @return mixed
     */
    public function exploadSupplier()
    {
        return $this->systemRepositories->exploadSupplier();
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
     * @return \App\Models\Supplier
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    /**
     * @param $request
     * @return \App\Models\Supplier
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