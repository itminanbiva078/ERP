<?php

namespace App\Services\AccountTransaction;
use App\Repositories\AccountTransaction\ReceiveVoucherRepositories;


class ReceiveVoucherService
{

    /**
     * @var ReceiveVoucherRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param ReceiveVoucherRepositories $receiveVoucherRepositories
     */
    public function __construct(ReceiveVoucherRepositories $systemRepositories)
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
   
    /**
     * @param $request
     * @return mixed
     */
    public function statusUpdate($request, $id)
    {
        return $this->systemRepositories->statusUpdate($request, $id);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function accountApproved($id, $status)
    {
        return $this->systemRepositories->accountApproved($id, $status);
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
     * @return \App\Models\ReceiveVoucher
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    /**
     * @param $request
     * @return \App\Models\ReceiveVoucher
     */
    public function details($id)
    {

        return $this->systemRepositories->details($id);
    }
     /**
     * @param $request
     * @return \App\Models\Brand
     */
    public function receiveVoucherDetails($receive_id)
    {
        return $this->systemRepositories->receiveVoucherDetails($receive_id);
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