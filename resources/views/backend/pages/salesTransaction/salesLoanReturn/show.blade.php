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
                    @if(helper::roleAccess('salesTransaction.salesLoanReturn.create'))
                    <li class="breadcrumb-item"><a href="{{route('salesTransaction.salesLoanReturn.create') }}"><i class="fas fa-plus"> Add </i> </a></li>
                    @endif
                    @if(helper::roleAccess('salesTransaction.salesLoanReturn.index'))
                    <li class="breadcrumb-item"><a href="{{route('salesTransaction.salesLoanReturn.index') }}"><i class="fas fa-list">  List</i> </a></li>
                    @endif
                    <li class="breadcrumb-item active"><span>Sales Loan Return List</span></li>
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
                    <h5><i class="fas fa-file-invoice"></i>  Sales Loan Return Invoice:</h5>
                      {{-- This page has been enhanced for printing. Click the print button at the bottom of the invoice to test. --}}
                  </div>
                </div>
                <div class="col-md-8">
                  {{-- @if($details->status == "Pending" && helper::roleAccess('salesTransaction.salesLoanReturn.approved'))
                  <button type="button" approved_url="{{route("salesTransaction.salesLoanReturn.approved",['id' => $details->id,'status' =>"Approved"])}}" class="btn btn-info float-right journal transaction_approved" style="margin-right: 5px;">
                    <i class="fas fa-check"></i> &nbsp;Approved ?
                  </button>
                 @endif --}}
                  <button type="button"  onclick="window.print();" class="btn btn-success float-right"><i class="fas fa-print"></i> Print
                  </button>
                  @if(!empty($details->general->journals))
                  <button type="button" class="btn btn-info float-right journal" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Journal Details
                  </button>
                  @endif
                 </div>
              </div>
            </div>
          <!-- Main content -->
            <div class="invoice p-3 mb-3">
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
                            @if(in_array('batch_no',$activeColumn))
                            <th>Batch No</th>
                            @endif
                            @if(in_array('pack_size',$activeColumn))
                            <th>Pack Size	</th>
                            @endif
                            @if(in_array('pack_no',$activeColumn))
                            <th>Pack No.	</th>
                            @endif
                            <th>Quantity</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                          $tqty = 0;
                          $tprice = 0;
                        @endphp
                        @foreach($details->slreturnDetails as $key => $eachDetails)
                        @php 
                            $tqty+=$eachDetails->quantity;
                            $tprice+=$eachDetails->quantity*$eachDetails->total_price;
                          @endphp
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$eachDetails->product->name ?? ''}}</td>
                                @if(in_array('batch_no',$activeColumn))
                                <td>{{$eachDetails->batch_no ?? ''}}</td>
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
                        <th colspan="{{helper::getColspan($activeColumn)}}" class="text-right">Total-Qty</th>
                        <th class="text-right">{{$tqty}}</th>
                       
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

                  </b></p>
                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                  {{$details->note}}
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-3">
               
                  <div class="table-responsive">
                   
                  
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

        <div class="row no-print journalDiv" style="display: none!important">
          <div class="col-12">
            <div class="callout callout-info">
              <h5><i class="fas fa-file-invoice"></i> Sales Return Journal :</h5>
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
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        @php 
                          $tdebit = 0;
                          $tcredit = 0;
                        @endphp
                        @if(!empty($details->general->journals))
                        @foreach($details->general->journals as $key => $eachDetails)

                        @php 
                      
                            $tdebit+=$eachDetails->debit;
                            $tcredit+=$eachDetails->credit;
                          @endphp
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$eachDetails->account->account_code ?? ''}}</td>
                                <td>{{$eachDetails->account->name ?? ''}}</td>
                                <td class="text-right">{{number_format($eachDetails->debit,2)}}</td>
                                <td class="text-right">{{number_format($eachDetails->credit,2)}}</td>
                                <td>{{$eachDetails->memo ?? ''}}</td>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="3" class="text-right">Sub-Total</th>
                        <th class="text-right">{{$tdebit}}</th>
                        <th class="text-right">{{$tcredit}}</th>
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
@endsection
@section('scripts')

<script>
  $(document).ready(function(){
    $(".journal").click(function(){
      $(".journalDiv").toggle();
    });
  });
  </script>
@endsection
