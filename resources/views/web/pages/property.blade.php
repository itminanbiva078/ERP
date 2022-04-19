<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@extends('web.layouts.master')
@section('title')
Hotel Mohona
@endsection
@section('frontend-content')
<?php
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
?>
<style type="text/css">
  .book_now{
    width: 40%;
    float: right;
    margin-top: -5px;
  }
</style>
<section class="common-page-breadcumb"  style="background-image: url({{asset('assets/images/common_banar-img.jpg')}})">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="pagetitle-and-breadcumb">
          <h3>Our Rooms</h3>
          <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li>Our Rooms</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- --------------------------- -->
<section class="who-we-content-section pad-30">
  <div class="container">
    <div class="property-search-box-here">
      <form method="POST" action="{{ route('rooms') }}">
        @csrf
        <div class="row justify-content-center">
          <div class="col-md-3" >
            <div class="form-group">
              <label class="control-label">Rooms Type</label>
              <select class="selectpicker form-control" id="room_type" name="room_type" data-live-search="true" required>
                <option selected disabled>Select Rooms Type</option>
                <option value="all-rooms">All Rooms</option>
                @foreach($category as $cat_id)
                  <option @if(!empty($room_type) && $room_type == $cat_id->id) selected @endif data-icon="fa fa-home" value="{{$cat_id->id}}">{{$cat_id->name}}</option>
                @endforeach                
              </select>
            </div>
          </div>
          <div class="col-md-3" >
            <div class="form-group">
              <label class="control-label"><br></label>
              <div>
                <button type="submit" class="btn btn-custom btn-block text-light">Search</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<section class="services-us-section product_section">
  @php
    use App\SM\SM;
  @endphp
  <div class="container">
    <div class="row">

      @if($product->isNotEmpty())
        @foreach($product as $value)
          <div class="col-md-3">
            <a href="{{ route('property_details',$value->id) }}">
              <div class="property-conent-box">
                <div class="product-images">
                  @php 
                  $image = $value->productImages[0] ?? '';
                  $productImage =   str_replace("public/","",$image->image ?? '');
                  @endphp

                  @if(!empty($productImage))
                  <img src="{{ asset('storage/'.$productImage) }}" width="100%!important" class="{{$value->name}}">
                  @else 
                  <img src="https://ttg.com.bd/uploads/tours/hotels/306_02jpg.jpg" class="{{$value->name}}">
                  @endif

                  <!-- <div class="booking-status">	
                    <div class="booking-status-contant">
                      <img src="{{asset('assets/images/blob.svg')}}" alt="">
                      <b> Booked </b>
                    </div>
                  </div> -->
                </div>
                <div class="product-info">
                  <div class="product-name">
                    <h4>{{$value->name}}</h4>
                  </div>
                  <div class="purchase-information">
                    <div class="items-number">
                      <h5>Number of Bed :{{$value->productDetails->number_of_bed ?? 0}}</h5>
                    </div>
                    <div class="items-price">
                      <h5> ৳ {{$value->sale_price}}</h5>
                    </div>
                  </div>
                </div>
                <div class="overlay">
                  <h3 class="property-title"><a href="{{ route('property_details',$value->id) }}">{{$value->name}}</a></h3>
                  <span><b>No of Bed : {{$value->productDetails->number_of_bed ?? 0}}<span> </span></b></span>,
                  <span><b>Room No: <span> {{$value->productDetails->room_no ?? 0}} </span> </b></span>
                  <p class="price-tag">৳ {{$value->sale_price ?? 0}} </p>
                  <div class="property-details">
                    <div class="hotel-service-info">
                      <?php 
                      if(!empty($value->productDetails->product_attributes)):
                          $room_attribute = explode(",",$value->productDetails->product_attributes);
                          ?>
                          @foreach($room_attribute as $attribute)
                          <p>{{$attribute}}</p>
                          @endforeach
                          <?php endif;?>
                      </div>
                  </div>
                  <div class="view-details-btn">
                    <a href="{{ route('property_details',$value->id) }}" class="btn btn-default search-now-btn "> View Details <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                  </div>
                  <!-- <div class="stock-check hidden">
                    <span> Stock Out </span>
                  </div> -->
                </div>
              </div>
            </a>
          </div>
        @endforeach
        @else
        <div class="alert alert-danger text-center">
          <strong>Warning!</strong> There  is no content!!.
        </div>
      @endif
      
      
    </div>
    <ul class="pagination custom-pagination" style="display: none;">
      <li><a href="#">Start</a></li>
      <li><a href="#">1</a></li>
      <li class="active"><a href="#">2</a></li>
      <li><a href="#">3</a></li>
      <li><a href="#">4</a></li>
      <li><a href="#">5</a></li>
      <li><a href="#">End</a></li>
    </ul>
  </div>
</section>
<script type="text/javascript">
  
  $('body').on('change', '#room_type', function (event) {
    var daterange = $('#daterange').val();
    var room_type = $('#room_type').val();
    var adult = $('#adult').val();
    var children = $('#children').val();
    var _token = "{{ csrf_token() }}";
    var actionurl = "{{route('search_room')}}";
    $.ajax({
      url: actionurl,
      type: 'get',
      data: {daterange: daterange, room_type: room_type,adult:adult,children:children,_token:_token},
      success: function(data) {
        console.log(data);
        $('.product_section').empty();
        $('.product_section').append(data);
      }
    });
  });
  $(document).ready(function(){
    $(function() {
      $('input[name="daterange"]').daterangepicker({
        opens: 'left'
      }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
      });
    }); 
  });

</script>
@endsection