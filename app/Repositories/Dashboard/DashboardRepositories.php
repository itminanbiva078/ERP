<?php

namespace App\Repositories\Dashboard;
use App\Helpers\Helper;

use App\Models\Booking;
use App\Models\BookingDetails;
use App\Models\Customer;
use App\Models\Floor;
use App\Models\General;
use App\Models\GeneralLedger;
use App\Models\Pos;
use App\Models\Product;
use App\Models\Purchases;
use App\Models\SalePayment;
use App\Models\User;
use DB;

class DashboardRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Booking
     */
    private $booking;
    /**
     * BookingRepositories constructor.
     * @param Booking $booking
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
      
    }

   
    /**
     * @param $request
     * @return mixed
     */
    
    public function getList($request)
    {
        
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");    
        $edit = Helper::roleAccess('booking.booking.edit') ? 1 : 0;
        $delete = Helper::roleAccess('booking.booking.destroy') ? 1 : 0;
        $view = Helper::roleAccess('booking.booking.show') ? 1 : 0;
        $show = Helper::roleAccess('booking.booking.show') ? 1 : 0;

        $ced = $edit + $delete + $view;

        $totalData = $this->booking::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $bookings = $this->booking::select($columns)->company()->with('customer')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->booking::count();
        } else {
            $search = $request->input('search.value');
            $bookings = $this->booking::select($columns)->company()->with('customer')->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                // ->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->booking::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }
        foreach($bookings as $key => $value):
            if(!empty($value->customer_id))
               $value->customer_id = $value->customer->name ?? '';
         endforeach;

        $columns = Helper::getTableProperty();
        $data = array();
        if ($bookings) {
            foreach ($bookings as $key => $booking) {
                $nestedData['id'] = $key + 1;
                    if ($ced != 0) :
                        if ($edit != 0)
                        $edit_data = '<a href="' . route('booking.booking.edit', $booking->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                        else
                            $edit_data = '';
                        if ($delete != 0 && $booking->booking_status == 'Pending')

                        $delete_data = '<a delete_route="' . route('booking.booking.destroy', $booking->id) . '" delete_id="' . $booking->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $booking->id . '"><i class="fa fa-times"></i></a>';
                        else
                        $delete_data = '';
                        if ($show != 0) {
                            $show_data = '<a href="' . route('booking.booking.show', $booking->id) . '" show_id="' . $booking->id . '" title="Details" class="btn btn-xs btn-default  uniqueid' . $booking->id . '"><i class="fa fa-search-plus"></i></a>';
                        } else {
                            $show_data = '';
                        }
                            $nestedData['action'] = $edit_data . ' ' . $delete_data . ' ' .$show_data;
                    else :
                        $nestedData['action'] = '';
                    endif;


                    foreach ($columns as $key => $value) :
                        if ($value == 'payment_status') :
                            $nestedData['payment_status'] = helper::statusBar($booking->payment_status);
                        elseif ($value == 'booking_status') :
                            $nestedData['booking_status'] = helper::statusBar($booking->booking_status);
                     else:    
                            $nestedData[$value] = $booking->$value;
                        endif;
                    endforeach;

                $data[] = $nestedData;
           
            }
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        return $json_data;
        
    }
    /**
     * @param $request
     * @return mixed
     */
    public function details($id)
    {
        $result = $this->booking::find($id);
        return $result;
    }

     /**
     * @param $request
     * @return mixed
     */
    public function getDashboardReport($date)
    {
        $saleResult = Pos::groupBy('date')->where('date',$date)->selectRaw('sum(grand_total) as totalSale,sum(due_amount) as totalSaleDue')->first();
        $purchasResult = Purchases::groupBy('date')->where('date',$date)->selectRaw('sum(grand_total) as totalPurchases,sum(due_amount) as totalPurchasesDue')->first();
        $bookingResult = Booking::groupBy('date')->where('date',$date)->selectRaw('sum(grand_total) as totalBooking,sum(due_amount) as totalBookingDue')->first();
       
            $result = array(
                'totalSale' => $saleResult->totalSale ?? 0,
                'totalSaleDue' => $saleResult->totalSaleDue ?? 0,
                'totalPurchases' => $purchasResult->totalPurchases ?? 0,
                'totalPurchasesDue' => $purchasResult->totalPurchasesDue ?? 0,
                'totalBooking' => $bookingResult->totalBooking ?? 0,
                'totalBookingDue' => $bookingResult->totalBookingDue ?? 0,
            );


        $fullResult = (object) $result;
       return $fullResult;


    }
     /**
     * @param $request
     * @return mixed
     */
    public function floorWiseRoom()
    {

        $allRooms = Floor::with([
            'products' => function($q){
              $q->select('*');
          },'products.product' => function ($q) {
            $q->select('id', 'name', 'image', 'category_id', 'purchases_price', 'sale_price');
        },

        ])->get();


      

          return $allRooms;
    }
     /**
     * @param $request
     * @return mixed
     */
    public function getAvailableRoom($request)
    {
        $dateRange = explode("-",$request->daterange);
        $from_date = date('Y-m-d',strtotime($dateRange[0]));
        $to_date = date('Y-m-d',strtotime($dateRange[1]));
        $adult = $request->adult;
        $child = $request->children;
        $sql = "select
        p.id
        from
            products p
            LEFT JOIN product_images as pi on pi.product_id = p.id
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
                    AND (  timestampdiff( day, b.entry_date, @parmEndDate ) 
                        * timestampdiff( day, @parmStartDate, b.exit_date  )) > 0 ) Occupied
            ON p.id = Occupied.room_id
        where
        Occupied.room_id IS NULL AND p.type_id='Rooms';";
        $result =  DB::SELECT($sql);
        $allRoomId=array();
        foreach($result as $key => $value): 
            array_push($allRoomId,$value->id);
        endforeach;
        $result = Product::with('productDetails','productImages')->whereIn('id', $allRoomId)->get();
         return $result;
       
        
    }

    /**
     * @param $request
     * @return mixed
     */
    public function store($request)
    {
        DB::beginTransaction();
        try {

            $booking = new $this->booking();
            $booking->date  = helper::mysql_date();
            $booking->customer_id  = $request->customer_id ;
            $booking->voucher_no  = $request->voucher_no ;
            $booking->payment_type  = $request->payment_type ;
            $booking->subtotal  = $request->sub_total ;
            $booking->discount  = $request->discount ;
            $booking->grand_total  = $request->grand_total ;
            $booking->due_amount = $request->grand_total;
            $booking->payment_status = 'Pending';
            $booking->booking_status = 'Pending';
            $booking->created_by = helper::userId();
            $booking->company_id = helper::companyId();
            $booking->save();

            if($booking): 
                $this->loginCredentialsSave($request);
                $this->detailsSave($booking,$request);
                $moneyReceitId =   $this->salesDebitPayment($booking->id);
                //general table data save
                $general_id = $this->generalSave($booking->id);
                //sales credit journal
                $this->saleCreditJournal($general_id);
                //if payment type cash then
                if($request->payment_type == "Cash"):
                    $this->salesCreditPayment($booking->id);
                  
                    //sales payment journal
                    $this->salePaymentJournal($booking->id,$request->paid_amount,$request->account_id[0],$booking->date,18);
                
                endif;
                $booking->booking_status =  'Approved';
                $booking->approved_by = helper::userId();
                $booking->save();
            endif;
           
            DB::commit();
            // all good 
            return $moneyReceitId;
        } catch (\Exception $e) {
           
            dd($e->getMessage());
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function update($request, $id)
    {
        $booking = $this->booking::findOrFail($id);
        $booking->customer_id  = $request->customer_id ;
        $booking->grand_total  = $request->grand_total ;
        $booking->addon  = $request->addon ;
        $booking->advance_paid  = $request->advance_paid ;
        $booking->due_amount = $request->due_amount;
        $booking->payment_status = 'Pending';
        $booking->booking_status = 'Pending';
        $booking->updated_by = helper::userId();
        $booking->company_id = helper::companyId();
        $booking->save();
        return $booking;
    }


    public function approved($id, $request)
    {


        DB::beginTransaction();
        try {
                $status = $request->status;  
             
                $bookingInfo= Booking::find($id);
              

                if(!empty($request->account_id[0])):
                    $accountId = $request->account_id[0];
                else: 
                    $accountId = 7;
                endif;
                

                    if($status == 'Approved'): 
                        $moneyReceitId =   $this->salesDebitPayment($bookingInfo->id);
                        //general table data save
                        $general_id = $this->generalSave($bookingInfo->id);
                        //sales credit journal
                        $this->saleCreditJournal($general_id);
                        //if payment type cash then
                        if($bookingInfo->payment_type == "Cash"):
                            $this->salesCreditPayment($bookingInfo->id);
                            //sales payment journal
                            $this->salePaymentJournal($bookingInfo->id,$bookingInfo->advanced_amount,$accountId,$bookingInfo->date,18);
                        endif;
                        $bookingInfo->booking_status =  'Approved';
                        $bookingInfo->approved_by = helper::userId();
                        $bookingInfo->save();
                        $bdetails = BookingDetails::where('booking_id',$id)->first();
                        $bdetails->status = 'Approved';
                        $bdetails->save();

                    else: 
                        $bookingInfo->booking_status =  $status;
                        $bookingInfo->approved_by = helper::userId();
                        $bookingInfo->save();
                        $bdetails = BookingDetails::where('booking_id',$id)->first();
                        $bdetails->status = $status;
                        $bdetails->save();
                    endif;    
                   
                    DB::commit();
                    // all good
                   die("test");
                    return $moneyReceitId;
                } catch (\Exception $e) {
                   
                    dd($e->getMessage());
                    DB::rollback();
                    return $e->getMessage();
            }
   
    }

    public function loginCredentialsSave($request){
        $customerInfo = Customer::find($request->customer_id);
        $user_info= User::where('customer_id',$request->customer_id)->first();
        if(empty($user_info)): 
            $user_info = new User();
        else: 
            $user_info = $user_info;
        endif;
        $user_info->customer_id = $request->customer_id;
        $user_info->company_id = helper::companyId();
        $user_info->name =$customerInfo->name;
        $user_info->email = $customerInfo->email;
        $user_info->phone = $customerInfo->phone;
       
        $user_info->password = bcrypt($customerInfo->phone);
        $user_info->save();  
    }
    public function detailsSave($booking, $request){
        
        $daterange = explode("-",$request->daterange);
        $product = Product::with('productDetails')->where('id',$request->room_id)->first();
        $bookingDetails = new BookingDetails;
        $bookingDetails->booking_id = $booking->id;
        $bookingDetails->company_id = helper::companyId();
        $bookingDetails->room_id = $request->room_id;
        $bookingDetails->product_id = $request->room_id;
        $bookingDetails->category_id = $product->category_id;
        $bookingDetails->room_price = $product->sale_price;
        $bookingDetails->quantity = 1;
        $bookingDetails->adult = $request->adult;
        $bookingDetails->child = $request->children;
        $bookingDetails->entry_date = helper::mysql_date($daterange[0]);
        $bookingDetails->exit_date = helper::mysql_date($daterange[1]);
        $bookingDetails->status = "Inactive";
        $bookingDetails->updated_by = 1;
        $bookingDetails->created_by = 1;
        $bookingDetails->deleted_by = 1;
        $bookingDetails->save();
    }



    public function generalSave($sale_id)
    {

        $salesInfo = $this->booking::find($sale_id);
        $general =  new General();
        $general->date = helper::mysql_date($salesInfo->date);
        $general->form_id = 18; //purchases info
        $general->branch_id  = $salesInfo->branch_id ?? helper::getDefaultBranch();
        $general->store_id  = $salesInfo->store_id ?? helper::getDefaultStore();
        $general->voucher_id  = $sale_id;
        $general->debit  = $salesInfo->grand_total;
        $general->status  = 'Approved';
        $general->updated_by = helper::userId();
        $general->company_id = helper::companyId();
        $general->save();
        return $general->id;
    }

    public static function saleCreditJournal($masterLedgerId,$costOfGoods=null)
    {

        $generalId =   General::where("id",$masterLedgerId)->company()->first();
        //account Receiable = debit
        $accountReceiveable = new GeneralLedger();
        $accountReceiveable->company_id = helper::companyId();
        $accountReceiveable->general_id = $masterLedgerId;
        $accountReceiveable->form_id = 18;
        $accountReceiveable->account_id = 12; //account receiveable come from chartOfAccount
        $accountReceiveable->date = helper::mysql_date();
        $accountReceiveable->debit = $generalId->debit;
        $accountReceiveable->memo = 'Account Receiable';
        $accountReceiveable->created_by = helper::userId();
        $accountReceiveable->save();
        //sales = credit
        $sales = new GeneralLedger();
        $sales->company_id = helper::companyId();
        $sales->general_id = $masterLedgerId;
        $sales->form_id = 18;
        $sales->account_id = 44; //sales
        $sales->date = helper::mysql_date();
        $sales->credit = $generalId->debit;
        $sales->memo = 'Sales';
        $sales->created_by = helper::userId();
        $sales->save();
       
    }

    public static function salePaymentJournal($masterLedgerId,$paidAmount,$accountId,$date,$form_id)
    {
        //account receivable = credit
        $accountReceiveable = new GeneralLedger();
        $accountReceiveable->company_id = helper::companyId();
        $accountReceiveable->general_id = $masterLedgerId;
        $accountReceiveable->form_id = $form_id;
        $accountReceiveable->account_id = 12; //account receiable come from chartOfAccount
        $accountReceiveable->date = helper::mysql_date($date);
        $accountReceiveable->credit = $paidAmount;
        $accountReceiveable->memo = 'Account Receiveable';
        $accountReceiveable->created_by = helper::userId();
        $accountReceiveable->save();
        //cash or bank = debit
        $cashOrBank = new GeneralLedger();
        $cashOrBank->company_id = helper::companyId();
        $cashOrBank->general_id = $masterLedgerId;
        $cashOrBank->form_id = $form_id;
        $cashOrBank->account_id = $accountId; //cash in hand
        $cashOrBank->date = helper::mysql_date($date);
        $cashOrBank->debit = $paidAmount;
        $cashOrBank->memo = 'Cash or bank debit';
        $cashOrBank->created_by = helper::userId();
        $cashOrBank->save();
    }

    public function salesCreditPayment($sale_id)
    {
       
        $saleInfo = $this->booking::find($sale_id);
        $saleDebitPayment =  new SalePayment();
        $saleDebitPayment->date = helper::mysql_date();
        $saleDebitPayment->company_id = helper::companyId(); //sales info
        $saleDebitPayment->form_id  = 18;
        $saleDebitPayment->payment_type  = $saleInfo->payment_type;
        $saleDebitPayment->customer_id  = $saleInfo->customer_id;
        $saleDebitPayment->branch_id  = $saleInfo->branch_id;
        $saleDebitPayment->voucher_id  = $saleInfo->id;
        $saleDebitPayment->voucher_no  = helper::generateInvoiceId("sales_payment_prefix","sale_payments");
        $saleDebitPayment->credit  = $saleInfo->advance_paid;
        $saleDebitPayment->note  = 'Hotel Booking amount';
        $saleDebitPayment->status  = 'Approved';
        $saleDebitPayment->updated_by = Helper::userId();
        $saleDebitPayment->created_by = Helper::userId();
        $saleDebitPayment->save();
        $saleInfo->paid_amount =  $saleInfo->advance_paid;
        $saleInfo->save();
        return $saleDebitPayment->id;
    }

    public function salesDebitPayment($sale_id)
    {
       
        $saleInfo = $this->booking::find($sale_id);
        $salesCreditPayment =  new SalePayment();
        $salesCreditPayment->date = helper::mysql_date();
        $salesCreditPayment->company_id = helper::companyId(); //sales info
        $salesCreditPayment->form_id  = 18;
        $salesCreditPayment->customer_id  = $saleInfo->customer_id;
        $salesCreditPayment->branch_id  = $saleInfo->branch_id;
        $salesCreditPayment->voucher_id  = $saleInfo->id;
        $salesCreditPayment->voucher_no  = helper::generateInvoiceId("sales_payment_prefix","sale_payments");
        $salesCreditPayment->debit  = $saleInfo->grand_total;
        $salesCreditPayment->note  = 'Hotel Booking amount';
        $salesCreditPayment->status  = 'Approved';
        $salesCreditPayment->updated_by = Helper::userId();
        $salesCreditPayment->created_by = Helper::userId();
        $salesCreditPayment->save();
        return $salesCreditPayment->id;
    }


    public function PaymentStatusUpdate($id, $status)
    {
        $booking = $this->booking::find($id);
        $booking->payment_status = $status;
        $booking->save();
        return $booking;
    }

    public function destroy($id)
    {
        $booking = $this->booking::find($id);
        $booking->delete();
        return true;
    }
   
}