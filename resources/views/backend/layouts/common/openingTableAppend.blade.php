    <div class="row">
    <table class="table table-bordered table-hover" id="show_item">
        <thead class="bg-default">
            <tr>
                @foreach($formInputDetails as $key => $eachInput)
                @if($eachInput->name == 'customer_id')
                <th @if(count($formInputDetails) >= 5) width="25%" @else   @endif>{{ucfirst($eachInput->label)}}</th>
                @else
                <th @if($eachInput->type == 'tnumber') class="text-right" @endif>{{ucfirst($eachInput->label)}}</th>
                @endif
                @endforeach
                <th width="1%">Action</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($invoiceDetails))
            @foreach($invoiceDetails as $key => $value)
            <tr class="new_item<?php echo $key + 99; ?>">
                @if(in_array('customer_id',$activeColumn))
                <td>
                    <select name="customer_id[]" class="form-control customer_id select2 " id=""
                        placeholder="Type Customer">
                        <option value="" selected="" disabled="" data-select2-id="55">(:-Select Customer-:)</option>
                        @foreach($customers as $key => $customer)
                        <option @if($value->customer_id == $customer->id) selected @endif
                            value="{{$customer->id}}">{{$customer->name}}</option>
                        @endforeach
                    </select>
                </td>
                @endif
            
                @if(in_array('opening_balance',$activeColumn))
                <td><input type="number" required=""  name="opening_balance[]" 
                        class="form-control opening_balance decimal" id="" placeholder="Opening Balance"
                        value="{{$value->opening_balance}}"></td>
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
           
            <tr>
                <td class="grand_total text-right">Sub Total:</td>
                <td><input  type="text" readonly id="sub_total" class="form-control subTotal"
                    value="{{$editInfo->subtotal ?? ''}}" name="sub_total" placeholder="0.00"></td>
                </tr>
           
            <tr>
                <td colspan="2" class="note"><textarea  name="note"  rows="4"   placeholder="Type Note Here...">{{$editInfo->note ?? ''}}</textarea></td>
            </tr>
        </tfoot>
    </table>
    </div>
        @section('scripts')
        <script>
        $(document).ready(function() {

        
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

                $(".select2").select2();

            const $selects = $(".customer_id");
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
                        $(this).attr('disaled', true);
                    }
                } else {
                    $(this).attr('disabled', false);
                }
            });
        });





                $('tbody,tfoot').delegate(
                    'input.customer_id,input.opening_balance',
                    'keyup',
                    function() {
                        calculation();
                    });

                function calculation() {
                    var total_opening_balance = 0;
                

                    $('.opening_balance').each(function(i, e) {

                        var customer_id = parseFloat($(this).val() - 0);
                        total_opening_balance += customer_id;
                    });

                
                    $('.sub_total_opening_balance').text(total_opening_balance);
                    $('#sub_total').val(total_opening_balance);


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
                            let totalRow = $('.opening_balance').length
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

            </script>
            @endsection