E<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>SL</th>
            <th>Date</th>
            <th>Voucher No </th>
            <th>Customer / Supplier</th>
            <th>Product</th>
            <th>Batch</th>
            <th>Store</th>
            <th class="text-right color1">Sales Qty</th>
            <th class="text-right color1">Unit Price</th>
            <th class="text-right color1">Amount</th>
           </tr>
    </thead>
    <tbody>
        @php 
        $sin=0;
        $sout=0;
        $tbalance=0;
        @endphp
        @foreach($reports as $key => $report)
           
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$report->date ?? ''}}</td>
                <td >{{$report->svoucher ?? ''}}</td>
                <td >{{$report->customerName ?? ''}}</td>
                <td >{{$report->productName ?? ''}}</td>
                <td >{{$report->batchName ?? ''}}</td>
                <td >{{$report->storeName ?? ''}}</td>
                <td class="color3 text-right">
                    {{$report->quantity ?? ''}}
                    @php 
                    $sin+=$report->quantity;
                    @endphp
                </td>
                <td  class="text-right">{{helper::pricePrint($report->unit_price ?? '')}}</td>
                <td class="text-right">
                    {{helper::pricePrint($report->total_price ?? '')}}
                     @php $tbalance+=$report->total_price; @endphp
                    </td>

            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7" class="text-right">Grand-Total: </td>
            <td class="text-right color1">{{helper::pricePrint($sin)}}</td>
            <td class="text-right color1">00</td>
            <td class="text-right color1">{{helper::pricePrint($tbalance)}}</td>
        </tr>
    </tfoot>
</table>