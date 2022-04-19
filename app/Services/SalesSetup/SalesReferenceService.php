<?php

namespace App\Services\SalesSetup;

use App\Repositories\SalesSetup\SalesReferenceRepositories;
use App\Rules\PhoneNumberValidationRules;
use Illuminate\Support\Facades\Validator;

class SalesReferenceService
{

    /**
     * @var SalesReferenceRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param SalesReferenceRepositories $systemRepositories
     */
    public function __construct(SalesReferenceRepositories $systemRepositories)
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
    public function implodeSaleReference($request)
    {
        return $this->systemRepositories->implodeSaleReference($request);
    }
    /**
     * @param $request
     * @return mixed
     */
    public function explodeSaleReference()
    {
        return $this->systemRepositories->explodeSaleReference();
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