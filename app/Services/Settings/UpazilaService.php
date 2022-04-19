<?php
namespace App\Services\Settings;
use App\Repositories\Settings\UpazilaRepositories;

class UpazilaService
{


    /**
     * @var UpazilaRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param UpazilaRepositories $upazilaRepositories
     */
    public function __construct(UpazilaRepositories $systemRepositories)
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
     * @return mixed
     */
    public function getUpazilaListByDistrictId($districtId)
    {
        return $this->systemRepositories->getUpazilaListByDistrictId($districtId);
    }





    /**
     * @param $request
     * @return \App\Models\Employee
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    /**
     * @param $request
     * @return \App\Models\Branch
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