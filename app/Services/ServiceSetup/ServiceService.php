<?php

namespace App\Services\ServiceSetup;
use App\Repositories\ServiceSetup\ServiceRepositories;

class ServiceService
{

    /**
     * @var ServiceRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param ServiceRepositories $serviceRepositories
     */
    public function __construct(ServiceRepositories $systemRepositories)
    {
        $this->systemRepositories = $systemRepositories;
    }


     /**
     * @param $request
     * @return mixed
     */
    public function getActiveService()
    {
        return $this->systemRepositories->getActiveService();
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
    public function implodeService($request)
    {
        return $this->systemRepositories->implodeService($request);
    }
    /**
     * @param $request
     * @return mixed
     */
    public function explodeService()
    {
        return $this->systemRepositories->explodeService();
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