<?php

namespace App\Services\Mailbox;

use App\Repositories\Mailbox\SentRepositories;


class SentService
{

    /**
     * @var SentRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param SentRepositories $systemRepositories
     */
    public function __construct(SentRepositories $systemRepositories)
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
    
    /**
     * @param $request
     * @return mixed
     */
    public function getTypeWiseUserList($request)
    {
        return $this->systemRepositories->getTypeWiseUserList($request);
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
     * @return \App\Models\Supplier
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    /**
     * @param $request
     * @return \App\Models\Supplier
     */
    public function details($id)
    {

        return $this->systemRepositories->details($id);
    }


  

}