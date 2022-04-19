<?php

namespace App\Services\SalesSetup;
use App\Repositories\SalesSetup\CustomerGroupRepositories;

class CustomerGroupService
{

    /**
     * @var CustomerGroupRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param CustomerGroupRepositories $customerGroupRepositories
     */
    public function __construct(CustomerGroupRepositories $systemRepositories)
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
    public function implodeCustomerGroup($request)
    {
        return $this->systemRepositories->implodeCustomerGroup($request);
    }
    /**
     * @param $request
     * @return mixed
     */
    public function explodeCustomerGroup()
    {
        return $this->systemRepositories->explodeCustomerGroup();
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