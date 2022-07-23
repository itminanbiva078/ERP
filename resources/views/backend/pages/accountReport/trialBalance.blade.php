
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
                <h1 class="m-0">Account Report</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><span>Trial Balance  Report</span></li>
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
                <h3 class="card-title">Trial Balance</h3>
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
                <form class="needs-validation" method="POST"  action="{{ route('accountReport.trialBalance') }}" novalidate>
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
                @include('backend.layouts.common.reportHeader',['reportTitle' => $reportTitle,'from_date' =>$from_date ?? ''])
               </div>
            @endif


            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-12 table-responsive">
                        @php 
                        $opening_debit=0;
                        $opening_credit=0;
                        $balance_debit=0;
                        $balance_credit=0;
                        $a=1;
                        $aa=1;
                        $b=1;
                        $bb=1;
                        $c=1;
                        $cc=1;
                        $d=1;
                        $dd=1;
                       @endphp

                    @if(!empty($from_date))

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td  rowspan="2" class="text-left" style="padding-top: 15px;"><strong>Account Name</strong></td>
                                <td  colspan="2" class="text-center color1"><strong>Brought Forward</strong></td>
                                <td  colspan="2" class="text-center color2"><strong>This Period</strong></td>
                                <td  colspan="2" class="text-center color3"><strong>Balance  </strong></td>
                            </tr>
                
                            <tr>
                                <td  class="text-right color1"><strong>Debit</strong></td>
                                <td  class="text-right color1"><strong>Credit</strong></td>
                                <td  class="text-right color2"><strong>Debit</strong></td>
                                <td  class="text-right color2"><strong>Credit</strong></td>
                                <td  class="text-right color3"><strong>Debit</strong></td>
                                <td  class="text-right color3"><strong>Credit</strong></td>
                            </tr>
                        </thead>
                    
                        <tbody>
                            
                    


{{-- start assets --}}
                            @foreach($assetLedger as $key => $eachLedger)
                                @if(($eachLedger['balance']+$eachLedger['opening']) > 0)
                                    <tr style="background-color: #E6F6F8!important;">
                                        <td colspan="7"><strong>&nbsp;&nbsp; A . {{$a}} {{$eachLedger['parent']->name}}</strong></td>
                                    </tr>
                                    @foreach ($eachLedger['parentChild'] as $child => $eachChildLedger)
                                        @if(!empty($eachChildLedger->final_balance))

                                        @php 
                                            $opening_debit+=$eachChildLedger->opening_debit-$eachChildLedger->opening_credit;
                                           //  $opening_credit+=$eachChildLedger->opening_credit;
                                             $balance_debit+=$eachChildLedger->balance_debit-$eachChildLedger->balance_credit;
                                             //$balance_credit+=$eachChildLedger->balance_credit;

                                             $opcredit = $eachChildLedger->opening_debit-$eachChildLedger->opening_credit;
                                             $blcredit = $eachChildLedger->balance_debit-$eachChildLedger->balance_credit;


                                        @endphp 




                                            <tr>
                                                <td><a href="#">&nbsp;&nbsp;&nbsp; A.  {{$a}} .  {{$aa}}&nbsp;&nbsp;&nbsp;{{$eachChildLedger->name}}</a></td>
                                                <td  class="text-right color1">{{ helper::pricePrint($eachChildLedger->opening_debit-$eachChildLedger->opening_credit) }}</td>
                                                <td  class="text-right color1"> </td>
                                                <td  class="text-right color2">{{helper::pricePrint($eachChildLedger->balance_debit-$eachChildLedger->balance_credit)}}</td>
                                                <td  class="text-right color2"></td>
                                                <td  class="text-right color3"> {{helper::pricePrint($opcredit+ $blcredit)}} </td>
                                                <td  class="text-right color3"></td>
                                            </tr>
                                            @php $aa++ @endphp
                                        @endif

                                    @endforeach
                                    @php $a++;$aa=1; @endphp
                                @endif
                            @endforeach

{{-- end assets --}}


{{-- start liability --}}



                            @foreach($liabilityLedger as $lia => $eachLedger)
                          
                                @if(($eachLedger['balance']+$eachLedger['opening']) > 0)
                                    <tr style="background-color: #E6F6F8!important;">
                                        <td colspan="7"><strong>&nbsp;&nbsp;B. {{$b}} {{$eachLedger['parent']->name}}</strong></td>
                                    </tr>
                                    @foreach ($eachLedger['parentChild'] as $child => $eachChildLedger)
                                        @if(!empty($eachChildLedger->final_balance))
                                            @php 
                                                // $opening_debit+=$eachChildLedger->opening_debit;
                                                $opening_credit+=$eachChildLedger->opening_credit-$eachChildLedger->opening_debit;
                                                // $balance_debit+=$eachChildLedger->balance_debit;
                                                $balance_credit+=$eachChildLedger->balance_credit-$eachChildLedger->balance_debit;

                                              $openingCredit = $eachChildLedger->opening_credit-$eachChildLedger->opening_debit;
                                              $balanceCredit = $eachChildLedger->balance_credit-$eachChildLedger->balance_debit;


                                            @endphp
                                            <tr>
                                                <td><a href="#">&nbsp;&nbsp;&nbsp; B. {{$b}} . {{$bb}}&nbsp;&nbsp;&nbsp;{{$eachChildLedger->name}}</a></td>
                                                <td  class="text-right color1"></td>
                                                <td  class="text-right color1"> {{helper::pricePrint($eachChildLedger->opening_credit-$eachChildLedger->opening_debit)}} </td>
                                                <td  class="text-right color2"></td>
                                                <td  class="text-right color2"> {{helper::pricePrint($eachChildLedger->balance_credit-$eachChildLedger->balance_debit)}} </td>
                                                <td  class="text-right color3"> </td>
                                                <td  class="text-right color3"> {{helper::pricePrint($openingCredit+$balanceCredit)}} </td>
                                            </tr>
                                            @php $bb++ @endphp
                                        @endif
                                    @endforeach
                                    @php $b++;$bb=0; @endphp
                                @endif
                            @endforeach
{{-- start assets --}}



{{-- start income --}}
                            @foreach($incomeLedger as $inc => $eachLedger)
                                @if(($eachLedger['balance']+$eachLedger['opening']) > 0)
                                    <tr style="background-color: #E6F6F8!important;">
                                        <td colspan="7"><strong>&nbsp;&nbsp;C. {{$c}} {{$eachLedger['parent']->name}}</strong></td>
                                    </tr>
                                    @foreach ($eachLedger['parentChild'] as $child => $eachChildLedger)
                                        @if(!empty($eachChildLedger->final_balance))
                                            @php 
                                                // $opening_debit+=$eachChildLedger->opening_debit;
                                                $opening_credit+=$eachChildLedger->opening_credit-$eachChildLedger->opening_debit;
                                                // $balance_debit+=$eachChildLedger->balance_debit;
                                                $balance_credit+=$eachChildLedger->balance_credit-$eachChildLedger->balance_debit;

                                               $opcreditbalance =  $eachChildLedger->opening_credit-$eachChildLedger->opening_debit;
                                               $opdebitbalance = $eachChildLedger->balance_credit-$eachChildLedger->balance_debit;
                                            @endphp
                                            <tr>
                                                <td><a href="#">&nbsp;&nbsp;&nbsp;C . {{$c}} .  {{$cc}}&nbsp;&nbsp;&nbsp;{{$eachChildLedger->name}}</a></td>
                                                <td  class="text-right color1"></td>
                                                <td  class="text-right color1"> {{helper::pricePrint($eachChildLedger->opening_credit-$eachChildLedger->opening_debit)}} </td>
                                                <td  class="text-right color2"></td>
                                                <td  class="text-right color2"> {{helper::pricePrint($eachChildLedger->balance_credit-$eachChildLedger->balance_debit)}} </td>
                                                <td  class="text-right color3"> </td>
                                                <td  class="text-right color3"> {{helper::pricePrint($opcreditbalance+$opdebitbalance)}} </td>
                                            </tr>
                                            @php $cc++ @endphp
                                        @endif
                                    @endforeach
                                    @php $c++; $cc=0;@endphp
                                @endif
                            @endforeach
{{-- start income --}}


{{-- start expense --}}
                            @foreach($expenseLedger as $ex => $eachLedger)
                                @if(($eachLedger['balance']+$eachLedger['opening']) > 0)
                                    <tr style="background-color: #E6F6F8!important;">
                                        <td colspan="7"><strong>&nbsp;&nbsp;D. {{$d}} {{$eachLedger['parent']->name}}</strong></td>
                                    </tr>
                                    @foreach ($eachLedger['parentChild'] as $child => $eachChildLedger)
                                        @if(!empty($eachChildLedger->final_balance))
                                        @php 
                                            $opening_debit+=$eachChildLedger->opening_debit-$eachChildLedger->opening_credit;
                                            // $opening_credit+=$eachChildLedger->opening_credit;
                                            $balance_debit+=$eachChildLedger->balance_debit-$eachChildLedger->balance_credit;
                                            // $balance_credit+=$eachChildLedger->balance_credit;
                                           $liabilityCredit =  $eachChildLedger->opening_debit-$eachChildLedger->opening_credit;
                                            $liabilityDebit = $eachChildLedger->balance_debit-$eachChildLedger->balance_credit;
                                        @endphp
                                            <tr>
                                                <td><a href="#">&nbsp;&nbsp;&nbsp;D . {{$d}} . {{$dd}}&nbsp;&nbsp;&nbsp;{{$eachChildLedger->name}}</a></td>
                                                <td  class="text-right color1">{{ helper::pricePrint($eachChildLedger->opening_debit-$eachChildLedger->opening_credit) }}</td>
                                                <td  class="text-right color1">  </td>
                                                <td  class="text-right color2">{{helper::pricePrint($eachChildLedger->balance_debit-$eachChildLedger->balance_credit)}}</td>
                                                <td  class="text-right color2">  </td>
                                                <td  class="text-right color3"> {{helper::pricePrint($liabilityCredit+$liabilityDebit)}} </td>
                                                <td  class="text-right color3">  </td>
                                            </tr>
                                            @php $dd++ @endphp
                                        @endif
                                    @endforeach
                                    @php $d++;$dd=0; @endphp
                                @endif
                            @endforeach
{{-- start expense --}}
                    
                            
                    
                            <!-- /chart_master -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right"><strong>Total Ending Balance (In BDT.)</strong></td>
                                <td  class="text-right color1"> <strong>{{helper::pricePrint($opening_debit)}}</strong> </td>
                                <td  class="text-right color1"> <strong>{{helper::pricePrint($opening_credit)}}</strong> </td>
                                <td  class="text-right color2"><strong>{{helper::pricePrint($balance_debit)}}</strong></td>
                                <td  class="text-right color2"><strong>{{helper::pricePrint($balance_credit)}}</strong></td>
                                <td  class="text-right color3"><strong>{{helper::pricePrint($opening_debit+$balance_debit)}}</strong></td>
                                <td  class="text-right color3"><strong>{{helper::pricePrint($opening_credit+$balance_credit)}}</strong></td>
                            </tr>
                        </tfoot>
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

















