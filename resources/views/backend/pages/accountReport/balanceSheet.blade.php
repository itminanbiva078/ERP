@extends('backend.layouts.master')
@section('title')
Balance Sheet
@endsection

@section('styles')
    <style>
        table tr td {
            padding: 2px !important;
        }
    </style>
@endsection

@section('navbar-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Balance Sheet</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><span>Balance Sheet  Report</span></li>
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
                <h3 class="card-title">Balance Sheet</h3>
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
                <form class="needs-validation" method="POST"  action="{{ route('accountReport.balanceSheet') }}" novalidate>
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
                            $sub_total_sales=0;
                            $sub_total_cost_of_goods=0;
                            $sub_total_expense=0;
                            $a=1;
                            $b=1;
                            $d=1;
                        @endphp
                        @if(!empty($from_date))
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td class="text-center"><strong>Account Code and Name</strong></td>
                                    <td class="text-center"><strong>Period Balance (In BDT.)</strong></td>
                                    <td class="text-center"><strong>Prior Year Balance (In BDT.)</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr  style="background-color: #69d7e4!important;" class="item-row">
                                    <td colspan="3" class="text-center">
                                        <div class="table-header">
                                            ASSETS
                                        </div>
                                    </td>
                                </tr>
                                @php 
                                $totalAsset=0;
                                $totalLiability=0;
                                @endphp 
                                @foreach($assetLedger as $key => $eachLedger)
                                    @php 
                                        $totalAsset+=$eachLedger['balance'];
                                    @endphp 
                                    <tr class="item-row" style="background-color: #CEE5F">
                                        <td  onclick="divShowHide()" data-toggle="collapse" data-target="#demo{{$key+100}}" style="padding-left: 10px;" class="collapsed" aria-expanded="false">
                                            <span class="show_hide" id="plus{{$key+100}}" style="display: inline-block;"><i class="fa fa-plus"></i>   <a href="javascript:void(0)">{{$eachLedger['parent']->name}} </a></span>
                                        </td>
                                        <td data-toggle="collapse" class="text-right">
                                            {{helper::pricePrint($eachLedger['balance'])}}
                                        </td>
                                        <td class="text-right">0.00</td>
                                    </tr>
                                    @php 
                                    $childSubLedger = $eachLedger['parentChild'];// journal::getChildList($eachLedger['parent']->id,$from_date);
                                    @endphp
                                        @if(!empty($childSubLedger))
                                            <tr>
                                                <td colspan="3">
                                                    <div id="demo{{$key+100}}" class="collapse" aria-expanded="false" style="height: 0px;">
                                                        <table class="table table-bordered">
                                                            <tbody>
                                                                @foreach($childSubLedger as $sub => $subLedger)
                                                                    <tr  style="background-color: #9cbdb9!important;">
                                                                        <td width="38.5%"><i class="fa fa-minus"></i> <a href="#">{{$subLedger->name}}</a></td>
                                                                        <td width="30%" class="text-right">
                                                                            {{helper::pricePrint($subLedger->balance)}}
                                                                        </td>
                                                                        <td class="text-right">0.00</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <tr style="background-color: #87b07d !important">
                                        <td class="text-right"><strong>Total Assets (In BDT.)</strong></td>
                                        <td class="text-right"><strong> {{helper::pricePrint($totalAsset)}}</strong></td>
                                        <td class="text-right"><strong> 0.00</strong></td>
                                    </tr>
                                    <tr  style="background-color: #69d7e4!important;" class="item-row">
                                        <td colspan="3" class="text-center">
                                            <div class="table-header">
                                                LIABILITIES &amp; EQUITY
                                            </div>
                                        </td>
                                    </tr>
                                    @foreach($liabilityLedger as $key => $eachLedger)
                                    @php 
                                        $totalLiability+=abs($eachLedger['balance']);
                                    @endphp 
                                    <tr class="item-row" style="background-color: #CEE5F">
                                        <td onclick="divShowHide()" data-toggle="collapse" data-target="#demo{{$key+500}}" style="padding-left: 10px;" class="collapsed" aria-expanded="false">
                                            <span class="show_hide" id="plus{{$key+500}}" style="display: inline-block;"><i class="fa fa-plus"></i>     <a href="javascript:void(0)">{{$eachLedger['parent']->name}} </a></span>
                                        </td>
                                        <td data-toggle="collapse" class="text-right">
                                            {{helper::pricePrint(abs($eachLedger['balance']))}}
                                        </td>
                                        <td class="text-right">0.00</td>
                                    </tr>
                                    @php 
                                    $childSubLedger = $eachLedger['parentChild'];// journal::getChildList($eachLedger['parent']->id,$from_date);
                                    @endphp
                                    @if(!empty($childSubLedger))
                                        <tr>
                                            <td colspan="3">
                                                <div id="demo{{$key+500}}" class="collapse" aria-expanded="false" style="height: 0px;">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            @foreach($childSubLedger as $sub => $subLedger)
                                                                <tr  style="background-color: #9cbdb9 !important;">
                                                                    <td width="38%"><i class="fa fa-minus"></i>  <a href="#">{{$subLedger->name}}</a></td>
                                                                    <td width="30%" class="text-right">
                                                                        {{helper::pricePrint(abs($subLedger->balance))}}
                                                                    </td>
                                                                    <td class="text-right">0.00</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                    @endforeach
                                    <tr style="background-color: #CEE5F">
                                        <td data-toggle="collapse" data-target="#demoReturn" style="padding-left: 10px;">
                                            <span class="show_hide" id="plus45" style="display: inline-block;"><i class="fa fa-plus"></i> <a href="javascript:void(0)">&nbsp;Profit / ( Loss )</a></span>
                                        </td>
                                        <td class="text-right">{{helper::pricePrint($profitOrLoss)}}</td>
                                        <td class="text-right"><strong> 0.00</strong></td>
                                    </tr>
                                    <tr  style="background-color: #87b07d !important">
                                        <td class="text-right"><strong>Total Liabilities &amp; Equity (In BDT.)</strong></td>
                                        <td class="text-right"><strong> {{helper::pricePrint($totalLiability+$profitOrLoss)}}</strong></td>
                                        <td class="text-right"><strong> 0.00</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

