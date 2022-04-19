<?php

namespace App\Repositories\Mailbox;
use Illuminate\support\Facades\Auth;
use App\Models\Mailbox;


class InboxRepositories
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
     * InboxRepositories constructor.
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
  
}