<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingDetails;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class AmarpayController extends Controller
{
    public function payNow(Request $request){
        


        

        $entry_date = date('Y-m-d', strtotime($request->entry_date));
        $exit_date = date('Y-m-d', strtotime($request->exit_date));

        /** calculates the entry date and exit date difference start*/ 
        $datetime1 = date_create($request->entry_date);
        $datetime2 = date_create($request->exit_date);
        $interval = date_diff($datetime1, $datetime2);
        $total_date_diff = $interval->format('%a');
        /** calculates the entry date and exit date difference end*/ 

        $total_days = $total_date_diff;
        $adult = $request->adult;
        $child = $request->child;
       
        $user_id = $request->user_id;
        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $address = $request->address;
        $note = $request->note;
        
        $user = User::where('id', $user_id)->first();
        if($user){
            $customer_id = $user->customer_id;
            
            $user_info= User::where('customer_id',$customer_id)->first();
            $user_info->company_id = 1;
            $user_info->name = $name;
            $user_info->email = $email;
            $user_info->phone = $phone;
            $user_info->save();  

            $customer = Customer::find($customer_id);
            $customer->company_id = 1;
            $customer->name = $name;
            $customer->email = $email;
            $customer->phone = $phone;
            $customer->address = $address;
            $customer->save();
        }else{
            $customer_id = 0;
        }

        $product_id = $request->product_id;
        $pay_only_advance_payment = $request->pay_only_advance_payment;
        $product = Product::with('productDetails')->where('id',$product_id)->first();
        $grand_total = 0;
        $pay_amount = 0;
        if(!empty($product)){
            $grand_total = $product->sale_price*$total_days;
            if($pay_only_advance_payment){
                $advance_percentage_percentage = $product->productDetails->advance_percentage;
                if(!empty($advance_percentage_percentage)){
                    $pay_amount = ($grand_total * $advance_percentage_percentage)/100;
                }else{
                    $pay_amount = $grand_total;
                }
            }else{
                $pay_amount = $grand_total;
            }
        }


      
        $date_range_array = array($entry_date,$exit_date);
        $date_range_implode = implode(',',$date_range_array);

        $person = array($adult,$child);
        $person_implode = implode(',',$person);

        if($pay_amount > 10){
            /** Payment gateway functionality start */
            $url = 'https://sandbox.aamarpay.com/request.php'; // live url https://secure.aamarpay.com/request.php
            $fields = array(
                'store_id' => 'aamarpay', //store id will be aamarpay,  contact integration@aamarpay.com for test/live id
                'amount' => $pay_amount, //transaction amount
                'payment_type' => 'VISA', //no need to change
                'currency' => 'BDT',  //currenct will be USD/BDT
                'tran_id' => rand(1111111,9999999), //transaction id must be unique from your end
                'cus_name' => $name,  //customer name
                'cus_email' => $email, //customer email address
                'cus_add1' => $address,  //customer address
                'cus_add2' => '', //customer address
                'cus_city' => 'Dhaka',  //customer city
                'cus_state' => 'Dhaka',  //state
                'cus_postcode' => '1206', //postcode or zipcode
                'cus_country' => 'Bangladesh',  //country
                'cus_phone' => $phone, //customer phone number
                'cus_fax' => 'Not¬Applicable',  //fax
                'ship_name' => $name, //ship name
                'ship_add1' => $address,  //ship address
                'ship_add2' => 'Mohakhali',
                'ship_city' => 'Dhaka', 
                'ship_state' => 'Dhaka',
                'ship_postcode' => '1212', 
                'ship_country' => 'Bangladesh',
                'desc' => 'hotel payment', 
                'success_url' => route('success'), //your success route
                'fail_url' => route('fail'), //your fail route
                'cancel_url' => route('cancel'), //your cancel url
                'opt_a' => $customer_id,  //optional paramter
                'opt_b' => $product_id,
                'opt_c' => $date_range_implode, 
                'opt_d' => $person_implode,
                'signature_key' => '28c78bb1f45112f5d40b956fe104645a'); //signature key will provided aamarpay, contact integration@aamarpay.com for test/live signature key

                $fields_string = http_build_query($fields);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_URL, $url);  
        
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $url_forward = str_replace('"', '', stripslashes(curl_exec($ch)));	
            curl_close($ch); 

            $this->redirect_to_merchant($url_forward);
            /** Payment gateway functionality end */
        }

    }

    function redirect_to_merchant($url) {

        ?>
        <html xmlns="http://www.w3.org/1999/xhtml">
          <head><script type="text/javascript">
            function closethisasap() { document.forms["redirectpost"].submit(); } 
          </script></head>
          <body onLoad="closethisasap();">
          
            <form name="redirectpost" method="post" action="<?php echo 'https://sandbox.aamarpay.com/'.$url; ?>"></form>
            <!-- for live url https://secure.aamarpay.com -->
          </body>
        </html>
        <?php	
        exit;
    } 

    
    public function success(Request $request){
      
           

            $customer_id = $request->opt_a;
            $product_id = $request->opt_b;
            $cus_name = $request->cus_name;
            $cus_email = $request->cus_email;
            $cus_phone = $request->cus_phone;
            $pg_txnid = $request->pg_txnid;
            $epw_txnid = $request->epw_txnid;
            $mer_txnid = $request->mer_txnid;
            $amount = $request->amount;
            $bank_txn = $request->bank_txn;
            $card_type = $request->card_type;
            $card_number = $request->card_number;
            $card_holder = $request->card_holder;
            $pay_status = $request->pay_status;

            $date_range = explode(',',$request->opt_c);
            if($date_range){
                $entry_date = $date_range[0];
                $exit_date = $date_range[1];
            }else{
                $entry_date = '0000-00-00';
                $exit_date = '0000-00-00';
            }
            $person = explode(',',$request->opt_d);
            if($person){
                $adult = $person[0];
                $child = $person[1];
            }else{
                $adult = 0;
                $child = 0;
            }
            /** calculates the entry date and exit date difference start*/ 
            

            $datetime1 = date_create($entry_date);
            $datetime2 = date_create($exit_date);
            $interval = date_diff($datetime1, $datetime2);
            $total_date_diff = $interval->format('%a');
            $total_days = $total_date_diff;
            /** calculates the entry date and exit date difference end*/

            $product = Product::with('productDetails')->where('id',$product_id)->first();

            $total_price = ($product->sale_price * $total_days);

            $advance_paid = $amount;

            $due_amount = ($total_price - $advance_paid);

            $booking = new Booking();
            $booking->company_id = 1;
            $booking->customer_id = $customer_id;
            $booking->date = date('Y-m-d');
            $booking->addon = 0;
            $booking->payment_type = "Cash";
            $booking->payment_status = "Pending";
            $booking->booking_status = "Pending";
            $booking->grand_total = $total_price;
            $booking->advance_paid = $advance_paid;
            $booking->due_amount = $due_amount;
            $booking->updated_by = 1;
            $booking->created_by = 1;
            if($booking->save()){
                $bookingDetails = new BookingDetails;
                $bookingDetails->booking_id = $booking->id;
                $bookingDetails->company_id = 1;
                $bookingDetails->room_id = $product_id;
                $bookingDetails->product_id = $product_id;
                $bookingDetails->category_id = $product->category_id;
                $bookingDetails->room_price = $product->sale_price;
                $bookingDetails->quantity = 1;
                $bookingDetails->adult = $adult;
                $bookingDetails->child = $child;
                $bookingDetails->entry_date = $entry_date;
                $bookingDetails->exit_date = $exit_date;
                $bookingDetails->status = "Inactive";
                $bookingDetails->updated_by = 1;
                $bookingDetails->created_by = 1;
                $bookingDetails->deleted_by = 1;
                $bookingDetails->save();
            }

            $user = User::where('customer_id', $customer_id)->first();
            if($user){
                Auth::login($user);
                return redirect()->route('profile');
            }
            
    }

    public function fail(Request $request){
        return view('web.pages.payment-fail');
    }

    public function cancel(){

        return view('web.pages.cancel');
    }
}
