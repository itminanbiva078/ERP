<?php

namespace App\Services\SalesSetup;
use App\Repositories\SalesSetup\CustomerMediaRepositories;

class CustomerMediaService
{

    /**
     * @var CustomerMediaRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param CustomerMediaRepositories $customerMediaRepositories
     */
    public function __construct(CustomerMediaRepositories $systemRepositories)
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
    public function implodeCustomerMedia($request)
    {
        return $this->systemRepositories->implodeCustomerMedia($request);
    }
    /**
     * @param $request
     * @return mixed
     */
    public function explodeCustomerMedia()
    {
        return $this->systemRepositories->explodeCustomerMedia();
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