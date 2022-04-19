<?php

namespace App\Services\Pos;

use App\Repositories\Pos\PosRepositories;


class PosService
{

    /**
     * @var PosRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param PosRepositories $systemRepositories
     */
    public function __construct(PosRepositories $systemRepositories)
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
    public function getProductList($request)
    {
        return $this->systemRepositories->getProductList($request);
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
    public function details($id)
    {

        return $this->systemRepositories->details($id);
    }

/**
     * @param $request
     * @return \App\Models\PurchasesMrr
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }



}