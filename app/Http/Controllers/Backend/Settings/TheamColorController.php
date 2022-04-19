<?php

namespace App\Http\Controllers\Backend\Settings;
use helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Settings\TheamColorService;
use App\Transformers\TheamColorTransformer;

class TheamColorController extends Controller
{

     /**
     * @var TheamColorService
     */
    private $systemService;
    /**
     * @var TheamColorTransformer
     */
    private $systemTransformer;

    /**
     * TheamController constructor.
     * @param TheamColorService $systemService
     * @param TheamColorTransformer $systemTransformer
     */
    public function __construct(TheamColorService $theamColorService, TheamColorTransformer $theamColorTransformer)
    {
        $this->systemService = $theamColorService;
        $this->systemTransformer = $theamColorTransformer;
    }



    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->systemService->store($request);
        session()->flash('success', 'Data successfully save!!');
        return back();
    }
    

   



    
    
}