<?php

namespace App\Services\Settings;

use App\Repositories\Settings\CompanyRepositories;
use App\Rules\PhoneNumberValidationRules;
use Illuminate\Support\Facades\Validator;

class CompanyService
{

    /**
     * @var CompanyRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param CompanyRepositories $branchRepositories
     */
    public function __construct(CompanyRepositories $systemRepositories)
    {
        $this->systemRepositories = $systemRepositories;
    }

   

    /**
     * @param $request
     * @return array
     */
    public function storeValidation($request)
    {
        return [
            'company_name'      => 'required|max:100|min:2',
            'logo'              => 'required',
            'favicon'           => 'required',
            'invoice_logo'      => 'required',
            'email'             => 'required|email|unique:branches,email',
            'phone'             => ['required', 'unique:branches,phone', 'regex:/(^(01))[3-9]{1}(\d){8}$/', new PhoneNumberValidationRules($request)],
            'address'           => 'nullable|max:200',
            'website'           => 'nullable|url',
            'status'            => 'nullable',
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function updateValidation($request, $id)
    {
        return [
            'company_name'      => 'required|max:100|min:2',
            'logo'              => 'required',
            'favicon'           => 'required',
            'invoice_logo'      => 'required',
            'email'             => 'required|email|unique:branches,email',
            'phone'             => ['required', 'unique:branches,phone', 'regex:/(^(01))[3-9]{1}(\d){8}$/', new PhoneNumberValidationRules($request)],
            'address'           => 'nullable|max:200',
            'website'           => 'nullable|url',
            'status'            => 'nullable',
        ];
    }

    /**
     * @param $request
     * @return \App\Models\Company
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    /**
     * @param $request
     * @return \App\Models\Company
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



}