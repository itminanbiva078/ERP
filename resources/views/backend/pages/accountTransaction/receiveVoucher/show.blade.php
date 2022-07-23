@extends('backend.layouts.master')
@section('title')
AccountTransaction - {{$title}}
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
                  Accounts Transaction </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home') }}">Dashboard</a></li>
                    @if(helper::roleAccess('accountTransaction.receiveVoucher.create'))
                    <li class="breadcrumb-item"><a href="{{route('accountTransaction.receiveVoucher.create') }}"><i class="fas fa-plus"> Add </i></a></li>
                    @endif
                    @if(helper::roleAccess('accountTransaction.receiveVoucher.index'))
                    <li class="breadcrumb-item"><a href="{{route('accountTransaction.receiveVoucher.index') }}"><i class="fas fa-list">  List</i> </a></li>
                    @endif
                    <li class="breadcrumb-item active"><span> Voucher  List</span></li>
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
                    <h5><i class="fas fa-file-invoice"></i> Receive Voucher Invoice :</h5>
                  </div>
                </div>
                <div class="col-md-8">
                  <button type="button"  onclick="window.print();" class="btn btn-success float-right"><i class="fas fa-print"></i> Print </button>
                   
                  @if($details->status == "Pending" && helper::roleAccess('accountTransaction.receiveVoucher.accountApproved'))
                  <button type="button" approved_url="{{route("accountTransaction.receiveVoucher.accountApproved",['id' => $details->id,'status' =>"Approved"])}}" class="btn btn-info float-right journal transaction_approved" style="margin-right: 5px;">
                    <i class="fas fa-check"></i> &nbsp;Approved ?
                  </button> 
                  @endif

                </div>
              </div>            
            </div>
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              @include('backend.layouts.common.detailsHeader',['details' => $details])
              <!-- /.row -->
              <?php// dd($details);?>
              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Account Code</th>
                            <th>Account Name</th>
                            <th class="text-right">Debit</th>
                            <th class="text-right">Credit</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php 
                      $totalDebit = 0;
                      $totalCredit = 0;
                      @endphp
                        @foreach($details->receiveVoucherLedger as $key => $eachLedger)
                       
                          @php 
                          $totalDebit+=$eachLedger->debit;
                          $totalCredit+=$eachLedger->credit;
                          @endphp
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$eachLedger->account->account_code ?? ''}}</td>
                                <td>{{$eachLedger->account->name ?? ''}}</td>
                                <td class="text-right">{{helper::priceprint($eachLedger->debit,2)}}</td>
                                <td class="text-right">{{helper::priceprint($eachLedger->credit,2)}}</td>
                                <td class="text-right">{{ $eachLedger->memo ?? ''}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="3" class="text-right">Total:</th>
                        <th class="text-right">{{helper::priceprint($totalDebit,2)}}</th>
                        <th class="text-right">{{helper::priceprint($totalCredit,2)}}</th>
                        <th></th>
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
                    <p class="" style="text-transform: capitalize;"><b> In Word : </b> {{ helper::get_bd_amount_in_text($totalDebit) }} </p>
                  {{$details->note ?? ''}}
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-3">
               
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>{{helper::priceprint($totalDebit ?? '',2)}}</td>
                      </tr>
                     
                      <tr>
                        <th>Total:</th>
                        <td><span style="border-bottom: double;">{{helper::pricePrint($totalDebit ?? '')}}</span></td>
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

