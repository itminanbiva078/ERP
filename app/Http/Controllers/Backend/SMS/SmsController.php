<?php

namespace App\Http\Controllers\Backend\SMS;
use helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SMS\SmsService;
use App\Transformers\SmsTransformer;
use Illuminate\Validation\ValidationException;


class SmsController extends Controller
{

    /**
     * @var SmsService
     */
    private $systemService;
    /**
     * @var SmsTransformer
     */
    private $systemTransformer;

    /**
     * SentController constructor.
     * @param SmsService $systemService
     * @param SmsTransformer $systemTransformer
     */
    public function __construct(SmsService $smsService, SmsTransformer $smsTransformer)
    {
        $this->systemService = $smsService;
        $this->systemTransformer = $smsTransformer;
    }

   /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
       $title = 'SMS List';
       $companyInfo =   helper::companyInfo();
       $result =  $this->systemService->getList($request);
       return view('backend.pages.sms.sms.index', get_defined_vars());
    }

   
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Sent Mail';
        $formInput =  helper::getFormInputByRoute();
        $companyInfo =   helper::companyInfo();
        return view('backend.pages.sms.sms.create', get_defined_vars());
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
        session()->flash('success', 'successfully sms sent!!');
        return redirect()->route('sms.sms.index');
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
        return view('backend.pages.sms.sms.show', get_defined_vars());
    }
   
}
