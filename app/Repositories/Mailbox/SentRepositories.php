<?php

namespace App\Repositories\Mailbox;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\support\Facades\Auth;
use App\Models\Mailbox;
use App\Models\Supplier;

class SentRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Mailbox
     */
    private $mailbox;
    /**
     * SentRepositories constructor.
     * @param mailbox $mailbox
     */
    
    public function __construct(Mailbox $mailbox)
    {
        $this->mailbox = $mailbox;
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
        $result = Mailbox::orderBy("id", "desc")->get();
        return $result;

    }


    /**
     * @param $request
     * @return mixed
     */
    public function details($id)
    {
        $result = $this->mailbox::find($id);
        return $result;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getTypeWiseUserList($request)
    {

        if($request->mail_type == 1){
         $result = Customer::select('email','id')->get();
        }else if($request->mail_type == 2){
            $result = Supplier::select('email','id')->get();
        }else{
            $result = Employee::select('email','id')->get();
        }

        return $result;
    }


    /**
     * @param $request
     * @return mixed
     */
    public function store($request)
    {

        $mailbox = new $this->mailbox();
        $mailbox->date = date("Y-m-d");
        $mailbox->mail_type = $request->mail_type;
        $mailbox->to_email = implode(",",$request->to_email) ?? 0;
        $mailbox->total_mail = count($request->to_email);
        $mailbox->email_title = $request->email_title;
        $mailbox->email_body = $request->email_body;
        $mailbox->attachment  = $request->attachment  ;
        $mailbox->status = 'Approved';
        $mailbox->created_by = Auth::user()->id;
        $mailbox->company_id = Auth::user()->company_id;
        $mailbox->save();
        return $mailbox;
    }

    
}