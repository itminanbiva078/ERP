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
                    @if(helper::roleAccess('inventoryTransaction.purchases.create'))
                    <li class="breadcrumb-item"><a href="{{route('inventoryTransaction.purchasesRequisition.create') }}"><i class="fas fa-plus"> Add </i></a></li>
                    @endif

                    @if(helper::roleAccess('inventoryTransaction.purchasesRequisition.edit') && $details->purchases_order_status == 'Pending')
                    <li class="breadcrumb-item"><a href="{{route('inventoryTransaction.purchasesRequisition.edit', $details->id) }}"><i class="fas fa-edit"> Edit</i></a></li>
                    @endif

                    @if(helper::roleAccess('inventoryTransaction.purchasesRequisition.index'))
                    <li class="breadcrumb-item"><a href="{{route('inventoryTransaction.purchasesRequisition.index') }}"><i class="fas fa-list">  List</i></a></li>
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
                    <h5><i class="fas fa-file-invoice"></i> Purchases Requisition Invoice</h5>
                    {{-- This page has been enhanced for printing. Click the print button at the bottom of the invoice to test. --}}
                  </div>
                </div>
                <div class="col-md-8">
                  <button type="button"  onclick="window.print();" class="btn btn-success float-right"><i class="fas fa-print"></i> Print
                  </button>

                  @if($details->requisition_status == "Pending" && helper::roleAccess('inventoryTransaction.purchasesRequisition.approved'))
                    <button type="button" approved_url="{{route("inventoryTransaction.purchasesRequisition.approved",['requisition_id' => $details->id,'status' =>"Approved"])}}" class="btn btn-info float-right journal transaction_approved" style="margin-right: 5px;">
                      <i class="fas fa-check"></i> &nbsp;Approved ?
                    </button>
                  @endif
                </div>
              </div>          
              </div>
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
               
                <!-- /.col -->
              </div>
              <!-- info row -->
              @include('backend.layouts.common.detailsHeader',['details' => $details])

              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Product</th>
                            
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
                        @foreach($details->requisitionDetails as $key => $eachDetails)
                        @php 
                            $tqty+=$eachDetails->quantity;
                            $tpack+=$eachDetails->pack_size;
                          
                          @endphp
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$eachDetails->product->name}}</td>
                              
                                @if(in_array('pack_size',$activeColumn))
                                <td class="text-right">{{$eachDetails->pack_size}}</td>
                                @endif
                                @if(in_array('pack_no',$activeColumn))
                                <td class="text-right">{{$eachDetails->pack_no}}</td>
                                @endif
                                <td class="text-right">{{$eachDetails->quantity}}</td>
                               
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>

                      <?php 
                        
                       // echo count($activeColumn);die("stop");
                        
                        ?>

                        @if(count($activeColumn) != 2)
                        <tr>
                          <th colspan="{{helper::getColspan($activeColumn)}}" class="text-right">Total Qty</th>
                          <th class="text-right"> {{helper::pricePrint($tpack)}}</th> 
                          <th class="text-right">0.00</th>
                          <th class="text-right">{{helper::pricePrint($tqty)}}</th>
                        </tr>
                    @else 

                      <tr>
                        <th colspan="2" class="text-right">Total Qty</th>
                        <th class="text-right"> {{helper::pricePrint($tpack)}}</th> 
                      
                      
                      </tr>
                    @endif
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
              <!-- /.row -->
              @include('backend.layouts.common.detailsFooter',['details' => $details])

              
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div>
@endsection

