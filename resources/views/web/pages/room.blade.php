@extends('web.layouts.master')
@section('title')
Room List
@endsection
@section('style')
<style>
  /* Mark input boxes that gets an error on validation: */
  input.invalid {
    background-color: #ffdddd;
  }
  /* Hide all steps by default: */
  .tab {
    display: none;
  }
  #prevBtn {
    background-color: #bbbbbb;
  }
  /* Mark the steps that are finished and valid: */
  .step.finish {
    background-color: #04AA6D;
  }
  .button-labels label { 
    display: inline-block; 
    border: solid 1px #ddd; 
    background-color: #eee;
    padding: 3px;
  }
  .book_style
  {
    border: 1px solid #4d0508;
    background-color: #af1f24;
    padding: 10px;
    color: #fff;
  }
  .hidden{
    display: none;
  }
  </style>
@endsection
@section('frontend-content')
@php
  $entry_date = date('m/d/Y');
  $date = date('M d, Y');
  $date = strtotime($date);
  $date = strtotime("+7 day", $date);
  $exit_date = date('m/d/Y', $date);
  $date_range = $entry_date.' - '.$exit_date;
  if(Session::has('entry_date') && Session::has('exit_date'))
  {
    $entry_date = Session::get('entry_date');
    $entry_date = date_create($entry_date);
    $entry_date = date_format($entry_date,"m/d/Y");
    $exit_date = Session::get('exit_date');
    $exit_date = date_create($exit_date);
    $exit_date = date_format($exit_date,"m/d/Y");
    $date_range = $entry_date.' - '.$exit_date;
  }
  if(Session::has('adult'))
  {
    $adult = Session::get('adult');
  }
  if(Session::has('children'))
  {
    $children = Session::get('children');
  }
@endphp
<div class="room-wise-service-section" >
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="container">
        <div class="header-filter-section">
          <div class="slider-contant">
            <form  action="{{route('room_list')}}">
              <input type="text" id="daterange" name="daterange" value="{{$date_range}}" />
              <select name="adult" class="select2">
                <option value="1" <?= $adult === '1' ? 'selected' : ''; ?>> 1 Adult</option>
                <option value="2" <?= $adult === '2' ? 'selected' : ''; ?>> 2 Adult</option>
                <option value="3" <?= $adult === '3' ? 'selected' : ''; ?>> 3 Adult</option>
                <option value="4" <?= $adult === '4' ? 'selected' : ''; ?>> 4 Adult</option>
                <option value="5" <?= $adult === '5' ? 'selected' : ''; ?>> 5 Adult</option>
                <option value="6" <?= $adult === '6' ? 'selected' : ''; ?>> 6 Adult</option>
                <option value="7" <?= $adult === '7' ? 'selected' : ''; ?>> 7 Adult</option>
                <option value="8" <?= $adult === '8' ? 'selected' : ''; ?>> 8 Adult</option>
                <option value="9" <?= $adult === '9' ? 'selected' : ''; ?>> 9 Adult</option>
                <option value="10" <?= $adult === '10' ? 'selected' : ''; ?>> 10 Adult</option>
              </select>
              <select name="children" class="select2" >
                <option value="0" <?= $children === '0' ? 'selected' : ''; ?>> 0 Children</option>
                <option value="1" <?= $children === '1' ? 'selected' : ''; ?>> 1 Children</option>
                <option value="2" <?= $children === '2' ? 'selected' : ''; ?>> 2 Children</option>
                <option value="3" <?= $children === '3' ? 'selected' : ''; ?>> 3 Children</option>
                <option value="4" <?= $children === '4' ? 'selected' : ''; ?>> 4 Children</option>
                <option value="5" <?= $children === '5' ? 'selected' : ''; ?>> 5 Children</option>
                <option value="6" <?= $children === '6' ? 'selected' : ''; ?>> 6 Children</option>
                <option value="7" <?= $children === '7' ? 'selected' : ''; ?>> 7 Children</option>
                <option value="8" <?= $children === '8' ? 'selected' : ''; ?>> 8 Children</option>
                <option value="9" <?= $children === '9' ? 'selected' : ''; ?>> 9 Children</option>
                <option value="10" <?= $children === '10' ? 'selected' : ''; ?>> 10 Children</option>
              </select>
              <button href="#" type="submit"><i class="fa fa-search"></i>Search</button>
            </form>
          </div>
        </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="category-wise-filter-section">
            <div class="section-title">
              <h2> Filter On </h2>
            </div>
            <div class="category-section-filter">
              <div class="section-title">
                <h5>  Category Filter </h5>
              </div>
              @foreach($category as $key => $cat_value)
              <div class="form-check">
                <input class="form-check-input category_filter" type="checkbox" value="{{$cat_value->id}}" id="flexCheckDefault-{{ $cat_value->id }}">
                <label class="form-check-label" for="flexCheckDefault-{{ $cat_value->id }}">
                  {{$cat_value->name}}
                </label>
              </div>
              @endforeach
            </div>
            <div class="price-filter-section">
              <div class="section-title">
                <h5>  Price Filter </h5>
              </div>
              <div class="range-slider">
                <input value="{{$min_price}}" id="min_price" min="{{$min_price}}" max="{{$max_price}}" step="100" type="range"/>
                <input value="{{$max_price}}" id="max_price" min="{{$min_price}}" max="{{$max_price}}" step="100" type="range"/>
                <div class="range-value">
                  <input class="left" type="number" value="{{$min_price}}" min="{{$min_price}}" max="{{$max_price}}"/>
                  <input class="right" type="number" value="{{$max_price}}" min="{{$min_price}}" max="{{$max_price}}"/>
                </div>
              </div>
            </div>
            <div class="category-section-filter">
              <div class="section-title">
                <h5>  Hotel Facilities </h5>
              </div>
              @foreach($feature as $fea_value)
              <div class="form-check">
                <input class="form-check-input feature_filter" type="checkbox" value="{{$fea_value->name}}" id="flexCheckDefault-{{ $fea_value->id }}">
                <label class="form-check-label" for="flexCheckDefault-{{ $fea_value->id }}">
                  {{$fea_value->name}}
                </label>
              </div>
              @endforeach
            </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="category-wise-filter-product">
          <div class="section-title">
            <h2> Hotels in Bangladesh </h2>
          </div>
          <div class="single-product-box right-side-section-contant">
            @if(!empty($main_product))
            <div class="row">
              <div class="col-md-4">
                <div class="room-gallary-section">
                  <div class="slider slider-products">
                    @foreach($main_product->productImages as $image)
                      @php
                      $productImage =   str_replace("public/","",$image->image ?? '');
                      @endphp
                      <div class="gallary-img">
                        <img src="{{ asset('storage/'.$productImage) }}" width="100%!important" class="{{$value->name}}">
                      </div>
                    @endforeach
                  </div>
                  <div class="slider slider-nav">
                    @foreach($main_product->productImages as $image)
                      @php
                      $productImage =   str_replace("public/","",$image->image ?? '');
                      @endphp
                      <div class="gallary-img">
                        <img src="{{ asset('storage/'.$productImage) }}" width="100%!important" class="{{$value->name}}">
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="right-section-contant">
                  <div class="product-name">
                    <span> {{$main_product->name}} </span>
                  </div>
                  <div class="hotel-aria">
                    <p> {{$main_product->description}} </p>
                  </div>
                  <div class="review-secton">
                    <a href="#" class="btn btn-sm"> <i class="fa fa-star" aria-hidden="true"></i> {{helper::productRating($main_product->id)}}</a>
                    <span> ({{count($main_product->reviews)}} ratings ) </span>
                  </div>
                  <div class="select" style="display: none;">
                    <select class="form-control" id="rows_{{$main_product->id}}" name="number_of_rooms[]">
                      <?php
                        for($i=1;$i<=$main_product->number_of_room;$i++)
                        {?>
                            <option value="{{$i}}">{{$i}}</option>
                        <?php } ?>
                    </select>
                  </div>
                  <input type="checkbox" class="hidden" data-advance = "{{$main_product->productDetails->advance_percentage}}" data-price ="{{$main_product->sale_price}}" data-name="{{$main_product->name}}" id="{{$main_product->id}}" value="{{$main_product->id}}" name="checbox_room[]">
                  <div class="price-section">
                    <div class="price-items">
                      <span class="regular-price"> ৳ {{$main_product->sale_price}} </span> 
                      <div class="hotel-service-info">
                        <?php 
                        $room_attribute = explode(",",$main_product->productDetails->product_attributes);
                        ?>
                        @foreach($room_attribute as $attribute)
                        <p> <span> <i class="fa fa-television" aria-hidden="true"></i> {{$attribute}} </span> </p>
                        @endforeach
                      </div>
                    </div>
                    <div class="booking-btn">
                      <a href="{{ route('property_details',$main_product->id) }}" class="btn btn-sm view-details "> View Details </a>
                      <a href="{{ route('book_now',$main_product->id)}}"  for="{{$main_product->id}}" class="btn btn-sm booking-now "> Book Now</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif
            @if(!empty($product))
              <div class="product_filter">
                <div class="related-product-box">
                  <div class="section-title">
                    <h4> <span> Related Room </span></h4>
                  </div>
                  @foreach($product as $value)
                  <div class="related-room-items">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="room-gallary-section">
                          <div class="slider slider-products">
                            @foreach($value->productImages as $image)
                              @php
                              $productImage =   str_replace("public/","",$image->image ?? '');
                              @endphp
                              <div class="gallary-img">
                                <img src="{{ asset('storage/'.$productImage) }}" width="100%!important" class="{{$value->name}}">
                              </div>
                            @endforeach
                          </div>
                          <div class="slider slider-nav">
                            @foreach($value->productImages as $image)
                                @php
                                $productImage =   str_replace("public/","",$image->image ?? '');
                                @endphp
                                <div class="gallary-img">
                                  <img src="{{ asset('storage/'.$productImage) }}" width="100%!important" class="{{$value->name}}">
                                </div>
                              @endforeach  
                          </div>
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="right-section-contant">
                          <div class="product-name">
                            <span> {{$value->name}} </span>
                          </div>
                          <div class="hotel-aria">
                            <p> {{$value->description}} </p>
                          </div>
                          <div class="review-secton">
                            <a href="#" class="btn btn-sm"> <i class="fa fa-star" aria-hidden="true"></i> {{helper::productRating($value->id)}}</a>
                            <span> ({{count($value->reviews)}} ratings ) </span>
                          </div>
                          <div class="select" style="display: none;">
                            <select class="form-control" id="rows_{{$value->id}}" name="number_of_rooms[]">
                              <?php
                                for($i=1;$i<=$value->number_of_room;$i++)
                                {?>
                                    <option value="{{$i}}">{{$i}}</option>
                                <?php } ?>
                            </select>
                          </div>
                          <input type="checkbox" class="hidden" data-advance = "{{$value->productDetails->advance_percentage}}" data-price ="{{$value->sale_price}}" data-name="{{$value->name}}" id="{{$value->id}}" value="{{$value->id}}" name="checbox_room[]">
                          <div class="price-section">
                            <div class="price-items">
                              <span class="regular-price"> ৳ {{$value->sale_price}} </span> 
                              <div class="hotel-service-info">
                                <?php 
                                $room_attribute = explode(",",$value->productDetails->product_attributes);
                                ?>
                                @foreach($room_attribute as $attribute)
                                <p><span> <i class="fa fa-television" aria-hidden="true"></i> {{$attribute}} </span></p>
                                @endforeach
                              </div>
                            </div>
                            <div class="booking-btn">
                              <a href="{{ route('property_details',$value->id) }}" class="btn btn-sm view-details "> View Details </a>
                              <a href="{{ route('book_now',$value->id)}}"  for="{{$value->id}}" class="btn btn-sm booking-now "> Book Now</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</div>
@endsection
@section('script')
<script>
  var total_price = 0;
  var total_advance_price = 0;
  $('body').on('change', '.range-slider', function (event) {
    var min_price =$('#min_price').val();
    var max_price = $('#max_price').val();
    var checkedVals = $('.category_filter:checkbox:checked').map(function() {
      return this.value;
    }).get();
    var room_type  = checkedVals.join(",");
    var checked = $('.feature_filter:checkbox:checked').map(function() {
      return this.value;
    }).get();
    var features  = checked.join(",");
    var daterange = $('#daterange').val();
    daterange = daterange.split(' - ');
    var entry_date = daterange[0];
    var exit_date = daterange[ 1];
    var adult = $('#adult').val();
    var children = $('#children').val();
    var actionurl = "{{route('search_filter')}}";
    $.ajax({
      url: actionurl,
      type: 'get',
      data: {entry_date: entry_date, features:features, exit_date: exit_date,room_type:room_type,adult:adult,children:children, min_price:min_price, max_price:max_price},
      success: function(data) {
        console.log(data);
        $('.right-side-section-contant').empty();
        $('.right-side-section-contant').append(data);
      }
    });
  });
  $('body').on('click', '.category_filter', function (event) {
    var checkedVals = $('.category_filter:checkbox:checked').map(function() {
      return this.value;
    }).get();
    var room_type  = checkedVals.join(",");
    var checked = $('.feature_filter:checkbox:checked').map(function() {
      return this.value;
    }).get();
    var features  = checked.join(",");
    var daterange = $('#daterange').val();
    daterange = daterange.split(' - ');
    var entry_date = daterange[0];
    var exit_date = daterange[ 1];
    var adult = $('#adult').val();
    var children = $('#children').val();
    var min_price =$('#min_price').val();
    var max_price = $('#max_price').val();
    var actionurl = "{{route('search_filter')}}";
    $.ajax({
      url: actionurl,
      type: 'get',
      data: {entry_date: entry_date, features:features, exit_date: exit_date,room_type:room_type,adult:adult,children:children, min_price:min_price, max_price:max_price},
      success: function(data) {
        console.log(data);
        $('.right-side-section-contant').empty();
        $('.right-side-section-contant').append(data);
      }
    });
  });
  $('body').on('click', '.feature_filter', function (event) {
    var checked = $('.feature_filter:checkbox:checked').map(function() {
        return this.value;
    }).get();
    var features  = checked.join(",");
    var checkedVals = $('.category_filter:checkbox:checked').map(function() {
      return this.value;
    }).get();
    var room_type  = checkedVals.join(",");
    var daterange = $('#daterange').val();
    daterange = daterange.split(' - ');
    var entry_date = daterange[0];
    var exit_date = daterange[ 1];
    var adult = $('#adult').val();
    var children = $('#children').val();
    var min_price =$('#min_price').val();
    var max_price = $('#max_price').val();
    var actionurl = "{{route('search_filter')}}";
    $.ajax({
      url: actionurl,
      type: 'get',
      data: {entry_date: entry_date,features:features, exit_date: exit_date,room_type:room_type,adult:adult,children:children, min_price:min_price, max_price:max_price},
      success: function(data) {
        console.log(data);
        $('.right-side-section-contant').empty();
        $('.right-side-section-contant').append(data);
      }
    });
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
   $('body').on('click', '.add_on_price', function (event) {
    var add_on= $(this).attr('data-id');
    var name = $('#'+add_on).attr('data-name');
    var price = $('#'+add_on).attr('data-price');
    total_price = Number(total_price)+Number(price) ;
    $('.total_price').html(total_price);
    $('.new_price').val(total_price);
   });
  // stepper
  var currentTab = 0; 
  showTab(currentTab); 
  function showTab(n) {
    // This function will display the specified tab of the form...
    var x = document.getElementsByClassName("tab");
    x[n].style.display = "block";
    //... and fix the Previous/Next buttons:
    if (n == 0) {
      document.getElementById("prevBtn").style.display = "none";
    } else {
      document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
      document.getElementById("nextBtn").innerHTML = "Submit";
    } else {
      document.getElementById("nextBtn").innerHTML = "Next";
    }
    //... and run a function that will display the correct step indicator:
    fixStepIndicator(n)
  }
  function nextPrev(n) {
    // This function will figure out which tab to display
    var x = document.getElementsByClassName("tab");
    // Exit the function if any field in the current tab is invalid:
    if (n == 1 && !validateForm()) return false;
    // Hide the current tab:
    x[currentTab].style.display = "none";
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;
    // if you have reached the end of the form...
    if (currentTab >= x.length) {
      // ... the form gets submitted:
      document.getElementById("room-service-items-section").submit();
      return false;
    }
    // Otherwise, display the correct tab:
    showTab(currentTab);
  }
  function validateForm() {
    // This function deals with validation of the form fields
    var x, y, i, valid = true;
    x = document.getElementsByClassName("tab");
    y = x[currentTab].getElementsByTagName("input");
    // A loop that checks every input field in the current tab:
    for (i = 0; i < y.length; i++) {
      // If a field is empty...
      if (y[i].value == "") {
        // add an "invalid" class to the field:
        y[i].className += " invalid";
        // and set the current valid status to false
        valid = false;
      }
    }
    // If the valid status is true, mark the step as finished and valid:
    if (valid) {
      document.getElementsByClassName("step")[currentTab].className += " finish";
    }
    return valid; // return the valid status
  }
  function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...
    var i, x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++) {
      x[i].className = x[i].className.replace(" active", "");
    }
    //... and adds the "active" class on the current step:
    x[n].className += " active";
  }
  $(document).ready(function(){
    $(function() {
      $('input[name="daterange"]').daterangepicker({
        opens: 'left'
      }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        var entry_date = start.format('YYYY-MM-DD');
        var exit_date = end.format('YYYY-MM-DD');
        var room_type = $('#room_type').val();
        var adult = $('#adult').val();
        var children = $('#children').val();
        var actionurl = "{{route('search_filter')}}";
        $.ajax({
          url: actionurl,
          type: 'get',
          data: {entry_date: entry_date, exit_date: exit_date,room_type:room_type,adult:adult,children:children},
          success: function(data) {
          console.log(data);
            $('.right-side-section-contant').empty();
            $('.right-side-section-contant').append(data);
          }
        });
      });
    });
  });   
</script>
@endsection