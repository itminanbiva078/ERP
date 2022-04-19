<?php

namespace App\Services\Opening;
use App\Repositories\Opening\SupplierOpeningRepositories;

class SupplierOpeningService
{

    /**
     * @var SupplierOpeningRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param SupplierOpeningRepositories $supplierOpeningRepositories
     */
    public function __construct(SupplierOpeningRepositories $systemRepositories)
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
     * @return \App\Models\Transformer
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    /**
     * @param $request
     * @return \App\Models\Transformer
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