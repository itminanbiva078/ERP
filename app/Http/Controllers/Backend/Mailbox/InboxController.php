<?php

namespace App\Http\Controllers\Backend\Mailbox;
use helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Mailbox\InboxService;
use App\Transformers\InboxTransformer;


class InboxController extends Controller
{

    /**
     * @var InboxService
     */
    private $systemService;
    /**
     * @var InboxTransformer
     */
    private $systemTransformer;

    /**
     * InboxController constructor.
     * @param InboxService $systemService
     * @param InboxTransformer $systemTransformer
     */
    public function __construct(InboxService $inboxService, InboxTransformer $inboxTransformer)
    {
        $this->systemService = $inboxService;
        $this->systemTransformer = $inboxTransformer;
    }

   /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
       $title = 'Inbox List';
       $companyInfo =   helper::companyInfo();
       $result =  $this->systemService->getList($request);
       return view('backend.pages.mailbox.inbox.index', get_defined_vars());
    }

  
     /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        if (!is_numeric($id)) {
            session()->flash('error', 'Details id must be numeric!!');
            return redirect()->back();
        }
        $details =   $this->systemService->details($id);
        if (!$details) {
            session()->flash('error', 'Details info is invalid!!');
            return redirect()->back();
        }
        $companyInfo =   helper::companyInfo();
        return view('backend.pages.mailbox.inbox.show', get_defined_vars());
    }
   
}
