<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>SL</th>
            <th>Date</th>
            <th>Voucher No </th>
            <th>Customer / Supplier</th>
            <th>Product</th>
            <th>Batch</th>
            <th>Store</th>
            <th>Type</th>
            <th class="text-right color1">Unit Price</th>
            <th class="text-right color1">Total Price</th>
            <th class="text-right color1">Stock In</th>
            <th class="text-right color1">Stock Out</th>
            <th class="text-right color1">Present Stock</th>
        </tr>
    </thead>
    <tbody>
        @php 
        $sin=0;
        $sout=0;
        $tbalance=0;
        @endphp
        @foreach($reports as $key => $report)

        <?php 
           $avgPrice = helper::productAvg($report->product_id);
        ?>

            <tr>
                <td>{{$key+1}}</td>
                <td>{{$report->date ?? ''}}</td>
                @if($report->type == 'in')
                <td >{{$report->pvoucher ?? ''}}</td>
                <td >{{$report->supplierName ?? ''}}</td>
                @else 
                <td >{{$report->svoucher ?? ''}}</td>
                <td >{{$report->customerName ?? ''}}</td>
                @endif
                <td >{{$report->productName ?? ''}}</td>
                <td >{{$report->batchName ?? ''}}</td>
                <td >{{$report->storeName ?? ''}}</td>
                <td >{{helper::getLedgerType($report->type) }}</td>
                <td  class="text-right">{{helper::pricePrint($avgPrice)}}</td>
                <td  class="text-right">{{helper::pricePrint($report->total_price ?? '')}}</td>
                    <td class="color3 text-right">
                        
                        @if($report->type == 'in' || $report->type == 'tin' || $report->type == 'rin' || $report->type == 'lin')
                        
                                {{$report->quantity ?? ''}}
                                
                                @php 
                                $sin+=$report->quantity;
                                @endphp
                        @endif
                    
                    </td>
                   
              
                 <td class="color2 text-right">
                    @if($report->type == 'out' || $report->type == 'tout' || $report->type == 'rout' || $report->type == 'lout')
                    
                        {{$report->quantity ?? ''}}
                        @php 
                        $sout+=$report->quantity;
                        @endphp
                    @endif
                 </td>
                  
              <td class="text-right color1">{{helper::pricePrint($sin - $sout)}}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="10" class="text-right">Grand-Total: </td>
            <td class="text-right color1">{{helper::pricePrint($sin)}}</td>
            <td class="text-right color1">{{helper::pricePrint($sout)}}</td>
            <td class="text-right color1">{{helper::pricePrint($sin - $sout)}}</td>
        </tr>
    </tfoot>
</table>