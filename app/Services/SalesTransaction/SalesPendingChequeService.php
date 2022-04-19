<?php

namespace App\Services\SalesTransaction;
use App\Repositories\SalesTransaction\SalesPendingChequeRepositories;

class SalesPendingChequeService
{

    /**
     * @var SalesPendingChequeRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param SalesPendingChequeRepositories $salesPendingChequeRepositories
     */
    public function __construct(SalesPendingChequeRepositories $systemRepositories)
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
     * @return \App\Models\Brand
     */
    public function details($id)
    {

        return $this->systemRepositories->details($id);
    }
    /**
     * @param $request
     * @return \App\Models\Brand
     */
    public function posDetails($id)
    {

        return $this->systemRepositories->posDetails($id);
    }


    /**
     * @param $request
     * @return mixed
     */
    public function approvedCheque($id,$status)
    {
        return $this->systemRepositories->approvedCheque($id,$status);
    }

   

    
}