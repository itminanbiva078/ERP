@extends('backend.layouts.master')
@section('title')
General Ledger Report
@endsection

@section('styles')
<style>
table#show_item tr td {
    padding: 2px !important;
}
</style>
@endsection

@section('navbar-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> Account Report</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><span>General Ledger Report</span></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
@section('admin-content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3>
                <div class="card-tools">
                    <span id="buttons"></span>
                    <a class="btn btn-tool btn-default" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </a>
                    <a class="btn btn-tool btn-default" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="needs-validation" method="POST"  action="{{ route('accountReport.generalLedger') }}" novalidate>
                    @csrf
                    @if(!empty($formInput) && is_array($formInput))
                    <div class="form-row">
                        @foreach ($formInput as $key => $eachInput)
                        @php htmlform::formfiled($eachInput, $errors, old()) @endphp
                        @endforeach
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group"><br>
                                <button class="btn btn-info btn-block" type="submit"><i class="fa fa-search"></i> &nbsp;Search</button>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-default">
                        <strong>Warning!</strong> Sorry you have no form access !!.
                    </div>
                    @endif
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="card card-default">
            <div class="card-header">
                <div class="card-tools">
                    <span id="buttons"></span>
                    <a class="btn btn-tool btn-default" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </a>
                    <a class="btn btn-tool btn-default" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
                @include('backend.layouts.common.reportHeader')
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-12 table-responsive">
                            @if(!empty($opening) || !empty($reportResult))
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Date</th>
                                        <th>Voucher No</th>
                                        <th>Voucher Type</th>
                                        <th>Voucher By</th>
                                        <th>Memo</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($opening))
                                    <tr>
                                        <td colspan="8" class="text-right">Opening Balance</td>
                                        <td class="text-right">@php echo number_format($opening,2); @endphp</td>
                                    </tr>
                                    @endif
                                    @php 
                                    $balance=0;
                                    $debit=0;
                                    $credit=0;
                                    @endphp
                                    @foreach($reportResult as $key => $eachResult)
                                        @php 
                                        $balance+=($eachResult->debit-$eachResult->credit);
                                        $debit+=$eachResult->debit;
                                        $credit+=$eachResult->credit;
                                        @endphp
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{helper::get_php_date($eachResult->date)}}</td>
                                            <td>@php echo helper::getVoucher($eachResult->general)@endphp</td>
                                            <td>{{$eachResult->general->formType->name}}</td>
                                            <td>@php echo helper::getVoucherBy($eachResult->general); @endphp</td>
                                            <td>{{$eachResult->memo}}</td>
                                            <td class="text-right">{{number_format($eachResult->debit,2)}}</td>
                                            <td class="text-right">{{number_format($eachResult->credit,2)}}</td>
                                            <td class="text-right">{{number_format($balance+$opening,2)}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" class="text-right">Grand-Total: </td>
                                        <td class="text-right">{{number_format($debit)}}</td>
                                        <td class="text-right">{{number_format($credit)}}</td>
                                        <td class="text-right">{{number_format($balance+$opening)}}</td>
                                    </tr>
                                </tfoot>
                            </table>
                            @else 
                              <div class="alert alert-default" role="alert">
                                Sorry Result not found!!
                              </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
</div>

@endsection

