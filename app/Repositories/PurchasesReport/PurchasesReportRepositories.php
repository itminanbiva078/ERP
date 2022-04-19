<?php

namespace App\Repositories\PurchasesReport;

use App\Models\AccountType;
use App\Models\GeneralLedger;
use App\Models\Purchases;
use App\Models\PurchasesPayment;
use App\Models\PurchasesPendingCheque;
use App\Models\Supplier;
use DB;

class PurchasesReportRepositories
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
    public function getSupplierLedger($supplierId,$from_date,$to_date)
    {
        if($supplierId == "All" && $to_date == "Opening"):
          $reports =  PurchasesPayment::selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as opening')->where('date', "<",$from_date)->company()->where('supplier_id',$supplierId)->first();
        elseif($supplierId != "All" && $to_date == "Opening"): 
            $reports =  PurchasesPayment::selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as opening')->where('supplier_id',$supplierId)->where('date', "<",$from_date)->company()->first();
        elseif($supplierId== "All" && $to_date != "Opening"): 
            

            $reports = Supplier::with(['ppayment' => function($query) use($from_date,$to_date){
                $query->selectRaw('sum(debit) as debit,sum(credit) as credit,supplier_id,date,id,payment_type')
                ->whereBetween('date', [$from_date, $to_date])->company()->groupBy("supplier_id");
            }])->groupBy('id')->get();
            
            $reports->map(function ($d) use($from_date,$to_date) {
                $opening = $this->getSupplierLedger($d->id,$from_date,"Opening");
                $d['opening']=$opening->opening;
                $d['debit']=$d->ppayment[0]->debit ?? 0;
                $d['credit']=$d->ppayment[0]->credit ?? 0;
                $d['supplier_id']=$d->ppayment[0]->supplier_id ?? 0;
                $d['date']=$d->ppayment[0]->date ?? '';
                $d['id']=$d->ppayment[0]->id ?? '';
                $d['payment_type']=$d->ppayment[0]->payment_type ?? '';
                
               return $d;
            });



      

        else: 
           $reports = PurchasesPayment::with("supplier","branch")->where('supplier_id',$supplierId)->whereBetween('date', [$from_date, $to_date])->company()->get();

       
         

        endif;
        return $reports;
    }

     /**
     * @param $request
     * @return mixed
     */
    public function getSupplierPayment($supplierId,$from_date,$to_date)
    {
        if($supplierId == "All" &&  $to_date == "Opening"):
            $reports = PurchasesPayment::selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as opening')->where('supplier_id',$supplierId)->where('credit', ">",0)->where('date', "<",$from_date)->company()->first();
        elseif($supplierId != "All" && $to_date == "Opening"): 
            $reports = PurchasesPayment::selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as opening')->where('supplier_id',$supplierId)->where('credit', ">",0)->where('date', "<",$from_date)->company()->first();
        elseif($supplierId== "All" && $to_date != "Opening"):
            $reports = Supplier::with(['ppayment' => function($query) use($from_date,$to_date){
                $query->selectRaw('sum(debit) as debit,sum(credit) as credit,supplier_id,date,id,payment_type')
                ->whereBetween('date', [$from_date, $to_date])->company()
                ->where('credit', ">",0)
                ->groupBy("supplier_id");
               
            }])->groupBy('id')->get();
            
            $reports->map(function ($d) use($from_date,$to_date) {
                $opening = $this->getSupplierPayment($d->id,$from_date,"Opening");
                $d['opening']=$opening->opening;
                $d['debit']=$d->ppayment[0]->debit ?? 0;
                $d['credit']=$d->ppayment[0]->credit ?? 0;
                $d['supplier_id']=$d->ppayment[0]->supplier_id ?? 0;
                $d['date']=$d->ppayment[0]->date ?? '';
                $d['id']=$d->ppayment[0]->id ?? '';
                $d['payment_type']=$d->ppayment[0]->payment_type ?? '';
               return $d;
            });
        else: 
            $reports = PurchasesPayment::with("supplier","branch")->whereBetween('date', [$from_date, $to_date])->where('credit', ">",0)->company()->where('supplier_id',$supplierId)->get();
        endif;
        return $reports;
    }    
      /**
     * @param $request
     * @return mixed
     */
    public function getSupplierCashPayment($supplierId,$from_date,$to_date)
    {
        if($supplierId == "All" &&  $to_date == "Opening"):
            $reports = PurchasesPayment::selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as opening')->where("payment_type","Cash")->where('supplier_id',$supplierId)->where('credit', ">",0)->where('date', "<",$from_date)->company()->first();
        elseif($supplierId != "All" && $to_date == "Opening"): 
            $reports = PurchasesPayment::selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as opening')->where("payment_type","Cash")->where('supplier_id',$supplierId)->where('credit', ">",0)->where('date', "<",$from_date)->company()->first();
        elseif($supplierId== "All" && $to_date != "Opening"):
            
            
            $reports = Supplier::with(['ppayment' => function($query) use($from_date,$to_date){
                $query->selectRaw('sum(debit) as debit,sum(credit) as credit,supplier_id,date,id,payment_type')
                ->whereBetween('date', [$from_date, $to_date])->company()
                ->where('credit', ">",0)
                ->where("payment_type","Cash")
                ->groupBy("supplier_id");
               
            }])->groupBy('id')->get();
            
            $reports->map(function ($d) use($from_date,$to_date) {
                $opening = $this->getSupplierCashPayment($d->id,$from_date,"Opening");
                $d['opening']=$opening->opening;
                $d['debit']=$d->ppayment[0]->debit ?? 0;
                $d['credit']=$d->ppayment[0]->credit ?? 0;
                $d['supplier_id']=$d->ppayment[0]->supplier_id ?? 0;
                $d['date']=$d->ppayment[0]->date ?? '';
                $d['id']=$d->ppayment[0]->id ?? '';
                $d['payment_type']=$d->ppayment[0]->payment_type ?? '';
               return $d;
            });
        else: 
            $reports = PurchasesPayment::with("supplier","branch")->whereBetween('date', [$from_date, $to_date])->where("payment_type","Cash")->where('credit', ">",0)->company()->where('supplier_id',$supplierId)->get();
        endif;
        return $reports;
    }

      /**
     * @param $request
     * @return mixed
     */
    public function getSupplierChequePayment($supplierId,$from_date,$to_date)
    {
        if($supplierId == "All" &&  $to_date == "Opening"):
            $reports = PurchasesPayment::selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as opening')->where("payment_type","Cheque")->where('supplier_id',$supplierId)->where('credit', ">",0)->where('date', "<",$from_date)->company()->first();
        elseif($supplierId != "All" && $to_date == "Opening"): 
            $reports = PurchasesPayment::selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as opening')->where("payment_type","Cheque")->where('supplier_id',$supplierId)->where('credit', ">",0)->where('date', "<",$from_date)->company()->first();
        elseif($supplierId== "All" && $to_date != "Opening"):
            
            
            $reports = Supplier::with(['ppayment' => function($query) use($from_date,$to_date){
                $query->selectRaw('sum(debit) as debit,sum(credit) as credit,supplier_id,date,id,payment_type')
                ->whereBetween('date', [$from_date, $to_date])->company()
                ->where('credit', ">",0)
                ->where("payment_type","Cheque")
                ->groupBy("supplier_id");
               
            }])->groupBy('id')->get();
            
            $reports->map(function ($d) use($from_date,$to_date) {
                $opening = $this->getSupplierChequePayment($d->id,$from_date,"Opening");
                $d['opening']=$opening->opening;
                $d['debit']=$d->ppayment[0]->debit ?? 0;
                $d['credit']=$d->ppayment[0]->credit ?? 0;
                $d['supplier_id']=$d->ppayment[0]->supplier_id ?? 0;
                $d['date']=$d->ppayment[0]->date ?? '';
                $d['id']=$d->ppayment[0]->id ?? '';
                $d['payment_type']=$d->ppayment[0]->payment_type ?? '';
               return $d;
            });
            
        else: 
            $reports = PurchasesPayment::with("supplier","branch")->whereBetween('date', [$from_date, $to_date])->where("payment_type","Cheque")->where('credit', ">",0)->company()->where('supplier_id',$supplierId)->get();
        endif;
        return $reports;
    }


    public function getSupplierPurchasesVoucher($supplierId,$from_date,$to_date){

        if($supplierId == "All" && $to_date == "Opening"):
          $reports =  Purchases::selectRaw('sum(IFNULL(subtotal,0)) as subtotal,sum(IFNULL(discount,0)) as discount,sum(grand_total) as grand_total')->with("supplier","branch")->where('date', "<",$from_date)->company()->groupBy("supplier_id")->first();
        elseif($supplierId != "All" && $to_date == "Opening"): 
         $reports =  Purchases::selectRaw('sum(IFNULL(subtotal,0)) as subtotal,sum(IFNULL(discount,0)) as discount,sum(grand_total) as grand_total')->with("supplier","branch")->where('date', "<",$from_date)->company()->where("supplier_id",$supplierId)->first();
        elseif($supplierId== "All" && $to_date != "Opening"):

        $reports = Purchases::selectRaw('sum(subtotal) as subtotal,sum(discount) as discount,sum(grand_total) as grand_total,supplier_id,id,branch_id')

            ->with("supplier","branch")->whereBetween('date', [$from_date, $to_date])->company()->groupBy("supplier_id")->get();
         foreach($reports as $key => $report): 
                $opening = $this->getSupplierPurchasesVoucher($report->supplier_id,$from_date,"Opening");
                $report->opening = $opening->opening;
            endforeach;
        else: 
         $reports =  Purchases::with("supplier","branch")->where('supplier_id',$supplierId)->whereBetween('date', [$from_date, $to_date])->company()->get();
       endif;
       return $reports;
    }

    public function getSupplierPendingChequePayment($supplierId,$from_date,$to_date){
        if($supplierId == "All" &&  $to_date == "Opening"):
            $reports = PurchasesPendingCheque::selectRaw('sum(IFNULL(payment,0)) as opening,receive_date,supplier_id')->where('supplier_id',$supplierId)->where('receive_date', "<",$from_date)->where('status','Pending')->company()->first();
        elseif($supplierId != "All" && $to_date == "Opening"): 
            $reports = PurchasesPendingCheque::selectRaw('sum(IFNULL(payment,0)) as opening,receive_date,supplier_id')->where('supplier_id',$supplierId)->where('receive_date', "<",$from_date)->where('status','Pending')->company()->first();
        elseif($supplierId== "All" && $to_date != "Opening"):
            
            
            $reports = Supplier::with(['pcpayment' => function($query) use($from_date,$to_date){
                $query->selectRaw('sum(payment) as payment,supplier_id,id')
                ->whereBetween('receive_date', [$from_date, $to_date])->company()
                ->where('status','Pending')
                ->groupBy("supplier_id");
               
            }])->groupBy('id')->get();
            
            $reports->map(function ($d) use($from_date,$to_date) {
                $opening = $this->getSupplierPendingChequePayment($d->id,$from_date,"Opening");
                $d['opening']=$opening->opening;
                $d['payment']=$d->pcpayment[0]->payment ?? 0;
              
                $d['supplier_id']=$d->pcpayment[0]->supplier_id ?? 0;
               
                $d['id']=$d->pcpayment[0]->id ?? '';
          
               return $d;
            });
            
        else: 
            $reports = PurchasesPendingCheque::with("supplier","branch")->whereBetween('receive_date', [$from_date, $to_date])->company()->where('status','Pending')->where('supplier_id',$supplierId)->get();
        endif;
        return $reports;
    }
    

     /**
     * @param $request
     * @return mixed
     */
    public function getSupplierDuePurchasesVoucher($supplierId,$from_date,$to_date)
    {
        if($supplierId == "All" &&  $to_date == "Opening"):
            $reports = PurchasesPayment::groupBy("voucher_id")->groupBy('supplier_id')
            ->with("supplier")
            ->selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as dueAmount,sum(credit) as totalPayment,sum(debit) as purchasesAmount,id,voucher_id,voucher_no,branch_id,supplier_id,debit,credit')
            ->havingRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) > 0')
            ->where('date', "<",$from_date)
            ->company()
            ->get();
        elseif($supplierId != "All" && $to_date == "Opening"): 
            $reports = PurchasesPayment::groupBy("voucher_id")
            ->with("supplier")
            ->selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as dueAmount,sum(credit) as totalPayment,sum(debit) as purchasesAmount,id,voucher_id,voucher_no,branch_id,supplier_id,debit,credit')
            ->havingRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) > 0')
            ->where('supplier_id',$supplierId)
            ->where('date', "<",$from_date)
            ->company()
            ->get();
        elseif($supplierId== "All" && $to_date != "Opening"):
            $reports = PurchasesPayment::selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as dueAmount,sum(credit) as totalPayment,sum(debit) as purchasesAmount,id,voucher_id,voucher_no,branch_id,supplier_id,debit,credit')
            ->with("supplier")
            ->havingRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) > 0')
            ->whereBetween('date', [$from_date, $to_date])
            ->groupBy("voucher_id")
            ->groupBy("supplier_id")
            ->company()
            ->get();
        else: 
            $reports = PurchasesPayment::groupBy("voucher_id")
            ->with("supplier")
            ->selectRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as dueAmount,sum(credit) as totalPayment,sum(debit) as purchasesAmount,id,voucher_id,voucher_no,branch_id,supplier_id,debit,credit')
            ->where('supplier_id',$supplierId)
            ->havingRaw('sum(IFNULL(debit,0)-IFNULL(credit,0)) > 0')
            ->whereBetween('date', [$from_date, $to_date])
            ->company()
            ->get();
        endif;

        return $reports;
    }

/*stock report start*/

/*stock report end*/






}