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
                <form class="needs-validation" method="POST"  action="{{ route('accountReport.journalCheck') }}" novalidate>
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
            @if(!empty($reportTitle))
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
                    @include('backend.layouts.common.reportHeader',['reportTitle' => $reportTitle,'from_date' =>$from_date])
                </div>
            @endif

            <div class="card-body">
                <div class="row">
                    <div class="col-12 table-responsive">
                        @php 
                            $total_debit=0;
                            $total_credit=0;
                           
                        @endphp
                        @if(!empty($from_date))
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td class="text-center"><strong>Date</strong></td>
                                    <td class="text-center"><strong>Voucher</strong></td>
                                    <td class="text-center"><strong>Voucher Type</strong></td>
                                    <td class="text-center"><strong>Account Head</strong></td>
                                    <td class="text-center"><strong>Debit</strong></td>
                                    <td class="text-center"><strong>Credit</strong></td>
                                    <td class="text-center"><strong>Balance</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                              
                                @php 
                                $totalAsset=0;
                                $totalLiability=0;
                                @endphp 
                                @foreach($journalCheck as $key => $eachLedger)
                                    @php 
                                        $totalAsset+=$eachLedger->debit ?? $eachLedger->credit ?? 0;
                                        
                                    @endphp 
                                    <tr class="item-row" style="background-color: #CEE5F">
                                        <td width="18.5%" onclick="divShowHide()" data-toggle="collapse" data-target="#demo{{$key+100}}" style="padding-left: 10px;" class="collapsed" aria-expanded="false">
                                            <span class="show_hide" id="plus{{$key+100}}" style="display: inline-block;"><i class="fa fa-plus"></i>   <a href="javascript:void(0)">{{$eachLedger->date}} </a></span>
                                        </td>
                                        <td width="10%" data-toggle="collapse" class="text-right">
                                            <?php echo helper::getVoucher($eachLedger);?>
                                        </td>
                                        <td width="10%" data-toggle="collapse"  class="text-right">{{$eachLedger->formType->name ?? ''}}</td>
                                        <td width="10%" data-toggle="collapse"  class="text-right">N/A</td>
                                        <td width="10%" data-toggle="collapse" class="text-right">{{$eachLedger->total_debit_amount ?? 0}}</td>
                                        <td width="10%" data-toggle="collapse" class="text-right">{{ $eachLedger->total_credit_amount ?? 0}} </td>
                                        <td width="10%" data-toggle="collapse" class="text-right">{{$eachLedger->total_debit_amount - $eachLedger->total_credit_amount}}</td>
                                    </tr>
                                    @php 
                                    $childSubLedger = $eachLedger->journals
                                    @endphp
                                        @if(!empty($childSubLedger))
                                            <tr>
                                                <td colspan="7">
                                                    <div id="demo{{$key+100}}" class="collapse" aria-expanded="false" style="height: 0px;">
                                                        <table class="table table-bordered">
                                                            <tbody>

                                                                @php 
                                                                    $t_debit=0;
                                                                    $t_credit=0;
                                                                @endphp

                                                                @foreach($childSubLedger as $sub => $subLedger)

                                                                    @php 
                                                                        $t_debit+=$subLedger->debit;
                                                                        $t_credit+=$subLedger->credit;
                                                                    @endphp

                                                                    <tr  style="background-color: #9cbdb9!important;">
                                                                        <td width="18.5%"><i class="fa fa-minus"></i> {{$eachLedger->date}}</td>
                                                                        <td width="10%">  <?php echo helper::getVoucher($eachLedger);?></td>
                                                                        <td width="10%">{{$eachLedger->formType->name}}</td>
                                                                        <td width="10%"> {{$subLedger->account->name}}</td>
                                                                        <td width="10%" class="text-right"> {{helper::pricePrint($subLedger->debit)}}  </td>
                                                                        <td width="10%" class="text-right"> {{helper::pricePrint($subLedger->credit)}}  </td>
                                                                        <td width="10%" class="text-right">0.00</td>
                                                                       
                                                                    </tr>
                                                                @endforeach
                                                                <tr>
                                                                    <td colspan="4" class="text-right"> Total Balance</td>
                                                                    <td   class="text-right"> {{$t_debit ?? 0 }}</td>
                                                                    <td   class="text-right"> {{$t_credit ?? 0}}</td>
                                                                    <td   class="text-right"> {{$t_debit - $t_credit ?? 0}}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach


                                    {{-- <tr style="background-color: #87b07d !important">
                                        <td class="text-right" colspan="4"><strong>Total Assets (In BDT.)</strong></td>
                                        <td class="text-right"><strong> {{helper::pricePrint($totalAsset)}}</strong></td>
                                        <td class="text-right"><strong> 0.00</strong></td>
                                    </tr> --}}
                                    
                                   
                                  
                                   
                                </tbody>
                            </table>
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

