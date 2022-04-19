@extends('backend.layouts.master')
@section('admin-content')

<section class="main-pos-section">
    <form id="pos_form" action="{{route('pos.transaction.pos.store')}}" method="POST">
        @csrf
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="pos-product-filter-section">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="pos-category-filter-btn">
                                    <div class="btn-group-vertical group-button">
                                
                                        <a  class="btn category_id" category_id="All"> 
                                            <input type="checkbox"  name="All" value="All">
                                            <label for="All"> All  </label>
                                        </a>
                                        
                                        @foreach($categorys as $key => $value )
                                        <a  class="btn category_id" category_id="{{$value->id}}"> 
                                            <input type="checkbox"  name="All" value="All">
                                            <label for="All"> {{$value->name}} </label>
                                        </a>
                                        @endforeach
                                    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="pos-filter-product">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="pos-search-bar">
                                                <div class="form-group">
                                                    <input class="form-control mr-sm-2 product_name" type="search" placeholder="Search" aria-label="Search">
                                                    <button type="button" class="search-btn" > <i class="fas fa-search"></i> </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="selespos-product-section">
                                        <div id="load_data"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="pos-product-add-datatable">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="pos-datatable-product-filter">
                                    <div class="form-row">
                                        <div class="col-md-8 col-sm-4 col-xs-6">
                                            <div class="pos-calculation-search">
                                                <div class="form-group">
                                                    <input type="search" class="form-control" placeholder="Barcode or QR-code scan here">
                                                    <button type="button" class="search-btn" > <i class="fas fa-search"></i> </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="pos-barcode-search">
                                                <div class="form-group">
                                                    <input type="search" name="voucher_no" readonly class="form-control" value="{{$invoiceId ?? 0}}" placeholder="Manual Input barcode">
                                                    <button type="button" class="search-btn" > <i class="fas fa-search"></i> </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pos-datatable-customar-add">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="input-group">
                                        <input type="search" value="Walking Customer" class="form-control" id="customerName" placeholder="Walking Customer">
                                        <input type="hidden" class="form-control" value="1" name="customer_id" id="customerId" placeholder="Walking Customer">
                                        <div class="customer-search-btn">
                                            <button class="btn" type="button"> <i class="fas fa-search"></i> </button>
                                        </div>
                                        <div class="input-group-prepend">
                                            <div class="btn btn-sm btn-success" onclick="loadModal('{{route('salesSetup.customer.store.ajax')}}','customerName','Add New Customer')" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i>
                                            </div>
                                            {{-- <button type="button" class="btn btn-info btn-lg customerForm" data-toggle="modal" data-target="#modal-default"> + </button> --}}
                                        </div>
                                    </div>
                                </div>
                            </div><br>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="product-add-datatable">
                                    <div class="table-responsive">          
                                        <table class="table table-bordered" id="appendTable">
                                            <thead>
                                                <tr>
                                                    <th style="width:20%;">Item Information *</th>
                                                    <th>Av. Qnty.</th>
                                                    <th>Qnty *</th>
                                                    <th>Rate *</th>
                                                    <th>Total</th>
                                                    <th style="width:10%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pos-amount-calculation">
                                    <div class="total-calculaton">
                                        <div class="form-group row">
                                            <label class="control-label col-sm-6" for="number">Sale Discount (-):</label>
                                            <div class="col-sm-6">
                                                <input type="number" class="form-control saleDiscount" name="discount" id="discount" placeholder="0.000">
                                            </div>
                                        </div>
                                        {{-- <div class="form-group row">
                                            <label class="control-label col-sm-6" for="number">TAX AMOUNT (%):</label>
                                            <div class="col-sm-6">
                                                <input type="number"  class="form-control grandTotal" name="tax_amount"  id="number" placeholder="0.000">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-6" for="number">SHIPPING CHARGE:</label>
                                            <div class="col-sm-6">
                                                <input type="number"  class="form-control changeAmount" id="number" placeholder="0.000">
                                            </div>
                                        </div> --}}
                                        <div class="form-group row">
                                            <label class="control-label col-sm-6" for="number">Other Charge(+):</label>
                                            <div class="col-sm-6">
                                                <input type="number" name="others_charge"  class="form-control othersCharge" id="number" placeholder="0.000">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sale-note">
                                        <div class="form-group">
                                            <label for="sale-note" class="form-control"> Sale Note: </label>
                                            <textarea name="sale_note" id="" cols="30" rows="2" class="form-control">

                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="total-calculate-result">
                                        <div class="form-group">
                                            <label for="" class="col-md-6"> Total Item:</label>
                                            <span class="col-md-6 totalSalesItem" > 0.00 </span>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-md-6"> Total Amount:</label>
                                            <input type="number" readonly name="grand_total" class="form-control grandTotal col-md-6" id="number" placeholder="0.000">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-12">
                                <div class="pos-form-action">
                                    <div class="draft btn">
                                        <button type="button"> <i class="far fa-edit"></i>  Draft </button>
                                    </div>
                                    <div class="suspend btn">
                                        <button type="button"> <i class="fas fa-pause"></i> Suspend </button>
                                    </div>
                                    <div class="credit-sale btn">
                                        <button type="button"> <i class="fas fa-check"></i> Credit Sale </button>
                                    </div>
                                    <div class="card-pay btn">
                                        <button type="button"> <i class="fas fa-credit-card"></i> Card </button>
                                    </div>
                                    <div class="multiple-pay btn">
                                        <button type="button" data-toggle="modal" data-target="#multiplePayment"> <i class="fas fa-credit-card"></i> Multiple Pay </button>
                                    </div>
                                    <div class="cash btn">
                                        <button type="button"> <i class="fas fa-money-check-alt"></i> Cash </button>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
        <div class="pos-footer-seciton">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pos-footer-items">
                            <!-- <div class="total-price">
                                <label for="#"> Net Total: <span id="netTotal">0.00  </span></label>
                            </div>
                            <div class="paid-amount">
                                <div class="form-group row">
                                    <label class="control-label col-sm-4" for="number">Paid Amount:</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="paidAmount" placeholder="0.000">
                                    </div>
                                </div>
                            </div>
                            <div class="due-amount">
                                <label for="#"> Due: <span id="netDue"> 0.00 </span></label>
                            </div> -->
                            <div class="footer-sumbit-btn">
                                <div class="pos-form-action">



                                    {{-- <div class="draft btn">
                                        <button    name="draft_sale"> <i class="far fa-edit"></i>  Draft </button>
                                    </div>
                                    <div class="suspend btn">
                                        <button    name="suspend_sale"> <i class="fas fa-pause"></i> Suspend </button>
                                    </div>
                                
                                    <div class="card-pay btn">
                                        <button    name="card"> <i class="fas fa-credit-card"></i> Card </button>
                                    </div>
                                    <div class="multiple-pay btn">
                                        <button   data-toggle="modal" data-target="#multiplePayment"> <i class="fas fa-credit-card"></i> Multiple Pay </button>
                                    </div>
                                    <div class="cash btn">
                                        <button type="submit"  name="cash"> <i class="fas fa-money-check-alt"></i> Cash </button>
                                    </div>
                                    <div class="partial-payment btn">
                                        <button type="button" data-toggle="modal" data-target="#partialPayment"> <i class="fas fa-money-check-alt"></i> partial payment </button>
                                    </div>
                                    <div class="sale-save btn">
                                        <button type="submit" name="Cash" class="btn"> Save Sale </button>
                                    </div> --}}


                                    {{-- <div class="credit-sale btn">
                                        <button type="submit" value="Credit" name="credit"> <i class="fas fa-check"></i> Credit Sale </button>
                                    </div> --}}
                                    <div class="cash btn">
                                        <button type="submit" value="Cash" disabled id="saveBtn" name="cash"> <i class="fas fa-money-check-alt"></i> Save </button>
                                    </div>
                                    <div class="pos-calculat btn">
                                        <button type="button" class="btn" id="calculaor-btn"> <i class="fa fa-calculator" aria-hidden="true"></i> </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    <div class="multiple-payment-modal">
        <div class="modal fade" id="multiplePayment" tabindex="-1" role="dialog" aria-labelledby="multipulPayment" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="multiplePayment"> Multiple Payment </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="multiple-payment-section">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="payment-information">
                                       
                                            <div class="multiple-payment-add-box" id="multiple-payment-add">
                                                <div class="payment-search-header">
                                                    <div class="row">
                                                        <div class="form-group col-md-4">
                                                            <label for=""> Amount:*</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for=""> Payment Method:*</label>
                                                            <select id="selectPaymentMethod" class="form-control">
                                                                <option value="" selected >(:-- Select Payment Method --:)</option>
                                                                <option value="option1"> Advance </option>
                                                                <option value="option2"> Cash </option>
                                                                <option value="option3"> Card </option>
                                                                <option value="option4"> Cheque </option>
                                                                <option value="option5"> Bank Transfer </option>
                                                                <option value="option6"> Other </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for=""> Payment Account:*</label>
                                                            <select id="selectPaymentAccount" class="form-control">
                                                                <option value="" selected >(:-- Select Payment Account --:)</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="payment-info-box">
                                                    <div id="option1" class="box-items">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for=""> Payment Note: </label>
                                                                    <textarea name="" id="" rows="6" placeholder="Describe Yourself"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="option2" class="box-items">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for=""> Payment Note: </label>
                                                                    <textarea name="" id="" rows="6" placeholder="Describe Yourself"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="option3" class="box-items">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for=""> Card Number:*</label>
                                                                    <input type="text" class="form-control" placeholder="Card Number">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for=""> Card Holder Name:*</label>
                                                                    <input type="text" class="form-control" placeholder="Card Holder Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for=""> Card Transaction No:*</label>
                                                                    <input type="text" class="form-control" placeholder="Card Transaction No">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for=""> Card Type:*</label>
                                                                    <select id="selectPaymentMethod" class="form-control">
                                                                        <option value="" selected >(:-- Select Card Type --:)</option>
                                                                        <option value="option1"> Paypal </option>
                                                                        <option value="option2"> Master Card </option>
                                                                        <option value="option3"> Visa Card </option>
                                                                        <option value="option4"> Discover Card </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for=""> Month:*</label>
                                                                    <input type="text" class="form-control" placeholder="Month">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for=""> Year:*</label>
                                                                    <input type="text" class="form-control" placeholder="Year">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for=""> Security Code:*</label>
                                                                    <input type="text" class="form-control" placeholder="Security Code">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for=""> Payment note: </label>
                                                                    <textarea name="" id="" rows="6" placeholder="Describe Yourself"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="option4" class="box-items">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for=""> Cheque No. </label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for=""> Payment note: </label>
                                                                    <textarea name="" id="" rows="6" placeholder="Describe Yourself"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="option5" class="box-items">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for=""> Bank Account No </label>
                                                                    <input type="text" class="form-control" placeholder="Bank Account No">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for=""> Payment note: </label>
                                                                    <textarea name="" id="" rows="6" placeholder="Describe Yourself"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="option6" class="box-items">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for=""> Payment note: </label>
                                                                    <textarea name="" id="" rows="6" placeholder="Describe Yourself"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" id="add-payment-row"> Add Payment Row </button>
                                            <br>
                                            <div class="staff-note-section">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="sell-note">
                                                            <div class="form-group">
                                                                <label for=""> Sell Note: </label>
                                                                <textarea name="note" id="" rows="6" placeholder="Describe Yourself"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="staff-note">
                                                            <div class="form-group">
                                                                <label for=""> Staff Note: </label>
                                                                <textarea name="" id="" rows="6" placeholder="Describe Yourself"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                       
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="payment-list">
                                        <ul>
                                            <li><p> Total Items: </p><span> 10 </span></li>
                                            <li><p> Total Payable: </p><input type="text" readonly class="form-control" value="$ 0.00"></li>
                                            <li><p> Total Paying: </p> <input type="text" readonly class="form-control" value="$ 0.00"></li>
                                            <li><p> Change Return: </p><input type="text" readonly class="form-control" value="$ 0.00"></li>
                                            <li><p> Balance: </p> <input type="text" readonly class="form-control" value="$ 0.00"> </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary"> Finalize Payment </button>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="partial-payment-modal">
        <div class="modal fade" id="partialPayment" tabindex="-1" role="dialog" aria-labelledby="partialPayment" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="partialPayment"> Partial Payment </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="partial-payment-section">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="porduct-history">
                                        <div class="product-items-info">
                                            <div class="product-image">
                                                <img src="{{ asset(helper::imageUrl($value->image ?? '')) }}" alt="">
                                            </div>
                                            <div class="paroduct-name">
                                                <p> test product name </p>
                                                <p> <b>  Quentity: </b> <span>(25)</span> </p>
                                            </div>
                                            <div class="product-price">
                                                <span> 250 Tk </span>
                                            </div>
                                        </div>
                                        <div class="product-items-info">
                                            <div class="product-image">
                                                <img src="{{ asset(helper::imageUrl($value->image ?? '')) }}" alt="">
                                            </div>
                                            <div class="paroduct-name">
                                                <p> test product name </p>
                                                <p> <b>  Quentity: </b> <span>(25)</span> </p>
                                            </div>
                                            <div class="product-price">
                                                <span> 250 Tk </span>
                                            </div>
                                        </div>
                                        <div class="product-items-info">
                                            <div class="product-image">
                                                <img src="{{ asset(helper::imageUrl($value->image ?? '')) }}" alt="">
                                            </div>
                                            <div class="paroduct-name">
                                                <p> test product name </p>
                                                <p> <b>  Quentity: </b> <span>(25)</span> </p>
                                            </div>
                                            <div class="product-price">
                                                <span> 250 Tk </span>
                                            </div>
                                        </div>
                                        <div class="product-items-info">
                                            <div class="product-image">
                                                <img src="{{ asset(helper::imageUrl($value->image ?? '')) }}" alt="">
                                            </div>
                                            <div class="paroduct-name">
                                                <p> test product name </p>
                                                <p> <b>  Quentity: </b> <span>(25)</span> </p>
                                            </div>
                                            <div class="product-price">
                                                <span> 250 Tk </span>
                                            </div>
                                        </div>
                                        <div class="product-items-info">
                                            <div class="product-image">
                                                <img src="{{ asset(helper::imageUrl($value->image ?? '')) }}" alt="">
                                            </div>
                                            <div class="paroduct-name">
                                                <p> test product name </p>
                                                <p> <b>  Quentity: </b> <span>(25)</span> </p>
                                            </div>
                                            <div class="product-price">
                                                <span> 250 Tk </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="partial-payment-info">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary"> Finalize Payment </button>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pos-calculator" id="pos-calcular-show">
        <div id="idCalculadora"></div>
    </div>
</form>
</section>

@endsection

@section('scripts') 
<script>
$(".category_id").trigger("click");


        ga('create', 'UA-74824848-1', 'auto');
        ga('send', 'pageview');

</script>
@include('backend.pages.pos.pos.scripts.script')

@endsection 