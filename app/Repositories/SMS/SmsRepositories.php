<?php

namespace App\Repositories\SMS;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\support\Facades\Auth;
use App\Models\Sms;
use App\Models\Supplier;
Use App\Helpers\Helper;

class SmsRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Sms
     */
    private $sms;
    /**
     * SmsRepositories constructor.
     * @param sms $sms
     */
    
    public function __construct(Sms $sms)
    {
        $this->sms = $sms;
        //$this->middleware(function ($request, $next) {
        $this->user_id = 1; //auth()->user()->id;
        //  return $next($request);
        //});
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $result = Sms::orderBy("id", "desc")->get();
        return $result;

    }


    /**
     * @param $request
     * @return mixed
     */
    public function details($id)
    {
        $result = $this->sms::find($id);
        return $result;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getTypeWiseUserList($request)
    {

        if($request->sms_type == 1){
         $result = Customer::select('phone','id')->get();
        }else if($request->sms_type == 2){
            $result = Supplier::select('phone','id')->get();
        }else{
            $result = Employee::select('phone','id')->get();
        }

        return $result;
    }


    /**
     * @param $request
     * @return mixed
     */
    public function store($request)
    {
         

        $sms = new $this->sms();
        $sms->date = date("Y-m-d");
        $sms->sms_type = $request->sms_type;
        $sms->user_phone = implode(",",$request->user_phone) ?? 0;
        $sms->total_sms = count($request->user_phone);
        $sms->sms_body = $request->sms_body;
        $sms->status = 'Approved';
        $sms->created_by = helper::userId();
        $sms->company_id = helper::companyId();
        $sms->save();
        return $sms;
    }

    
}