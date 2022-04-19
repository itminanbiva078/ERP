<?php

namespace App\Services\AccountTransaction;
use App\Repositories\AccountTransaction\JournalVoucherRepositories;


class JournalVoucherService
{

    /**
     * @var JournalVoucherRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param JournalVoucherRepositories $journalVoucherRepositories
     */
    public function __construct(JournalVoucherRepositories $systemRepositories)
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
    public function journalVoucherDetails($journal_id )
    {
        return $this->systemRepositories->journalVoucherDetails($journal_id );
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