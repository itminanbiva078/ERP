<?php

namespace App\Services\Settings;

use App\Repositories\Settings\StoreRepositories;
use App\Rules\PhoneNumberValidationRules;
use Illuminate\Support\Facades\Validator;

class StoreService
{


    /**
     * @var StoreRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param StoreRepositories $storeRepositories
     */
    public function __construct(StoreRepositories $systemRepositories)
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
    public function getStoreListByBranch($id)
    {
        return $this->systemRepositories->getStoreListByBranch($id);
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
     * @return \App\Models\Branch
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