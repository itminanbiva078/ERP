
<script>
    $('form').submit(function(e){
        var spinner = $('#loader');
        spinner.show();
        $(this).find(':input[type=submit]').prop('disabled', true);
    });
    $(document).on({
       
        ajaxStart: function(){
            $('#loader').fadeIn();
        },
        ajaxStop: function(){ 
            $('#loader').fadeOut();
            
        }    
    });


    function ValidationEvent(){
        let quantity =$('input[name="quantity[]"]').length;
        var values = $("input[name='total_price[]']").map(function(){return $(this).val();}).get();
        var total_product_id = true;
        var total_batch_no = true;
        var total_pack_size = true;
        var total_pack_no = true;
        var total_quanity = true;
        var total_unit_price = true;
        var total_total_price = true;
        var ps_payment = true;

        var ps_paymentValue=parseFloat($(".payment").val() - 0);
        var payment_type = $(".payment_type").val();
        if((payment_type == "Cash" || payment_type == "Bank") && ps_paymentValue <=0 ){
            ps_payment=false;
            $('.payment').addClass("border border-danger");
        }

        $('input[name^="product_id"]').each(function() {
            if($(this).find(':selected')){
                $(this).addClass("border border-success");
                $(this).removeClass("border border-danger");
            }else{
                total_product_id=false;
                $($(this).select2("container")).addClass("error");
                // $(this).addClass("border border-danger");
                // $(this).removeClass("border border-success");
            }
        });

        $('input[name^="batch_no"]').each(function() {
            if($(this).val()){
                $(this).addClass("border border-success");
                $(this).removeClass("border border-danger");
            }else{
                total_batch_no=false;
                $(this).addClass("border border-danger");
                $(this).removeClass("border border-success");
            }
        });


        $('input[name^="pack_size"]').each(function() {
            if(parseFloat($(this).val()) > 0){
                $(this).addClass("border border-success");
                $(this).removeClass("border border-danger");
            }else{
                total_pack_size=false;
                $(this).addClass("border border-danger");
                $(this).removeClass("border border-success");
            }
        });
        $('input[name^="pack_no"]').each(function() {
            if(parseFloat($(this).val()) > 0){
                $(this).addClass("border border-success");
                $(this).removeClass("border border-danger");
            }else{
                total_pack_no=false;
                $(this).addClass("border border-danger");
                $(this).removeClass("border border-success");
            }
        });

        $('input[name^="quantity"]').each(function() {
            if(parseFloat($(this).val()) > 0){
                $(this).addClass("border border-success");
                $(this).removeClass("border border-danger");
            }else{
                total_quanity=false;
                $(this).addClass("border border-danger");
                $(this).removeClass("border border-success");
            }
        });

        $('input[name^="unit_pirce"]').each(function() {
            if(parseFloat($(this).val()) > 0){
                $(this).addClass("border border-success");
                $(this).removeClass("border border-danger");
            }else{
                total_unit_price=false;
                $(this).addClass("border border-danger");
                $(this).removeClass("border border-success");
            }
        });

        $('input[name^="total_price"]').each(function() {
            if(parseFloat($(this).val()) > 0){
                $(this).addClass("border border-success");
                $(this).removeClass("border border-danger");
            }else{
                total_total_price=false;
                $(this).addClass("border border-danger");
                $(this).removeClass("border border-success");
            }
        });
        if(quantity >= 1){
            if(total_product_id == true && ps_payment == true && total_batch_no == true && total_pack_size == true && total_pack_no == true && total_quanity == true && total_unit_price == true && total_total_price == true){
                return true;
            }else{

                $('#loader').hide();
                $('#loader').css("display", "none");
                
                setTimeout(function(){ 
                    Swal.fire('Warning!','Validation Error.','warning');
                        $('#loader').hide();
                        $('#loader').css("display", "none");
                        
                        $("button").attr("disabled",false);
                    }, 100);
                return false;
            }
        }else{
            return false;
        }
    }
    
    
    function numberFormat(amount){
        return (amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }
    
    $(document).on("keypress", ".decimal", function () {
       $(this).val($(this).val().replace(/[^0-9\.]/g,''));
       if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
           event.preventDefault();
       }
    });
    
    $(document).ready(function(){
        $(".decimal").click(function () {
        $(this).select();
        });
    });
    $(document).ready(function(){
        $(".decimal").on("click", function () {
        $(this).select();
        });
    });
    
    
    function search_filter(el) {
        $('#search_filter').submit();
    }

    $(document).on('click', '.delete_row', function(e) {
        e.preventDefault();
        let delete_url = $(this).attr('delete_route');
        let delete_id = $(this).attr('delete_id');
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
                var btn = this;
                $.ajax({
                    url: delete_url,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (data.code == 203) {
                            Swal.fire(
                                'Warning!',
                                'Your status id must be numeric.',
                                'success'
                            )
                        } else if (data.code == 404) {
                            Swal.fire(
                                'Warning!',
                                'Your status info not found.',
                                'warning'
                            )
                        } else {
                            $('.uniqueid' + delete_id).parents("tr").remove();
                            Toast.fire({
                                icon: 'success',
                                title: 'Your data successfully deleted!!'
                            })
                        }
    
                    },
                    error: function(data) {
                        alert(data.responseText);
                    }
                });
            }
        })
    
    });

    $(document).on('click', '.transaction_approved', function(e) {
        e.preventDefault();
        let approved_url = $(this).attr('approved_url');
        Swal.fire({
            title: 'Pending Request Status Update',
            html: ` <select class="form-control select2" id="approved_type">
                        <option  value="Approved">Approved</option>
                        <option  value="Cancel">Cancel</option>
                    </select> <br>
            <input type="date" id="date_picker" class="swal2-input" value="<?php echo date('Y-m-d');?>" placeholder="date_picker">`,
            confirmButtonText: 'Yes, Status Update',
            showCancelButton: true,
            focusConfirm: true,
                preConfirm: () => {
                    const date_picker = Swal.getPopup().querySelector('#date_picker').value
                    const status = Swal.getPopup().querySelector('#approved_type').value
                    if(status == 'Approved'){
                        if (!status) {
                            Swal.showValidationMessage(`Please select status`)
                        }else if( !date_picker){
                            Swal.showValidationMessage(`Please select deposit date`)
                        }
                    }else{
                        //everything looks good
                    }
                       return { date_picker: date_picker,status:status }
                    }
        }).then((result) => {
                if (result.isConfirmed) {
                    const date_picker = Swal.getPopup().querySelector('#date_picker').value
                    const status = Swal.getPopup().querySelector('#approved_type').value
                    var btn = this;
                    $.ajax({
                        url: approved_url,
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "data": {
                        "status": status,
                        "date_picker": date_picker,
                    },
                    success: function(data) {
                        if (data.code == 203) {
                            Swal.fire(
                                'Warning!',
                                'Your status id must be numeric.',
                                'success'
                            )
                        } else if (data.code == 404) {
                            Swal.fire(
                                'Warning!',
                                'Your status info not found.',
                                'warning'
                            )
                        } else {
                            $(".transaction_approved").hide(1000);
                            Toast.fire({
                                icon: 'success',
                                title: 'Status Successfully apprvoed!!'
                            })
                        }
                    },
                    error: function(data) {
                        alert(data.responseText);
                    }
                    });
                }
            })
    
    });


    function check_approved_type(){
      var check_status =  $("#check_approved_type").val();
     
        if(check_status !='Approved'){
            $(".modal_bank_id").hide();
        }else{
            $(".modal_bank_id").show();
        }
      
    }
    

    $(document).on('click', '.transaction_approved2', function(e) {
            e.preventDefault();
            let approved_url = $(this).attr('approved_url');

            <?php 
            use App\Helpers\Journal;
            $bankAccountHead =  Journal::getChildHeadList(8);
        
            ?>

            Swal.fire({
            title: 'Select Bank Credentials',
            html: ` <select onchange="check_approved_type()" class="form-control select2" id="check_approved_type">
                        <option  value="Approved">Approved</option>
                        <option  value="Dishonoured">Dishonoured</option>
                        <option  value="Cancel">Cancel</option>
                    </select> <br>
           <select class="form-control select2 modal_bank_id" id="bank_id">
            <?php foreach ($bankAccountHead as $key => $parent) :  ?>
                <optgroup label="<?php echo $parent['parent']->name ?? '' ?>">
                    <?php foreach ($parent['parentChild'] as $child => $accountHeads) : ?>
                    <option <?php if (!empty($selected) && $selected == $accountHeads->id) : ?> selected <?php endif; ?>
                        value="<?php echo $accountHeads->id ?? ''; ?>"><?php echo $accountHeads->name ?? ''; ?></option>
                    <?php endforeach; ?>
                </optgroup>
            <?php endforeach; ?>
            </select>
            <input type="date" id="date_picker" class="swal2-input" value="<?php echo date('Y-m-d');?>" placeholder="date_picker">`,
            confirmButtonText: 'Clear Cheque',
            showCancelButton: true,
            focusConfirm: true,

            
                preConfirm: () => {
            const bank_id = Swal.getPopup().querySelector('#bank_id').value
            const date_picker = Swal.getPopup().querySelector('#date_picker').value
            const status = Swal.getPopup().querySelector('#check_approved_type').value

                    if(status == 'Approved'){
                        if (!bank_id) {
                            Swal.showValidationMessage(`Please select deposit bank`)
                        }else if( !date_picker){
                            Swal.showValidationMessage(`Please select deposit date`)
                        }
                    }else{
                        //everything looks good
                    }

           
        return { bank_id: bank_id, date_picker: date_picker,status:status }
    }
    }).then((result) => {
        if (result.isConfirmed) {
        const bank_id = Swal.getPopup().querySelector('#bank_id').value
        const date_picker = Swal.getPopup().querySelector('#date_picker').value
        const status = Swal.getPopup().querySelector('#check_approved_type').value
        $.ajax({
            url: approved_url,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            "data": {
            "_token": "<?= csrf_token() ?>",
            "status": status,
            "bank_id": bank_id,
            "date_picker": date_picker,
        },
            
            success: function(data) {
                if (data.code == 203) {
                    Swal.fire(
                        'Warning!',
                        'Your status id must be numeric.',
                        'success'
                    )
                } else if (data.code == 404) {
                    Swal.fire(
                        'Warning!',
                        'Your status info not found.',
                        'warning'
                    )
                } else {
                    $(".transaction_approved2").hide(1000);
                    Toast.fire({
                        icon: 'success',
                        title: 'Pending Cheque successfully clear!!'
                    })
                }
            },
            error: function(data) {
                alert(data.responseText);
            }
        });
        }

    })

    });



    $(document).on('click', '.transaction_approved11', function(e) {
        e.preventDefault();
        let approved_url = $(this).attr('approved_url');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approved it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var btn = this;
                $.ajax({
                    url: approved_url,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (data.code == 203) {
                            Swal.fire(
                                'Warning!',
                                'Your status id must be numeric.',
                                'success'
                            )
                        } else if (data.code == 404) {
                            Swal.fire(
                                'Warning!',
                                'Your status info not found.',
                                'warning'
                            )
                        } else {
                           $(".transaction_approved").hide(1000);
                            Toast.fire({
                                icon: 'success',
                                title: 'Purchases Successfully apprvoed!!'
                            })
                        }
                    },
                    error: function(data) {
                        alert(data.responseText);
                    }
                });
            }
        })
    
    });
    
    
    $('#systemDatatable').on('switchChange.bootstrapSwitch', 'input[name="my-checkbox"]', function(event, state) {
        let status_url = $(this).attr('status_route');
    
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, status change!'
        }).then((result) => {
            if (result.isConfirmed) {
                var btn = this;
                $.ajax({
                    url: status_url,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        // console.log(data.code);
                        if (data.code == 203) {
                            Swal.fire(
                                'Warning!',
                                'Your status id must be numeric.',
                                'success'
                            )
                        } else if (data.code == 404) {
                            Swal.fire(
                                'Warning!',
                                'Your status info not found.',
                                'warning'
                            )
                        } else {
                            Toast.fire({
                                icon: 'success',
                                title: 'Status successfully updated!!'
                            })
                        }
                    },
                    error: function(data) {
                        alert(data.responseText);
                    }
                });
            }
        })
    });
    
    
    
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    
    $(document).ready(function() {
    
        $(".store_hide").hide();
        $('.branch_id').on('change', function() {
            let selected = $(this).find(":selected").attr('value');
            $.ajax({
                "url": "{{ route('settings.store.by.branch') }}",
                "dataType": "json",
                "type": "GET",
                "data": {
                    "_token": "<?= csrf_token() ?>",
                    "branch_id": selected,
                }
            }).done(function(data) {
                let select = $('.store_id');
                select.empty();
                select.append('<option value="0" >(:-Select Store-:)</option>');
                $.each(data, function(key, value) {
                    select.append('<option value=' + value.id + '>' + value.name + '</option>');
                });
    
            })
        });
    });


    $(document).ready(function() {
        $('.division_id').on('change', function() {
            let selected = $(this).find(":selected").attr('value');
            $.ajax({
                "url": "{{ route('settings.district.list.divission.id') }}",
                "dataType": "json",
                "type": "GET",
                "data": {
                    "_token": "<?= csrf_token() ?>",
                    "divission_id": selected,
                }
            }).done(function(data) {
                let select = $('.district_id');
                select.empty();
                select.append('<option value="0" >(:-Select District-:)</option>');
                $.each(data.data, function(key, value) {
                    select.append('<option value=' + value.id + '>' + value.name + '</option>');
                });
    
            })
        });
    });


    $(document).ready(function() {
        $('.district_id').on('change', function() {
            let selected = $(this).find(":selected").attr('value');
            $.ajax({
                "url": "{{ route('settings.upazila.list.district.id') }}",
                "dataType": "json",
                "type": "GET",
                "data": {
                    "_token": "<?= csrf_token() ?>",
                    "district_id": selected,
                }
            }).done(function(data) {
                let select = $('.upazila_id');
                select.empty();
                select.append('<option value="0" >(:-Select Upazila-:)</option>');
                $.each(data.data, function(key, value) {
                    select.append('<option value=' + value.id + '>' + value.name + '</option>');
                });
    
            })
        });
    });


    $(document).ready(function() {
        $('.upazila_id').on('change', function() {
            let selected = $(this).find(":selected").attr('value');
            $.ajax({
                "url": "{{ route('settings.union.list.upazila.id') }}",
                "dataType": "json",
                "type": "GET",
                "data": {
                    "_token": "<?= csrf_token() ?>",
                    "upazila_id": selected,
                }
            }).done(function(data) {
                let select = $('.union_id');
                select.empty();
                select.append('<option value="0" >(:-Select Union-:)</option>');
                $.each(data.data, function(key, value) {
                    select.append('<option value=' + value.id + '>' + value.name + '</option>');
                });
    
            })
        });
    });



    $(document).on('change', '.mail_type', function() {
        let mail_type = $(this).val();
        $.ajax({
                "url": '<?php echo route("mailbox.mailtype.userlist"); ?>',
                "dataType": "json",
                "type": "GET",
                "data": {
                    "_token": "<?= csrf_token() ?>",
                    "mail_type": mail_type,//import save route
                }
                }).done(function(data) {
            let select = $('.to_email');
            select.empty();
            select.append('<option value="0" >  </option>');
            $.each(data.data, function(key, value) {
                select.append('<option value=' + value.email + '>' + value.email +
                    '</option>');
            });
        })
    });

    $(document).on('change', '.sms_type', function() {
        let sms_type = $(this).val();
        $.ajax({
                "url": '<?php echo route("sms.smstype.userlist"); ?>',
                "dataType": "json",
                "type": "GET",
                "data": {
                    "_token": "<?= csrf_token() ?>",
                    "sms_type": sms_type,//import save route
                }
                }).done(function(data) {
            let select = $('.user_phone');
            select.empty();
            select.append('<option value="0" >  </option>');
            $.each(data.data, function(key, value) {
                select.append('<option value=' + value.phone + '>' + value.phone +
                    '</option>');
               
            });

        })

    });


$(document).on('change', '.payment_type', function() {
    let payment_type = $(this).val();
    if(payment_type == 'Cash'){
        $('.div_account_id').removeClass("hide");
        $('.div_bank_id').addClass('hide');
        $('.div_cheque_number').addClass("hide");
        $('.div_bank_id').addClass("hide");
        $('.div_cheque_date').addClass("hide");
        $('.div_payment').show();
    }else if(payment_type == 'Credit'){
        $('.div_account_id').addClass("hide");
        $('.div_bank_id').addClass("hide");
        $('.div_cheque_number').addClass("hide");
        $('.div_bank_id').addClass("hide");
        $('.div_cheque_date').addClass("hide");
        $('.div_payment').hide();
    }else{
        $('.div_account_id').addClass("hide");
        $('.div_bank_id').removeClass("hide");
        $('.div_cheque_number').removeClass("hide");
        $('.div_cheque_date').removeClass("hide");
        $('.div_payment').show();
    }   
});


$(document).on('keyup', '#paid_amount', function() {
  
  var thisPayment = parseFloat($(this).val()-0);
  var grandTotal = parseFloat($(".grandTotal").val()-0);

    if(grandTotal > thisPayment ){
        $(this).removeClass("border border-danger");
        $(this).addClass("border border-success");
        $("#due_amount").val(grandTotal-thisPayment);
        $("#due_amount").addClass("bg-danger border-success");
       
    }else if(grandTotal < thisPayment){
        Swal.fire('Warning!', 'Payment should be less than grand total.', 'warning' );
        $(this).val(grandTotal);
        $("#due_amount").val(0);
        $("#due_amount").removeClass("bg-danger border-success");
        $("#due_amount").addClass("bg-success border-success");
        $(this).removeClass("border border-success");
        $(this).addClass("border border-danger");
    }else{
        $("#due_amount").removeClass("bg-danger border-success");
        $("#due_amount").addClass("bg-primary border-success text-black");
    }
});

setTimeout(function(){ 
$('.product_type').trigger('change');
},100);


$(document).on('change', '.product_type', function() {
    var product_type = $(this).val();
    if(product_type == 'Rooms'){
        $('.div_number_of_bed').removeClass("hide");
        $('.div_advance_percentage').removeClass("hide");
        $('.div_room_no').removeClass("hide");
        $('.div_product_attributes').removeClass("hide");
        $('.div_number_of_room').removeClass("hide");
        $('.div_floor_id').removeClass("hide");
        $('.div_low_stock').addClass("hide");
        $('.div_purchases_price').addClass("hide");
        $('.div_brand_id').addClass("hide");
        $('.div_unit_id').addClass("hide");
    }else{
        $(".div_number_of_bed").addClass("hide");
        $(".div_advance_percentage").addClass("hide");
        $(".div_room_no").addClass("hide");
        $(".div_product_attributes").addClass("hide");
        $(".div_number_of_room").addClass("hide");
        $(".div_floor_id").addClass("hide");
        $(".div_low_stock").removeClass("hide");
        $(".div_purchases_price").removeClass("hide");
        $(".div_brand_id").removeClass("hide");
        $(".div_unit_id").removeClass("hide");
    }
});



$(document).on('change', '.is_branch', function() {
  var is_branch = $(this).val();
    if(is_branch == 'No'){
        $('.div_is_store').addClass("hide");
    }else{
        $(".div_is_store").removeClass("hide");
    }
});

$(document).on('change', '.purchases_mrr', function() {
  var purchases_mrr = $(this).val();
    if(purchases_mrr == 'Yes'){
        $('.div_mrr_approval').removeClass("hide");
    }else{
        $(".div_mrr_approval").addClass("hide");
    }
});

$(".purchases_mrr").trigger("change");
$(".is_branch").trigger("change");

$(document).on('change', '.delivery_challan', function() {
  var challa_mrr = $(this).val();
    if(challa_mrr == 'Yes'){
        $('.div_challan_approval').removeClass("hide");
    }else{
        $(".div_challan_approval").addClass("hide");
    }
});

$(".delivery_challan").trigger("change");

</script>    