<?php

namespace App\Services\InventorySetup;
use App\Repositories\InventorySetup\UnitRepositories;

class UnitService
{

    /**
     * @var UnitRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param UnitRepositories $branchRepositories
     */
    public function __construct(UnitRepositories $systemRepositories)
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
     * @return mixed
     */
    public function implodeUnit($request)
    {
        return $this->systemRepositories->implodeUnit($request);
    }
    /**
     * @param $request
     * @return mixed
     */
    public function exploadUnit()
    {
        return $this->systemRepositories->exploadUnit();
    }

    /**
     * @param $request
     * @return \App\Models\ProductUnit
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    /**
     * @param $request
     * @return \App\Models\ProductUnit
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