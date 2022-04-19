<?php

namespace App\Services\AccountSetup;
use App\Repositories\AccountSetup\BankRepositories;


class BankService
{

    /**
     * @var BankRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param BankRepositories $bankRepositories
     */
    public function __construct(BankRepositories $systemRepositories)
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
    public function implodeBank($request)
    {
        return $this->systemRepositories->implodeBank($request);
    }
    /**
     * @param $request
     * @return mixed
     */
    public function explodeBank()
    {
        return $this->systemRepositories->explodeBank();
    }

     /**
     * @param $request
     * @return mixed
     */
   
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
     * @return \App\Models\Bank
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    /**
     * @param $request
     * @return \App\Models\Bank
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