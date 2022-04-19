<?php

namespace App\Repositories\SalesReport;

use App\Models\AccountType;
use App\Models\Customer;
use App\Models\GeneralLedger;
use App\Models\Sales;
use App\Models\SalePayment;
use App\Models\SalePendingCheque;
use DB;

class SalesReportRepositories
{

    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var AccountType
     */
    private $accountType;
    /**
     * CourseRepository constructor.
     * @param AccountType $accountType
     */
    public function __construct(AccountType $accountType)
    {
        $this->accountType = $accountType;
       
    }

     /**
     * @param $request
     * @return mixed
     */
    public function getCustomerLedger($customerId,$from_date,$to_date)
    {
        if($customerId == "All" && $to_date == "Opening"):
          $reports =  SalePayment::selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as opening')->where('date', "<",$from_date)->company()->where('customer_id',$customerId)->first();
        elseif($customerId != "All" && $to_date == "Opening"): 
            $reports =  SalePayment::selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as opening')->where('customer_id',$customerId)->where('date', "<",$from_date)->company()->first();
        elseif($customerId== "All" && $to_date != "Opening"): 

            $reports = Customer::with(['spayment' => function($query) use($from_date,$to_date){
                $query->selectRaw('sum(debit) as debit,sum(credit) as credit,customer_id,date,id,payment_type')
                ->whereBetween('date', [$from_date, $to_date])->company()->groupBy("customer_id");
            }])->groupBy('id')->get();
            
            $reports->map(function ($d) use($from_date,$to_date) {
                $opening = $this->getCustomerLedger($d->id,$from_date,"Opening");
                $d['opening']=$opening->opening;
                $d['debit']=$d->spayment[0]->debit ?? 0;
                $d['credit']=$d->spayment[0]->credit ?? 0;
                $d['customer_id']=$d->spayment[0]->customer_id ?? 0;
                $d['date']=$d->spayment[0]->date ?? '';
                $d['id']=$d->spayment[0]->id ?? '';
                $d['payment_type']=$d->spayment[0]->payment_type ?? '';

                return $d;
            });
         else: 
           $reports = SalePayment::with("customer","branch")->where('customer_id',$customerId)->whereBetween('date', [$from_date, $to_date])->company()->get();

        endif;
        return $reports;
    }




     /**
     * @param $request
     * @return mixed
     */
    public function getCustomerPayment($customerId,$from_date,$to_date)
    {
        if($customerId == "All" &&  $to_date == "Opening"):
            $reports = SalePayment::selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as opening')->where('customer_id',$customerId)->where('credit', ">",0)->where('date', "<",$from_date)->company()->first();
        elseif($customerId != "All" && $to_date == "Opening"): 
            $reports = SalePayment::selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as opening')->where('customer_id',$customerId)->where('credit', ">",0)->where('date', "<",$from_date)->company()->first();
        elseif($customerId== "All" && $to_date != "Opening"):

           
             $reports = Customer::with(['spayment' => function($query) use($from_date,$to_date){
                $query->selectRaw('sum(debit) as debit,sum(credit) as credit,customer_id,date,id,payment_type')
                ->whereBetween('date', [$from_date, $to_date])->company()
                ->where('credit', ">",0)
                ->groupBy("customer_id");
               
            }])->groupBy('id')->get();
            
            $reports->map(function ($d) use($from_date,$to_date) {
                $opening = $this->getCustomerPayment($d->id,$from_date,"Opening");
                $d['opening']=$opening->opening;
                $d['debit']=$d->spayment[0]->debit ?? 0;
                $d['credit']=$d->spayment[0]->credit ?? 0;
                $d['customer_id']=$d->spayment[0]->customer_id ?? 0;
                $d['date']=$d->spayment[0]->date ?? '';
                $d['id']=$d->spayment[0]->id ?? '';
                $d['payment_type']=$d->spayment[0]->payment_type ?? '';
               return $d;
            });

        else: 
            $reports = SalePayment::with("customer","branch")->whereBetween('date', [$from_date, $to_date])->where('credit', ">",0)->company()->where('customer_id',$customerId)->get();
        endif;
        return $reports;
    }    
      /**
     * @param $request
     * @return mixed
     */
    public function getCustomerCashPayment($customerId,$from_date,$to_date)
    {
        if($customerId == "All" &&  $to_date == "Opening"):
            $reports = SalePayment::selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as opening')->where("payment_type","Cash")->where('customer_id',$customerId)->where('credit', ">",0)->where('date', "<",$from_date)->company()->first();
        elseif($customerId != "All" && $to_date == "Opening"): 
            $reports = SalePayment::selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as opening')->where("payment_type","Cash")->where('customer_id',$customerId)->where('credit', ">",0)->where('date', "<",$from_date)->company()->first();
        elseif($customerId== "All" && $to_date != "Opening"):

            $reports = Customer::with(['spayment' => function($query) use($from_date,$to_date){
                $query->selectRaw('sum(debit) as debit,sum(credit) as credit,customer_id,date,id,payment_type')
                ->whereBetween('date', [$from_date, $to_date])->company()
                ->where('credit', ">",0)
                ->where("payment_type","Cash")
                ->groupBy("customer_id");
               
            }])->groupBy('id')->get();
            
            $reports->map(function ($d) use($from_date,$to_date) {
                $opening = $this->getCustomerCashPayment($d->id,$from_date,"Opening");
                $d['opening']=$opening->opening;
                $d['debit']=$d->spayment[0]->debit ?? 0;
                $d['credit']=$d->spayment[0]->credit ?? 0;
                $d['customer_id']=$d->spayment[0]->customer_id ?? 0;
                $d['date']=$d->spayment[0]->date ?? '';
                $d['id']=$d->spayment[0]->id ?? '';
                $d['payment_type']=$d->spayment[0]->payment_type ?? '';
               return $d;
            });

        else: 
            $reports = SalePayment::with("customer","branch")->whereBetween('date', [$from_date, $to_date])->where("payment_type","Cash")->where('credit', ">",0)->company()->where('customer_id',$customerId)->get();
        endif;
        return $reports;
    }

      /**
     * @param $request
     * @return mixed
     */
    public function getCustomerChequePayment($customerId,$from_date,$to_date)
    {
        if($customerId == "All" &&  $to_date == "Opening"):
            $reports = SalePayment::selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as opening')->where("payment_type","Cheque")->where('customer_id',$customerId)->where('credit', ">",0)->where('date', "<",$from_date)->company()->first();
        elseif($customerId != "All" && $to_date == "Opening"): 
            $reports = SalePayment::selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as opening')->where("payment_type","Cheque")->where('customer_id',$customerId)->where('credit', ">",0)->where('date', "<",$from_date)->company()->first();
        elseif($customerId== "All" && $to_date != "Opening"):

            $reports = Customer::with(['spayment' => function($query) use($from_date,$to_date){
                $query->selectRaw('sum(debit) as debit,sum(credit) as credit,customer_id,date,id,payment_type')
                ->whereBetween('date', [$from_date, $to_date])->company()
                ->where('credit', ">",0)
                ->where("payment_type","Cheque")
                ->groupBy("customer_id");
               
            }])->groupBy('id')->get();
            
            $reports->map(function ($d) use($from_date,$to_date) {
                $opening = $this->getCustomerChequePayment($d->id,$from_date,"Opening");
                $d['opening']=$opening->opening;
                $d['debit']=$d->spayment[0]->debit ?? 0;
                $d['credit']=$d->spayment[0]->credit ?? 0;
                $d['customer_id']=$d->spayment[0]->customer_id ?? 0;
                $d['date']=$d->spayment[0]->date ?? '';
                $d['id']=$d->spayment[0]->id ?? '';
                $d['payment_type']=$d->spayment[0]->payment_type ?? '';
               return $d;
            });

        else: 
            $reports = SalePayment::with("customer","branch")->whereBetween('date', [$from_date, $to_date])->where("payment_type","Cheque")->where('credit', ">",0)->company()->where('customer_id',$customerId)->get();
        endif;
        return $reports;
    }


    public function getCustomerSalesVoucher($customerId,$from_date,$to_date){

        if($customerId == "All" && $to_date == "Opening"):
          $reports =  Sales::selectRaw('sum(IFNULL(subtotal,0)) as subtotal,sum(IFNULL(discount,0)) as discount,sum(grand_total) as grand_total')->with("customer","branch")->where('date', "<",$from_date)->company()->groupBy("customer_id")->first();
        elseif($customerId != "All" && $to_date == "Opening"): 
         $reports =  Sales::selectRaw('sum(IFNULL(subtotal,0)) as subtotal,sum(IFNULL(discount,0)) as discount,sum(grand_total) as grand_total')->with("customer","branch")->where('date', "<",$from_date)->company()->where("customer_id",$customerId)->first();
        elseif($customerId== "All" && $to_date != "Opening"):

            $reports = Sales::selectRaw('sum(subtotal) as subtotal,sum(discount) as discount,sum(grand_total) as grand_total,customer_id,id,branch_id')->with("customer","branch")->whereBetween('date', [$from_date, $to_date])->company()->groupBy("customer_id")->get();
         foreach($reports as $key => $report): 
                $opening = $this->getCustomerSalesVoucher($report->customer_id,$from_date,"Opening");
                $report->opening = $opening->opening;
            endforeach;

        else: 
         $reports =  Sales::with("customer","branch")->where('customer_id',$customerId)->whereBetween('date', [$from_date, $to_date])->company()->get();
       endif;
       return $reports;
    }

    public function getCustomerPendingChequePayment($customerId,$from_date,$to_date){

      


        if($customerId == "All" &&  $to_date == "Opening"):
         
            $reports = SalePendingCheque::selectRaw('sum(IFNULL(payment,0)) as opening,receive_date,customer_id')->where('customer_id',$customerId)->where('receive_date', "<",$from_date)->where('status','Pending')->company()->first();
        elseif($customerId != "All" && $to_date == "Opening"): 
           
            $reports = SalePendingCheque::selectRaw('sum(IFNULL(payment,0)) as opening,receive_date,customer_id')->where('customer_id',$customerId)->where('receive_date', "<",$from_date)->where('status','Pending')->company()->first();
        elseif($customerId== "All" && $to_date != "Opening"):
          
            $reports = Customer::with(['scpayment' => function($query) use($from_date,$to_date){
                $query->selectRaw('sum(payment) as payment,customer_id,id')
                ->whereBetween('receive_date', [$from_date, $to_date])->company()
                ->where('status','Pending')
                ->groupBy("customer_id");
               
            }])->groupBy('id')->get();
            
            $reports->map(function ($d) use($from_date,$to_date) {
                $opening = $this->getCustomerPendingChequePayment($d->id,$from_date,"Opening");
                $d['opening']=$opening->opening;
                $d['payment']=$d->scpayment[0]->payment ?? 0;
                $d['customer_id']=$d->scpayment[0]->customer_id ?? 0;
                $d['id']=$d->scpayment[0]->id ?? '';
               return $d;
            });

        else: 
          
            $reports = SalePendingCheque::with("customer","branch")->whereBetween('receive_date', [$from_date, $to_date])->company()->where('status','Pending')->where('customer_id',$customerId)->get();
        endif;
       


        return $reports;
    }

     /**
     * @param $request
     * @return mixed
     */
    public function getCustomerDueSalesVoucher($customerId,$from_date,$to_date)
    {
        if($customerId == "All" &&  $to_date == "Opening"):
            $reports = SalePayment::groupBy("voucher_id")->groupBy('customer_id')
            ->selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as dueAmount,sum(credit) as totalPayment,sum(debit) as salesAmount,id,voucher_id,voucher_no,branch_id,customer_id,debit,credit')
            ->havingRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) > 0')
            ->where('date', "<",$from_date)
            ->company()
            ->get();
        elseif($customerId != "All" && $to_date == "Opening"): 
            $reports = SalePayment::groupBy("voucher_id")
            ->selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as dueAmount,sum(credit) as totalPayment,sum(debit) as salesAmount,id,voucher_id,voucher_no,branch_id,customer_id,debit,credit')
            ->havingRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) > 0')
            ->where('customer_id',$customerId)
            ->where('date', "<",$from_date)
            ->company()
            ->get();
        elseif($customerId== "All" && $to_date != "Opening"):
            $reports = SalePayment::selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as dueAmount,sum(credit) as totalPayment,sum(debit) as salesAmount,id,voucher_id,voucher_no,branch_id,customer_id,debit,credit')
            ->havingRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) > 0')
            ->whereBetween('date', [$from_date, $to_date])
            ->groupBy("voucher_id")
            ->groupBy("customer_id")
            ->company()
            ->get();
        else: 
            $reports = SalePayment::groupBy("voucher_id")
            ->selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as dueAmount,sum(credit) as totalPayment,sum(debit) as salesAmount,id,voucher_id,voucher_no,branch_id,customer_id,debit,credit')
            ->where('customer_id',$customerId)
            ->havingRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) > 0')
            ->whereBetween('date', [$from_date, $to_date])
            ->company()
            ->get();
        endif;

        return $reports;
    }

   

     /**
     * @param $request
     * @return mixed
     */
    public function getCustomerChequePayment3($customerId,$from_date,$to_date)
    {
        if($customerId == "All"):
            $report_result = SalePayment::groupBy("voucher_id")->groupBy('customer_id')
            ->selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as dueAmount,sum(credit) as totalPayment,sum(debit) as salesAmount,id,voucher_id,voucher_no,branch_id,customer_id,debit,credit')
            ->where('payment_type',"Cheque")
            ->whereBetween('date', [$from_date, $to_date])
            ->company()
            ->get();
        else: 
            $report_result = SalePayment::groupBy("voucher_id")
            ->selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as dueAmount,sum(credit) as totalPayment,sum(debit) as salesAmount,id,voucher_id,voucher_no,branch_id,customer_id,debit,credit')
            ->where('customer_id',$customerId)
            ->where('payment_type',"Cheque")
            ->whereBetween('date', [$from_date, $to_date])
            ->company()
            ->get();
        endif;
        
        return $report_result;
    }

    



}