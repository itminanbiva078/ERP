
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
                    <td  style="width:50%!important">
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
                 <td><input type="number" name="debit[]"  class="form-control debit debitAmount decimal border-success border" id="debitAmount" placeholder="0.00" value="{{ $value->debit}}"></td>
                @endif
                @if(in_array('credit',$activeColumn))
                 <td><input type="number" name="credit[]"  class="form-control credit decimal border-success border" id="" placeholder="0.00" value="{{ $value->credit}}"></td>
                @endif
                @if(in_array('amount',$activeColumn))
                 <td><input type="number" name="amount[]"  class="form-control amount decimal border-success border" id="" placeholder="0.00" value="{{ $value->amount}}"></td>
                @endif
                @if(in_array('memo',$activeColumn))
                 <td><input type="text" required=""  name="memo[]" class="form-control memo border border-success" id="" placeholder="memo" value="{{$value->memo}}"></td>
                @endif
                <td class="text-center"><button del_id="<?php echo $key + 99; ?>" class="delete_item btn btn-danger" type="button" href="javascript:;" title="Are you Remove?"><i class="fa fa-minus"></i></button> </td>
            </tr>
           @endforeach
           @endif

            <tr class="new_item1">
                @foreach($formInputDetails as $key2 => $eachInput)
                <td> @php htmlform::formfiled($eachInput, $errors, old()) @endphp</td>
                @endforeach
                <td class="text-center"><button del_id="1" class="delete_item btn btn-danger" type="button" href="javascript:;" title="Are you Remove?"><i class="fa fa-minus"></i></button></td>
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
            $('.select2').select2();
          }, 1000);

        let j = 2;
        $("#add_item").click(function() {
            $("#show_item tbody").append('<tr  style="white-space: nowrap!important;" class="new_item' + j +
                '">' +
                '<input type="hidden" value="">'
                <?php foreach ($formInputDetails as $key => $eachInput) : ?> +
                    '<td><?php trim(htmlform::formfiled($eachInput, $errors, old())); ?></td>'
                <?php endforeach; ?> +
                '<td class="text-center"><button del_id="' + j +
                '" class="delete_item btn btn-danger" href="javascript:;" title=""><i class="fa fa-minus" type="button"></i></button></td></tr>'
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

        $('tbody,tfoot').delegate( 'input.debit_id,input.debit,input.credit', 'keyup',  function() {

                var tr = $(this).closest('tr');
                var debit_id = tr.find('input.debit_id').val();
                var debit = tr.find('input.debit').val();
                var credit = Number(tr.find('input.credit').val());
                $(this).removeClass("border border-danger");
                $(this).addClass("border border-success");
                calculation();

            });

        function calculation() {
            var total_total_price = 0;
            
            $('.amount').each(function(i, e) {
                var total_price = parseFloat($(this).val() - 0);
                total_total_price += total_price;
            });

            var subTotal = total_total_price - 0;
            $('.sub_total_amount').text(numberFormat(subTotal));

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
                    let totalRow = $('.debit').length
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

        $('.account_val_id').on('change', function() {
          
            let account_id = $(this).find(":selected").attr('value');
            $.ajax({
                "url": "{{ route('accountSetup.chartOfAccount.getAccountBalance') }}",//new route
                "dataType": "json",
                "type": "GET",
                "data": {
                    "_token": "<?= csrf_token() ?>",
                    "account_id": account_id,
                }
            }).done(function(data) {

               $('.accountBalance').val(data);

            })
        });

        $('#account_type_id').on('change', function() {
     
            let type_id = $(this).find(":selected").attr('value');
            let payment_type = $(this).val();

            if (payment_type == 4) {
                $('.div_customer_id').removeClass("hide");
                $('.div_supplier_id').addClass('hide');
                $('.div_miscellaneous').addClass('hide');
            } else if (payment_type == 5) {
                $('.div_customer_id').addClass("hide");
                $('.div_supplier_id').removeClass('hide');
                $('.div_miscellaneous').addClass('hide');
            } else {
                $('.div_customer_id').addClass("hide");
                $('.div_supplier_id').addClass('hide');
                $('.div_miscellaneous').addClass('hide');
            }

           // alert(type_id);
            $.ajax({
                "url": "{{ route('accountSetup.chartOfAccount.getAccountHeadTypeWise') }}",//new route
                "dataType": "json",
                "type": "GET",
                "data": {
                    "_token": "<?= csrf_token() ?>",
                    "type_id": type_id,
                }
            }).done(function(data) {
            //    alert(data);
               console.log(data.data);
               $('.debit_id').html(data.data);

            })
        });

    });



    $(document).on('change', '.payment_type,#account_type_id4', function() {
        let payment_type = $(this).val();

        if (payment_type == 4) {
          
            $('.div_customer_id').removeClass("hide");
            $('.div_supplier_id').addClass('hide');
            $('.div_miscellaneous').addClass('hide');
        } else if (payment_type == 5) {
            $('.div_customer_id').addClass("hide");
            $('.div_supplier_id').removeClass('hide');
            $('.div_miscellaneous').addClass('hide');
        } else {
            $('.div_customer_id').addClass("hide");
            $('.div_supplier_id').addClass('hide');
            $('.div_miscellaneous').addClass('hide');
        }

            $.ajax({

                "url":"{{ route('accountSetup.chartOfAccount.typeWiseList') }}",
                "dataType": "json",
                "type": "GET",
                "data": {
                    "_token": "<?= csrf_token() ?>",
                    "payment_type": payment_type,
                }
            }).done(function(data) {
               // console.log(data.data);
                let select = $('.debit_id');
                select.empty();
                select.append(data.data);


            })

    });

    $('.credit_id').change(function() {
    var credit_id  = $(this).val();
    $('.debit_id  option[value="'+credit_id  +'"]').prop('disabled', true);
});




$(document).on('keyup', '.debitAmount', function() {

var thisPayment = 0;
$('.debitAmount').each(function(i, e) {
    var total_price = parseFloat($(this).val() - 0);
    thisPayment += total_price;
});

var accountBalance = parseFloat($(".accountBalance").val()-0);
if(accountBalance < thisPayment){
      Swal.fire('Warning!', 'Payment should be less than account balance.', 'warning' );
      $(this).val(accountBalance);
      $("#debitAmount").val(0);
      $(this).removeClass("bg-danger border-success");
      $(this).removeClass("border border-success");
      $(this).addClass("border border-danger");
  }else{
      $(this).removeClass("bg-danger border-success");
      $(this).addClass("bg-primary border-success text-black");
  }



});

</script>
@endsection
