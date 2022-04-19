<?php

namespace App\Services\SalesTransaction;
use App\Repositories\SalesTransaction\SalesRepositories;

class SalesService
{

    /**
     * @var SalesRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param SalesRepositories $salesRepositories
     */
    public function __construct(SalesRepositories $systemRepositories)
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
    public function checkPendingQuatation($request)
    {
        return $this->systemRepositories->checkPendingQuatation($request);
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
    public function accountApproved($id, $request)
    {
        return $this->systemRepositories->accountApproved($id, $request);
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