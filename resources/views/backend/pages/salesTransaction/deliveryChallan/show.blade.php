@extends('backend.layouts.master')
@section('title')
DeliveryChallan - {{$title}}
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
                  Delivery Challan </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home') }}">Dashboard</a></li>
                    @if(helper::roleAccess('salesTransaction.deliveryChallan.create'))
                    <li class="breadcrumb-item"><a href="{{route('salesTransaction.deliveryChallan.create') }}"><i class="fas fa-plus"> Add </i> </a></li>
                    @endif
                    @if(helper::roleAccess('salesTransaction.deliveryChallan.index'))
                    <li class="breadcrumb-item"><a href="{{route('salesTransaction.deliveryChallan.index') }}"><i class="fas fa-list">  List</i> </a></li>
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
                    <h5><i class="fas fa-file-invoice"></i> Delivery Challan Invoice</h5>
                    {{-- This page has been enhanced for printing. Click the print button at the bottom of the invoice to test. --}}
                  </div>
                </div>
                <div class="col-md-8">
                  <button type="button"  onclick="window.print();" class="btn btn-success float-right"><i class="fas fa-print"></i> Print
                  </button>
                   
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
                            
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                          $tqty = 0;
                          $tprice = 0;
                        @endphp
                        @foreach($details->deliveryChallanDetails as $key => $eachDetails)
                        @php 
                            $tqty+=$eachDetails->quantity;
                            $tprice+=$eachDetails->quantity*$eachDetails->total_price;
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
                                <td class="text-right">{{$eachDetails->approved_quantity}}</td>
                               
                            </tr>
                        @endforeach
                    </tbody>
                   
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-9">
                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                  {{$details->note}}
                  </p>
                </div>
              
              </div>
              @include('backend.layouts.common.detailsFooter',['details' => $details])

             
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div>
@endsection
