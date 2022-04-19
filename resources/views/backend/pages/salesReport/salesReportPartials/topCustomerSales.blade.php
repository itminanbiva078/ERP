<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>SL</th>
            <th>Customer</th>
            <th class="text-right color1">Balance</th>
        </tr>
    </thead>
    <tbody>
        @php 
        $tbalance=0;
        $stbalance=0;
        @endphp
        @foreach($reports as $key => $report)
            @php 
            $tbalance+=$report->subtotal;
            $stbalance+=$report->subtotal;
            @endphp
            <tr>
                <td>{{$key+1}}</td>
                <td >{{$report->customer->name ?? ''}}</td>
                <td class="color3 text-right">{{helper::pricePrint($report->subtotal ?? 0)}} </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" class="text-right">Grand-Total: </td>
            <td class="text-right color1">{{helper::pricePrint($stbalance)}}</td>
        </tr>
    </tfoot>
</table>