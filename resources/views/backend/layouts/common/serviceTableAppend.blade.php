


<?php 
$accessRoute = array(
    'serviceTransaction.serviceInvoice.create',
    'serviceTransaction.serviceInvoice.edit',
   
);

?>

<div class="row">
    <table class="table table-bordered table-hover" id="show_item">
        <thead class="bg-default">
            <tr>
                @foreach($formInputDetails as $key => $eachInput)
                @if($eachInput->name == 'service_id')
                <th @if(count($formInputDetails) >= 5) width="25%" @else   @endif>{{ucfirst($eachInput->label)}}</th>
                @else
                <th @if($eachInput->type == 'tnumber') class="text-left" @endif>{{ucfirst($eachInput->label)}}</th>
                @endif
                @endforeach
                <th width="1%">Action</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($invoiceDetails))
            @foreach($invoiceDetails as $key => $value)
            <tr class="new_item<?php echo $key + 99; ?>">
                @if(in_array('service_id',$activeColumn))
                <td>
                    <select name="service_id[]" class="form-control service_id select2 " id=""
                        placeholder="Type Service">
                        <option value="" selected="" disabled="" data-select2-id="55">(:-Select Service-:)</option>
                        @foreach($services as $key => $service)
                        <option @if($value->service_id == $service->id) selected @endif
                            value="{{$service->id}}">{{$service->name}}</option>
                        @endforeach
                    </select>
                </td>
                @endif
                
                @if(in_array('batch_no',$activeColumn))
                <td><input type="text" name="batch_no[]" class="form-control batch_no border-success border" id=""
                        placeholder="Batch No" value="{{ $value->batch_no}}"></td>
                @endif

                @if(in_array('pack_size',$activeColumn))
                <td><input type="number" required=""  name="pack_size[]"
                        class="form-control pack_size decimal border border-success" id="" placeholder="Pack Size"
                        value="{{$value->pack_size}}"></td>
                @endif

                @if(in_array('pack_no',$activeColumn))
                <td><input type="number" required=""  name="pack_no[]"
                        class="form-control pack_no decimal border-success border" id="" placeholder="Pack No."
                        value="{{$value->pack_no}}"></td>
                @endif

                @if(in_array('quantity',$activeColumn))
                <td><input type="number" required=""  name="quantity[]"
                        class="form-control quantity decimal" id="" placeholder="Quantity" value="{{$value->quantity}}"
                        readonly="readonly">
                </td>
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

                <td class="text-center"><button del_id="<?php echo $key + 99; ?>" class="delete_item btn btn-danger"
                        type="button" href="javascript:;" title="Are you Remove?"><i class="fa fa-minus"></i></button>
                </td>
            </tr>

            @endforeach
            @endif

            <tr class="new_item1">
                @foreach($formInputDetails as $key => $eachInput)
                <td> @php htmlform::formfiled($eachInput, $errors, old()) @endphp</td>
                @endforeach
                <td class="text-center"><button del_id="1" class="delete_item btn btn-danger" type="button"
                        href="javascript:;" title="Are you Remove?"><i class="fa fa-minus"></i></button></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                @foreach($formInputDetails as $key => $eachInput)
                <td class="text-right table_data_{{$eachInput->name}}"><span
                        class="sub_total_{{$eachInput->name}}">0.00</span></td>
                @endforeach
                <td nowrap class="text-center"><button id="add_item" class="btn btn-success" type="button"
                        title="Add new Item"><i class="fa fa-plus"></i></button></td>
            </tr>
           

            @if(in_array(Route::currentRouteName(),$accessRoute))

            <tr>
            <td class="grand_total text-right">Sub Total:</td>
            <td><input  type="text" readonly id="sub_total" class="form-control subTotal"
                    value="{{$editInfo->subtotal ?? ''}}" name="sub_total" placeholder="0.00"></td>
            </tr>
                    <tr>
                        <td class="grand_total text-right">Discount:</td>
                        <td><input  type="text" id="discount" class="form-control discount decimal"
                                value="{{$editInfo->discount ?? ''}}" name="discount" placeholder="0.00"></td>
                    </tr>
                    <tr>
                        <td class="grand_total text-right">Grand Total:</td>
                        <td><input  type="text" id="grand_total" readonly class="form-control grandTotal"
                                value="{{$editInfo->grand_total ?? ''}}" name="grand_total" placeholder="0.00"></td>
                    </tr>

                    <tr>
                        <td class="grand_total text-right">Payment:</td>
                        <td><input  type="text" id="paid_amount" class="form-control payment"
                                value="{{$editInfo->paid_amount ?? ''}}" name="paid_amount" placeholder="0.00"></td>
                    </tr>
                @endif
            <tr>
                <td class="note"><textarea  name="note" rows="4"   placeholder="Type Note Here...">{{$editInfo->note ?? ''}}</textarea></td>
            </tr>
        </tfoot>
    </table>
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
            '<input type="hidden" value="">'
            <?php foreach ($formInputDetails as $key => $eachInput) : ?> +
            '<td><?php trim(htmlform::formfiled($eachInput, $errors, old())); ?></td>'
            <?php endforeach; ?> +
            '<td class="text-center"><a del_id="' + j +'" class="delete_item btn btn-danger" href="javascript:;" title=""><i class="fa fa-minus"></i></a></td></tr>'
        );

        j++;

    $('.select2').select2();
        if ($(".pack_size")[0]) {
            $('.quantity').attr('readonly', true);
        }
        $(".decimal").on("click", function() {
            $(this).select();
        });


    const $selects = $(".product_id");
    const selectedValue = [];
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
                $(this).attr('disabled', true);
            }
        } else {
            $(this).attr('disabled', false);
        }
    });
});



$(document).on('change', '.product_id', function() {      
 const $selects2 = $(".product_id");
    const selectedValue = [];
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
                $(this).attr('disabled', true);
            }
        } else {
            $(this).attr('disabled', false);
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

            if ($(".pack_size ")[0]) {
                tr.find('input.quantity').val(pack_size * pack_no);
                var quantity = Number(pack_size * pack_no);
            } else {
                var quantity = Number(tr.find('input.quantity').val());
            }
            var approved_quantity = Number(tr.find('input.approved_quantity').val());
            var remaining_quantity = Number(tr.find('input.remaining_quantity').val());
         
            var unit_price = Number(tr.find('input.unit_price').val());
            var total_price = Number(tr.find('input.total_price').val());
            var totalPrice = quantity * unit_price;
            tr.find('input.total_price').val(totalPrice);

            if(approved_quantity > remaining_quantity){
                tr.find('input.approved_quantity').val(remaining_quantity);
                Swal.fire('Warning!', "Approved QTY can't greater than from main qty", 'warning');  
            }

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

        var subTotal = total_total_price - 0;
        var discount = parseFloat($('.discount').val() - 0);
        var grandTotal = subTotal - discount;

        $('.sub_total_pack_size').text(numberFormat(total_pack_size));
        $('.sub_total_pack_size').text(numberFormat(total_pack_size));
        $('.sub_total_pack_no').text(numberFormat(total_pack_no));
        $('.sub_total_quantity').text(numberFormat(total_quantity));
        $('.table_data_total_price').text(numberFormat(total_total_price));
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

$(document).on('change', '.service_quatation_id', function() {
    let service_quatation_id = $(this).val();
    $("#show_item tbody").empty();
    $.ajax({
        url: "{{route('serviceTransaction.serviceQuatation.detailsInfo')}}",
        method: 'GET',
        data: {
            service_quatation_id: service_quatation_id
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


$(document).on('keyup', '.paid_amount', function() {
    let requisition_id = parseFloat((this).val()-0);
         
});





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


$('.from_branch').change(function() {
    var from_branch = $(this).val();
    $('.to_branch  option[value="'+from_branch +'"]').prop('disabled', true);
});

</script>
@endsection