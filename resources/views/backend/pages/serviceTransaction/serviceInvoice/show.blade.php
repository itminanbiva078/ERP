@extends('backend.layouts.master')
@section('title')
ServiceTransaction - {{$title}}
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
                Service Transaction </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home') }}">Dashboard</a></li>
                    @if(helper::roleAccess('serviceTransaction.serviceInvoice.create'))
                    <li class="breadcrumb-item"><a href="{{route('serviceTransaction.serviceInvoice.create') }}">Add Service Invoice </a></li>
                    @endif
                    @if(helper::roleAccess('serviceTransaction.serviceInvoice.index'))
                    <li class="breadcrumb-item"><a href="{{route('serviceTransaction.serviceInvoice.index') }}">Service Invoice</a></li>
                    @endif
                    <li class="breadcrumb-item active"><span>Service Invoice</span></li>
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
              <button type="button"  onclick="window.print();" class="btn btn-success float-right"><i class="fas fa-print"></i> Print
              </button>

              @if($details->service_status == "Pending" && helper::roleAccess('serviceTransaction.serviceInvoice.approved'))
              <button type="button" approved_url="{{route("serviceTransaction.serviceInvoice.approved",['service_invoice_id' => $details->id,'status' =>"Approved"])}}" class="btn btn-info float-right journal transaction_approved" style="margin-right: 5px;">
                <i class="fas fa-check"></i> &nbsp;Approved
              </button>
            @endif

              <h5><i class="fas fa-file-invoice"></i> Service Invoice:</h5>
              {{-- This page has been enhanced for printing. Click the print button at the bottom of the invoice to test. --}}
            </div>
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              
              @include('backend.layouts.common.detailsHeader',['details' => $details])


              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Service</th>
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
                    @foreach($details->serviceInvoiceDetails as $key => $eachDetails)
                    @php 
                        $tqty+=$eachDetails->quantity;
                        $tprice+=$eachDetails->total_price;
                      @endphp                           
                          <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$eachDetails->sevice->name ?? ''}}</td>
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
                  <p class="" style="text-transform: capitalize;"><b> In Word : </b> {{ helper::get_bd_amount_in_text($tprice) }}</p>
                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                  {{$details->note}}
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-3">
               
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td class="text-right">{{helper::pricePrint($tprice)}}</td>
                      </tr>
                      @if(!empty($details->discount))
                      <tr>
                        <th style="width:50%">Discount(-):</th>
                        <td class="text-right">{{helper::pricePrint($details->discount,2)}}</td>
                      </tr>
                      @endif
                      <tr>
                        <th>Grand Total</th>
                        <td class="text-right">{{helper::pricePrint($details->grand_total)}}</td>
                      </tr>
                      @if(!empty($details->paid_amount))
                      <tr>
                        <th>Total Payment (-):</th>
                        <td class="text-right" ><span style="border-bottom: double;">{{helper::pricePrint($details->paid_amount,2)}}</span></td>
                      </tr>
                    @endif
                    <tr>
                      <th>Present Due:</th>
                      <td class="text-right" ><span style="border-bottom: double;">{{helper::pricePrint($details->due_amount,2)}}</span></td>
                    </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              @include('backend.layouts.common.detailsFooter',['details' => $details])

            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div>
@endsection

