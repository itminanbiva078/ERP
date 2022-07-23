<?php

namespace App\Http\Controllers\Backend\Mailbox;
use helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Mailbox\SentService;
use App\Transformers\SentTransformer;
use Illuminate\Validation\ValidationException;


class SentController extends Controller
{

    /**
     * @var SentService
     */
    private $systemService;
    /**
     * @var SentTransformer
     */
    private $systemTransformer;

    /**
     * SentController constructor.
     * @param SentService $systemService
     * @param SentTransformer $systemTransformer
     */
    public function __construct(SentService $sentService, SentTransformer $sentTransformer)
    {
        $this->systemService = $sentService;
        $this->systemTransformer = $sentTransformer;
    }

   /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
       $title = 'Inbox List';
       $companyInfo =   helper::companyInfo();
       $result =  $this->systemService->getList($request);
       return view('backend.pages.mailbox.sent.index', get_defined_vars());
    }

   

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Sent Mail';
        $formInput =  helper::getFormInputByRoute();
        $companyInfo =   helper::companyInfo();

        return view('backend.pages.mailbox.sent.create', get_defined_vars());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTypeWiseUserList(Request $request)
    {
      $result =  $this->systemService->getTypeWiseUserList($request);
        return response()->json($this->systemTransformer->details($result), 200);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, helper::isErrorStore($request));
        } catch (ValidationException $e) {
          
            session()->flash('error', 'Validation error !!');
            return redirect()->back()->withErrors($e->errors())->withInput();
           
        }
        $this->systemService->store($request);
        session()->flash('success', 'successfully email sent!!');
        return redirect()->route('mailbox.sent.index');
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
        return view('backend.pages.mailbox.sent.show', get_defined_vars());
    }
   
}
