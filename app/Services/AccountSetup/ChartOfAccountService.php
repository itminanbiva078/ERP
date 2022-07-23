<?php

namespace App\Services\AccountSetup;
use App\Repositories\AccountSetup\ChartOfAccountRepositories;


class ChartOfAccountService
{

    /**
     * @var ChartOfAccountRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param ChartOfAccountRepositories $categoryRepositories
     */
    public function __construct(ChartOfAccountRepositories $systemRepositories)
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
     * @return \App\Models\ChartOfAccount
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    /**
     * @param $request
     * @return \App\Models\ChartOfAccount
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
    public function chartListByTypeWise($id)
    {
        return $this->systemRepositories->chartListByTypeWise($id);
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
