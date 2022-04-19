
    
    @if(!empty($purchasesList))
    
    <div class="form-row">
      <div class="form-group row col-md-6 mb-3 ">
         <label for="validationCustom01" class="col-sm-3 col-form-label">Purchases Date :</label>
         <div class="col-sm-6">
            <div class="input-group date" id="reservationdate" data-target-input="nearest">
               <input type="text" readonly value="{{$purchasesList->date}}" name="date" id="" class="form-control datetimepicker-input" data-target="#reservationdate">
               <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
               </div>
            </div>
         </div>
      </div>
      <div class="form-group row col-md-6 mb-3   div_voucher_no">
         <label for="inputEmail3" class="col-sm-3 col-form-label">Voucher No. :</label>
         <div class="col-sm-6">
            <input type="text" name="voucher_no" readonly="" class="form-control" id="" placeholder="Voucher No." value="{{$purchasesList->voucher_no}}">
            <input type="hidden" name="branch_id" readonly="" class="form-control" id="" placeholder="Voucher No." value="1">
            <input type="hidden" name="purchases_id" readonly="" class="form-control" id="" placeholder="Voucher No." value="{{$purchasesList->id}}">
         </div>
      </div>
      <div class="form-group row col-md-6 mb-3   div_supplier_id">
         <label for="validationCustom01" class="col-sm-3 col-form-label">Supplier :</label>
         <div class="col-sm-6">
           <input type="text" name="supplier_id" readonly="" class="form-control" id="" placeholder="Voucher No." value="{{$purchasesList->supplier->name}}">
        </div>
      </div>
      <div class="form-group row col-md-6 mb-3 ">
         <label for="validationCustom01" class="col-sm-3 col-form-label">Document Upload :</label>
         <div class="col-sm-6"> 
            <input type="file" name="documents" class="form-control" id="" value="">
         </div>
      </div>

     @foreach ($formInput as $key => $eachInput)
        @php 
        $array=array('account_id','payment_type','bank_id');
        @endphp
        @if(in_array($eachInput->name,$array))
           @php
                 htmlform::formfiled($eachInput, $errors, old())
           @endphp
        @endif
     @endforeach
     
   </div>
   <div class="row">
      <table class="table table-bordered table-hover" >
         <thead class="bg-default">
            <tr>
               <th width="15%">Product</th> 
               @if(in_array('pack_size',$activeColumn))
               <th class="text-right">Pack Size</th>
               @endif 
               @if(in_array('pack_no',$activeColumn))
               <th class="text-right">Pack No.</th>
               @endif
               <th class="text-right">Quantity</th>
               <th class="text-right">Remaining Quantity</th>
               <th class="text-right">Return Quantity</th>
               <th class="text-right">Unit Price</th>
               <th class="text-right">Deduction %</th>
               <th class="text-right">Total Price</th>
            </tr>
         </thead>
            @php 
            $tpsize=0;
            $tpno =0;
            $tqty = 0;
            $rqty = 0;
            @endphp
         <tbody>
            @foreach($purchasesList->purchasesDetails as $key => $eachProduct)
              @php 
                 $tpsize += $eachProduct->pack_size;
                 $tpno += $eachProduct->pack_no;
                 $tqty += $eachProduct->quantity;
                 $rqty += $eachProduct->quantity - $eachProduct->return_quantity;
              @endphp

            <tr class="new_item{{$key}}">
              @if(in_array('product_id',$activeColumn))
               <td> {{$eachProduct->product->name}}</td>
               @endif
               @if(in_array('pack_size',$activeColumn))
               <td class="text-right"> {{$eachProduct->pack_size}}</td>
               @endif
               @if(in_array('pack_no',$activeColumn))
               <td class="text-right"> {{$eachProduct->pack_no}}</td>
               @endif
               @if(in_array('quantity',$activeColumn))
               <td class="text-right"> <input type="number" required=""  name="quantity[]" class="form-control quantity decimal" id="" placeholder="Quantity" value="{{$eachProduct->quantity}}" readonly="readonly"></td>
               @endif
               <td> <input type="number" required=""  name="remaining_quantity[]" class="form-control remaining_quantity decimal" id="" placeholder="Quantity" value="{{$eachProduct->quantity - $eachProduct->return_quantity}}" readonly="readonly"></td>
               <td> <input type="number" required=""  name="return_quantity[]" class="form-control return_quantity decimal" id="" placeholder="Return Quantity" value="" ></td>
              
               @if(in_array('unit_price',$activeColumn))
               <td> <input type="number" required=""  name="unit_price[]" class="form-control unit_price decimal" id="" readonly="readonly" placeholder="Unit Price" value="{{$eachProduct->unit_price}}"></td>
               @endif
               <td> 
                  <input type="hidden" required=""  name="product_id[]" class="form-control product_id decimal" id="product_id"   placeholder="" value="{{$eachProduct->product_id}}">
                  <input type="hidden" required=""  name="deduction_percen_amount[]" class="form-control deduction_percen_amount decimal" id="deduction_percen_amount"   placeholder="" value="">
                  <input type="number" required=""  name="deduction[]" class="form-control deduction decimal" id=""   placeholder="Deduction : 5% " value=""></td>
               @if(in_array('total_price',$activeColumn))
               <td> <input type="number" required=""  name="total_price[]" readonly="" class="form-control total_price decimal" id="" placeholder="Total Price" value=""></td>
               @endif
            </tr>
            @endforeach
         </tbody>


         <tfoot>
            <tr>
               <td class="text-right table_data_product_id">Sub-Total</td>
               @if(in_array('batch_no',$activeColumn))
               {{-- <td class="text-right table_data_batch_no"><span class="sub_total_batch_no"></span></td> --}}
               @endif
               @if(in_array('pack_size',$activeColumn))
               <td class="text-right table_data_pack_size"><span class="sub_total_pack_size">@php echo number_format($tpsize,2); @endphp</span></td>
               @endif

               @if(in_array('pack_no',$activeColumn))
               <td class="text-right pack_no"><span class="sub_total_pack_no">@php echo number_format($tpno,2); @endphp </span></td>
               @endif

               <td class="text-right table_data_quantity"><span class="sub_data_quantity">@php echo number_format($tqty,2); @endphp</span></td>
               <td class="text-right table_data_remaining"><span class="sub_data_remaining">@php echo number_format($rqty,2); @endphp</span></td>
               <td class="text-right table_data_return"><span class="sub_data_return">0.00</span></td>
               <td class="text-right table_data_unit_price"><span class="sub_data_unit_price">0.00</span></td>
               <td class="text-right table_data_deduction"><span class="sub_data_deduction">0.00</span></td>
               <td class="text-right table_data_total_price"><span class="sub_data_total_price">0.00</span></td>
            </tr>
            <tr>
               <td class="grand_total text-right" colspan="@php helper::getColspan($activeColumn,4);@endphp">Sub Total:</td>
               <td><input  type="text" readonly="" id="sub_total" class="form-control subTotal" value="" name="sub_total" placeholder="0.00"></td>
            </tr>
           
            <tr>
               <td class="grand_total text-right" colspan="@php helper::getColspan($activeColumn,4);@endphp">Deduction Amount (-):</td>
               <td><input  type="text" id="deduction_amount" readonly class="form-control deduction_amount decimal" value="" name="deduction_amount" placeholder="0.00"></td>
            </tr>
            <tr>
               <td class="grand_total text-right" colspan="@php helper::getColspan($activeColumn,4);@endphp">Grand Total:</td>
               <td><input  type="text" id="grand_total" readonly="" class="form-control grandTotal" value="" name="grand_total" placeholder="0.00"></td>
            </tr>
            <tr>
               <td class="grand_total text-right" colspan="@php helper::getColspan($activeColumn,4);@endphp">Payment:</td>
               <td><input  type="text" id="paid_amount" class="form-control payment" value="" name="paid_amount" placeholder="0.00"></td>
            </tr>
            <tr>
               <td class="note" colspan="@php helper::getColspan($activeColumn,4);@endphp"><textarea  name="note" rows="4" placeholder="Type Note Here..."></textarea></td>
            </tr>
         </tfoot>
      </table>
   </div>
<script>
  $('.select2').select2();
   $('tfoot,tbody').delegate('input.return_quantity,input.deduction', 'keyup', function() {
           var tr = $(this).closest('tr');
           var return_quantity = Number(tr.find('input.return_quantity').val()-0);
           var deduction = Number(tr.find('input.deduction').val()-0);
           var remaining_quantity = Number(tr.find('input.remaining_quantity').val()-0);
           var unit_price = Number(tr.find('input.unit_price').val()-0);

           if(return_quantity > remaining_quantity){
               tr.find('input.return_quantity').val(remaining_quantity);
               Swal.fire('Warning!', "Approved QTY can't greater than from main qty", 'warning');  
           }
          var deducAmount = (unit_price/100)*deduction;
          console.log(deducAmount);
          tr.find('input.deduction_percen_amount').val(deducAmount*return_quantity.toFixed(2));
          tr.find('input.total_price').val(unit_price*return_quantity);
           $(this).removeClass("border border-danger");
           $(this).addClass("border border-success");
           calculation();
   });

   function calculation() {
         var total_return_quantity = 0;
         var total_deduction = 0;
         var total_price_amount = 0;
         var total_deduction_percentage_amount = 0;
         $('.return_quantity').each(function(i, e) {
            var return_quantity = parseFloat($(this).val() - 0);
            total_return_quantity += return_quantity;
         });

         if(total_return_quantity > 0){
            $(".sbtn").show();
            $(".sbtn").attr('disabled',false);
           
         }else{
            $(".sbtn").hide();
         }


         $('.sub_data_return').text(total_return_quantity);

         $('.total_price').each(function(i, e) {
            var total_price = parseFloat($(this).val() - 0);
            total_price_amount += total_price;
         });
         
         $('.sub_data_total_price').text(total_price_amount.toFixed(2));

         $('.deduction').each(function(i, e) {
            var deduction = parseFloat($(this).val() - 0);
            total_deduction += deduction;
         });
         var deductionPercen = total_deduction.toFixed(2);

         $('.sub_data_deduction').text(deductionPercen+' %  ');

         $('.deduction_percen_amount').each(function(i, e) {
            var deduction_percent = parseFloat($(this).val() - 0);
            total_deduction_percentage_amount += deduction_percent;
         });

         $('#deduction_amount').val(total_deduction_percentage_amount.toFixed(2));
         $('#sub_total').val(total_price_amount.toFixed(2));
         $('#grand_total').val((total_price_amount-total_deduction_percentage_amount).toFixed(2));
         $('#paid_amount').val((total_price_amount-total_deduction_percentage_amount).toFixed(2));
   }

   
$(document).on('change', '.payment_type', function() {
   let payment_type = $(this).val();
   if(payment_type == 'Cash'){
       $('.div_account_id').removeClass("hide");
       $('.div_bank_id').addClass('hide');
   }else if(payment_type == 'Credit'){
       $('.div_account_id').addClass("hide");
       $('.div_bank_id').addClass("hide");
   }else{
       $('.div_account_id').addClass("hide");
       $('.div_bank_id').removeClass("hide");
   }  

});
</script>
@else 

<div class="alert alert-danger">
   <strong>Warning !</strong>Sorry Purchases return not found!.
 </div>
@endif

  
