@extends('backend.layouts.master')
@section('title')
InventoryTransaction - {{$title}}
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
                Inventory Transaction </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home') }}">Dashboard</a></li>
                    @if(helper::roleAccess('inventoryTransaction.purchasesMRR.index'))
                    <li class="breadcrumb-item"><a href="{{route('inventoryTransaction.purchasesMRR.create') }}"><i class="fas fa-plus"> Add </i></a></li>
                    @endif
                    @if(helper::roleAccess('inventoryTransaction.purchasesMRR.edit') && $details->purchases_status == 'Pending')
                    <li class="breadcrumb-item"><a href="{{route('inventoryTransaction.purchasesMRR.edit', $details->id) }}"><i class="fas fa-edit"> Edit</i></a></li>
                    @endif
                    @if(helper::roleAccess('inventoryTransaction.purchasesMRR.index'))
                    <li class="breadcrumb-item"><a href="{{route('inventoryTransaction.purchasesMRR.index') }}"><i class="fas fa-list">  List</i> </a></li>
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
                    <h5><i class="fas fa-file-invoice"></i> Purchases MRR Invoice </h5>
                    {{-- This page has been enhanced for printing. Click the print button at the bottom of the invoice to test. --}}
                  </div>
                </div>
                <div class="col-md-8">
                  <button type="button" onclick="loadVoucher('<?php echo $details->voucher_no?>','<?php echo helper::imageUrl($details->documents)?>')" data-toggle="modal" data-target="#modal-default"  class="btn btn-success float-right"><i class="fa fa-upload" ></i> Document </button>

                  <button type="button"  onclick="window.print();" class="btn btn-success float-right"><i class="fas fa-print"></i> Print
                  </button>
                   
                </div>
              </div>            </div>
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
             
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-3 invoice-col">
                  Company Info
                  <address>
                    <strong>{{$companyInfo->name ?? ''}}</strong><br>
                    {{$companyInfo->address  ?? ''}}
                    <br>
                    Phone: {{$companyInfo->phone ?? ''}}<br>
                    Email: {{$companyInfo->email ?? ''}}
                  </address>
                </div>
                <!-- /.col -->
                @if(helper::isBranchEnable() && helper::branchIsActive())
                <div class="col-sm-3 invoice-col">
                  Branch Info
                  <address>
                    <strong>{{$details->branch->name ?? ''}}</strong>
                   <br>
                    {{$details->branch->address ?? ''}}<br>
                    Phone: {{$details->branch->phone ?? ''}}<br>
                    Email: {{$details->branch->email ?? ''}} 
                  </address>
                </div>
                @endif
                <!-- /.col -->
                <!-- /.col -->
                @if(helper::isStoreEnable() && helper::storeIsActive())
                <div class="col-sm-3 invoice-col">
                  Store Info
                  <address>
                    <strong>{{$details->store->name ?? ''}}</strong>
                     <br>
                    {{$details->store->address ?? ''}}<br>
                    Phone: {{$details->store->phone ?? ''}}<br>
                    Email: {{$details->store->email ?? ''}}
                  </address>
                </div>
                @endif
                <!-- /.col -->
                <div class="col-sm-3 invoice-col">
                  <b>Voucher ID: {{$details->voucher_no ?? ''}}</b><br>
                  <b>Purchases Voucher :</b> {{$details->purchases->voucher_no ?? ''}}<br>
                  <b>Date:</b> {{ helper::get_php_date($details->date)}}<br>
                  <b>Status:</b> @php echo helper::statusBar($details->status) @endphp
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
                            <th>Batch No</th>
                            @endif
                            @if(in_array('pack_size',$activeColumn))
                            <th class="text-right">Pack Size	</th>
                            @endif
                            @if(in_array('pack_no',$activeColumn))
                            <th class="text-right">Pack No.	</th>
                            @endif
                            <th class="text-right">Received Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                        //echo count($activeColumn);die;
                          $tqty = 0;
                          $tprice = 0;
                          $tpack = 0;
                          $tpackno = 0;

                        @endphp
                        @foreach($details->purchasesMrrDetails as $key => $eachDetails)
                        @php 
                            $tqty+=$eachDetails->approved_quantity;
                            $tpack+=$eachDetails->pack_size;
                            $tpackno+=$eachDetails->pack_no;
                            $tprice+=$eachDetails->quantity*$eachDetails->total_price;
                          @endphp 
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$eachDetails->product->name ?? ''}}</td>
                                @if(in_array('batch_no',$activeColumn))
                                <td>{{$eachDetails->batchNumber->name ?? ''}}</td>
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
                   
                    <tfoot>
                      <tr>
                       
                        <th class="text-right" colspan="3">Sub-Total</th>
                        @if(in_array('pack_size',$activeColumn))
                        <th class="text-right">{{helper::pricePrint($tpack)}}</th>
                        @endif
                        @if(in_array('pack_no',$activeColumn))
                        <th class="text-right">{{helper::pricePrint($tpackno)}}</th>
                        @endif
                        <th class="text-right">{{helper::pricePrint($tqty)}}</th>
                       
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

