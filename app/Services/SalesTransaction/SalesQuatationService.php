<?php

namespace App\Services\SalesTransaction;
use App\Repositories\SalesTransaction\SalesQuatationRepositories;

class SalesQuatationService
{

    /**
     * @var SalesQuatationRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param SalesQuatationRepositories $salesQuatationRepositories
     */
    public function __construct(SalesQuatationRepositories $systemRepositories)
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
    public function approved($request, $id)
    {
        return $this->systemRepositories->approved($request, $id);
    }

    /**
     * @param $request
     * @return \App\Models\Sales
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    /**
     * @param $request
     * @return \App\Models\Sales
     */
    public function details($id)
    {

        return $this->systemRepositories->details($id);
    }

/**
     * @param $request
     * @return mixed
     */
    public function salesQuatations($request)
    {
        return $this->systemRepositories->salesQuatations($request);
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