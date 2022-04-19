<?php

namespace App\Services\Settings;

use App\Repositories\Settings\DepartmentRepositories;
use App\Rules\PhoneNumberValidationRules;
use Illuminate\Support\Facades\Validator;

class DepartmentService
{


    /**
     * @var DepartmentRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param DepartmentRepositories $departmentRepositories
     */
    public function __construct(DepartmentRepositories $systemRepositories)
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
    public function implodeDepartment($request)
    {
        return $this->systemRepositories->implodeDepartment($request);
    }
  /**
     * @param $request
     * @return mixed
     */
    public function explodeDepartment()
    {
        return $this->systemRepositories->explodeDepartment();
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
     * @return \App\Models\Department
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    /**
     * @param $request
     * @return \App\Models\Department
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