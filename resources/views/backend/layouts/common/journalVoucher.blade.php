<div class="row">
    <table class="table table-bordered table-hover" id="show_item">
        <thead class="bg-default">
            <tr>
                @foreach($formInputDetails as $key => $eachInput)
                @if($eachInput->name == 'account_id')
                <th width="50%">{{ucfirst($eachInput->label)}}</th>
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
                @if(in_array('debit_id',$activeColumn))
                <?php $datas = helper::getLedgerHead(); ?>
                    <td>
                    <select name="debit_id[]" class="select2 debit_id form-control" id="">
                            <?php foreach ($datas as $key => $parent) :  ?>
                                <optgroup label="<?php echo $parent['parent']->name ?? '' ?>">
                                    <?php foreach ($parent['parentChild'] as $child => $accountHeads) : ?>
                                        <option <?php if ($value->account_id == $accountHeads->id) : ?> selected <?php endif; ?> value="<?php echo $accountHeads->id ?? ''; ?>">
                                            <?php echo $accountHeads->name ?? ''; ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>
                    </td>
                @endif
                @if(in_array('debit',$activeColumn))
                 <td><input type="text" name="debit[]" class="form-control debit decimal border-success border" id="" placeholder="0.00" value="{{ $value->debit}}"></td>
                @endif
                @if(in_array('credit',$activeColumn))
                 <td><input type="text" name="credit[]" class="form-control credit decimal border-success border" id="" placeholder="0.00" value="{{ $value->credit}}"></td>
                @endif
                @if(in_array('amount',$activeColumn))
                 <td><input type="text" name="amount[]" class="form-control amount border-success border" id="" placeholder="0.00" value="{{ $value->amount}}"></td>
                @endif
                @if(in_array('memo',$activeColumn))
                 <td><input type="text" required=""  name="memo[]" class="form-control memo border border-success" id="" placeholder="memo" value="{{$value->memo}}"></td>
                @endif
                <td class="text-center"><button del_id="<?php echo $key + 99; ?>" class="delete_item btn btn-danger"
                    type="button" href="javascript:;" title="Are you Remove?"><i class="fa fa-minus"></i></button>
            </td>            </tr>
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
                <td class="text-right table_data_{{$eachInput->name}}"><span class="sub_total_{{$eachInput->name}}">0.00</span></td>
                @endforeach
                <td nowrap class="text-center"><button id="add_item" class="btn btn-success" type="button" title="Add new Item"><i class="fa fa-plus"></i></button></td>
            </tr>
            <tr>
                <td colspan="3" class="note"><textarea  name="note" rows="4" placeholder="Type Note Here...">{{$editInfo->note ?? ''}}</textarea></td>
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

        let j = 2;
        $("#add_item").click(function() {
            $("#show_item tbody").append('<tr  style="white-space: nowrap!important;" class="new_item' + j +
                '">' +
                '<input type="hidden" value="">'
                <?php foreach ($formInputDetails as $key => $eachInput) : ?> +
                    '<td><?php trim(htmlform::formfiled($eachInput, $errors, old())); ?></td>'
                <?php endforeach; ?> +
                '<td class="text-center"><button del_id="' + j +'" class="delete_item btn btn-danger" type="button"  title="Remove This Item"><i class="fa fa-minus"></i></button></td></tr>'

            );
            j++;
            $('.select2').select2();

            $(".decimal").on("click", function() {
                $(this).select();
        });


            const $selects = $(".debit_id");
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


                $(document).on('change', '.debit_id', function() {

                        const $selects2 = $(".debit_id");
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

        $('tbody,tfoot').delegate( 'input.debit,input.credit', 'keyup',  function() {
                var tr = $(this).closest('tr');
                var debit = (tr.find('input.debit').val()-0);
                var credit = (tr.find('input.credit').val()-0);

                if(debit === credit){
                    tr.find('input.credit').attr('readonly',false);
                    tr.find('input.debit').attr('readonly',false);
                }else if(debit > 0){
                    tr.find('input.credit').attr('readonly',true);
                    tr.find('input.debit').attr('readonly',false);
                }else{
                    tr.find('input.debit').attr('readonly',true);
                    tr.find('input.credit').attr('readonly',false);
                }
                $(this).removeClass("border border-danger");
                $(this).addClass("border border-success");

                calculation();
                checkDebitAndCreditAmount();
            });


            function checkDebitAndCreditAmount(){
                let tdebit =  parseFloat($('.sub_total_debit').text() - 0);
                let tcredit =  parseFloat($('.sub_total_credit').text() - 0);
                if (isNaN(tdebit)) {
                    tdebit=0;
                }
                if (isNaN(tcredit)) {
                    tcredit=0;
                }
                console.log(tdebit);
                console.log(tcredit);
                if(tdebit == tcredit){
                    $('#sbtn').attr('disabled',false);
                }else{
                    $('#sbtn').attr('disabled',true);
                }
            }


        function calculation() {

            var total_debit_price = 0;
            var total_credit_price = 0;
            $('.debit').each(function(i, e) {
                var total_price = parseFloat($(this).val() - 0);
                total_debit_price += total_price;
            });
            $('.credit').each(function(i, e) {
                var total_price = parseFloat($(this).val() - 0);
                total_credit_price += total_price;
            });

            $('.sub_total_debit').text((total_debit_price));
            $('.sub_total_credit').text((total_credit_price));

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



    $(document).on('change', '.payment_type', function() {
        let payment_type = $(this).val();

        if (payment_type == 'Customer') {
            $('.div_customer_id').removeClass("hide");
            $('.div_supplier_id').addClass('hide');
            $('.div_miscellaneous').addClass('hide');
        } else if (payment_type == 'Supplier') {
            $('.div_customer_id').addClass("hide");
            $('.div_supplier_id').removeClass('hide');
            $('.div_miscellaneous').addClass('hide');
        } else {
            $('.div_customer_id').addClass("hide");
            $('.div_supplier_id').addClass('hide');
            $('.div_miscellaneous').removeClass('hide');
        }


    });
</script>
@endsection
