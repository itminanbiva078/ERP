<?php

namespace App\Services\InventorySetup;
use App\Repositories\InventorySetup\SupplierGroupRepositories;

class SupplierGroupService
{

    /**
     * @var SupplierGroupRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param SupplierGroupRepositories $supplierGroupRepositories
     */
    public function __construct(SupplierGroupRepositories $systemRepositories)
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
    public function implodeSupplierGroup($request)
    {
        return $this->systemRepositories->implodeSupplierGroup($request);
    }
    /**
     * @param $request
     * @return mixed
     */
    public function exploadSupplierGroup()
    {
        return $this->systemRepositories->exploadSupplierGroup();
    }

    /**
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