<?php

namespace App\Services\AccountSetup;
use App\Repositories\AccountSetup\OpeningBalanceRepositories;


class OpeningBalanceService
{

    /**
     * @var OpeningBalanceRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param OpeningBalanceRepositories $categoryRepositories
     */
    public function __construct(OpeningBalanceRepositories $systemRepositories)
    {
        $this->systemRepositories = $systemRepositories;
    }
   

   /**
     * @param $request
     * @return \App\Models\JournalVoucher
     */
    public function details()
    {

        return $this->systemRepositories->details(1);
    }
    public function statusValidation($request)
    {
        return [
            'id'                   => 'required',
            'status'               => 'required',
        ];
    }
   

    public function getAccountList()
    {
        return $this->systemRepositories->getAccountList();
    }

    public function inventoryBalance()
    {
        return $this->systemRepositories->inventoryBalance();
    }


    public function customerBalance()
    {
        return $this->systemRepositories->customerBalance();
    }

    public function supplierBalance()
    {
        return $this->systemRepositories->supplierBalance();
    }


    /**
     * @param $request
     * @param $id
     */
    public function update($request)
    {
        return $this->systemRepositories->update($request);
    }
 
}