<?php

namespace App\Services\SalesTransaction;
use App\Repositories\SalesTransaction\SalesReturnRepositories;

class SalesReturnService
{

    /**
     * @var SalesReturnRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param SalesReturnRepositories $SalesReturnRepositories
     */
    public function __construct(SalesReturnRepositories $systemRepositories)
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
    public function salesList($request)
    {
        return $this->systemRepositories->salesList($request);
    }
    

     /**
     * @param $request
     * @return mixed
     */
    public function salesDetails($request)
    {
        return $this->systemRepositories->salesDetails($request);
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
     * @return \App\Models\Sales
     */
    public function invoiceDetails($id)
    {

        return $this->systemRepositories->invoiceDetails($id);
    }





}