<?php

namespace App\Services\Settings;

use App\Repositories\Settings\TheamColorRepositories;

class TheamColorService
{


    /**
     * @var TheamColorRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param TheamColorRepositories $TheamColorRepositories
     */
    public function __construct(TheamColorRepositories $systemRepositories)
    {
        $this->systemRepositories = $systemRepositories;
    }
    
   
    /**
     * @param $request
     * @return \App\Models\Branch
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }


    
}