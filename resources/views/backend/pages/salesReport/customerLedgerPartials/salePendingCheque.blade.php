


<?php 



    //dd($reports);

?>


@if($customer_id == "All")
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>SL</th>
            <th>Name</th>
            <th>Address</th>
            <th>Contact Number</th>
            <th class="text-right">Opening Balance	</th>
            <th class="text-right">Cheque Payment</th>
          
            <th class="text-right">Balance</th>
        </tr>
    </thead>
    <tbody>
    
        @php 
        $topening=0;
        $tpayable=0;
        $tpaid=0;
        $tbalance=0;
        @endphp
        @foreach($reports as $key => $report)
            @php 
        
            $topening+=$report->opening;
            $tpayable+=$report->payment;
         
            $tbalance +=$report->opening + $report->payment;
            @endphp
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$report->customer->name}} [{{$report->customer->code}}]</td>
                <td>{{$report->customer->address}}</td>
                <td>{{$report->customer->phone}}</td>
                <td class="text-right">{{helper::pricePrint($report->opening ?? '')}}</td>
                <td class="text-right">{{helper::pricePrint($report->payment)}}</td>
                <td class="text-right">{{helper::pricePrint($report->opening+$report->payment)}}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" class="text-right">Grand-Total: </td>
            <td class="text-right">{{helper::pricePrint($topening)}}</td>
            <td class="text-right">{{helper::pricePrint($tpayable)}}</td>
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
                  
                    <th class="text-right">Cheque Payment</th>
                    <th class="text-right">Balance</th>
                </tr>
            </thead>
            <tbody>


            @if(!empty($opening->opening))
            <tr>
                <td colspan="8" class="text-right">Opening Balance</td>
                <td class="text-right">{{ helper::pricePrint($opening->opening) }}</td>
            </tr>
            @endif

            @php 
            $topening=0;
            $tpayable=0;
            $tpaid=0;
            $tbalance=0;
            @endphp
            @foreach($reports as $key => $report)
                @php 
                $topening+=$report->opening;
                $tpayable+=$report->payment;
              
               
                @endphp
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{helper::get_php_date($report->date)}}</td>
                    <td>{{$report->voucher_no}}</td>
                    <td>{{$report->sale->voucher_no ?? ''}}</td>
                    <td>{{$report->payment_type ?? "Voucher Create"}}</td>
                    <td>{{$report->note}}</td>
                    <td class="text-right">{{helper::pricePrint($report->payment)}}</td>
                  
                    <td class="text-right">{{helper::pricePrint($tpayable+$opening->opening)}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                    <tr>
                        <td colspan="6" class="text-right">Grand-Total: </td>
                        <td class="text-right">{{helper::pricePrint($tpayable)}}</td>
                      
                        <td class="text-right">{{helper::pricePrint($tpayable+$opening->opening)}}</td>
                    </tr>
            </tfoot>
        </table>


@endif