
@if($supplier_id == "All")
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>SL</th>
            <th>Name</th>
            <th>Address</th>
            <th>Contact Number</th>
            <th class="text-right">Opening Balance	</th>
            <th class="text-right">Grand Total</th>
            <th class="text-right">Total Payment</th>
            <th class="text-right">Present Due</th>
        </tr>
    </thead>
    <tbody>
        @php 
        $topening=0;
        $tdueAmount=0;
        $ttotalPayment=0;
        $tpurchasesAmount=0;
        @endphp
        @foreach($reports as $key => $report)
            @php 
            $topening+=$report->opening;
            $tdueAmount+=$report->dueAmount;
            $ttotalPayment+=$report->totalPayment;
            $tpurchasesAmount+=$report->purchasesAmount;
          
            @endphp
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$report->supplier->name}} [{{$report->code}}]</td>
                <td>{{$report->supplier->address}}</td>
                <td>{{$report->supplier->phone}}</td>
                <td class="text-right">{{helper::pricePrint($report->opening)}}</td>
                <td class="text-right">{{helper::pricePrint($report->purchasesAmount)}}</td>
                <td class="text-right">{{helper::pricePrint($report->totalPayment)}}</td>
                <td class="text-right">{{helper::pricePrint($report->dueAmount)}}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" class="text-right">Grand-Total: </td>
            <td class="text-right">{{helper::pricePrint($topening)}}</td>
            <td class="text-right">{{helper::pricePrint($tpurchasesAmount)}}</td>
            <td class="text-right">{{helper::pricePrint($ttotalPayment)}}</td>
            <td class="text-right">{{helper::pricePrint($tdueAmount)}}</td>
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
            <th class="text-right">Grand Total</th>
            <th class="text-right">Total Payment</th>
            <th class="text-right">Present Due</th>
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
            $tpurchasesAmount=0;
            $tdueAmount=0;
            $ttotalPayment=0;
          
        @endphp
        @foreach($reports as $key => $report)
            @php 
                $topening+=$report->opening;
                $tdueAmount+=$report->dueAmount;
                $ttotalPayment+=$report->totalPayment;
                $tpurchasesAmount+=$report->purchasesAmount;

            @endphp
            <tr>
                <td>{{$key+1}}</td>
                <td>{{helper::get_php_date($report->date)}}</td>
                <td>
                    <a target="_blank" href="{{ route('inventoryTransaction.purchases.show', $report->id) }}" show_id="{{ $report->id }}" title="Details" class="btn btn-xs btn-default  uniqueid{{ $report->id }}"><i class="fa fa-search-plus"></i>   {{$report->voucher_no}}</a>
                </td>    
            
                <td class="text-right">{{helper::pricePrint($report->purchasesAmount)}}</td>
                <td class="text-right">{{helper::pricePrint($report->totalPayment)}}</td>
                <td class="text-right">{{helper::pricePrint($report->dueAmount)}}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" class="text-right">Grand-Total: </td>

            <td class="text-right">{{helper::pricePrint($tpurchasesAmount)}}</td>
            <td class="text-right">{{helper::pricePrint($ttotalPayment)}}</td>
            <td class="text-right">{{helper::pricePrint($tdueAmount)}}</td>
        </tr>
    </tfoot>
</table>

@endif