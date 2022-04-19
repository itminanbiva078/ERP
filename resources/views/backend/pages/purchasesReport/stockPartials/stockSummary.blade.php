<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>SL</th>
            <th>Category</th>
            <th>Product</th>
            <th class="color3">Store</th>
            <th class="color2">Batch</th>
            <th class="text-right color1">Present Stock</th>
        </tr>
    </thead>
    <tbody>
        @php 
        $tbalance=0;
        @endphp
        @foreach($reports as $key => $report)
            @php 
                $tbalance+=$report->quantity;
            @endphp
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$report->product->category->name ?? ''}}</td>
                <td >{{$report->product->name}}</td>
                <td class="color2">{{$report->store->name ?? ''}}</td>
                <td class="color2">{{$report->batch->name ?? ''}}</td>
                <td class="text-right color1">{{helper::pricePrint($report->quantity ?? 0)}}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-right">Grand-Total: </td>
            <td class="text-right color1">{{helper::pricePrint($tbalance)}}</td>
        </tr>
    </tfoot>
</table>