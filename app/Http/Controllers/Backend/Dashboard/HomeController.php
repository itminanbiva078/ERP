<?php

namespace App\Http\Controllers\Backend\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Booking\BookingService;
use App\Services\Dashboard\DashboardService;
use DB;

class HomeController extends Controller
{

    /**
     * @var BookingService
     */
    private $systemService;
    /**
     * @var bookingService
     */
    private $bookingService;
    /**
     * @var BookingTransformer
     */
    private $systemTransformer;

    /**
     * BookingController constructor.
     * @param BookingService $systemService
     * @param BookingTransformer $systemTransformer
     */
    public function __construct(DashboardService $dashboardService,BookingService $bookingService)
    {
        $this->systemService = $dashboardService;
        $this->bookingService = $bookingService;

    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        $from_date = date('Y-m-d');
        $to_date = date("Y-m-d", time() + 86400);
        $allRooms = Product::company()->where('type_id','Rooms')->get();
        $totalRoom = count($allRooms);
        $bookedRoom = $this->getFreeRoom($from_date,$to_date);
       //dd($bookedRoom);
        $freeRoom = count($bookedRoom);
        $totalBookRoom = $totalRoom - $freeRoom;
        $allBookedRoom = array();
        foreach($bookedRoom as $value):
            array_push($allBookedRoom,$value->id);
        endforeach;

      //  dd($allBookedRoom);
       // $floors = $this->bookingService->floorWiseRoom();

        $result = $this->systemService->getDashboardReport($from_date);


        return view('backend.pages.dashboard.index',get_defined_vars());
    }


    // Get Free Room
    public function getFreeRoom($from_date,$to_date){
        $from_date = date('Y-m-d',strtotime($from_date));
        $to_date = date('Y-m-d',strtotime($to_date));
        $totalPerson=1;
        $sql = "select
        p.id
        from
            products p
            LEFT JOIN product_images as pi on pi.product_id = p.id
            LEFT JOIN product_details as pd on pd.product_id = p.id
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
                    AND b.deleted_at IS NULL
                    AND b.status = 'Approved'
                    AND (  timestampdiff( day, b.entry_date, @parmEndDate )
                        * timestampdiff( day, @parmStartDate, b.exit_date  )) > 0 ) Occupied
            ON p.id = Occupied.room_id
        where pd.number_of_room >= '$totalPerson' and

        Occupied.room_id IS NULL AND p.type_id='Rooms' and p.deleted_at IS NULL group by p.id;";
        $result =  DB::SELECT($sql);

        return $result;
    }


}
