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
                    @if(helper::roleAccess('inventoryTransaction.transfer.create'))
                    <li class="breadcrumb-item"><a href="{{route('inventoryTransaction.transfer.create') }}"><i class="fas fa-plus"> Add </i> </a></li>
                    @endif
                    @if(helper::roleAccess('inventoryTransaction.transfer.index'))
                    <li class="breadcrumb-item"><a href="{{route('inventoryTransaction.transfer.index') }}"><i class="fas fa-list">  List</i></a></li>
                    @endif
                    <li class="breadcrumb-item active"><span>Transformer List</span></li>
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
                    <h5><i class="fas fa-file-invoice"></i> Transfer Invoice :</h5>
                  </div>
                </div>
                <div class="col-md-8">
                  <button type="button" onclick="loadVoucher('<?php echo $details->voucher_no?>','<?php echo helper::imageUrl($details->documents)?>')" data-toggle="modal" data-target="#modal-default"  class="btn btn-success float-right"><i class="fa fa-upload" ></i> Document </button>
                  <button type="button"  onclick="window.print();" class="btn btn-success float-right"><i class="fas fa-print"></i> Print </button>
                </div>
              </div>            
            </div>
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-3 invoice-col">
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
                <div class="col-sm-3 invoice-col">
                  From Store Info
                  <address>
                    <strong>{{$details->fStore->name ?? ''}}</strong>
                    <br>
                    {{$details->fStore->address ?? ''}}<br>
                    Phone: {{$details->fStore->phone ?? ''}}<br>
                    Email: {{$details->fStore->email ?? ''}} 
                  </address>
                </div>
                <!-- /.col -->
                <!-- /.col -->
                <div class="col-sm-3 invoice-col">
                  Transfer Store Info
                  <address>
                    <strong>{{$details->tStore->name ?? ''}}</strong>
                   <br>
                    {{$details->tStore->address ?? ''}}<br>
                    Phone: {{$details->tStore->phone ?? ''}}<br>
                    Email: {{$details->tStore->email ?? ''}} 
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-3 invoice-col">
                  <b>Voucher ID : {{$details->voucher_no ?? ''}}</b>
                  <br>
                  <b>Date:</b> {{date('Y-M-d',strtotime($details->date))}}<br>
                  <b>Status:</b>  @php echo helper::statusBar($details->status) @endphp
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
                            <th class="text-right">Quantity</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                          $tqty = 0;
                          $tpack = 0;
                        @endphp
                        @foreach($details->transferDetails as $key => $eachDetails)
                        @php 

                      

                            $tqty+=$eachDetails->quantity;
                            $tpack+=$eachDetails->pack_no;
                          @endphp
                        <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$eachDetails->product->name}}</td>
                                @if(in_array('batch_no',$activeColumn))
                                <td>{{$eachDetails->batch->name ?? ''}}</td>
                                @endif
                                @if(in_array('pack_size',$activeColumn))
                                <td class="text-right">{{$eachDetails->pack_size ?? ''}}</td>
                                @endif
                                @if(in_array('pack_no',$activeColumn))
                                <td class="text-right">{{$eachDetails->pack_no ?? ''}}</td>
                                @endif
                                <td class="text-right">{{$eachDetails->quantity ?? ''}}</td>
                               
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="{{helper::getColspan($activeColumn)}}" class="text-right">Sub-Total</th>
                        <th></th>
                        <th class="text-right">{{helper::pricePrint($tpack)}}</th>
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
                <p class="" style="text-transform: capitalize;"><b> In Word : </b> {{ helper::get_bd_amount_in_text($tqty) }} </p>
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
                        <td class="text-right">{{helper::pricePrint($tqty)}}</td>
                      </tr>
                      
                      <tr>
                        <th>Grand Total:</th>
                        <td class="text-right" ><span style="border-bottom: double;">{{helper::pricePrint($tqty)}}</span></td>
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
            
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div>
@endsection
@section('scripts')
@endsection
