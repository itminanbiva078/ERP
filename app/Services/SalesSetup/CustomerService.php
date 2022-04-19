<?php

namespace App\Services\SalesSetup;

use App\Repositories\SalesSetup\CustomerRepositories;
use App\Rules\PhoneNumberValidationRules;
use Illuminate\Support\Facades\Validator;

class CustomerService
{

    /**
     * @var CustomerRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param CustomerRepositories $systemRepositories
     */
    public function __construct(CustomerRepositories $systemRepositories)
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
    public function customerList($request)
    {
        return $this->systemRepositories->customerList($request);
    }
    /**
     
     * @param $request
     * @return mixed
     */
    public function customerCode()
    {
        return $this->systemRepositories->customerCode();
    }
    /**
     * @param $request
     * @return mixed
     */
    public function implodeCustomer($request)
    {
        return $this->systemRepositories->implodeCustomer($request);
    }
    /**
     * @param $request
     * @return mixed
     */
    public function explodeCustomer()
    {
        return $this->systemRepositories->explodeCustomer();
    }

     /**
     * @param $request
     * @return mixed
     */
    public function getActiveCustomer()
    {
        return $this->systemRepositories->getActiveCustomer();
    }
    /** 
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