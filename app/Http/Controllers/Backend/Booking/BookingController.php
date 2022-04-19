<?php

namespace App\Http\Controllers\Backend\Booking;

use helper;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Floor;
use App\Services\Booking\BookingService;
use App\Transformers\BookingTransformer;

class BookingController extends Controller
{

    /**
     * @var BookingService
     */
    private $systemService;
    /**
     * @var BookingTransformer
     */
    private $systemTransformer;

    /**
     * BookingController constructor.
     * @param BookingService $systemService
     * @param BookingTransformer $systemTransformer
     */
    public function __construct(BookingService $bookingService, BookingTransformer $bookingTransformer)
    {
        $this->systemService = $bookingService;
        $this->systemTransformer = $bookingTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        
        $title = 'Booking | Booking - List';
        $createRoute = "booking.booking.create";
        $columns = helper::getTableProperty();
        $datatableRoute = 'booking.booking.dataProcessingBooking';
        return view('backend.layouts.common.datatable.datatable', get_defined_vars());
        
    }


    public function dataProcessingBooking(Request $request)
    {
        $json_data = $this->systemService->getList($request);  
        return json_encode($this->systemTransformer->dataTable($json_data));
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    { 
        $title = "Booking | Add New - Booking";
        $listRoute = "booking.booking.index";
        $storeRoute = "booking.booking.store";
        $formInput =  helper::getFormInputByRoute();
       //return view('backend.layouts.common.addEdit.addEditPage', get_defined_vars());  
       return view('backend.pages.booking.booking.create', get_defined_vars());  
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function selectBookinCreate($id)
    { 
        $title = "Booking | Add New - Booking";
        $listRoute = "booking.booking.index";
        $storeRoute = "booking.booking.store";
        $formInput =  helper::getFormInputByRoute('booking.booking.create');
        
       return view('backend.pages.booking.booking.selectCreate', get_defined_vars());  
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchAvailableRoom(Request $request)
    { 
        //$freeRoomList = $this->systemService->getAvailableRoom($request);
        $freeRoomList = helper::getAvailableRoom($request);
      
       
        $returnHtml = view('backend.pages.booking.booking.ajax.searchView', get_defined_vars())->render();
        return response()->json(array('success' => true, 'html' => $returnHtml));
    
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
        session()->flash('success', 'Data successfully save!!');
        return redirect()->route('booking.booking.index');
    }
    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if (!is_numeric($id)) {
            session()->flash('error', 'Edit id must be numeric!!');
            return redirect()->back();
        }
        $editInfo =   $this->systemService->details($id);
        if (!$editInfo) {
            session()->flash('error', 'Edit info is invalid!!');
            return redirect()->back();
        }
        $title = 'Booking Edit';
        $formInput =  helper::getFormInputByRoute();
        return view('backend.pages.booking.booking.edit', get_defined_vars());
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
        $details =   $this->systemService->bookingDetails($id);
        if (!$details) {
            session()->flash('error', 'Details info is invalid!!');
            return redirect()->back();
        }

        $title = 'Booking';
        $formInput =  helper::getFormInputByRoute();
        return view('backend.pages.booking.booking.show', get_defined_vars());
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if (!is_numeric($id)) {
            session()->flash('error', 'Edit id must be numeric!!');
            return redirect()->back();
        }
        $editInfo = $this->systemService->details($id);
        if (!$editInfo) {
            session()->flash('error', 'Edit info is invalid!!');
            return redirect()->back();
        }
        try {
            $this->validate($request, helper::isErrorUpdate($request, $id));
        } catch (ValidationException $e) {
            session()->flash('error', 'Validation error !!');
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        $this->systemService->update($request, $id);
        session()->flash('success', 'Data successfully updated!!');
        return redirect()->route('booking.booking.index');
    }

   
    

    public function approved(Request $request,$id, $status)
    {

        if (!is_numeric($id)) {
            return response()->json($this->systemTransformer->invalidId($id), 200);
        }
        $detailsInfo =   $this->systemService->details($id);
        if (!$detailsInfo) {
            return response()->json($this->systemTransformer->notFound($detailsInfo), 200);
        }
        $statusInfo =  $this->systemService->approved($id, $request);
        if ($statusInfo) {
            return response()->json($this->systemTransformer->statusUpdate($statusInfo), 200);
        }
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function PaymentStatusUpdate($id, $status)
    {
        if (!is_numeric($id)) {
            return response()->json($this->systemTransformer->invalidId($id), 200);
        }
        $detailsInfo =   $this->systemService->details($id);
        if (!$detailsInfo) {
            return response()->json($this->systemTransformer->notFound($detailsInfo), 200);
        }
        $statusInfo =  $this->systemService->PaymentStatusUpdate($id, $status);
        if ($statusInfo) {
            return response()->json($this->systemTransformer->PaymentStatusUpdate($statusInfo), 200);
        }
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

   
    // Get Free Room
    public function getFreeRoom($from_date,$to_date){
        $from_date = date('Y-m-d',strtotime($from_date));
        $to_date = date('Y-m-d',strtotime($to_date));
        $sql = "select
        r.id,r.name,r.purchases_price,r.sale_price,r.description, r.category_id, r.type_id, pi.image
        from
            products r 
            LEFT JOIN product_images as pi on pi.product_id = r.id
            LEFT JOIN 
            ( select 
                    b.room_id
                    from 
                    booking_details b,
                    ( select @parmStartDate := '$from_date',
                        @parmEndDate := '$to_date'  ) sqlvars 
                    where 
                        b.exit_date >= @parmStartDate
                    AND b.entry_date <= @parmEndDate
                    AND ( timestampdiff( day, b.entry_date, @parmEndDate ) 
                        * timestampdiff( day, @parmStartDate, b.exit_date  )) > 0 ) Occupied
            ON r.id = Occupied.room_id
        where
        Occupied.room_id IS NULL AND r.type_id='Rooms';";
        $result =  DB::SELECT($sql);
        return $result;
    }

}