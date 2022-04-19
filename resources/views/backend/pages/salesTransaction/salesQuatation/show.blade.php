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
                    @if(helper::roleAccess('salesTransaction.salesQuatation.create'))
                    <li class="breadcrumb-item"><a href="{{route('salesTransaction.salesQuatation.create') }}"><i class="fas fa-plus"> Add </i>  </a></li>
                    @endif

                    @if(helper::roleAccess('salesTransaction.salesQuatation.edit') && $details->sales_status == 'Pending')
                    <li class="breadcrumb-item"><a href="{{route('salesTransaction.salesQuatation.edit', $details->id) }}"><i class="fas fa-edit"> Edit</i> </a></li>
                    @endif

                    @if(helper::roleAccess('salesTransaction.salesQuatation.index'))
                    <li class="breadcrumb-item"><a href="{{route('salesTransaction.salesQuatation.index') }}"><i class="fas fa-list">  List</i></a></li>
                    @endif
                    <li class="breadcrumb-item active"><span> Invoice</span></li>
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
                    <h5><i class="fas fa-file-invoice"></i> Sales Quatation Invoice</h5>
                      {{-- This page has been enhanced for printing. Click the print button at the bottom of the invoice to test. --}}
                  </div>
                </div>
             
              <div class="col-md-8">
                <button type="button" onclick="loadVoucher('<?php echo $details->voucher_no?>','<?php echo helper::imageUrl($details->documents)?>')" data-toggle="modal" data-target="#modal-default"  class="btn btn-success float-right"><i class="fa fa-upload" ></i> Document </button>

                  <button type="button"  onclick="window.print();" class="btn btn-success float-right"><i class="fas fa-print"></i> Print
                  </button>

                  @if($details->quatation_status == "Pending" && helper::roleAccess('salesTransaction.salesQuatation.approved'))
                    <button type="button" approved_url="{{route("salesTransaction.salesQuatation.approved",['sales_quatation_id' => $details->id,'status' =>"Approved"])}}" class="btn btn-info float-right journal transaction_approved" style="margin-right: 5px;">
                      <i class="fas fa-check"></i> &nbsp;Approved ?
                    </button>
                  @endif
                </div>
                
              </div>
            </div>
          
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              
              @include('backend.layouts.common.detailsHeader',['details' => $details])


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
                        @foreach($details->salesQuatationDetails as $key => $eachDetails)
                        @php 
                            $tqty+=$eachDetails->quantity;
                            $tprice+=$eachDetails->quantity*$eachDetails->unit_price;

                        @endphp
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$eachDetails->product->name ?? ''}}</td>
                                @if(in_array('batch_no',$activeColumn))
                                <td class="text-right">{{$eachDetails->batch_no ?? ''}}</td>
                                @endif
                                @if(in_array('pack_size',$activeColumn))
                                <td class="text-right">{{$eachDetails->pack_size ?? ''}}</td>
                                @endif
                                @if(in_array('pack_no',$activeColumn))
                                <td class="text-right">{{$eachDetails->pack_no ?? ''}}</td>
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
                        <td  class="text-right">{{helper::pricePrint($tprice)}}</td>
                      </tr>
                     
                      <tr>
                        <th class="text-right">Grand Total:</th>
                        <td class="text-right" ><span style="border-bottom: double;">{{helper::pricePrint($details->grand_total)}}</span></td>
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
          </div>
          </div><!-- /.col -->
        </div>
@endsection

