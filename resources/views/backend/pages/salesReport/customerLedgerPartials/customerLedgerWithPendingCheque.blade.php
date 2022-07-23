

@if($customer_id == "All")
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact Number</th>
                    <th class="text-right">Opening Balance	</th>
                    <th class="text-right">Payable</th>
                    <th class="text-right">Paid</th>
                    <th class="text-right">Balance</th>
                </tr>
            </thead>
            <tbody>

                @php

                $topening=0;
                $tpayable=0;
                $tpaid=0;
                $tbalance=0;
                $transaction=0;
                @endphp
                @if(!empty($reports))
                    @foreach($reports as $key => $report)
                        @php

                        $topening+=$report->opening ?? 0;
                        $tpayable+=$report->debit;
                        $tpaid+=$report->credit;
                        $tbalance +=($report->debit+$report->opening ?? 0) - $report->credit;
                        $transaction=$report->debit+$report->opening;
                        @endphp
                        @if(!empty($transaction))
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$report->name ?? ''}} [{{$report->code ?? ''}}]</td>
                                <td>{{$report->address ?? ''}}</td>
                                <td>{{$report->phone ?? ''}}</td>
                                <td class="text-right">{{helper::pricePrint($report->opening ?? 0)}}</td>
                                <td class="text-right">{{helper::pricePrint($report->debit)}}</td>
                                <td class="text-right">{{helper::pricePrint($report->credit,2)}}</td>
                                <td class="text-right">{{helper::pricePrint(($report->debit+$report->opening ?? 0) - $report->credit)}}</td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right">Grand-Total: </td>
                    <td class="text-right">{{helper::pricePrint($topening)}}</td>
                    <td class="text-right">{{helper::pricePrint($tpayable)}}</td>
                    <td class="text-right">{{helper::pricePrint($tpaid)}}</td>
                    <td class="text-right">{{helper::pricePrint($tbalance)}}</td>
                </tr>
            </tfoot>
        </table>

@else

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>SL</th>
            <th>Date</th>
            <th>Voucher No</th>
            <th>Invoice No</th>
            <th>Payment Type</th>
            <th>Memo</th>
            <th class="text-right">Payable</th>
            <th class="text-right">Paid</th>
            <th class="text-right">Balance</th>
        </tr>
    </thead>
    <tbody>


        @if(isset($opening) && !empty($opening->opening))
        <tr>
            <td colspan="8" class="text-right">Opening Balance</td>
            <td class="text-right">{{ helper::pricePrint($opening->opening ?? 0) }}</td>
        </tr>
        @endif

        @php

        //dd($reports);

        $topening=0;
        $tpayable=0;
        $tpaid=0;
        $tbalance=0;
        @endphp




        @foreach($reports as $key => $report)
            @php
            if(!empty($report)):
            $topening+=$report->opening ?? 0;
            $tpayable+=$report->debit;
            $tpaid+=$report->credit;
            $tbalance +=$report->debit - $report->credit;
            @endphp
            <tr>
                <td>{{$key+1}}</td>
                <td>{{helper::get_php_date($report->date)}}</td>
                <td>{{$report->voucher_no}}</td>
                <td>{{$report->sale->voucher_no ?? ''}}</td>
                <td>{{$report->payment_type ?? "Voucher Create"}}</td>
                <td>{{$report->note}}</td>
                <td class="text-right">{{helper::pricePrint($report->debit)}}</td>
                <td class="text-right">{{helper::pricePrint($report->credit)}}</td>
                <td class="text-right">{{helper::pricePrint($tbalance+$opening->opening)}}</td>
            </tr>
            <?php endif;?>
        @endforeach

        @foreach($pendingReports as $key => $report)
            @php

           // dd($report);
            if(!empty($report)):


            $tpaid+=$report->payment;
            $tbalance +=-$report->payment;
            @endphp
            <tr>
                <td>{{$key+1}}</td>
                <td>{{helper::get_php_date($report->receive_date)}}</td>
                <td>{{$report->voucher_no}}</td>
                <td>{{$report->voucher_no ?? ''}}</td>
                <td>Cheque Payment</td>
                <td>Pending Cheque</td>
                <td class="text-right">{{helper::pricePrint(0)}}</td>
                <td class="text-right">{{helper::pricePrint($report->payment)}}</td>
                <td class="text-right">{{helper::pricePrint($tbalance)}}</td>
            </tr>
            <?php endif;?>
        @endforeach






    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" class="text-right">Grand-Total: </td>
            <td class="text-right">{{helper::pricePrint($tpayable)}}</td>
            <td class="text-right">{{helper::pricePrint($tpaid)}}</td>
            <td class="text-right">{{helper::pricePrint($tbalance+$opening->opening)}}</td>
        </tr>
    </tfoot>
</table>


@endif
