<?php

namespace App\Http\Controllers\Backend\Theme;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\Theme\SubscribeService;
use App\Transformers\SubscribeTransformer;


class SubscribeController extends Controller
{

    /**
     * @var SubscribeService
     */
    private $systemService;
    /**
     * @var SubscribeTransformer
     */
    private $systemTransformer;

    /**
     * SubscribeController constructor.
     * @param SubscribeService $systemService
     * @param SubscribeTransformer $systemTransformer
     */
    public function __construct(SubscribeService $subscribeService, SubscribeTransformer $subscribeTransformer)
    {
        $this->systemService = $subscribeService;
        $this->systemTransformer = $subscribeTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Subscribe List';
        $datatableRoute = 'theme.appearance.subscribe.dataProcessingSubscribe';
        return view('backend.pages.website.subscribe.index', get_defined_vars());
    }


    public function dataProcessingSubscribe(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //dd($request->all());

        try {
            $this->validate($request, helper::isErrorStore($request));
        } catch (ValidationException $e) {
            session()->flash('error', 'Validation error !!');
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        $this->systemService->store($request);
        session()->flash('success', 'Data successfully save!!');
        return redirect()->route('contact');
    }
    

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy($id)
    {
        if (!is_numeric($id)) {
            return response()->json($this->systemTransformer->invalidId($id), 200);
        }
        $detailsInfo =   $this->systemService->details($id);
        if (!$detailsInfo) {
            return response()->json($this->systemTransformer->notFound($detailsInfo), 200);
        }
        $deleteInfo =  $this->systemService->destroy($id);
        if ($deleteInfo) {
            return response()->json($this->systemTransformer->delete($deleteInfo), 200);
        }
    }
}