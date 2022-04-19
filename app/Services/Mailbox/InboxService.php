<?php

namespace App\Services\Mailbox;

use App\Repositories\Mailbox\InboxRepositories;


class InboxService
{

    /**
     * @var InboxRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param InboxRepositories $systemRepositories
     */
    public function __construct(InboxRepositories $systemRepositories)
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