<?php

namespace App\Services\SMS;

use App\Repositories\SMS\SmsRepositories;


class SmsService
{

    /**
     * @var SmsRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param SmsRepositories $systemRepositories
     */
    public function __construct(SmsRepositories $systemRepositories)
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