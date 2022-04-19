

<style>
table tr td {
    margin: 1px !important;
    padding: 1px !important;
}
</style>


<div class="row">
    <div class="col-12 table-responsive">
            @if(!empty($dueVoucherList) && count($dueVoucherList) > 0)
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th nowrap>Puchases Date</th>
                        <th>Voucher No</th>
                        <th class="text-left">Grand Total</th>
                        <th class="text-left">Total Payment</th>
                        <th class="text-left">Current Due</th>
                        <th class="text-left">Payment Now</th>
                        <th class="text-left">Present Due</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                    $pamount=0;
                    $tpayment=0;
                    $damount=0;
                    $npayment=0;
                    $ppayment=0;
                    @endphp
                    @foreach($dueVoucherList as $key => $eachResult)
                        @php 
                            $pamount+=$eachResult->purchasesAmount;
                            $tpayment+=$eachResult->totalPayment;
                            $damount+=$eachResult->dueAmount;
                        @endphp
                        <tr>
                            <td>{{$key+1}}</td>
                            <td nowrap>{{helper::get_php_date($eachResult->date)}}</td>
                            <td>
                                <input type="hidden" name="purchases_voucher_id[]" value="{{$eachResult->voucher_id}}"/>
                                <input type="text" readonly class="form-control purchasesAmount" value="{{$eachResult->voucher_no}}"></td>
                            <td><input type="number"  name="purchases_amount[]" readonly class="form-control purchasesAmount" value="{{$eachResult->purchasesAmount}}"></td>
                            <td><input type="number"  name="total_payment[]"  readonly class="form-control totalPayment" value="{{$eachResult->totalPayment}}"></td>
                            <td><input type="number"  name="due_amount[]"  readonly class="form-control dueAmount" value="{{$eachResult->dueAmount}}"></td>
                            <td><input type="number"  name="credit[]"   class="form-control paymentNow decimal" value="{{$eachResult->dueAmount}}"></td>
                            <td><input type="number"  name="present_due[]"  readonly class="form-control presentDue  decimal" value="" placeholder="0.00"></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right">Grand-Total: </td>
                        <td class="text-left">{{helper::pricePrint($pamount)}}</td>
                        <td class="text-left">{{helper::pricePrint($tpayment)}}</td>
                        <td class="text-left">{{helper::pricePrint($damount)}}</td>
                        <td class="text-left "><span class="ppaymentnow">{{helper::pricePrint($damount)}}</span></td>
                        <td class="text-left "><span class="pdueamount">0.00</span></td>
                    </tr>
                    <tr>
                        <td colspan="7"></td>
                        {{-- <td><h1>Total Payment : <span id="totalPayment" class="text-right"></span> </h1></td> --}}
                        <td >
                            <div class="col-md-12 text-right">
                                <div class="form-group"><br>
                                    <button class="btn btn-info text-right" type="submit"><i class="fa fa-save"></i> &nbsp;Payment</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
            @else 
              <div class="alert alert-default" role="alert">
                Sorry , selected supplier have no due purhases!
              </div>
            @endif
        </div>
    </div>
</div>


<script>
$(document).ready(function(){
    $(".decimal").on("click", function () {
    $(this).select();
    });
});
$('tbody,tfoot').delegate( 'input.paymentNow', 'keyup', function() {
            var tr = $(this).closest('tr');
            var current_dueAmount = parseFloat(tr.find('input.dueAmount').val()-0);
            var paymentNow = parseFloat(tr.find('input.paymentNow').val()-0);
            var present_due = parseFloat(tr.find('input.presentDue').val()-0);
            tr.find('input.presentDue').val(current_dueAmount-paymentNow);
            if(paymentNow > current_dueAmount){
                tr.find('input.paymentNow').val(current_dueAmount);
                Swal.fire('Warning!', "Payment can't gratherthan from current due", 'warning');  
            }
            $(this).removeClass("border border-danger");
            $(this).addClass("border border-success");
            calculation();
        });

    function calculation() {
        var total_due_payment = 0;
        var total_payment_now = 0;
        var total_present_due = 0;
        $('.dueAmount').each(function(i, e) {
            var due_payemnt = parseFloat($(this).val() - 0);
            total_due_payment += due_payemnt;
        });
        $('.paymentNow').each(function(i, e) {
            var payment_now = parseFloat($(this).val() - 0);
            total_payment_now += payment_now;
        });
        $('.presentDue').each(function(i, e) {
            var present_due = parseFloat($(this).val() - 0);
            total_present_due += present_due;
        });


       $('#totalPayment').text(total_payment_now);
       $('.ppaymentnow').text(total_payment_now);
       $('.pdueamount').text(total_due_payment-total_payment_now);


    }

</script>