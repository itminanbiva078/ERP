<?php

namespace App\Services\Theme;
use App\Repositories\Theme\SubscribeRepositories;

class SubscribeService
{

    /**
     * @var SubscribeRepositories
     */
    private $systemRepositories;
    /**
     * ContactService constructor.
     * @param SubscribeRepositories $subscribeRepositories
     */
    public function __construct(SubscribeRepositories $systemRepositories)
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
     * @return \App\Models\Sales
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    
   
    /**
     * @param $request
     * @return \App\Models\Sales
     */
    public function details($id)
    {

        return $this->systemRepositories->details($id);
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