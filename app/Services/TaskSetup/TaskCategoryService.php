<?php

namespace App\Services\TaskSetup;
use App\Repositories\TaskSetup\TaskCategoryRepositories;

class TaskCategoryService
{

    /**
     * @var TaskCategoryRepositories
     */
    private $systemRepositories;
    /**
     * TaskCategoryService constructor.
     * @param TaskCategoryRepositories $taskCategoryRepositories
     */
    public function __construct(TaskCategoryRepositories $systemRepositories)
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
    public function implodeTaskCategory($request)
    {
        return $this->systemRepositories->implodeTaskCategory($request);
    }
    /**
     * @param $request
     * @return \App\Models\Sales
     */
    public function explodeTaskCategory()
    {
        return $this->systemRepositories->explodeTaskCategory();
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