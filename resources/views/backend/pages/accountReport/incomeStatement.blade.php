@extends('backend.layouts.master')
@section('title')
Income Statement Report
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
                <h1 class="m-0"> Account Report</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><span> Income Statement  Report</span></li>
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
                <form class="needs-validation" method="POST"  action="{{ route('accountReport.incomeStatement') }}" novalidate>
                    @csrf
                    @if(!empty($formInput) && is_array($formInput))
                    <div class="form-row">
                        @foreach ($formInput as $key => $eachInput)
                        @php htmlform::formfiled($eachInput, $errors, $oldValue ?? ''   ) @endphp
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
                @include('backend.layouts.common.reportHeader',['reportTitle' => $reportTitle,'from_date' =>$from_date,'to_date' => $to_date])
               </div>
            @endif
            <!-- /.card-header -->
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
                                            <th>Particulars</th>
                                            <th class="text-right">Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="2" style="background-color: #87b07d!important;"><b>Sales Revenue ( A ) </b></td>
                                        </tr>
                                        @foreach($salesLedger as $key => $value)
                                            @if($value['balance'] > 0)
                                                @php 
                                                $sub_total_sales+=$value['balance'];
                                                @endphp
                                                    <tr>
                                                        <td colspan="2"><b>A . {{$a++}}  {{$value['parent']->name}} </b></td>
                                                    </tr>
                                                @foreach ($value['parentChild'] as $child => $accountHeads)
                                                    @if(!empty($accountHeads->balance))
                                                        <tr >
                                                            <td class="text-left"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$accountHeads->name}}</td>
                                                            <td class="text-right">{{helper::pricePrint($accountHeads->balance)}}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                        @if(!empty($sub_total_sales))
                                        <tr class="bg-mute">
                                            <td class="text-left"><strong>Sub-Total</strong></td>
                                            <td class="text-right"><strong>{{helper::pricePrint($sub_total_sales)}}</strong></td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td colspan="2"><b>Less Cost of goods sold ( B )</b></td>
                                        </tr>
                                        @foreach($costOfGoodsLedger as $key => $value)
                                            @if($value['balance'] > 0)
                                            @php 
                                            $sub_total_cost_of_goods+=$value['balance'];
                                            @endphp 
                                                <tr>
                                                    <td colspan="2"><b>B . {{$b++}}  {{$value['parent']->name}}</b></td>
                                                </tr>
                                                @foreach ($value['parentChild'] as $child => $accountHeads)
                                                    @if(!empty($accountHeads->balance))
                                                        <tr>
                                                            <td class="text-left"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$accountHeads->name}}</td>
                                                            <td class="text-right">{{helper::pricePrint($accountHeads->balance)}}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                        @if(!empty($sub_total_cost_of_goods))
                                            <tr class="bg-mute">
                                                <td class="text-left"><strong>Sub-Total</strong></td>
                                                <td class="text-right"><strong>{{helper::pricePrint($sub_total_cost_of_goods)}}</strong></td>
                                            </tr>
                                        @endif
                                        @php 
                                          $grossProfit =  $sub_total_sales-$sub_total_cost_of_goods;
                                        @endphp
                                        @if($grossProfit > 0)
                                            <tr style="background-color: #EEF7EE!important;">
                                                <td class="text-right"><strong> Gross Profit / Loss ( C = A -  B )</strong></td>
                                                <td class="text-right"><strong>{{helper::pricePrint($sub_total_sales-$sub_total_cost_of_goods)}}</strong></td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td colspan="2" style="background-color: #87b07d!important;"><b> Operating Expenses (D)</b></td>
                                        </tr>
                                        @foreach($expenseLedger as $key => $value)
                                            @if($value['balance'] > 0)
                                            @php 
                                            $sub_total_expense+=$value['balance'];
                                            @endphp
                                            <tr>
                                                <td colspan="2"><b>D. {{$d++}}  {{$value['parent']->name}}</b></td>
                                            </tr>
                                                @foreach ($value['parentChild'] as $child => $accountHeads)
                                                    @if(!empty($accountHeads->balance))
                                                        <tr>
                                                            <td class="text-left"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$accountHeads->name}}</td>
                                                            <td class="text-right">{{helper::pricePrint($accountHeads->balance)}}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                        @if($sub_total_expense > 0)
                                            <tr>
                                                <td class="text-left"><strong>Sub-Total</strong></td>
                                                <td class="text-right"><strong>{{helper::pricePrint($sub_total_expense)}}</strong></td>
                                            </tr>
                                        @endif
                                            @php 
                                              $netProfit = $grossProfit-$sub_total_expense;
                                            @endphp 
                                        @if($netProfit  > 0)
                                            <tr style="background-color: #F0F7F7!important">
                                                <td class="text-right"><strong>Operating Profit / Loss ( C - D )	</strong></td>
                                                <td class="text-right"><strong>{{helper::pricePrint($netProfit)}}</strong></td>
                                            </tr>
                                        @endif
                                        @if($netProfit > 0)
                                            <tr style="background-color: #D8F1F3!important;">
                                                <td class="text-right"><strong>Total forwarded to balance sheet	</strong></td>
                                                <td class="text-right"><strong>{{helper::pricePrint($netProfit)}}</strong></td>
                                            </tr>
                                        @endif
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

