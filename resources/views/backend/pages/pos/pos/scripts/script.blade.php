    <script>
    loadProduct('All',null);
    $(document).on('click', '.category_id', function() {
        var category_id=$(this).attr('category_id');
        console.log(category_id);
        var product_name=$('.product_name').val();
        loadProduct(category_id,product_name);
    });

    $(document).on('keyup', '.product_name', function() {
        var product_name=$('.product_name').val();
    if(product_name.length >=2){
        var category_id=$(this).attr('category_id');
        loadProduct(category_id,product_name);
    }else if(product_name.length ==0){
        loadProduct('All',null);
    }
        
    });


    $(document).on('click', '#minus', function() {
    
        var tr = $(this).closest('tr');
    var product_qty =  tr.find('input.sale_quantity').val();
    var product_id =  tr.find('input.product_id').val();
    var unit_price =  tr.find('input.unit_price').val();
    var avl_quantity =  tr.find('input.avl_quantity').val();
    addRowProduct(product_id,null,avl_quantity,1,unit_price,2);
    
        
    });

    $(document).on('click', '#plus', function() {
    
    var tr = $(this).closest('tr');
    var product_qty =  tr.find('input.sale_quantity').val();
    var product_id =  tr.find('input.product_id').val();
    var unit_price =  tr.find('input.unit_price').val();
    var avl_quantity =  tr.find('input.avl_quantity').val();
    addRowProduct(product_id,null,avl_quantity,1,unit_price,1);
    
        
    });



    $(document).on('keyup', '.saleDiscount,#paidAmount,.othersCharge', function() {
        calculation();
    });

    $(document).on('click', '.fullPaid', function() {
    var grandTotal = parseFloat($('.grandTotal').val()-0);
    $('#paidAmount').val(grandTotal);
    $('#netDue').text('0.00');
    });


    $(document).on('click', '.product_id', function() {
    batch(this,0);
    });

    $(document).on('click', '.customerForm', function() {

                    var form = '<form action="" class="form-vertical" id="newcustomer" method="post" accept-charset="utf-8">'+
                    '<div class="panel-body"><input type="hidden" name="csrf_test_name" id="" value="">'+
                        
                       '<div class="form-group row">'+
                            '<label for="customer_name" class="col-sm-4 col-form-label">Customer Name <i class="text-danger">*</i></label>'+
                            '<div class="col-sm-6">'+
                                '<input class="form-control" name="customer_name" id="m_customer_name" type="text" placeholder="Customer Name" required="" tabindex="1">'+
                            '</div>'+
                        '</div>'+

                        '<div class="form-group row">'+
                            '<label for="email" class="col-sm-4 col-form-label">Customer Email</label>'+
                            '<div class="col-sm-6">'+
                                '<input class="form-control" name="email" id="email" type="email" placeholder="Customer Email" tabindex="2"> '+
                            '</div>'+
                       '</div>'+

                        '<div class="form-group row">'+
                            '<label for="mobile" class="col-sm-4 col-form-label">Customer Mobile</label>'+
                            '<div class="col-sm-6">'+
                                '<input class="form-control" name="mobile" id="mobile" type="number" placeholder="Customer Mobile" min="0" tabindex="3">'+
                            '</div>'+
                        '</div>'+

                        '<div class="form-group row">'+
                            '<label for="address " class="col-sm-4 col-form-label">Customer Address</label>'+
                            '<div class="col-sm-6">'+
                                '<textarea class="form-control" name="address" id="address " rows="3" placeholder="Customer Address" tabindex="4"></textarea>'+
                            '</div>'+
                       '</div>'+
                    '</div>'+
                        '</form>';    
        $('#loadModalResult').empty().html(form);
    });



    function tableRowCount(){
        var rowCount = $('#appendTable tr').length;
       if(rowCount == 1 || rowCount <=1 ){
        $("#saveBtn").attr('disabled',true);
       }else{
           $("#saveBtn").attr('disabled',false);
       }
    }





function loadProduct(category_id,product_name){

    var products =  $("input[name='product_id[]']").map(function(){return $(this).val();}).get();
    var quantitys =  $("input[name='quantity[]']").map(function(){return $(this).val();}).get();
    if(products.length === 0){
        products=[];
        quantitys=[];
    }

        $.ajax({
        url: "{{route('pos.product.filter')}}",
        method: 'GET',
        data: {
            category_id: category_id,
            product_name: product_name,
            products: products,
            quantitys: quantitys,
        },
        success: function(data) {
            $('#load_data').empty().html(data.html);
        }
    });  
}


function batch(reference,batchQty=0){
    
     if(batchQty == 0){
        var product_id = $(reference).attr('product_id');
        $(reference).closest('.selespos-product').addClass('activeDiv');
        $(reference).closest('.selespos-product').find('.batch').addClass('quantityBatch');
        var qty =  parseFloat($(reference).closest('.selespos-product').find('.active_qty').text()-0);
        $(reference).closest('.selespos-product').find('.active_qty').text(qty+1)
        appendProduct(product_id);
     }else{
        var qty =  batchQty;
        $('.active_id_'+reference).text(qty);
     }
     
}



$("#customerName").autocomplete({
    source: "{{route('salesSetup.customer.customer.list')}}",
    response: function (event, ui) {
        if (ui.content) {
            $("#customerName").val('');
            $("#customerId").val('');
           
        }
    },
    select: function (event, ui) {
      
       $("#customerName").val(ui.item.label);
       $("#customerId").val(ui.item.value);
        return false;
    }

});



    function appendProduct(product_id){
        var products =  $("input[name='product_id[]']").map(function(){return $(this).val();}).get();
        var quantitys =  $("input[name='quantity[]']").map(function(){return $(this).val();}).get();

        if(products.length === 0){
            products=[];
            quantitys=[];
        }
        
        $.ajax({
            url: "{{route('pos.product.details')}}",
            method: 'GET',
            data: {
                product_id: product_id,
                products : products,
                quantitys : quantitys
            },
            success: function(data) {

                console.log('product details');
                console.log(data);


                    addRowProduct(data.data.id,data.data.name,data.data.presentStock,1,data.data.sale_price,1);
            }
        }); 
    }

        var addRowProduct = function (product_id, pname,avlStock,quantity,unit_price,appendType) {
                var exits_product_id = parseFloat($('#product_id_' + product_id).val()-0);
                var tr = $("#product_id_" + product_id).closest('tr');


                if (product_id == exits_product_id) {
                    var productQuantity =   parseFloat(tr.find('input.sale_quantity').val()-0);
                    if(appendType == 1){
                        //plus
                        var updateQuantity = productQuantity+1;
                        batch(product_id,updateQuantity);
                    }else{
                        //minus

                            if(productQuantity >1){
                                var updateQuantity = productQuantity-1;
                                batch(product_id,updateQuantity);
                            }else{
                                Swal.fire('Warning!', 'Minimum Quantity Should be One!.', 'warning');
                                return false;
                            }
                    }
                    
                    if (avlStock >= updateQuantity) {
                        var unit_price =   tr.find('input.unit_price').val();
                        tr.find('input.sale_quantity').val(updateQuantity);
                        tr.find('input.unit_price').val(unit_price);
                        tr.find('input.total_price').val(updateQuantity*unit_price);
                        return calculation();
                    } else {
                        Swal.fire('Warning!', 'Stock not available!.', 'warning');
                        return calculation();
                    }

                    //inventorySetup.product.show
                }else{

                    var detailRoute = "/admin/inventory-setup-product-show/" + product_id + "/" + 2;
                    $('<tr style="white-space: nowrap!important;" id="new_item' + product_id +'">' +
                    '<td class="text-left"><input type="hidden"  name="product_id[]" class="form-control product_id" id="product_id_'+product_id+'" value="'+product_id+'"><input type="text" readonly  class="text-left form-control"   placeholder="Product Name" value="'+pname+'"></td>'+
                    '<td><input type="number" required readonly  name="avl_quantity[]"  class="form-control avl_quantity decimal" id="avl_quantity_'+product_id+'" placeholder="Stock: '+avlStock+'" value="'+avlStock+'"></td>'+
                    '<td><div class="pos-inc-dic"> <button type="button" id="minus" class="minus btn-danger">-</button> <input type="text" required  name="quantity[]"  class="form-control count sale_quantity decimal" id="sale_quantity_'+product_id+'" placeholder="0.00" value="'+quantity+'"> <button type="button" id="plus" class="plus btn-success">+</button></div></td>'+
                    '<td><input type="number" required  name="unit_price[]"  class="form-control unit_price decimal" id="unit_price_'+product_id+'" placeholder="0.00" value="'+unit_price+'"></td>'+
                    '<td><input type="number" required  name="total_price[]" readonly class="form-control total_price decimal" id="total_price_'+product_id+'" placeholder="0.00" value="'+unit_price*quantity+'"></td>'+
                    '<td class="text-center">'+ 
                    '<button onclick="loadModalView('+ "'"+ detailRoute  + "'" + ','+product_id+','+"'Product Details'" +')" data-toggle="modal" data-target="#modal-default"  class="btn btn-success" type="button"  title="Details of Product"><i class="fas fa-eye"></i></button>'
                    +'<button del_id="' + product_id +'" class="delete_item btn btn-danger" type="button"  title="Remove This Item"><i class="fas fa-times"></i></button></td></tr>').appendTo('#appendTable tbody');
                }
                return calculation();
    };
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
                $('#new_item' + id).remove();
                loadProduct('all',null);
                calculation();
                Swal.fire('Successs!', 'You are remove one item!.', 'success');
            }

        }
    })
});

$('tbody,tfoot').delegate('input.sale_quantity,input.unit_price','keyup',function() {
    var tr = $(this).closest('tr');
    var product_id = tr.find('input.product_id').val();
    var avl_quantity = parseFloat(tr.find('input.avl_quantity').val()-0);
    var sale_quantity = parseFloat(tr.find('input.sale_quantity').val()-0);
    var unit_price = parseFloat(tr.find('input.unit_price').val()-0);
    var total_price = parseFloat(tr.find('input.total_price').val()-0);
    
    if(sale_quantity < 1){
        tr.find('input.sale_quantity').val(1);
        Swal.fire('Warning!', 'Minimum Quantity Should be One!.', 'warning');
        return false;
    }
    if(sale_quantity > avl_quantity){
        tr.find('input.sale_quantity').val(avl_quantity);
        $(this).removeClass("border border-success");
        $(this).addClass("border border-danger");
        Swal.fire('Warning!', "Approved QTY can't greater than from main qty="+avl_quantity, 'warning');  
        var totalPrice = avl_quantity * unit_price;
        tr.find('input.total_price').val(totalPrice);
        batch(product_id,avl_quantity);
    }else{
        batch(product_id,sale_quantity);
        $(this).removeClass("border border-danger");
        $(this).addClass("border border-success");
        var totalPrice = sale_quantity * unit_price;
        tr.find('input.total_price').val(totalPrice);
    }
    calculation();
});


function calculation() {

    var total_quantity = 0;
    var total_total_price = 0;
    var total_discount = 0;
    var change = 0;
    
    tableRowCount();
    

    $('.sale_quantity').each(function(i, e) {
        var quantity = parseFloat($(this).val() - 0);
        total_quantity += quantity;
    });

    $('.total_price').each(function(i, e) {
        var total_price = parseFloat($(this).val() - 0);
        total_total_price += total_price;
    });
    
    var subTotal = total_total_price - 0;
    var othersCharge = parseFloat($('.othersCharge').val() - 0);
    var discount = parseFloat($('.saleDiscount').val() - 0);
    var paidAmount =   parseFloat($("#paidAmount").val()-0);
    var grandTotal = (subTotal+othersCharge) - discount;

    $(".totalSalesItem").text(total_quantity);
    
    if(paidAmount > 0 && grandTotal <= paidAmount){
        $('.changeAmount').val(paidAmount-grandTotal);
        $("#netDue").text((0));
    }else{
        $('.changeAmount').val(0);
       // $("#netDue").text((grandTotal-paidAmount));
    }

    
    
    $('#netTotal').text((grandTotal));
    $('.grandTotal').val((grandTotal));
    


}



$("#idCalculadora").Calculadora();
$("#micalc").Calculadora({'EtiquetaBorrar':'Clear'});
$("#CalcOptoins").Calculadora({
    EtiquetaBorrar:'Clear',
    ClaseBtns1: 'warning', 
    ClaseBtns2: 'success', 
    ClaseBtns3: 'primary', 
    TituloHTML:'<h2>Develoteca.com</h2>',
    Botones:["+","-","*","/","0","1","2","3","4","5","6","7","8","9",".","="]
});

(function(i,s,o,g,r,a,m){
    i['GoogleAnalyticsObject']=r;i[r]=i[r]||
function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-74824848-1', 'auto');
    ga('send', 'pageview');

</script>