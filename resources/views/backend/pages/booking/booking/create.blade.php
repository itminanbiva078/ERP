@extends('backend.layouts.master')

@section('title')
Booking - {{$title}}
@endsection

@section('styles')
<style>
table#show_item tr td {
    padding: 2px !important;
}
</style>
@endsection

@section('navbar-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> Booking</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    @if(helper::roleAccess('booking.booking.index'))
                    <li class="breadcrumb-item"><a
                            href="{{ route('booking.booking.index') }}">Booking List</a>
                    </li>
                    @endif
                    <li class="breadcrumb-item active"><span>Add New Booking</span></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('admin-content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3>
                <div class="card-tools">
                  
                    <a class="btn btn-default" style="display:none!important" id="reBookNow" href="#"><i  class="fa fa-search"></i>  Filter Again ?</a>
                    @if(helper::roleAccess('booking.booking.index'))
                    <a class="btn btn-default" href="{{ route('booking.booking.index') }}"><i
                            class="fa fa-list"></i>
                        Booking List</a>
                    @endif
                    <span id="buttons"></span>

                    <a class="btn btn-tool btn-default" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </a>
                    <a class="btn btn-tool btn-default" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body" id="bookingForm" style="display: none">
                <form class="needs-validation" method="POST"  action="{{ route('booking.booking.store') }}" novalidate>
                    @csrf
                    
                    @if(!empty($formInput) && is_array($formInput))

                    <div class="form-row">
                        @foreach ($formInput as $key => $eachInput)
                        @if($eachInput->inputShow == true)
                        @php htmlform::formfiled($eachInput, $errors, old()) @endphp
                        @endif
                        @endforeach
                        <input type="hidden" class="bookDaterange" name="daterange" value=""/>
                        <input type="hidden" class="bookAdult" name="adult" value=""/>
                        <input type="hidden" class="bookChildren" name="children" value=""/>
                        <input type="hidden" class="room_id" name="room_id" value=""/>
                    </div>
                    <div class="form-row">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>Booking Room: </td>
                                    <td>Booking Date: </td>
                                    <td>Adult: </td>
                                    <td>Children: </td>
                                    <td>Price: </td>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td><input type="text" name="" value="" readonly class="room_name form-control"/></td>
                                        <td><input type="text" name="" value="" readonly class="bookDaterange form-control"/></td>
                                        <td><input type="text" name="" value="" readonly class="bookAdult form-control"/></td>
                                        <td><input type="text" name="" value="" readonly class="bookChildren form-control"/></td>
                                        <td><input type="text" name="" value="" readonly  class="room_price subTotal total_price  form-control"/></td>
                                    </tr>

                                    <tr>
                                        <td class="grand_total text-right "  colspan="4">Sub Total:</td>
                                        <td><input  type="text" readonly id="sub_total" class="form-control subTotal"  value="" name="sub_total" placeholder="0.00">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="grand_total text-right" colspan="4">Discount:</td>
                                        <td><input  type="text" id="discount" class="form-control discount decimal"  value="" name="discount" placeholder="0.00"></td>
                                    </tr>
                                    <tr>
                                        <td class="grand_total text-right" colspan="4">Grand Total:</td>
                                        <td><input  type="text" id="grand_total" readonly class="form-control grandTotal" value="" name="grand_total" placeholder="0.00"></td>
                                    </tr>
                    
                                    <tr class="div_payment" style="display: none!important">
                                        <td class="grand_total text-right" colspan="4">Payment:</td>
                                        <td><input  type="text" id="paid_amount" class="form-control paid_amount"  value="" name="paid_amount" placeholder="0.00"></td>
                                    </tr>
                                    <tr class="div_payment" style="display: none!important">
                                        <td class="grand_total text-right" colspan="4">Present Due:</td>
                                        <td><input  type="text" id="due_amount" class="form-control due_amount" readonly  value="" name="due_amount" placeholder="0.00"></td>
                                    </tr>

                            </tbody>
                        </table>
                    </div>

                    
                    <button class="btn btn-info" type="submit"><i class="fa fa-save"></i> &nbsp;Save</button>
                    @else
                    <div class="alert alert-default">
                        <strong>Warning!</strong> Sorry you have no form access !!.
                    </div>
                    @endif
                </form>
            </div>
            <div class="card-body" id="filterForm">
               
                    <div class="room-search-section">
                        <div class="row">
                            <div class="col-md-12">
                                    <div class="room-search-items">
                                        <input type="text" class="form-control" id="reservation"  value="" />
                                        <select name="adult" class="select2 adult form-control">
                                            <option value="1" > 1 Adult</option>
                                            <option value="2" > 2 Adult</option>
                                            <option value="3" > 3 Adult</option>
                                            <option value="4" > 4 Adult</option>
                                            <option value="5" > 5 Adult</option>
                                            <option value="6" > 6 Adult</option>
                                            <option value="7" > 7 Adult</option>
                                            <option value="8" > 8 Adult</option>
                                            <option value="9" > 9 Adult</option>
                                            <option value="10" > 10 Adult</option>
                                        </select>
                                        <select name="children" class="select2 children form-control" >
                                            <option value="0" > 0 Children</option>
                                            <option value="1" > 1 Children</option>
                                            <option value="2" > 2 Children</option>
                                            <option value="3" > 3 Children</option>
                                            <option value="4" > 4 Children</option>
                                            <option value="5" > 5 Children</option>
                                            <option value="6" > 6 Children</option>
                                            <option value="7" > 7 Children</option>
                                            <option value="8" > 8 Children</option>
                                            <option value="9" > 9 Children</option>
                                            <option value="10" > 10 Children</option>
                                        </select>
                                        <button class="searchFreeRoom" type="button"><i class="fa fa-search"></i>Search</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                   <hr>
               
                    <div class="room-items-section">
                        <span id="loadSearchResult"></span>
                    </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">

            </div>
        </div>
    </div>
    <!-- /.col-->
</div>


@endsection

@section('scripts')

<script>
    $(document).on('click', '.searchFreeRoom', function() {
           
            var reservation = $('#reservation').val();
            var adult = $('.adult').val();
            var children = $('.children').val();
            $.ajax({
                url: "{{route('booking.search.avaialble.room')}}",
                method: 'GET',
                data: {
                    daterange: reservation,
                    adult: adult,
                    children: children,
                },
                success: function(data) {
                   
                   console.log(data.html);
                    $("#loadSearchResult").html(data.html);
                    
                }
        });  
    });

function bookNow(room_id,room_name,room_price){

           $("#bookDaterange").val('');
           $("#bookAdult").val('');
           $("#bookChildren").val('');
           $('#bookingForm').show();
           $('#reBookNow').show();
           $('#filterForm').hide();
           $(".bookDaterange").val($('#reservation').val());
           $(".bookAdult").val($('.adult').val());
           $(".bookChildren").val($('.children').val());
           $(".room_id").val(room_id);
           $(".room_name").val(room_name);
           $(".room_price").val(room_price);
           $(".subTotal").val(room_price);
           $('.discount').trigger('keyup');

}
 
$('tbody,tfoot').delegate( 'input.subTotal,input.discount,input.payment', 'keyup', function() {
            calculation()
        });



function calculation() {
       
        var subTotal = parseFloat($('.subTotal').val() - 0);
        var discount = parseFloat($('.discount').val() - 0);
        var payment = parseFloat($('.paid_amount').val() - 0);
        var grandTotal = (subTotal - discount);
        $('.subTotal').val(subTotal);
        $('.grand_total').val(grandTotal);
        $('#grand_total').val(grandTotal);
        $('#due_amount').val(grandTotal-payment);


    }
   
    $(document).on('click', '#reBookNow', function() {

           $('#bookingForm').hide();
           $('#filterForm').show();
           $('#reBookNow').hide();
           
    });

</script>
@endsection
