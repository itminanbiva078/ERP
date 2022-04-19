@extends('backend.layouts.master')
@section('title')
SalesTransaction - {{$title}}
@endsection

@section('styles')
<style>
.bootstrap-switch-large {
    width: 200px;
}
</style>
@endsection

@section('navbar-content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                Sales Transaction </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home') }}">Dashboard</a></li>
                    @if(helper::roleAccess('salesTransaction.salesLoan.create'))
                    <li class="breadcrumb-item"><a href="{{route('salesTransaction.salesLoan.create') }}"><i class="fas fa-plus"> Add </i> </a></li>
                    @endif
                    @if(helper::roleAccess('salesTransaction.salesLoan.index'))
                    <li class="breadcrumb-item"><a href="{{route('salesTransaction.salesLoan.index') }}"><i class="fas fa-list">  List</i> </a></li>
                    @endif
                    <li class="breadcrumb-item active"><span>Invoice</span></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('admin-content')
<div class="row">
          <div class="col-12">
            <div class="callout callout-info">
              <div class="row no-print">
                <div class="col-md-4">
                  <div class="section-title">
                    <h5><i class="fas fa-file-invoice"></i> Sales Loan Invoice</h5>
                      {{-- This page has been enhanced for printing. Click the print button at the bottom of the invoice to test. --}}
                  </div>
                </div>
                <div class="col-md-8">
                  <button type="button" onclick="loadVoucher('<?php echo $details->voucher_no?>','<?php echo helper::imageUrl($details->documents)?>')" data-toggle="modal" data-target="#modal-default"  class="btn btn-success float-right"><i class="fa fa-upload" ></i> Document </button>
                  <button type="button"  onclick="window.print();" class="btn btn-success float-right"><i class="fas fa-print"></i> Print
                  </button>
                    @if(!empty($details->general->journals))
                    <button type="button"  class="btn btn-info float-right journal" style="margin-right: 5px;">
                      <i class="fas fa-download"></i> Journal Details
                    </button>
                  @endif
                  
                </div>
              </div>
            </div>
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
             
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  Company Info
                  <address>
                    <strong>{{$companyInfo->name ?? ''}}</strong><br>
                    {{$companyInfo->address ?? ''}}
                    <br>
                    Phone: {{$companyInfo->phone ?? ''}}<br>
                    Email: {{$companyInfo->email ?? ''}}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  Customer Info
                  <address>
                    <strong>{{$details->customer->name ?? ''}}</strong>
                    <br>
                    {{$details->customer->address ?? ''}}<br>
                    Phone: {{$details->customer->phone ?? ''}}<br>
                    Email: {{$details->customer->email ?? ''}}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Invoice {{$details->voucher_no}}</b><br>
                  <b>Date:</b> {{ helper::get_php_date($details->date)}}<br>
                  <b>Payment Type:</b> {{$details->payment_type}}<br>
                  <b>Sales Status:</b> @php echo helper::statusBar($details->sales_status) @endphp<br>
                  <b>Challan Status:</b> @php echo helper::statusBar($details->challan_status) @endphp<br>

                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Product</th>
                            @if(in_array('batch_no',$activeColumn))
                            <th class="text-right">Batch No</th>
                            @endif
                            @if(in_array('pack_size',$activeColumn))
                            <th class="text-right">Pack Size	</th>
                            @endif
                            @if(in_array('pack_no',$activeColumn))
                            <th class="text-right">Pack No.	</th>
                            @endif
                            <th class="text-right">Quantity</th>
                            <th class="text-right">Unit Price</th>
                            <th class="text-right">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                          $tqty = 0;
                          $tprice = 0;
                        @endphp
                        @foreach($details->salesLoanDetails as $key => $eachDetails)
                        @php 
                            $tqty+=$eachDetails->quantity;
                            $tprice+=$eachDetails->quantity*$eachDetails->unit_price;

                          @endphp
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$eachDetails->product->name ?? ''}}</td>
                                @if(in_array('batch_no',$activeColumn))
                                <td  class="text-right">{{$eachDetails->batch->name ?? ''}}</td>
                                @endif
                                @if(in_array('pack_size',$activeColumn))
                                <td  class="text-right">{{$eachDetails->pack_size ?? ''}}</td>
                                @endif
                                @if(in_array('pack_no',$activeColumn))
                                <td  class="text-right">{{$eachDetails->pack_no ?? ''}}</td>
                                @endif
                                <td class="text-right">{{$eachDetails->quantity ?? ''}}</td>
                                <td class="text-right">{{helper::pricePrint($eachDetails->unit_price)}}</td>
                                <td class="text-right">{{helper::pricePrint($eachDetails->total_price)}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="{{helper::getColspan($activeColumn)}}" class="text-right">Sub-Total</th>
                        <th class="text-right">{{$tqty}}</th>
                        <th class="text-right">0.00</th>
                        <th class="text-right">{{helper::pricePrint($tprice)}}</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-9">
                  <p class="" style="text-transform: capitalize;"><b> In Word :  </b>{{ helper::get_bd_amount_in_text($tprice) }}</p>
                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                  {{$details->note}}
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-3">
               
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th  class="text-right" style="width:50%">Subtotal:</th>
                        <td  class="text-right">{{helper::pricePrint($details->subtotal)}}</td>
                      </tr>
                     
                      <tr>
                        <th class="text-right">Grand Total:</th>
                        <td class="text-right" ><span style="border-bottom: double;">{{helper::pricePrint($details->grand_total,2)}}</span></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <div class="row">
                <div class="col-md-4">
                    <p class="text-center">____________________<br>Prepared By</p>                        
                </div>
                <div class="col-md-4">
                    <p class="text-center">____________________<br>Checked By</p>           
                </div>
                <div class="col-md-4">
                    <p class="text-center">____________________<br>Approved By </p>             
                </div>
             </div>
              <!-- this row will not appear when printing -->
              
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div>


        @if(!empty($details->general->journals))
        <div class="row no-print journalDiv" id="journalDetails"  style="display: none!important">
          <div class="col-12">
            <div class="callout callout-info">
              <h5><i class="fas fa-journal-whills"></i> Sales Journal </h5>
              {{-- This page has been enhanced for printing. Click the print button at the bottom of the invoice to test. --}}

            </div>
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
            
        
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Account Code</th>
                            <th>Account Head</th>
                            <th class="text-right">Debit</th>
                            <th class="text-right">Credit</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 

                          $tdebit = 0;
                          $tcredit = 0;
                        @endphp
                        @foreach($details->general->journals as $key => $eachDetails)
                        @php 
                            $tdebit+=$eachDetails->debit;
                            $tcredit+=$eachDetails->credit;
                          @endphp
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$eachDetails->account->account_code ?? ''}}</td>
                                <td>{{$eachDetails->account->name ?? ''}}</td>
                                <td class="text-right">{{helper::pricePrint($eachDetails->debit)}}</td>
                                <td class="text-right">{{helper::pricePrint($eachDetails->credit)}}</td>
                                <td>{{$eachDetails->memo ?? ''}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="3" class="text-right">Sub-Total</th>
                        <th class="text-right">{{helper::pricePrint($tdebit)}}</th>
                        <th class="text-right">{{helper::pricePrint($tcredit)}}</th>
                        <th></th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.col -->
              </div>
 
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div>
        @endif
@endsection


@section('scripts')

<script>
  $(document).ready(function(){
    $(".journal").click(function(){
      $(".journalDiv").toggle();
    });
  });


$(document).ready(function () {
    $('button.journal').click(function() {
    $('html, body').animate({
      scrollTop: $("div#journalDetails").offset().top
    }, 1000)
  })
});


  </script>
@endsection
