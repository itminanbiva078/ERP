<?php

namespace App\Services\ServiceSetup;
use App\Repositories\ServiceSetup\ServiceCategoryRepositories;

class ServiceCategoryService
{

    /**
     * @var ServiceCategoryRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param ServiceCategoryRepositories $serviceCategoryRepositories
     */
    public function __construct(ServiceCategoryRepositories $systemRepositories)
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
    public function implodeServiceCategory($request)
    {
        return $this->systemRepositories->implodeServiceCategory($request);
    }

    /**
     * @param $request
     * @return \App\Models\Sales
     */
    public function explodeServiceCategory()
    {
        return $this->systemRepositories->explodeServiceCategory();
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