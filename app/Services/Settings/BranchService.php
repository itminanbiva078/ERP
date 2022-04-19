<?php

namespace App\Services\Settings;

use App\Helpers\Helper as HelpersHelper;
use App\Repositories\Settings\BranchRepositories;
use App\Rules\PhoneNumberValidationRules;
use Illuminate\Support\Facades\Route;
use helper;
use Illuminate\Support\Facades\Validator;

class BranchService
{


    /**
     * @var BranchRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param branchRepositories $branchRepositories
     */
    public function __construct(BranchRepositories $systemRepositories)
    {
        $this->systemRepositories = $systemRepositories;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getAllBranch()
    {
        return $this->systemRepositories->getAllBranch();
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
