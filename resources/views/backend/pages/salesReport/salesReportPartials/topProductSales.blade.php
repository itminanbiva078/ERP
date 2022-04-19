<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>SL</th>
            <th>Products</th>
            <th class="text-right color1">Qty</th>
            <th class="text-right color1">Balance</th>
        </tr>
    </thead>
    <tbody>
        @php 
        $tqty=0;
        $tbalance=0;
        $stbalance=0;
        @endphp
        @foreach($reports as $key => $report)

            @php 
            $tqty+=$report->quantity;
            $tbalance+=$report->total_price;
            $stbalance+=$report->subtotal;
            @endphp
            <tr>
                <td>{{$key+1}}</td>
                <td >{{$report->product->name ?? ''}}</td>
                <td class="color3 text-right">{{helper::pricePrint($report->quantity ?? 0)}} </td>
                <td class="color3 text-right">{{helper::pricePrint($report->total_price ?? 0)}}</td>
                        
                   
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" class="text-right">Grand-Total: </td>
            <td class="text-right color1">00</td>
            <td class="text-right color1">00</td>
        </tr>
    </tfoot>
</table>