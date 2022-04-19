<?php
  use App\SM\SM;
  $hotel_policy = SM::smGetThemeOption( "hotel_policy", "" );
  $guset_policy = SM::smGetThemeOption( "guset_policy", "" );
?>
@extends('web.layouts.master')
@section('title')
Book Now
@endsection

@section('style')
    <style>
        label::before {
            width: 1.25rem !important;
            height: 1.25rem !important;
            background-color: #e6c886;
            box-shadow: none !important;
        }
        .custom-control-label::after {
            width: 1.25rem;
            height: 1.25rem;
            background-color: #e6c886;
            box-shadow: none !important;
        }
    </style>
@endsection
@php 
$total_days = $total_days;


@endphp 

@section('frontend-content')
<div class="booking-customer-information">
    <div class="container"> 
        <div class="section-title">
            <h3>Booking Form</h3>
        </div>
        <!-- <form action="{{route('booking_submit')}}"> -->
        <form action="{{route('paynow')}}" method="POST">
            @csrf
            <input type="hidden" name="daterange" value="{{$date_range}}" />
            <input type="hidden" name="entry_date" value="{{ $entry_date }}">
            <input type="hidden" name="exit_date" value="{{ $exit_date }}">
            <input type="hidden" id="" name="room_id" value="{{ $product->id ?? '' }}" />
            <input type="hidden" name="user_id" value="{{ $user->id ?? '' }}">
            <input type="hidden" name="adult" value="{{ $adult }}">
            <input type="hidden" name="child" value="{{ $child }}">
            <div class="row">
                <div class="col-md-8">
                    <div class="user-informaiton-section">
                        <div class="single-contact-form">
                            <div class="section-title">
                                <h4>Profile Details:</h4>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ $user->name ?? old('name') }}">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="Phone Number" value="{{ $user->phone ?? old('phone') }}" readonly>
                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ $user->email ?? old('email') }}" required>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="{{ $user->address ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="note">Note</label>
                                        <input type="text" class="form-control" name="note" id="note" value="{{$user->note ?? ''}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="single-adon-box">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-title">
                                        <h4><u> Add On: </u></h4>
                                    </div>
                                    @if(!empty($add_on))
                                        @foreach($add_on as $adds)
                                            <div class="adon-check-box">
                                                <div class="check">
                                                    <input type="checkbox" id="{{$adds->id}}" data-id="{{$adds->id}}" data-price ="{{$adds->sale_price}}" data-name="{{$adds->name}}"  name="addon[]" value="{{$adds->id}}" class="form-check-input add_on_price ">
                                                    <input type="hidden" id="add_on_{{$adds->id}}" value="{{$adds->sale_price}}">
                                                    <label class="form-check-label"  for="{{$adds->id}}">{{$adds->name}} - {{$adds->sale_price}} TK</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="section-title">
                            <h4><u>Privacy Policy</u></h4>
                        </div>
                        <div class="form-group custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="vehicle1" name="hotel_policy" value="hotel_policy" required>
                            <label class="custom-control-label" for="vehicle1" style="display: contents;"> Accept All Policies Of Hotel
                            {!!$hotel_policy!!} <a href=" #" type="button"  data-toggle="modal" data-target=".hotel-policy-modal"> Reed More </a></label>
                        </div>
                        <div class="form-group custom-control custom-checkbox mb-3">
                            <input type="checkbox" id="vehicle2" class="custom-control-input" name="guset_policy" value="guset_policy" required>
                            <label class="custom-control-label" for="vehicle2" style="display: contents;">Accept All Policies Of Guest 
                            {!!$guset_policy!!} <a href=" #" type="button"  data-toggle="modal" data-target=".geaust-policy-modal"> Reed More </a> </label>
                        </div>
                        <div class="modal fade hotel-policy-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle"> Hotel Policies  </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="hotel-policies">
                                        <div class="hotel-policies-list">
                                            <ul> 
                                                <li> <i class="fa fa-dot-circle-o" aria-hidden="true"></i> <span> As per the local police instruction guest below 21 years are not allowed </span></li>
                                                <li> <i class="fa fa-dot-circle-o" aria-hidden="true"></i> <span> Outside Food Not Allow </span></li>
                                                <li> <i class="fa fa-dot-circle-o" aria-hidden="true"></i> <span> It is mandatory for all guests to present valid photo identification at the time of check-in. 
                                                According to government regulations, a valid Photo ID has to be carried by every person above the age of 
                                                18 staying at the hotel. The identification proofs accepted are Aadhar Card, Driving License, Voter ID Card, 
                                                and Passport. Note that PAN card is not acceptable. Without an original copy of a valid ID, you will not be 
                                                allowed to check-in </span></li>
                                                <li> <i class="fa fa-dot-circle-o" aria-hidden="true"></i> <span> Visitors are not allowed in rooms </span></li>
                                                <li> <i class="fa fa-dot-circle-o" aria-hidden="true"></i> <span> No Check-in allowed between 11 pm to 7 am [As per Local Authority Directive] </span></li>
                                                <li> <i class="fa fa-dot-circle-o" aria-hidden="true"></i> <span> Couples are welcome </span></li>
                                                <li> <i class="fa fa-dot-circle-o" aria-hidden="true"></i> <span> Guests can check in using any local or outstation ID proof (PAN card not accepted). </span></li>
                                                <li> <i class="fa fa-dot-circle-o" aria-hidden="true"></i> <span> Only Indian Nationals allowed </span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade geaust-policy-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle"> Guest Policies </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="guest-policies">
                                        <div class="guest-policies-list">
                                            <ul> 
                                                <li> <i class="fa fa-dot-circle-o" aria-hidden="true"></i> <span> As per the local police instruction guest below 21 years are not allowed </span></li>
                                                <li> <i class="fa fa-dot-circle-o" aria-hidden="true"></i> <span> Outside Food Not Allow </span></li>
                                                <li> <i class="fa fa-dot-circle-o" aria-hidden="true"></i> <span> It is mandatory for all guests to present valid photo identification at the time of check-in. 
                                                According to government regulations, a valid Photo ID has to be carried by every person above the age of 
                                                18 staying at the hotel. The identification proofs accepted are Aadhar Card, Driving License, Voter ID Card, 
                                                and Passport. Note that PAN card is not acceptable. Without an original copy of a valid ID, you will not be 
                                                allowed to check-in </span></li>
                                                <li> <i class="fa fa-dot-circle-o" aria-hidden="true"></i> <span> Visitors are not allowed in rooms </span></li>
                                                <li> <i class="fa fa-dot-circle-o" aria-hidden="true"></i> <span> No Check-in allowed between 11 pm to 7 am [As per Local Authority Directive] </span></li>
                                                <li> <i class="fa fa-dot-circle-o" aria-hidden="true"></i> <span> Couples are welcome </span></li>
                                                <li> <i class="fa fa-dot-circle-o" aria-hidden="true"></i> <span> Guests can check in using any local or outstation ID proof (PAN card not accepted). </span></li>
                                                <li> <i class="fa fa-dot-circle-o" aria-hidden="true"></i> <span> Only Indian Nationals allowed </span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="user-service-section">
                        <div class="room-section">
                            <div class="row">
                                <div class="col-md-8"> 
                                    <div class="media-body">
                                        <h5 class="mt-0"> {{$product->name ?? ''}} </h5>
                                        <input type="hidden" name="product_id" value="{{$product->id ?? ''}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="room-img">
                                        @php 
                                        $image = $product->productImages[0] ?? '';
                                        $productImage =   str_replace("public/","",$image->image ?? '');
                                        @endphp

                                        @if(!empty($productImage))
                                        <img src="{{ asset('storage/'.$productImage) }}" width="100%!important" class="{{$product->name ?? ''}}">
                                        @else 
                                        <img src="https://ttg.com.bd/uploads/tours/hotels/306_02jpg.jpg" class="{{$product->name ?? ''}}">
                                        @endif                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="booking-date">
                            <div class="row">
                                <div class="col-md-8"> 
                                    <p> <span> <i class="fa fa-calendar" aria-hidden="true"></i> </span> {{$date_range}}  </p>
                                </div>
                                <div class="col-md-4">
                                    <div class="geaust-quentity">
                                        <span>{{$adult}} Adult </span> <span> {{$child}} Children </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="payment-section">
                            <table class="table">
                                <tr>
                                    <td> {{$product->name ?? ''}} </td>
                                    <td> {{$product->sale_price ?? ''}} TK x {{$total_days}} days</td>
                                </tr>
                                <tr>
                                    <td> Add On </td>
                                    <td id="add_on_price"> 0 TK </td>
                                </tr>
                                <tr>
                                    <td> Total </td>
                                    <td id="total_price"> {{$product->sale_price*$total_days}}  TK </td>
                                </tr>

                                @php 
                                $grand_total = $product->sale_price*$total_days;

                                $advance_percentage_percentage = $product->productDetails->advance_percentage;
                                $advance_payment_amount = ($grand_total * $advance_percentage_percentage)/100;
                                @endphp

                                <tr>
                                    <td>Advance Payment</td>
                                    <td>
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input name="pay_only_advance_payment" value="1" type="checkbox" class="custom-control-input" id="advance-payment" required>
                                            <label class="custom-control-label" for="advance-payment"></label>
                                            {{ $advance_payment_amount }} TK
                                        </div>
                                    </td>
                                </tr>
                               
                            </table>
                        </div>
                        <div class="submit-now-btn">
                        
                            <button type="submit" class="btn btn-sm"> Pay Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    var add_on_price=0; 
    var total_price=0;
    var total_days = "{{$total_days}}";
        $('.add_on_price').on('click', function() { 
            var id = $(this).val();
            alert(id)
            if ($(this).is(':checked'))
            {
                var price = $('#add_on_' + id ).val();
                var room_price = "{{$product->sale_price}}" * total_days;
                add_on_price = parseInt(add_on_price) + parseInt(price);
                total_price = parseInt(add_on_price) + parseInt(room_price);
                $('#add_on_price' ).html(add_on_price+' TK');
                $('#total_price' ).html(total_price+' TK');
            }
            else
            {
                var price = $('#add_on_' + id ).val();
                var room_price = "{{$product->sale_price}}" * total_days;
                add_on_price = parseInt(add_on_price) - parseInt(price);
                total_price = parseInt(room_price) - parseInt(add_on_price);
                $('#add_on_price' ).html(add_on_price+' TK');
                $('#total_price' ).html(total_price+' TK');
            }
    });

    $('body').on('click', '.book_style', function (event) {
    total_price = $('.new_price').val();
    total_advance_price =  $('.new_adv').val();
    var room= $(this).attr('for');
    if ($('#'+room).is(':checked')) {
        var val = $('#'+room).prop( "checked", false);
        var name = $('#'+room).attr('data-name');
        var price = $('#'+room).attr('data-price');
        var advance = $('#'+room).attr('data-advance');
        var quantity = $('#rows_'+room).val();
        price  = Number(price) * Number(quantity);
        var advance_price = (Number(price) * Number(advance) ) / 100 ;
        advance_price = Number(advance_price) * Number(quantity);
        total_price = Number(total_price) - Number(price);
        total_advance_price = Number(total_advance_price)-Number(advance_price) ;
        total_advance_price = parseInt(total_advance_price);
        $('.total_price').html(total_price);
        $('.advance_price').html(total_advance_price);
        $(this).html("Book Now");
    }
    else
    {
        var val = $('#'+room).prop( "checked", true);
        var name = $('#'+room).attr('data-name');
        var price = $('#'+room).attr('data-price');
        var advance = $('#'+room).attr('data-advance');
        var quantity = $('#rows_'+room).val();
        price  = Number(price) * Number(quantity);
        var advance_price = (Number(price) * Number(advance) ) / 100 ;
        advance_price = Number(advance_price) * Number(quantity);

        total_price = Number(total_price) + Number(price);
        total_advance_price = Number(total_advance_price)+Number(advance_price) ;
        total_advance_price = parseInt(total_advance_price);
        $('.total_price').html(total_price);
        $('.advance_price').html(total_advance_price);
        $(this).html("Booked");
    }
    $('.new_price').val(total_price);
    $('.new_adv').val(total_advance_price);
    });
</script>
@endsection