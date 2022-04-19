<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td rowspan="2" class="text-left" style="text-align:left;"><strong>Categorys</strong></td>
            <td rowspan="2" class="text-left"><strong>Brands</strong></td>
            <td rowspan="2" class="text-left"><strong>Products</strong></td>
            <td  colspan="3" class="text-center color4"><strong>Opening Stock <br>(QTY or Taka) </strong></td>
            <td  colspan="3" class="text-center color3"><strong>Stock In  <br>(QTY or Taka)</strong></td>
            <td  colspan="3" class="text-center color2"><strong>Stock Out <br> (QTY or Taka)</strong></td>
            <td  colspan="3" class="text-center color1"><strong>Closing stock <br> (QTY or Taka)</strong>
            </td>
        </tr>
        <tr>
            <td  class="text-right color4">Qty</td>
            <td  class="text-right color4">Rate</td>
            <td  class="text-right color4">TK</td>
            <td   class="text-right color3">Qty</td>
            <td   class="text-right color3"> Rate</td>
            <td   class="text-right color3">TK</td>
            <td   class="text-right color2">Qty</td>
            <td   class="text-right color2"> Rate</td>
            <td   class="text-right color2">TK</td>
            <td  class="text-right color1">Qty</td>
            <td  class="text-right color1">Rate</td>
            <td  class="text-right color1">TK</td>
        </tr>
    </thead>
    <tbody>

        @php 


        $oqty=0;
        $oprice=0;
        $iqty=0;
        $iprice=0;
        $sqty=0;
        $sprice=0;
        $cqty=0;
        $cprice=0;

       @endphp

     @foreach($reports as $key => $report)

        @php 
        $oqty+=$report->sopQty;
        $oprice+=$report->sopQty*$report->sopUnitPrice;
        $iqty+=$report->stockIn;
        $iprice+=$report->stockIn*$report->sinUnitPrice;
        $sqty+=$report->stockOut;
        $sprice+=$report->stockOut*$report->soutUnitPrice;
        $cqty+=$report->currentStock;
        $cprice+=$report->currentStock*$report->avgPrice;
       @endphp

        <tr>
            <td>{{$report->categoryName}}</td>
            <td>{{$report->brandName}}</td>
            <td>{{$report->pname}}</td>

            <td   class="text-right color4">{{helper::pricePrint($report->sopQty)}}</td>
            <td   class="text-right color4">{{helper::pricePrint($report->sopUnitPrice)}}</td>
            <td   class="text-right color4">{{helper::pricePrint($report->sopQty*$report->sopUnitPrice)}}</td>

            <td    class="text-right color3">{{helper::pricePrint($report->stockIn)}}</td>
            <td    class="text-right color3">{{helper::pricePrint($report->sinUnitPrice)}}</td>
            <td    class="text-right color3">{{helper::pricePrint($report->stockIn*$report->sinUnitPrice)}}</td>

            <td    class="text-right color2">{{helper::pricePrint($report->stockOut)}}</td>
            <td    class="text-right color2">{{helper::pricePrint($report->soutUnitPrice)}}</td>
            <td    class="text-right color2">{{helper::pricePrint($report->stockOut*$report->soutUnitPrice)}}</td>

            <td    class="text-right color1">{{helper::pricePrint($report->currentStock)}}</td>
            <td    class="text-right color1">{{helper::pricePrint($report->avgPrice)}}</td>
            <td    class="text-right color1">{{helper::pricePrint($report->currentStock*$report->avgPrice)}}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" class="text-right"><strong>Total (BDT) </strong></td>
            <td  class="text-right color4" ><strong>{{helper::pricePrint($oqty)}}</strong></td>
            <td  class="text-right color4"><strong></strong></td>
            <td  class="text-right color4" ><strong>{{helper::pricePrint($oprice)}}</strong></td>
            <td  class="text-right color3" ><strong>{{helper::pricePrint($iqty)}}</strong></td>
            <td  class="text-right color3"><strong></strong></td>
            <td  class="text-right color3" ><strong>{{helper::pricePrint($iprice)}}</strong></td>
            <td  class="text-right color2" ><strong>{{helper::pricePrint($sqty)}}</strong></td>
            <td  class="text-right color2"><strong></strong></td>
            <td  class="text-right color2" ><strong>{{helper::pricePrint($sprice)}}</strong></td>
            <td  class="text-right color1" ><strong>{{helper::pricePrint($cqty)}}</strong></td>
            <td  class="text-right color1"><strong></strong></td>
            <td  class="text-right color1" ><strong>{{helper::pricePrint($cprice)}}</strong></td>
        </tr>
    </tfoot>

</table>