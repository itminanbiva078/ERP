
<?php

$accessRoute = array(
    'inventoryTransaction.purchases.create',
    'inventoryTransaction.purchases.edit',
    'salesTransaction.sales.create',
    'salesTransaction.sales.edit',
    'salesTransaction.salesLoan.create',
    'salesTransaction.salesLoan.edit',
    'inventoryTransaction.transfer.create',
    'inventoryTransaction.transfer.edit',
    'inventoryTransaction.inventoryAdjustment.create',
    'inventoryTransaction.inventoryAdjustment.edit',

);


$transferRoute = array(
    'inventoryTransaction.transfer.create',
    'inventoryTransaction.transfer.edit',
);

$saleLoanRoute = array(
    'salesTransaction.salesLoan.create',
    'salesTransaction.salesLoan.edit',
);

$notificationRoute = array(

    'inventoryTransaction.purchases.create',
    'inventoryTransaction.purchases.edit',
    'salesTransaction.sales.create',
    'salesTransaction.sales.edit',
);

$accessSaleTransRoute = array(
    'salesTransaction.sales.create',
    'salesTransaction.sales.edit',
    'salesTransaction.salesLoan.create',
    'salesTransaction.salesLoan.edit',
    'inventoryTransaction.transfer.create',
    'inventoryTransaction.transfer.edit',
    'inventoryTransaction.inventoryAdjustment.create',
    'inventoryTransaction.inventoryAdjustment.edit',
);

$saleRoute = array(
    'salesTransaction.sales.create',
    'salesTransaction.sales.edit',
    'salesTransaction.salesQuatation.create',
    'salesTransaction.salesQuatation.edit',
);

$mrrRoute = array(
    'inventoryTransaction.purchasesMRR.create',
    'inventoryTransaction.purchasesMRR.edit',
);


?>
<div class="row">
    <div class="table-responsive">
    <table class="table table-bordered table-hover" id="show_item">
        @if(Route::currentRouteName() == "inventoryTransaction.purchasesMRR.create")
        <thead id="thead" class="bg-default" style="display: none!important">
        @else
        <thead class="bg-default">
        @endif
            <tr>
                @if(!empty($formInputDetails))
                    @foreach($formInputDetails as $key => $eachInput)

                        @if($eachInput->name == 'product_id')
                           <th @if(count($formInputDetails) >= 5) width="20%" @else   @endif>{{ucfirst($eachInput->label)}}</th>
                        @elseif($eachInput->name == 'batch_no')
                            @if(helper::mrrIsActive() ||  Route::currentRouteName() == "openingSetup.inventory.create")
                           <th  width="15%" class="text-left">{{ucfirst($eachInput->label)}}</th>
                           @endif
                        @elseif($eachInput->name == 'quantity')
                            @if(in_array(Route::currentRouteName(),$saleRoute))
                              <th @if($eachInput->type == 'tnumber') class="text-left" @endif>Sales {{ucfirst($eachInput->label)}}</th>
                            @elseif(in_array(Route::currentRouteName(),$transferRoute))
                            <th @if($eachInput->type == 'tnumber') class="text-left" @endif>Transfer  {{ucfirst($eachInput->label)}}</th>
                            @else
                            <th @if($eachInput->type == 'tnumber') class="text-left" @endif>Purchases {{ucfirst($eachInput->label)}}</th>

                            @endif
                        @else
                           <th @if($eachInput->type == 'tnumber') class="text-left" @endif>{{ucfirst($eachInput->label)}}</th>
                        @endif
                    @endforeach
                @endif
                <th width="1%">Action</th>
            </tr>
        </thead>



        <tbody>
            @if(!empty($invoiceDetails))
            @foreach($invoiceDetails as $ekey => $value)
            <tr class="new_item<?php echo $ekey + 99; ?>">
                @if(in_array('product_id',$activeColumn))
                <td>
                    <select name="product_id[]" class="form-control product_id select2 " id=""
                        placeholder="Type Product">
                        <option value="" selected="" disabled="" data-select2-id="55">(:-Select Product -:)</option>
                        @foreach($products as $key => $product)
                        <option @if($value->product_id == $product->id) selected @endif
                            value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                    </select>
                </td>
                @endif

                @if(in_array('batch_no',$activeColumn))
                @if(helper::mrrIsActive() ||  Route::currentRouteName() == "openingSetup.inventory.create")
                <td>
                    @if(in_array(Route::currentRouteName(),$saleRoute))
                    <input type="hidden" value="" class="old_stock_value"/>
                        <select name="batch_no[]" class="form-control batch_no select2" id=""  placeholder="Search Batch">
                            <option value="" selected="" disabled="" data-select2-id="55">(:- Search Batch -:)</option>
                                @foreach($products as $key => $product)
                                <option @if($value->product_id == $product->id) selected @endif
                                    value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                        </select>
                        @else
                        <input type="text" name="batch_no[]" class="form-control batch_no border-success border" id=""  placeholder="Batch No" value="{{ $value->batch_no}}">

                        @endif

                    </td>
                @endif
                @endif

                @if(in_array('pack_size',$activeColumn))
                <td><input type="number" required=""  name="pack_size[]"  class="form-control pack_size decimal border border-success" id="" placeholder="Pack Size"  value="{{$value->pack_size}}"></td>
                @endif

                @if(in_array('pack_no',$activeColumn))
                <td><input type="number" required=""  name="pack_no[]"
                        class="form-control pack_no decimal border-success border" id="" placeholder="Pack No."
                        value="{{$value->pack_no}}"></td>
                @endif
                @if(in_array('quantity',$activeColumn))
                <td><input type="number" required=""  name="quantity[]"   class="form-control quantity decimal" id="" placeholder="Quantity" value="{{$value->quantity}}"   readonly="readonly"> </td>
                @endif

                @if(in_array('remaining_quantity',$activeColumn))
                <td><input type="number" required=""  name="remaining_quantity[]" class="form-control remaining_quantity decimal" id="" placeholder="Remaining Quantity" value="{{$value->quantity - $value->approved_quantity}}" readonly="readonly">
                </td>
                @endif

                @if(in_array('approved_quantity',$activeColumn))
                <td><input type="number" required=""  name="approved_quantity[]" class="form-control approved_quantity decimal" id="" placeholder="Approved Quantity" value="{{$value->approved_quantity}}" readonly="readonly">
                </td>
                @endif

                @if(in_array('unit_price',$activeColumn))
                <td><input type="number" required=""  name="unit_price[]"
                        class="form-control unit_price decimal border border-success" id="" placeholder="Unit Price"
                        value="{{$value->unit_price}}"></td>
                @endif

                @if(in_array('total_price',$activeColumn))
                <td><input type="number" required=""  name="total_price[]" readonly=""
                        class="form-control total_price decimal" id="" placeholder="Total Price"
                        value="{{$value->total_price}}"></td>
                @endif

                <td class="text-center"><button del_id="<?php echo $ekey + 99; ?>" class="delete_item btn btn-danger"
                        type="button" href="javascript:;" title="Are you Remove?"><i class="fa fa-minus"></i></button>
                </td>
            </tr>

            @endforeach
            @endif

            @if(Route::currentRouteName() !== "inventoryTransaction.purchasesMRR.create")

            <tr class="new_item1">
                <input type="hidden" value="" class="old_stock_value"/>
                @foreach($formInputDetails as $key => $eachInput)

                    @if($eachInput->name == 'batch_no')
                        @if(helper::mrrIsActive() ||  Route::currentRouteName() == "openingSetup.inventory.create")
                          <td>@php htmlform::formfiled($eachInput, $errors, old()) @endphp</td>
                        @endif
                    @else
                         <td>@php htmlform::formfiled($eachInput, $errors, old()) @endphp</td>
                    @endif



                @endforeach
                <td class="text-center"><button del_id="1" class="delete_item btn btn-danger" type="button"   href="javascript:;" title="Are you Remove?"><i class="fa fa-minus"></i></button></td>

            </tr>

           @endif
        </tbody>
        @if(Route::currentRouteName() == "inventoryTransaction.purchasesMRR.create")
        <tfoot id="tfoot" style="display: none!important">
        @else
        <tfoot>
        @endif

            <tr>
                <input type="hidden" value="" class="old_stock_value"/>
                @foreach($formInputDetails as $key => $eachInput)

                    @if($eachInput->name == "batch_no")
                        @if(helper::mrrIsActive() ||  Route::currentRouteName() == "openingSetup.inventory.create")
                        <td class="text-left table_data_{{$eachInput->name}}"><span class="sub_total_{{$eachInput->name}}">0.00</span></td>
                        @endif
                    @else
                    <td class="text-left table_data_{{$eachInput->name}}"><span class="sub_total_{{$eachInput->name}}">0.00</span></td>
                    @endif

                @endforeach

                <td nowrap class="text-center"><button id="add_item" class="btn btn-success" type="button"  title="Add new Item"><i class="fa fa-plus"></i></button></td>

            </tr>


            @if(in_array(Route::currentRouteName(),$accessRoute) &&  !in_array(Route::currentRouteName(),$transferRoute) && !in_array(Route::currentRouteName(), $saleLoanRoute))

                <tr>
                    <td class="grand_total text-right "  colspan="6">Sub Total:</td>
                    <td><input  type="text" readonly id="sub_total" class="form-control subTotal"
                        value="{{$editInfo->subtotal ?? ''}}" name="sub_total" placeholder="0.00">
                    </td>
                </tr>
                <tr>
                    <td class="grand_total text-right" colspan="6">Discount:</td>
                    <td><input  type="text" id="discount" class="form-control discount decimal"
                            value="{{$editInfo->discount ?? ''}}" name="discount" placeholder="0.00"></td>
                </tr>
                <tr>
                    <td class="grand_total text-right" colspan="6">Grand Total:</td>
                    <td><input  type="text" id="grand_total" readonly class="form-control grandTotal"
                            value="{{$editInfo->grand_total ?? ''}}" name="grand_total" placeholder="0.00"></td>
                </tr>

                
                <tr class="div_payment" style="display: none!important">
                    <td class="grand_total text-right" colspan="6">Available Balance:</td>
                    <td><input  type="text" id="accountBalance" class="form-control accountBalance" readonly  name="accountBalance" placeholder="0.00"></td>
                </tr>

                <tr class="div_payment" style="display: none!important">
                    <td class="grand_total text-right" colspan="6">Payment:</td>
                    <td><input  type="text" id="paid_amount" class="form-control payment"  value="{{$editInfo->paid_amount ?? ''}}" name="paid_amount" placeholder="0.00"></td>
                </tr>

               

                <tr class="div_payment" style="display: none!important">
                    <td class="grand_total text-right" colspan="6">Present Due:</td>
                    <td><input  type="text" id="due_amount" class="form-control" readonly  value="{{$editInfo->due_amount ?? ''}}" name="due_amount" placeholder="0.00"></td>
                </tr>

            @endif
            @if(in_array(Route::currentRouteName(),$notificationRoute))

            <tr>
                <td class="check-information" style="border:0; padding:5px !important; ">

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                        <label class="form-check-label" for="inlineCheckbox1"> <i class="far fa-comment-dots"></i> sms </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                        <label class="form-check-label" for="inlineCheckbox2"> <i class="far fa-envelope"></i> email </label>
                    </div>

                </td>
            </tr>
            @endif

            <tr>
                <td colspan="8" class="note"><textarea class="summernote"  name="note" rows="4" colspan="6" placeholder="Type Note Here...">{{$editInfo->note ?? ''}}</textarea></td>
            </tr>
        </tfoot>
    </table>
    </div>
</div>





@section('scripts')
<script>

$(document).ready(function() {

    setTimeout(function() {
        calculation();
    }, 1000);

    let totalColumn = document.getElementById('show_item').rows[0].cells.length;
    setTimeout(function() {
        if ($(".pack_size")[0] && $(".pack_no")[0]) {
            $('.quantity').attr('readonly', true);
        }
    }, 1000);

    if ($(".batch_no")[0]) {
        $('.table_data_batch_no').remove();
        $('.table_data_product_id').attr('colspan', 2);
    }
    $('.table_data_product_id').text('Sub-Total');
    $('.table_data_product_id').addClass('text-right');
    if (totalColumn == 8) {
        $('.grand_total').attr('colspan', 6);
        $('.note').attr('colspan', 7);
    } else if (totalColumn == 7) {
        $('.grand_total').attr('colspan', 5);
        $('.note').attr('colspan', 6);
    } else if (totalColumn == 6) {
        $('.grand_total').attr('colspan', 4);
        $('.note').attr('colspan', 5);
    } else if (totalColumn == 5) {
        $('.grand_total').attr('colspan', 3);
        $('.note').attr('colspan', 4);
    } else {

    }

    let j = 2;

    $("#add_item").click(function() {
     $("#show_item tbody").append('<tr  style="white-space: nowrap!important;" class="new_item' + j +'">' +
            '<input type="hidden" value="" class="old_stock_value"/>'
            <?php if(in_array(Route::currentRouteName(),$mrrRoute)): ?>
            +  '<input type="hidden"   class="form-control actual_remaining_quantity decimal"  placeholder="Remaining" value="">'+
            '<input type="hidden"  class="form-control product_id" value="" name="product_id[]">'
            <?php endif;?>
            <?php foreach ($formInputDetails as $key => $eachInput) :
                    if($eachInput->name == 'batch_no' ):
                        if(helper::mrrIsActive() ||  Route::currentRouteName() == "openingSetup.inventory.create"):
                            ?> +
                            '<td><?php trim(htmlform::formfiled($eachInput, $errors, old())); ?></td>'
                        <?php
                        endif;
                        else:
                        ?>+
            '<td><?php trim(htmlform::formfiled($eachInput, $errors, old())); ?></td>'
            <?php

             endif;

            endforeach; ?> +
            '<td class="text-center"><button del_id="' + j +'" class="delete_item btn btn-danger" type="button"  title="Remove This Item"><i class="fa fa-minus"></i></button></td></tr>'
        );

        j++;



        $('.select2').select2();
        if ($(".pack_size")[0]) {
            $('.quantity').attr('readonly', true);
        }
        $(".decimal").on("click", function() {
            $(this).select();
        });


        <?php if(in_array(Route::currentRouteName(),$mrrRoute)): ?>
            var tr =  $('#show_item tbody tr:last').closest('tr');
            $('select.product_id').prop('disabled', true);
            tr.find('select.product_id').prop('disabled', false);
            var checkValue = tr.find('.product_id').val();
            tr.find('.product_id').empty().trigger("change");
            $('.remaining_quantity').prop('readonly', true);
            $('.remaining_quantity').prop('readonly', true);
            $('.approved_quantity').prop('readonly', true);
            $('.pack_size').prop('readonly', true);
            $('.pack_no').prop('readonly', true);
            $('.delete_item').prop('disabled', true);
            var firstOption = new Option('(:- Select Product -:)', null, false, false);
                        // Append it to the select
                $('.product_id').append(firstOption);
                $(".product_id").each(function(){
                    var existing_product_id = $(this).val();
                    var existing_product_name = $(this).attr('pname');
                    var newOption = new Option(existing_product_name, existing_product_id, false, false);
                    // Append it to the select
                    tr.find('.product_id').append(newOption);
                });


        <?php endif;?>
        const $selects = $(".product_id");
        const selectedValue = [];
        $("#store_id").trigger("keyup");


        $selects.find(':selected').filter(function(idx, el) {
            return $(el).attr('value');
        }).each(function(idx, el) {
            selectedValue.push($(el).attr('value'));
        });
        // loop all the options
        $selects.find('option').each(function(idx, option) {
            // if the array contains the current option value otherwise we re-enable it.
            if (selectedValue.indexOf($(option).attr('value')) > -1) {
                // if the current option is the selected option, we skip it otherwise we disable it.
                if ($(option).is(':checked')) {
                    return;
                } else {
                // $(this).attr('disabled', true);
                }
            } else {
            // $(this).attr('disabled', false);
            }
        });
});





$(document).on('change', '.product_id', function() {
    const $selects2 = $(".product_id");
    const selectedValue = [];

    <?php if(in_array(Route::currentRouteName(),$mrrRoute)): ?>

            var product_id = $(this).val();
            var allApprovedQty = 0;

            if($(this).val() > 0){
            var remaining_value  = parseFloat($(".mainQuantity_"+$(this).val()).val()-0);
            $(".approved_quantity_"+product_id).each(function(){
                    allApprovedQty += parseFloat($(this).val()-0);
            });
            var pack_size  = $("#pack_size_"+$(this).val()).val();
            var quantity  = $("#quantyty_"+$(this).val()).val();
            $('#pack_no_'+$(this).val()).prop('readonly', true);
               var tr = $(this).closest('tr');

                tr.find('input.product_id').val(product_id);
                tr.find('input.remaining_quantity').val(remaining_value-allApprovedQty);
                tr.find('input.actual_remaining_quantity').val(remaining_value-allApprovedQty);
                tr.find('input.pack_size').val(pack_size);
                tr.find('input.pack_no').val('');
                tr.find('input.pack_no').prop('readonly', false);
                tr.find('button.delete_item').prop('disabled', false);
                tr.find('input.quantity').val(quantity);
                tr.find('input.approved_quantity').removeClass("approved_quantity_"+product_id );
                tr.find('input.approved_quantity').addClass("approved_quantity_"+product_id );

            }

    <?php endif;?>

    // get all selected options and filter them to get only options with value attr (to skip the default options). After that push the values to the array.
    $selects2.find(':selected').filter(function(idx, el) {
        return $(el).attr('value');
    }).each(function(idx, el) {
        selectedValue.push($(el).attr('value'));
    });
    // loop all the options
    $selects2.find('option').each(function(idx, option) {
        // if the array contains the current option value otherwise we re-enable it.
        if (selectedValue.indexOf($(option).attr('value')) > -1) {
            // if the current option is the selected option, we skip it otherwise we disable it.
            if ($(option).is(':checked')) {
                return;
            } else {
               // $(this).attr('disabled', true);
            }
        } else {
           // $(this).attr('disabled', false);
        }
    });


});

 $('tbody,tfoot').delegate(
        'input.product_id,input.discount,input.batch_no,input.pack_size,input.pack_no,input.quantity,input.unit_price,input.total_price,input.approved_quantity',
        'keyup',
        function() {
            var tr = $(this).closest('tr');
            var product_id = tr.find('input.product_id').val();
            var batch_no = tr.find('input.batch_no').val();
            var pack_size = Number(tr.find('input.pack_size').val());
            var pack_no = Number(tr.find('input.pack_no').val());
            var old_stock_value = Number(tr.find('input.old_stock_value').val());

            <?php if(in_array(Route::currentRouteName(),$mrrRoute)): ?>


                    if ($(".pack_size ")[0]) {
                        tr.find('input.approved_quantity').val(pack_size * pack_no);
                        var quantity = Number(pack_size * pack_no);
                    } else {
                        var quantity = Number(tr.find('input.quantity').val());
                    }
                    var approved_quantity = Number(tr.find('input.approved_quantity').val()-0);
                    var remaining_quantity = Number(tr.find('input.actual_remaining_quantity').val()-0);

                    tr.find('input.remaining_quantity').val(remaining_quantity-approved_quantity);

                    if(approved_quantity > remaining_quantity){
                        tr.find('input.approved_quantity').val(0);
                        tr.find('input.remaining_quantity').val(remaining_quantity);
                        tr.find('input.pack_no').val(0);
                        Swal.fire('Warning!', "Approved QTY can't greater than from main qty="+remaining_quantity, 'warning');
                    } 



            <?php else: ?>


                        if ($(".pack_size ")[0]) {
                            tr.find('input.quantity').val(pack_size * pack_no);
                            var quantity = Number(pack_size * pack_no);
                        } else {
                            var quantity = Number(tr.find('input.quantity').val());
                        }

                        var approved_quantity = Number(tr.find('input.approved_quantity').val());
                        var remaining_quantity = Number(tr.find('input.actual_remaining_quantity').val());
                        tr.find('input.remaining_quantity').val(remaining_quantity-approved_quantity);

                        if(approved_quantity > remaining_quantity){
                            tr.find('input.approved_quantity').val(0);
                            tr.find('input.remaining_quantity').val(remaining_quantity);
                            tr.find('input.pack_no').val(0);
                            Swal.fire('Warning!', "Approved QTY can't greater than from main qty="+remaining_quantity, 'warning');
                        }


           <?php endif; ?>

            var unit_price = Number(tr.find('input.unit_price').val());
            var total_price = Number(tr.find('input.total_price').val());
            var totalPrice = quantity * unit_price;
            tr.find('input.total_price').val(totalPrice);

            <?php if(in_array(Route::currentRouteName(),$accessSaleTransRoute)): ?>
           //check only for sales
            if( quantity > old_stock_value){
                tr.find('input.quantity').val(0);
                tr.find('input.pack_no').val(0);

                Swal.fire('Warning!', "Quantity should be less than = "+ old_stock_value, 'warning');
            }
          <?php endif;?>

            if (total_price > 0) {
                tr.find('input.total_price').removeClass("border border-danger");
                tr.find('input.total_price').addClass("border border-success");
            }
            $(this).removeClass("border border-danger");
            $(this).addClass("border border-success");

            calculation();
        });


    function calculation() {
        var total_pack_size = 0;
        var total_pack_no = 0;
        var total_quantity = 0;
        var total_total_price = 0;
        var total_approved_quantity = 0;
        var total_remaining_quantity = 0;


        $('.pack_size').each(function(i, e) {

            var pack_size = parseFloat($(this).val() - 0);
            total_pack_size += pack_size;
        });

        $('.pack_no').each(function(i, e) {
            var pack_no = parseFloat($(this).val() - 0);
            total_pack_no += pack_no;
        });

        $('.quantity').each(function(i, e) {
            var quantity = parseFloat($(this).val() - 0);
            total_quantity += quantity;
        });

        $('.total_price').each(function(i, e) {
            var total_price = parseFloat($(this).val() - 0);
            total_total_price += total_price;
        });
        $('.approved_quantity').each(function(i, e) {
            var approved_quantity = parseFloat($(this).val() - 0);
            total_approved_quantity += approved_quantity;
        });

        var subTotal = total_total_price - 0;
        var discount = parseFloat($('.discount').val() - 0);
        var grandTotal = subTotal - discount;


        $('.sub_total_pack_size').text(numberFormat(total_pack_size));
        $('.sub_total_pack_size').text(numberFormat(total_pack_size));
        $('.sub_total_pack_no').text(numberFormat(total_pack_no));
        $('.sub_total_approved_quantity').text(numberFormat(total_approved_quantity));
        $('.sub_total_remaining_quantity').text(numberFormat(total_remaining_quantity));
        $('.sub_total_quantity').text(numberFormat(total_quantity));
        $('.table_data_total_price').text(numberFormat(total_total_price));
        $("#paid_amount").trigger("keyup");
        $('.subTotal').val(total_total_price);
        $('.grand_total').val(grandTotal);
        $('#grand_total').val(grandTotal);


    }

    $(document).on('click', '.delete_item', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let totalRow = $('.batch_no').length
                if (totalRow == 1) {
                    Swal.fire('Warning!', "There only one row you can't delete", 'warning');
                } else {
                    let id = $(this).attr("del_id");
                    $('.new_item' + id).remove();
                    calculation();
                    Swal.fire('Successs!', 'You are remove one item!.', 'success');
                }

            }
        })
    });

});




// $(document).on('change', '.sproduct_id', function() {

//             var tr = $(this).closest('tr');
//             var product_id = tr.find('.product_id').val();

//             $.ajax({
//                 url: "{{route('salesTransaction.sales.batch')}}",
//                 method: 'GET',
//                 data: {
//                     product_id: product_id
//                 },
//                 success: function(data) {
//                     if (data) {
//                         $('.select2').select2();
//                         let select = tr.find('.batch_no');
//                         select.empty();
//                         select.append('<option value="0" selected> (:-Select Batch-:) </option>');
//                         $.each(data.data, function(key, value) {
//                             select.append('<option value=' + value.batch.id + '>' + value.batch.name + '</option>');
//                         });
//                     }
//                 }
//         });
//     });

//     $(document).on('change', '.sproduct_id', function() {
//             var tr = $(this).closest('tr');
//             var product_id = tr.find('.product_id').val();

//             $.ajax({
//                 url: "{{route('salesTransaction.salesLoan.batch')}}",
//                 method: 'GET',
//                 data: {
//                     product_id: product_id
//                 },
//                 success: function(data) {
//                     if (data) {
//                         $('.select2').select2();
//                         let select = tr.find('.batch_no');
//                         select.empty();
//                         select.append('<option value="0" selected> (:-Select Batch-:) </option>');
//                         $.each(data.data, function(key, value) {
//                             select.append('<option value=' + value.batch.id + '>' + value.batch.name + '</option>');
//                         });
//                     }
//                 }
//         });
//     });



$(document).on('change', '.requsisition_id', function() {
    let requisition_id = $(this).val();
    $("#show_item tbody").empty();
    $.ajax({
        url: "{{route('inventoryTransaction.purchasesRequisition.detailsInfo')}}",
        method: 'GET',
        data: {
            requisition_id: requisition_id
        },
        success: function(data) {
            if (data) {
                $("#show_item tbody").append(data.html);
                $('.select2').select2();
                if ($(".pack_size")[0]) {
                    $('.quantity').attr('readonly', true);
                }
                $(".decimal").on("click", function() {
                    $(this).select();
                });
                $(".unit_price").trigger("keyup");
                $("#branch_id").val(data.details.branch_id).trigger("change");

            }
        }
    });
});


$(document).on('keyup', '.payment', function() {
    let paymentNow = parseFloat($(this).val()-0);
   var grandTotal =  parseFloat($('#grand_total').val()-0);
   var presentDue = grandTotal - paymentNow;
   $("#due_amount").val(presentDue);

});


$(document).on('change', '.purchases_order_id', function() {
    let order_id = $(this).val();
    $("#show_item tbody").empty();
    $.ajax({
        url: "{{route('inventoryTransaction.purchasesOrder.detailsInfo')}}",
        method: 'GET',
        data: {
            order_id: order_id
        },
        success: function(data) {
            if (data) {

                $("#show_item tbody").append(data.html);
                $('.select2').select2();
                if ($(".pack_size")[0]) {
                    $('.quantity').attr('readonly', true);
                }
                $(".decimal").on("click", function() {
                    $(this).select();
                });
                $(".unit_price").trigger("keyup");

                $("#supplier_id").val(data.details.supplier_id).trigger("change")
                $("#branch_id").val(data.details.branch_id).trigger("change")

            }else{
                $("#supplier_id").val("").trigger("change")
                $("#branch_id").val("").trigger("change")
            }
        }
    });
});


$(document).on('change', '.purchases_id', function() {
    let purchases_id = $(this).val();
    $("#show_item tbody").empty();
    $("#thead").show();
    $("#tfoot").show();
    $("#submitBtn").show();
    $.ajax({
        url: "{{route('inventoryTransaction.purchases.detailsInfo')}}",
        method: 'GET',
        data: {
            purchases_id: purchases_id
        },
        success: function(data) {
            if (data) {

                $("#show_item tbody").append(data.html);
                $('.select2').select2();
                if ($(".pack_size")[0]) {
                    $('.quantity').attr('readonly', true);
                }
                $(".decimal").on("click", function() {
                    $(this).select();
                });
                $(".approved_quantity").trigger("keyup");
            }else{
                $("#thead").hide();
                $("#tfoot").hide();
                $("#submitBtn").hdie();
            }
        }
    });
});



$(document).on('change', '.branch_id,.store_id', function() {
    let branch_id = $('.branch_id').val();
    let store_id = $('.store_id').val();
    var tr = $(this).closest('tr');


    $.ajax({
        url: "{{route('inventorySetup.product.stockInfo')}}",
        method: 'GET',
        data: {
            branch_id: branch_id,
            store_id: store_id,
        },
        success: function(data) {
            if (data.code == 200) {
                <?php if(in_array(Route::currentRouteName(),$accessSaleTransRoute)): ?>
                  tr.find('.unit_price').val(data.data.sprice);

                        $('.select2').select2();
                        let bselect = $('.batch_no');
                        bselect.empty();
                        bselect.append('<option value="0" selected> (:-Select Batch-:) </option>');
                        $.each(data.data, function(key, value) {
                            bselect.append('<option value=' + value.batch_no + '>' + value.bname + '</option>');
                        });

                        var pselect = $('.product_id');
                        pselect.empty();
                        pselect.append('<option value="0" selected> (:-Select Product-:) </option>');
                        $.each(data.data, function(key, value   ) {
                           console.log(value.product_id);
                            pselect.append('<option value=' + value.product_id + '>' + value.pname + '</option>');
                        });


                <?php else: ?>
                tr.find('.unit_price').val(data.data.puprice);
                <?php endif;?>
                $(".unit_price").trigger("keyup");
            }else{

            }
        }
    });
});



$(document).on('keyup', '#store_id', function() {
    let branch_id = $('.branch_id').val();
    let store_id = $('.store_id').val();
   var tr =  $('table tbody tr:last').closest('tr');

    $.ajax({
        url: "{{route('inventorySetup.product.stockInfo')}}",
        method: 'GET',
        data: {
            branch_id: branch_id,
            store_id: store_id,
        },
        success: function(data) {
            if (data.code == 200) {
                <?php if(in_array(Route::currentRouteName(),$accessSaleTransRoute)): ?>
                  tr.find('.unit_price').val(data.data.sprice);

                        $('.select2').select2();

                        let bselect = tr.find('.batch_no');
                        bselect.empty();
                        bselect.append('<option value="0" selected> (:-Select Batch-:) </option>');
                        $.each(data.data, function(key, value) {
                            bselect.append('<option value=' + value.batch_no + '>' + value.bname + '</option>');
                        });

                        var pselect =  tr.find('.product_id');
                        pselect.empty();
                        pselect.append('<option value="0" selected> (:-Select Product-:) </option>');
                        $.each(data.data, function(key, value   ) {
                           console.log(value.product_id);
                            pselect.append('<option value=' + value.product_id + '>' + value.pname + '</option>');
                        });
                <?php else: ?>
                tr.find('.unit_price').val(data.data.puprice);
                <?php endif;?>
                $(".unit_price").trigger("keyup");
            }else{

            }
        }
    });
});




<?php if(in_array(Route::currentRouteName(),$accessRoute)): ?>

$(document).on('change', '.product_id', function() {
    let product_id = $(this).val();
    let branch_id = $('.branch_id').val();
    let store_id = $('.store_id').val();
    var tr = $(this).closest('tr');

    <?php if(in_array(Route::currentRouteName(),$accessSaleTransRoute)): ?>
   var url = "<?php echo route('inventorySetup.product.stockInfo');?>";
   <?php else: ?>
   var url = "<?php echo route('inventorySetup.product.single.info');?>";
   <?php endif;?>


    $.ajax({
        url: url,
        method: 'GET',
        data: {
            product_id: product_id,
            branch_id: branch_id,
            store_id: store_id,
        },
        success: function(data) {
            if (data.code == 200) {
                <?php if(in_array(Route::currentRouteName(),$accessSaleTransRoute)): ?>

                        <?php if(helper::mrrIsActive()): ?>

                            $('.select2').select2();
                            let bselect = tr.find('.batch_no');
                            bselect.empty();
                            bselect.append('<option value="0" selected> (:-Select Batch-:) </option>');
                            $.each(data.data, function(key, value) {
                                bselect.append('<option value=' + value.batch_no + '>' + value.bname + '</option>');
                            });

                            <?php else: ?>

                            tr.find('.old_stock_value').val(data.data.quantity);
                            tr.find('.unit_price').val(data.data.sprice);

                            <?php endif; ?>

                <?php else: ?>
                tr.find('.unit_price').val(data.data.purchases_price);
                <?php endif;?>
                $(".unit_price").trigger("keyup");
            }else{
               //login implement later
            }
        }
    });
});


$(document).on('change', '.batch_no', function() {

var tr = $(this).closest('tr');
var batch_no = tr.find('.batch_no').val();
var product_id = tr.find('.product_id').val();
var branch_id = $('.branch_id').val();
var store_id = $('.store_id').val();
$.ajax({
    url: "{{route('inventorySetup.product.stockInfo')}}",
    method: 'GET',
    data: {
        batch_no: batch_no,
        product_id: product_id,
        branch_id: branch_id,
        store_id: store_id,
    },
    success: function(data) {
        if (data.code == 200) {

            console.log(data.data);
            tr.find('.old_stock_value').val(data.data[0].quantity);
            tr.find('.unit_price').val(data.data[0].sprice);
            tr.find('.pack_size').val(data.data[0].pack_size);
        }
    }
});
});

<?php endif;?>

$(document).on('change', '.sales_id', function() {
    let sales_id = $(this).val();
    $("#show_item tbody").empty();
    $.ajax({
        url: "{{route('salesTransaction.sales.detailsInfo')}}",
        method: 'GET',
        data: {
            sales_id: sales_id
        },
        success: function(data) {
            if (data) {

                $("#show_item tbody").append(data.html);
                $('.select2').select2();
                if ($(".pack_size")[0]) {
                    $('.quantity').attr('readonly', true);
                }
                $(".decimal").on("click", function() {
                    $(this).select();
                });
                $(".unit_price").trigger("keyup");
            }
        }
    });
});


$(document).on('change', '.sales_quatation_id', function() {
    let sales_quatation_id = $(this).val();
    $("#show_item tbody").empty();
    $.ajax({
        url: "{{route('salesTransaction.salesQuatation.detailsInfo')}}",
        method: 'GET',
        data: {
            sales_quatation_id: sales_quatation_id
        },
        success: function(data) {
            if (data) {

                $("#show_item tbody").append(data.html);

                $('.select2').select2();
                if ($(".pack_size")[0]) {
                    $('.quantity').attr('readonly', true);
                }
                $(".decimal").on("click", function() {
                    $(this).select();
                });
                $(".unit_price").trigger("keyup");
            }
        }
    });
});





$('.from_branch').change(function() {
    var from_branch = $(this).val();
    //$('.to_branch  option[value="'+from_branch +'"]').prop('disabled', true);
});


// report-section js

function tableToTree(table_Selector, tr_OpenedClass, tr_VisibleClass, tr_ToggleButton) {

// Table elements variables
var table = document.querySelector(table_Selector);
var trs = document.querySelectorAll(table_Selector + " tr");

// Add the buttons above the table
var buttons = document.createElement('div');
buttons.innerHTML = '<button>[‒] All</button><button>[+] All</button>';
table.insertBefore(buttons, table.childNodes[0]);
buttons = buttons.querySelectorAll('button');
// Add the actions of these buttons
buttons[0].addEventListener("click", function() {
  trs.forEach(function(elm) {
    elm.classList.remove(tr_OpenedClass);
    elm.classList.remove(tr_VisibleClass);
  });
});
buttons[1].addEventListener("click", function() {
  trs.forEach(function(elm) {
    if (elm.innerHTML.includes(tr_ToggleButton))
      elm.classList.add(tr_OpenedClass);
    elm.classList.add(tr_VisibleClass);
  });
});

// Next tr function
function nextTr(row) {
  while ((row = row.nextSibling) && row.nodeType != 1);
  return row;
}

// On creation, automatically add toggle buttons if the tr has childs elements
trs.forEach(function(tr, index) {
  if (index < trs.length - 1) {
    if (+tr.getAttribute("level") < +trs[index + 1].getAttribute("level")) {
      var elm1 = tr.firstElementChild;
      elm1.innerHTML = tr_ToggleButton + elm1.innerHTML;
    }
  }
});

// Use the buttons added by the function above
table.addEventListener("click", function(e) {

  // Event management
  if (!e) return;
  if (e.target.outerHTML !== tr_ToggleButton) return;
  e.preventDefault();

  // Get the parent tr and its level
  var row = e.target.closest("tr");
  row.classList.toggle(tr_OpenedClass);
  var lvl = +(row.getAttribute("level"));

  // Loop to make childs visible/hidden
  while ((row = nextTr(row)) && ((+(row.getAttribute("level")) == (lvl + 1)) || row.className.includes(tr_VisibleClass))) {
    row.classList.remove(tr_OpenedClass);
    row.classList.toggle(tr_VisibleClass);
  }
});

}
/* ---- </ MAIN FUNCTION > ---- */

// Call the above main function to make the table tree-like
tableToTree('#balanceSheet', 'opened', 'visible', '<span class="toggle"></span>');

</script>
@endsection
