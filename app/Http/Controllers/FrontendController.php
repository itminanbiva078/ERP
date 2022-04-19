<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use helper;
use App\SM\SM;
use App\Models\User;
use App\Models\Review;
use App\Models\Booking;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\BookingDetails;
use App\Models\ProductDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Helpers\Helper as HelpersHelper;
use App\Models\Contact;
use App\Models\ProductAttribute;
use App\Models\Subscribe;

class FrontendController extends Controller
{
    
    public function index() 
    {
        $entry_date = date('m/d/Y');
        $date = date('M d, Y');
        $date = strtotime($date);
        $date = strtotime("+7 day", $date);
        $exit_date = date('m/d/Y', $date);
        $product = Product::with('productDetails','productImages')->where('type_id', 'Rooms')->get();
        $prod_category = array();
        foreach ($product as $key => $value) {
            array_push($prod_category, $value->category_id);
        }
        $category = Category::whereIn('id', $prod_category)->orderBy('priority','asc')->get();

        return view('auth.login', get_defined_vars());
       //return view('welcome', get_defined_vars());
    }
    
    public function who_we_are()
    {
        $about_banner_title = SM::smGetThemeOption( "about_banner_title", "" );
        $wwr_subtitle = SM::smGetThemeOption( "wwr_subtitle", "" );
        $wwr_description = SM::smGetThemeOption( "wwr_description", "" );
        $about_page_add = SM::smGetThemeOption( "about_page_add", "" );
        $history_title = SM::smGetThemeOption( "history_title", "" );
        $history = SM::smGetThemeOption( "history", "" );
        return view('web.pages.who_we_are',get_defined_vars());
    }
    public function foundation_of_passion()
    {
        $foundation_title = SM::smGetThemeOption( "foundation_title", "" );
        $foundation_description = SM::smGetThemeOption( "foundation_description", "" );
        $foundation_image = SM::smGetThemeOption( "foundation_image", "" );
        return view('web.pages.foundation_of_passion',get_defined_vars());
    }
    public function board_of_director()
    {
        $teams = SM::smGetThemeOption( "teams", "" );
        $team_description = SM::smGetThemeOption( "team_description", "" );
        return view('web.pages.board_of_director',get_defined_vars());
    }
    public function company_management()
    {
        $teams = SM::smGetThemeOption( "teams", "" );
        $team_description = SM::smGetThemeOption( "team_description", "" );
        return view('web.pages.company_management',get_defined_vars());
    }
    public function statement()
    {
        return view('web.pages.statement');
    }
    public function service()
    {
        $features = SM::smGetThemeOption( "features", "" );
        $features_title = SM::smGetThemeOption( "features_title", "" );
        $features_sub_title = SM::smGetThemeOption( "features_sub_title", "" );
        return view('web.pages.service',get_defined_vars());
    }
    public function project()
    {
        return view('web.pages.project');
    }
    // Room List
    public function rooms(Request $request)
    {
        if(!empty($request->room_type)): 
            $room_type = $request->room_type;
            if($request->room_type == 'all-rooms'){
                $product = Product::with('productDetails','productImages')->where('type_id', 'Rooms')->get();
            }else{
                $product = Product::with('productDetails','productImages')->where('type_id', 'Rooms')->where('category_id',$request->room_type)->get();
            }
        else: 
            $product = Product::with('productDetails','productImages')->where('type_id', 'Rooms')->get();
        endif;
        $prod_category = array();
        foreach ($product as $key => $value) {
            array_push($prod_category, $value->category_id);
        }
        $category = Category::whereIn('id',$prod_category)->get();
        $flag = 0;
        return view('web.pages.property', get_defined_vars());
    }
    // Search Product
    public function search_product(Request $request)
    {

        $daterange = $request->daterange;
        $daterange = explode(" - ",$request->daterange);
        $entry_date = $daterange[0];
        $entry_date = date_create($entry_date);
        $entry_date = date_format($entry_date,"Y-m-d");
        $exit_date = $daterange[1];
        $exit_date = date_create($exit_date);
        $exit_date = date_format($exit_date,"Y-m-d");
        if(!empty($exit_date) && !empty($entry_date))
        {
            if(Session::has('entry_date')){
                Session::forget('entry_date');
            }
            if(Session::has('exit_date')){
                Session::forget('exit_date');
            }
            Session::put('entry_date', $entry_date);
            Session::put('exit_date', $exit_date);
        }
        if(is_numeric($request->room_type))
        {
            if(Session::has('room_type')){
                Session::forget('room_type');
            }
            Session::put('room_type', $request->room_type);
        }
        if(!empty($request->adult))
        {
            if(Session::has('adult')){
                Session::forget('adult');
            }
            Session::put('adult', $request->adult);
        }
        if(!empty($request->children))
        {
            if(Session::has('child')){
                Session::forget('child');
            }
            Session::put('child', $request->children);
        }

        $data['product'] = $this->available_room($entry_date,$exit_date,$request->room_type);

        $prod_category = array();
        foreach ($data['product'] as $key => $value) {
            array_push($prod_category, $value->category_id);
        }
        $data['category'] = Category::whereIn('id', $prod_category)->get();
        $data['flag'] = 1;
        return view('web.pages.property',$data);
    }
    // Search Room
    public function search_room(Request $request)
    {

        $daterange = $request->daterange;
        $daterange = explode(" - ",$request->daterange);
        $entry_date = $daterange[0];
        $entry_date = date_create($entry_date);
        $entry_date = date_format($entry_date,"Y-m-d");
        $exit_date = $daterange[1];
        $exit_date = date_create($exit_date);
        $exit_date = date_format($exit_date,"Y-m-d");
        if(!empty($daterange))
        {
            if(Session::has('entry_date')){
                Session::forget('entry_date');
            }
            if(Session::has('exit_date')){
                Session::forget('exit_date');
            }
            Session::put('entry_date', $entry_date);
            Session::put('exit_date', $exit_date);
        }
        if(is_numeric($request->room_type))
        {
            if(Session::has('room_type')){
                Session::forget('room_type');
            }
            Session::put('room_type', $request->room_type);
        }
        if(!empty($request->adult))
        {
            if(Session::has('adult')){
                Session::forget('adult');
            }
            Session::put('adult', $request->adult);
        }
        if(!empty($request->children))
        {
            if(Session::has('child')){
                Session::forget('child');
            }
            Session::put('child', $request->children);
        }
        $data['product'] = $this->available_room($entry_date,$exit_date,$request->room_type);

        return view('web.pages.products', $data);
    }

    // Search Filtering
    public function search_filter(Request $request)
    {

        if(!empty($request->features)):
            $features = explode(",",$request->features);
            $featuresProducts = ProductAttribute::select('product_id')->whereIn('name',$features)->get();
        else: 
            $featuresProducts = null;
        endif;
       

        $entry_date = $request->entry_date;
        $exit_date = $request->exit_date;
        if(!empty($exit_date) && !empty($entry_date))
        {
            if(Session::has('entry_date')){
                Session::forget('entry_date');
            }
            if(Session::has('exit_date')){
                Session::forget('exit_date');
            }
            Session::put('entry_date', $entry_date);
            Session::put('exit_date', $exit_date);
        }
        if(is_numeric($request->room_type))
        {
            if(Session::has('room_type')){
                Session::forget('room_type');
            }
            Session::put('room_type', $request->room_type);
        }
        if(!empty($request->adult))
        {
            if(Session::has('adult')){
                Session::forget('adult');
            }
            Session::put('adult', $request->adult);
        }
        if(!empty($request->children))
        {
            if(Session::has('child')){
                Session::forget('child');
            }
            Session::put('child', $request->children);
        }
        $data['product'] = $this->available_room($entry_date,$exit_date,$request->room_type,'','',$featuresProducts,$request->min_price, $request->max_price);
        return view('web.pages.product_filter', $data);
    }


    // Search Facilities
    public function search_facilities(Request $request)
    {
        $product = Product::with('productDetails', 'productImages','reviews')->where('type_id', 'Rooms');
        $features = $request->features;
        $product = $product->whereHas('productDetails', function ($p) use ($features) {
            $p->whereIn('product_attributes', ['Locker']);
        });
        $product = $product->get();
        return $product;

    }
    // Category Product
    public function category_product($id)
    {
        $entry_date = Session::get('entry_date');
        $exit_date = Session::get('exit_date');
        $product = $this->getFreeRoom($entry_date,$exit_date,$id);
        $prod_category = array();
        foreach ($product as $key => $value) {
            array_push($prod_category, $value->category_id);
        }
        $category = Category::whereIn('id', $prod_category)->orderBy('priority','asc')->get();
        $flag = 1;
        return view('web.pages.property',get_defined_vars());
    }
    // Available Room
    public function available_room($entry_date,$exit_date,$room_type=NULL,$limit=NULL,$id=NULL,$features=NULL,$min_price=NULL, $max_price=NULL ,$numer_of_person=NULL)
    {
        
        $freeRoomId =  $this->getFreeRoom($entry_date,$exit_date,null,1);
        $product = Product::with('productDetails','productImages','reviews')->where('type_id', 'Rooms')->whereIn('id', $freeRoomId);
        if(is_numeric($room_type))
        {
            $product = $product->where('products.category_id', $room_type);
        }
        if((preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $room_type)))
        {
            $room_category = explode(',', $room_type);
            $product = $product->whereIn('products.category_id', $room_category);
        }
        if(!empty($numer_of_person))
        {
            $product = $product->whereHas('productDetails', function($q) use($numer_of_person) {
                            $q->where('number_of_room', '>=', $numer_of_person);
                        });
        }
        if(!empty($min_price) && !empty($max_price))
        {
            $product = $product->whereBetween('products.sale_price', [$min_price, $max_price]);
        }
        if(!empty($features))
        {

            $product = $product->whereIn('id',$features);

          
        }        
        if(!empty($id))
        {
            $product = $product->where('id', '!=', $id);
        }
        if(!empty($limit))
        {
            $product = $product->limit($limit)->get();
        }
        else
        {
            $product = $product->get();
        }
        return $product;
    }
    // Contactpage
    
    public function contact()
    {
        return view('web.pages.contact');
    }


   



    // Product Details
    public function property_details(Request $request, $id)
    {

        if(!empty($request->daterange)): 

           
            $dateran = $request->daterange;
            $daterange = explode("-",$request->daterange);
            $from_date = date('Y-m-d',strtotime($daterange[0]));
            $to_date = date('Y-m-d',strtotime($daterange[1]));
            if($from_date == $to_date){
                $to_date = date('Y-m-d', strtotime( $daterange[1]. " +1 days"));

                $dateran = date('m/d/Y',strtotime($from_date)) .' - '.date('m/d/Y',strtotime($to_date));
          
            }
            $roomStatus = $this->getFreeRoom($from_date,$to_date,1,null,$id);
           
            Session::put('entry_date', $from_date);
            Session::put('exit_date', $to_date);

        else: 
           

            $entry_date = Session::get('entry_date');
            $exit_date = Session::get('exit_date');

            if(!empty($entry_date) && !empty($exit_date)):
               $dateran = date('m/d/Y',strtotime($entry_date)) .' - '.date('m/d/Y',strtotime($exit_date));
            else: 
                $entry_date = date('m-d-Y');
                $exit_date = date("m/d/Y", time() + 86400);
                $dateran = date('m/d/Y') .' - '.date("m/d/Y", time() + 86400);
            endif;
           
           // echo $dateran;die;
            $roomStatus = $this->getFreeRoom($entry_date,$exit_date,1,null,$id);
        
      
        endif;
        $detailsId = $id;
        $product = Product::with('productDetails','productImages','reviews')->where('id', $id)->first();
        $product_attributes = $product->productDetails->product_attributes;
        $similar_product = Product::with('productDetails','productImages')->where('type_id', 'Rooms')->where('category_id', $product->category_id)->where('id', '!=', $id)->limit(4)->get();
        return view('web.pages.property_details', get_defined_vars());
    }
    // Get Free Room
    public function getFreeRoom($from_date,$to_date, $numer_of_person=NULL,$reportType=null,$singleRoom=null){
        $from_date = date('Y-m-d',strtotime($from_date));
        $to_date = date('Y-m-d',strtotime($to_date));
        $totalPerson = $numer_of_person ?? 1;

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
        $allRoomId=array();
        foreach($result as $key => $value): 
            array_push($allRoomId,$value->id);
  

        endforeach;

        if(!empty($reportType) && $reportType == 1): 
            return $allRoomId;

        elseif(!empty($singleRoom)): 

            if(in_array($singleRoom,$allRoomId)){
                return 'show';
            }else{
                return 'hide';
            }

        else: 

            $result = Product::with('productDetails','productImages')->whereIn('id', $allRoomId)->get();
            return $result;
        endif;


        
    }
    // Search Available Room
    public function room_list(Request $request)
    {

        if($request->has('daterange')){
            $daterange = explode(" - ", $request->daterange);
            $entry_date = date('Y-m-d', strtotime($daterange[0]));
            $exit_date = date('Y-m-d', strtotime($daterange[1]));

            if($entry_date == $exit_date){
                $exit_date = date('Y-m-d', strtotime( $daterange[1]. " +1 days"));
          
            }

            if(Session::has('entry_date')){
                Session::forget('entry_date');
            }
            if(Session::has('exit_date')){
                Session::forget('exit_date');
            }
            Session::put('entry_date', $entry_date);
            Session::put('exit_date', $exit_date);
        }
        if($request->has('adult')){
            $adult = $request->adult;
            if(Session::has('adult')){
                Session::forget('adult');
            }
            Session::put('adult', $adult);
        }
        if($request->has('children')){
            $children = $request->children;
            if(Session::has('children')){
                Session::forget('children');
            }
            Session::put('children', $children);
        }
        $numer_of_person = ($adult + $children);
        $main_product = array(); 
        $main_product_count = 0; 
        if(!empty($request->id))
        { 
            $product_id = $request->id;
            $main_product = Product::with('productDetails','productImages')->where('id', $product_id)->first();
            $main_product_count = Product::where('category_id', $main_product->category_id)->get();
            //$main_product->number_of_room = $main_product_count->count();
        }else{
            $product_id = '';
        }
        /** Available room query start */
        // $product = $this->available_room($entry_date, $exit_date,'',100,$product_id,'','','',$numer_of_person);
        $product = $this->getFreeRoom($entry_date, $exit_date,$numer_of_person);
        $min_price = Product::where('type_id', 'Rooms')->min('sale_price');
        $max_price = Product::where('type_id', 'Rooms')->max('sale_price');
        $prod_category = array();
        foreach ($product as $key => $value) {
            if(!empty($value->category_id)): 
               array_push($prod_category, $value->category_id);
            endif;
        }
        $category = Category::whereIn('id', $prod_category)->orderBy('priority','asc')->get();
        $reviews = Review::get();
        $feature = helper::getSetupData(13);
        $add_on = Product::with('productDetails','productImages')->where('type_id','Add On')->get();
        return view('web.pages.room', get_defined_vars());
    }

    public function booking_delete($id){

        Booking::where('id',$id)->delete();
        BookingDetails::where('booking_id',$id)->delete();
        session()->flash('success', 'User room successfully delete!!');
        return redirect()->route('profile'); 

    }


    // Booking Submit
    public function booking_submit(Request $request)
    {
        /*$this->validate($request, [
            'email' => 'required|email|unique:users,email',
        ]);*/
        $daterange = $request->daterange;
        $daterange = explode(" - ",$request->daterange);
        $entry_date = $daterange[0];
        $entry_date = date_create($entry_date);
        $entry_date = date_format($entry_date,"Y-m-d");
        $exit_date = $daterange[1];
        $exit_date = date_create($exit_date);
        $exit_date = date_format($exit_date,"Y-m-d");
        $datediff =  strtotime($exit_date) - strtotime($entry_date);
        $total_days = (int)round($datediff / (60 * 60 * 24));
        $addon = '';
        if(!empty($request->addon))
        {
            $addon = implode(',',$request->addon);
        }
        $customer_info = Customer::where('id',Auth::user()->customer_id)->first();
        if(empty($customer_info))
        {
            $pin= rand(1111,9999);
            $password = bcrypt($pin);
            $customer = new Customer;
            $customer->company_id = 1;
            $customer->name = $request->name;
            $customer->code = $this->customerCode();
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->status = "Approved";
            $customer->created_by = 1;
            $customer->updated_by = 1;
            $customer->deleted_by = 1;
            $customer->save();  
            $user = new User;
            $user->customer_id = $customer->id;
            $user->company_id = 1;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->status = "Approved";
            $user->password = $password;
            $user->created_by = 1;
            $user->updated_by = 1;
            $user->deleted_by = 1;
            $user->save(); 
        }else{
            $customer = Customer::find($customer_info->id);
            $customer->company_id = 1;
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->save();

            $user_info= User::where('customer_id',$customer->id)->first();
            $user_info->company_id = 1;
            $user_info->name = $request->name;
            $user_info->email = $request->email;
            $user_info->phone = $request->phone;
            $user_info->save();  
        }
        $booking = new Booking;
        $booking->company_id = 1;
        $booking->customer_id = $customer->id;
        $booking->date = date('Y-m-d');
        $booking->addon = $addon;
        $booking->payment_status = "Pending";
        $booking->booking_status = "Pending";
        $booking->updated_by = 1;
        $booking->created_by = 1;
        $booking->save();
        $total_price = 0;
        $advance_paid = 0;
        $paid = 0;

        $product = Product::with('productDetails')->where('id',$request->room_id)->first();
        $bookingDetails = new BookingDetails;
        $bookingDetails->booking_id = $booking->id;
        $bookingDetails->company_id = 1;
        $bookingDetails->room_id = $request->room_id;
        $bookingDetails->product_id = $request->room_id;
        $bookingDetails->category_id = $product->category_id;
        $bookingDetails->room_price = $product->sale_price;
        $bookingDetails->quantity = 1;
        $bookingDetails->adult = Session::get('adult') ? : 0;
        $bookingDetails->child = Session::get('children') ? : 0;
        $bookingDetails->entry_date = $entry_date;
        $bookingDetails->exit_date = $exit_date;
        $bookingDetails->status = "Inactive";
        $bookingDetails->updated_by = 1;
        $bookingDetails->created_by = 1;
        $bookingDetails->deleted_by = 1;
        $bookingDetails->save();
        $price = $bookingDetails->room_price * $total_days;
        $total_price += $price;
        if($product->advance_percentage > 0)
        {
            $paid = (($price * $product->productDetails->advance_percentage ) / 100 );
            $advance_paid += (int)$paid;
        }
        if(!empty($request->addon))
        {
            foreach ($request->addon as $key_addon => $value_addon)
            {
                $product = Product::where('id',$value_addon)->first();
                $addon_price = $product->sale_price;
                $total_price += $addon_price;
            }
        }
        $booking->grand_total = $total_price;
        $booking->advance_paid = $advance_paid;
        $booking->due_amount = $booking->grand_total - $booking->advance_paid;
        $booking->update();
        session()->flash('success', 'Data successfully save!!');
        Session::forget(['entry_date', 'exit_date', 'adult','child']);
        return redirect()->route('rooms'); 
    }
    public function customerCode()
    {
        $code = Customer::first();
        $code =  "COD" . date("y") . date("m"). str_pad($code->id ?? 0 +1, 5, "0", STR_PAD_LEFT);
        return $code;
    }
    // Booking Now
    public function book_now($id)
    {
        $user = Auth::user();
        $adult = Session::get('adult') ? : 0;
        $child = Session::get('children') ? : 0;
        $entry_date = Session::get('entry_date');
        $entry_date = date_create($entry_date);
        $entry_date = date_format($entry_date,"m/d/Y");
        $exit_date = Session::get('exit_date');
        $exit_date = date_create($exit_date);
        $exit_date = date_format($exit_date,"m/d/Y");
        $date_range = $entry_date.' - '.$exit_date;

        $date1=date_create($entry_date);
        $date2=date_create($exit_date);
        $diff=date_diff($date1,$date2)->days;

        
        $datediff =  strtotime($entry_date) - strtotime($exit_date);
        $total_date_difference = (int)round($datediff / (60 * 60 * 24));
       
        $total_days = $diff;//$total_date_difference + 1;
        $product_id = $id;
        if(Session::has('room_id')){
            Session::get('room_id');
        }else{
            Session::put('room_id', $product_id);
        }
        // if($id){
        //     $product_id = $id;
        // }else{
        //     $product_id = Session::get('room_id');
        // }
        if($product_id){
            $product = Product::with('productDetails','productImages')->where('id',$product_id)->first();
        }else{
            $product = array();
        }
        $add_on = Product::with('productDetails')->where('type_id','Add On')->get();
        if($user){
            return view('web.pages.book_now', get_defined_vars());
        }else{
            return redirect()->route('otp');
        }
    }
    // View to Login page with otp
    public function otp()
    {
        return view('web.pages.otp', get_defined_vars());
    }
    // Otp Submit
    public function otp_submit(Request $request)
    {
        $this->validate($request, [  
            'phone_number' => 'required|digits:11',
        ]);
        $pin= rand(1111,9999);
        $to = $request->phone_number;
        $message = "Your Hotel Mohona One time PIN is ".$pin.". It will expire in 3 minutes.";
        $customer_info = Customer::where("phone", $to)->first();
        if(!empty($customer_info))
        {
            $customer_id = $customer_info->id;
            $user_info = User::where('customer_id',$customer_id)->first();
            if($user_info){
                $user_info->otp_code = $pin;
                $user_info->save();
            }
        }else{
            $password = bcrypt($pin);
            $customer = new Customer;
            $customer->company_id = 1;
            $customer->code = $this->customerCode();
            $customer->phone = $request->phone_number;
            $customer->status = "Approved";
            $customer->created_by = 1;
            $customer->updated_by = 1;
            $customer->deleted_by = 1;
            $customer->save(); 
            $user = new User;
            $user->customer_id = $customer->id;
            $user->company_id = 1;
            $user->phone = $request->phone_number;
            $user->otp_code = $pin;
            $user->status = "Approved";
            $user->password = $password;
            $user->created_by = 1;
            $user->updated_by = 1;
            $user->deleted_by = 1;
            $user->save(); 
        }
        // $data = array(
        //     'username' => "nextpagetl",
        //     'password' => "NPTLGeeksWHM@551100#@",
        //     'number' => "$to",
        //     'message' => "$message"
        // );
        // return view('web.pages.otp_login',$data);
        $url = "http://66.45.237.70/api.php";
        $data = array(
            'username' => "nextpagetl",
            'password' => "NPTLGeeksWHM@551100#@",
            'number' => "$to",
            'message' => "$message"
        );
        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $p = explode("|", $smsresult);
        $sendstatus = $p[0];
        if($sendstatus == '1101')
        {
            return view('web.pages.otp_login',$data);
        }
        else
        {
            return view('web.pages.otp',$data);
        }
    }

    // Otp submit for login
    public function otp_submit_login(Request $request)
    {
        $this->validate($request, [  
            'otp' => 'required|integer',
        ]);
        $user = User::where('phone', $request->phone_number)->first();
        if(!empty($user)){
            $sended_otp_code = $user->otp_code;
            $otp = $request->otp;
            if($sended_otp_code == $otp) {
                Auth::login($user);
                $room_id = Session::get('room_id');
                if($room_id){
                    return redirect()->route('book_now',$room_id);
                }else{
                    return redirect()->route('profile');
                }
            }else{
                $data = array(
                    'number' => $request->phone_number,
                    'otp_not_match' => 'Invalid OTP'
                );
                return view('web.pages.otp_login',$data);
                //return redirect()->back()->with('otp_not_match', 'Invalid OTP');
            } 
        }else{
            return redirect()->back();
        }
    }
    // Logout
    public function logout()
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        \Auth::logout($user);
        return redirect()->route('welcome');
    }
    // Profile
    public function profile()
    {
        $auth_info = Auth::user();
        if($auth_info){
            $id = $auth_info->id;
            $cutomer_id = $auth_info->customer_id;
            $user_info = Auth::user();
            $customer_info = array();
            $bookings = array();
            if($cutomer_id){
                $customer_info = Customer::where('id', $cutomer_id)->first();
                $bookings = Booking::join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
                            ->where('bookings.customer_id', $cutomer_id)
                            ->get();
            }
            return view('web.pages.user_bookings', get_defined_vars());
        }
        
    }
    
    // Send Review
    function sendReview(Request $request)
    {
        $this->validate( $request, [
            "name" => "required|min:3|max:40",
            'rating' => 'required',

        ] );
        if(Auth::user()){
            $comment = new Review();
            $comment->product_id = $request->product_id;
            $comment->name = $request->name;
            $comment->rating = $request->rating;
            $comment->comments = strip_tags($request->comments);
            $comment->updated_by = helper::userId();
            $comment->company_id = helper::companyId();
            $comment->save();
            return redirect()->back()->with('success', 'Comment added Successfully');
        }else{
            return redirect()->back()->with('error', 'Please Login First');
        }
    } 

    // Send contact info

    function contactSubmit(Request $request)
    {
        $this->validate( $request, [
            "name" => "required|min:3|max:40",
            'email' => 'required|email|unique:contacts,email',
            "phone"  => "required|min:11",

        ] );
        if(Auth::user()){

            $contact = new Contact();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->phone = $request->phone;
            $contact->messege = $request->messege;
            $contact->company_id = helper::companyId();
            $contact->save();
            return redirect()->back()->with('success', 'Successfully Submit');
        }else{
            return redirect()->back()->with('error', 'Please Login First');
        }
    } 
    function subscribeEmail(Request $request)
    {
        $this->validate( $request, [
            'email' => 'required|email|unique:subscribes,email',

        ] );
        if(Auth::user()){

            $subscribeEmail = new Subscribe();
            $subscribeEmail->email = $request->email;
            $subscribeEmail->company_id = helper::companyId();
            $subscribeEmail->save();
            return redirect()->back()->with('success', 'Successfully Sent Email');
        }else{
            return redirect()->back()->with('error', 'Please Login First');
        }
    } 
            
} 
        

    