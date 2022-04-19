<?php

namespace App\Services\ServiceTransaction;
use App\Repositories\ServiceTransaction\ServiceQuatationRepositories;

class ServiceQuatationService
{

    /**
     * @var ServiceQuatationRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param ServiceQuatationRepositories $serviceQuatationRepositories
     */
    public function __construct(ServiceQuatationRepositories $systemRepositories)
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
    public function approved($id, $request)
    {
        return $this->systemRepositories->approved($id, $request);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function serviceQuatationDetails($request)
    {
        return $this->systemRepositories->serviceQuatationDetails($request);
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
     * @return \App\Models\Brand
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    /**
     * @param $request
     * @return \App\Models\Brand
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