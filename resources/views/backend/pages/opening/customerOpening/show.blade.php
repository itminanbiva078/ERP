@extends('backend.layouts.master')
@section('title')
Opening - {{$title}}
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
                  Opening </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home') }}">Dashboard</a></li>
                    @if(helper::roleAccess('openingSetup.customerOpening.index'))
                    <li class="breadcrumb-item"><a href="{{route('openingSetup.customerOpening.index') }}">Customer Opening</a></li>
                    @endif
                    <li class="breadcrumb-item active"><span>Customer Opening List</span></li>
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
                    <h5><i class="fas fa-file-invoice"></i> Customer Opening Invoice :</h5>
                  </div>
                </div>
                <div class="col-md-8">
                  <button type="button"  onclick="window.print();" class="btn btn-success float-right"><i class="fas fa-print"></i> Print </button>
                </div>
              </div>            
            </div>
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-6 invoice-col">
                  Company Info 
                  <address>
                    <strong>{{$companyInfo->name ?? ''}}</strong><br>
                    {{$companyInfo->address ?? ''}}
                    <br>
                    Phone: {{$companyInfo->phone ?? ''}}<br>
                    Email: {{$companyInfo->email ?? ''}}
                  </address>
                </div>
               
              
                <div class="col-sm-6 invoice-col">
                  <b>Voucher ID : {{$details->voucher_no ?? ''}}</b>
                  <br>
                  <b>Date:</b> {{date('Y-M-d',strtotime($details->date))}}<br>
                
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
                            <th>Customer</th>
                           
                            @if(in_array('opening_balance',$activeColumn))
                            <th class="text-right">Opening Balance	</th>
                            @endif
                           
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                          $tqty = 0;
                        @endphp
                        @foreach($details->customerOpeningDetails as $key => $eachDetails)
                        @php 

                      

                            $tqty+=$eachDetails->opening_balance;
                          @endphp
                        <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$eachDetails->customer->name}}</td>
                              
                                @if(in_array('opening_balance',$activeColumn))
                                <td class="text-right">{{$eachDetails->opening_balance ?? ''}}</td>
                                @endif
                        
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th></th>
                        <th colspan="{{helper::getColspan($activeColumn)}}" class="text-right">Sub-Total</th>
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
                <p class="" style="text-transform: capitalize;"><b> In Word : </b>{{ helper::get_bd_amount_in_text($tqty) }} </p>
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
