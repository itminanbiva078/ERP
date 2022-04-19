

@if($customer_id == "All")
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>SL</th>
            <th>Name</th>
            <th>Address</th>
            <th>Contact Number</th>
            <th class="text-right">Opening Balance	</th>
            <th class="text-right">Sub-Total</th>
            <th class="text-right">Discount</th>
            <th class="text-right">Grand Total</th>
        </tr>
    </thead>
    <tbody>
        @php 
        $topening=0;
        $tsub_total=0;
        $tdiscount=0;
        $tbalance=0;
        $tgrand_total=0;
        @endphp
        @foreach($reports as $key => $report)
            @php 
            $topening+=$report->opening;
            $tsub_total+=$report->subtotal;
            $tdiscount+=$report->discount;
            $tgrand_total+=$report->grand_total;
          
            @endphp
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$report->customer->name}} [{{$report->customer->code}}]</td>
                <td>{{$report->customer->address}}</td>
                <td>{{$report->customer->phone}}</td>
                <td class="text-right">{{helper::pricePrint($report->opening)}}</td>
                <td class="text-right">{{helper::pricePrint($report->subtotal)}}</td>
                <td class="text-right">{{helper::pricePrint($report->discount)}}</td>
                <td class="text-right">{{helper::pricePrint($report->grand_total)}}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" class="text-right">Grand-Total: </td>
            <td class="text-right">{{helper::pricePrint($topening)}}</td>
            <td class="text-right">{{helper::pricePrint($tsub_total)}}</td>
            <td class="text-right">{{helper::pricePrint($tdiscount)}}</td>
            <td class="text-right">{{helper::pricePrint($tgrand_total)}}</td>
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
            <th>Payment Type</th>
            <th>Note</th>
            <th class="text-right">Sub Total</th>
            <th class="text-right">Discount</th>
            <th class="text-right">Grand Total</th>
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
            $tsub_total=0;
            $tdiscount=0;
            $tgrand_total=0;
        @endphp
        @foreach($reports as $key => $report)
            @php 
                $topening+=$report->opening;
                $tsub_total+=$report->subtotal;
                $tdiscount+=$report->discount;
                $tgrand_total+=$report->grand_total;
            @endphp
            <tr>
                <td>{{$key+1}}</td>
                <td>{{helper::get_php_date($report->date)}}</td>
                <td>
                    <a target="_blank" href="{{ route('salesTransaction.sales.show', $report->id) }}" show_id="{{ $report->id }}" title="Details" class="btn btn-xs btn-default  uniqueid{{ $report->id }}"><i class="fa fa-search-plus"></i>   {{$report->voucher_no}}</td></a>
                  
                <td>{{$report->payment_type}}</td>
                <td>{{$report->note}}</td>
                <td class="text-right">{{helper::pricePrint($report->subtotal)}}</td>
                <td class="text-right">{{helper::pricePrint($report->discount)}}</td>
                <td class="text-right">{{helper::pricePrint($report->grand_total)}}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-right">Grand-Total: </td>
            <td class="text-right">{{helper::pricePrint($tsub_total)}}</td>
            <td class="text-right">{{helper::pricePrint($tdiscount)}}</td>
            <td class="text-right">{{helper::pricePrint($tgrand_total)}}</td>
        </tr>
    </tfoot>
</table>

@endif