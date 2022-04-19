<?php

namespace App\Services\Settings;

use App\Repositories\Settings\CompanyRepositories;
use App\Rules\PhoneNumberValidationRules;
use Intervention\Image\Facades\Image;
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


        // dd($request->all());

        return [
            'company_name'      => 'required|max:100|min:2',
            'logo'              => 'nullable|mimes:jpeg,jpg,png,gif|max:10000',
            'favicon'           => 'nullable|mimes:jpeg,jpg,png,gif|max:10000',
            'invoice_logo'      => 'nullable|mimes:jpeg,jpg,png,gif|max:10000',
            'email'             => 'required|email|unique:companies,email,' . $id,
            'phone'             => ['required', 'unique:companies,phone,' . $id, 'regex:/(^(01))[3-9]{1}(\d){8}$/', new PhoneNumberValidationRules($request)],
            'address'           => 'nullable|max:200',
            'website'           => 'nullable|url',
            'status'            => 'nullable',
        ];
    }

    private function logoUpload($request, $oldImage=null)

    {

        if (!$request->hasFile('logo')) return null;
        $file = $request->file('logo');
        $file_name = 'logo' . time() . '.' . $file->getClientOriginalExtension();
        $path = 'backend/assets/image/';
        //if file exits old image delete
        if (file_exists($oldImage))
            unlink($oldImage);
        //Check if the directory already exists.
        if (!is_dir($path)) {
            //Directory does not exist, so lets create it.
            mkdir($path, 0755, true);
        }
        Image::make($file)->resize(180, 30)->save($path . $file_name);
        return '/' . $path . $file_name;
    }

    private function faviconUpload($request, $oldImage = null)
    {

        if (!$request->hasFile('favicon')) return null;
        $file = $request->file('favicon');
        $file_name = 'favicon' . time() . '.' . $file->getClientOriginalExtension();
        $path = 'backend/assets/image/';
        //if file exits old image delete
        if (file_exists($oldImage))
            unlink($oldImage);
        //Check if the directory already exists.
        if (!is_dir($path)) {
            //Directory does not exist, so lets create it.
            mkdir($path, 0755, true);
        }
        Image::make($file)->resize(180, 30)->save($path . $file_name);
        return '/' . $path . $file_name;
    }

    private function invoiceUpload($request, $oldImage = null)
    {

        if (!$request->hasFile('invoice_logo')) return null;
        $file = $request->file('invoice_logo');
        $file_name = 'invoice' . time() . '.' . $file->getClientOriginalExtension();
        $path = 'backend/assets/image/';
        //if file exits old image delete
        if (file_exists($oldImage))
            unlink($oldImage);
        //Check if the directory already exists.
        if (!is_dir($path)) {
            //Directory does not exist, so lets create it.
            mkdir($path, 0755, true);
        }
        Image::make($file)->resize(180, 30)->save($path . $file_name);
        return '/' . $path . $file_name;
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

        $details =  $this->details($id);

        if ($request->hasFile('logo'))
            $request->logo = $this->logoUpload($request, $details->logo);
        else
            $request->logo = $details->logo;


        if ($request->hasFile('favicon'))
            $request->favicon = $this->faviconUpload($request, $details->favicon);
        else
            $request->favicon = $details->favicon;

        if ($request->hasFile('invoice_logo'))
            $request->invoice_logo = $this->invoiceUpload($request, $details->invoice_logo);
        else
            $request->invoice_logo = $details->invoice_logo;


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