<?php

namespace App\Services\AccountReport;
use App\Repositories\AccountReport\AccountReportRepositories;


class AccountReportService
{

    /**
     * @var AccountReportRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param AccountReportRepositories $accountReportRepositories
     */
    public function __construct(AccountReportRepositories $systemRepositories)
    {
        $this->systemRepositories = $systemRepositories;
    }

  
    /**
     * @param $request
     * @return mixed
     */
    public function getAccountLedger($account_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getAccountLedger($account_id,$from_date,$to_date);
    }
     

   
 

}