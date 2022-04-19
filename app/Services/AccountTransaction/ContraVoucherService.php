<?php

namespace App\Services\AccountTransaction;
use App\Repositories\AccountTransaction\ContraVoucherRepositories;


class ContraVoucherService
{

    /**
     * @var ContraVoucherRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param ContraVoucherRepositories $contraVoucherRepositories
     */
    public function __construct(ContraVoucherRepositories $systemRepositories)
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

    public function statusValidation($request)
    {
        return [
            'id'                   => 'required',
            'status'               => 'required',
        ];
    }
 


    /**
     * @param $request
     * @return \App\Models\JournalVoucher
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    /**
     * @param $request
     * @return \App\Models\JournalVoucher
     */
    public function details($id)
    {

        return $this->systemRepositories->details($id);
    }
/**
     * @param $request
     * @return \App\Models\JournalVoucher
     */
    public function contraVoucherDetails($contra_voucher_id )
    {
        return $this->systemRepositories->contraVoucherDetails($contra_voucher_id );
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