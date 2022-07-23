<?php

namespace App\Services\SalesTransaction;
use App\Repositories\SalesTransaction\SalesLoanReturnRepositories;

class SalesLoanReturnService
{

    /**
     * @var SalesLoanReturnRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param SalesLoanReturnRepositories $salesLoanReturnRepositories
     */
    public function __construct(SalesLoanReturnRepositories $systemRepositories)
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
    public function salesLoanList($request)
    {
        return $this->systemRepositories->salesLoanList($request);
    }
    

     /**
     * @param $request
     * @return mixed
     */
    public function salesLoanDetails($request)
    {
        return $this->systemRepositories->salesLoanDetails($request);
    }

    
   
    /**
     * @param $request
     * @return mixed
     */
    public function approved($id,$request)
    {
        return $this->systemRepositories->approved($id,$request);
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