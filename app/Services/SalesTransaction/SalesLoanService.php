<?php

namespace App\Services\SalesTransaction;
use App\Repositories\SalesTransaction\SalesLoanRepositories;

class SalesLoanService
{

    /**
     * @var SalesLoanRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param SalesLoanRepositories $salesLoanRepositories
     */
    public function __construct(SalesLoanRepositories $systemRepositories)
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
    public function getActiveBatch()
    {
        return $this->systemRepositories->getActiveBatch();
    }
   
 /**
     * @param $request
     * @return mixed
     */
    public function checkPendingQuatation($request)
    {
        return $this->systemRepositories->checkPendingQuatation($request);
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