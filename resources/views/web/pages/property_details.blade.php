<?php
  use App\SM\SM;
  $hotel_policy = SM::smGetThemeOption( "hotel_policy", "" );
  $guset_policy = SM::smGetThemeOption( "guset_policy", "" );
?>
@extends('web.layouts.master')
@section('title')
Hotel Mohona
@endsection


@section('style')
  <style>
    .form-control:focus {
      box-shadow: none;
      border-color: none !important;
    }
    .form-control:focus {
      border-color: white !important !important !important;
    }
  </style>
@endsection

@section('frontend-content')
  <section class="common-page-breadcumb"  style="background-image: url({{asset('assets/images/common_banar-img.jpg')}})" >
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="pagetitle-and-breadcumb">
            <h3>Room Details</h3>
            <ul class="breadcrumb">
              <li><a href="/">Home</a></li>
              <li>Room Details</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="services-us-section property-details-section ">
    <div class="container">
      <div class="property-detais-section">
        <div class="row">
          <div class="col-md-9">
            <div class="property-details-page">
              <div class="section-title">
                <h4 >{!!$product->name!!} </h4>
              </div>
              <div class="property-slide-content">
                <div class="owl-carousel property-discription-active owl-theme">
                  @foreach($product->productImages as $key=> $eachImage)
                    @php 
                      $products =   str_replace("public/","",$eachImage->image);
                    @endphp
                    <div class="item">
                      <div class="property-details-img">
                        @if(!empty($products))
                        <img src="{{ asset('storage/'.$products) }}" width="100%!important" class="{{$product->name}}">
                        @else 
                        <img src="{{asset('assets/images/property-1.jpg')}}" class="img-responsive">
                        @endif
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
              <div class="product-details-btn">
                <div class="booking-btn">
                  <a href="{{ route('book_now',$product->id)}}"  for="{{$product->id}}" class="btn btn-default btn-block search-now-btn"> Book Now</a>
                </div>
              </div>
              <div class="hotel-facilitys">
                <div class="section-title">
                  <h4> Hotel Facilities </h4>
                </div>
                <ul>
                  <?php
                  $room_attribute = explode(",",$product->productDetails->product_attributes);
                  ?> 
                  @foreach($room_attribute as $attribute)
                  <li> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span> {{$attribute ?? ''}} </span></li>
                  @endforeach
                </ul>
              </div>
              <form action="{{ route('review') }}" method="POST">
                @csrf
                <div class="coustomer-rating">
                  <div class="section-title">
                    <h4> Customer Rating </h4>
                  </div>
                  <div class="rating-star" >
                    <div class="smileybox">	
                        <label for="r1" class="check"><input type="checkbox" id="r1" name="rating" value="1" onchange="ratingStar(event)"/><i class="em em-weary"></i></label>
                        <label for="r2" class="check"><input type="checkbox" id="r2" name="rating" value="2" onchange="ratingStar(event)"/><i class="em em-worried"></i></label>
                        <label for="r3" class="check"><input type="checkbox" id="r3" name="rating" value="3" onchange="ratingStar(event)"/><i class="em em-blush"></i></label>
                        <label for="r4" class="check"><input type="checkbox" id="r4" name="rating" value="4" onchange="ratingStar(event)"/><i class="em em-smiley"></i></label>
                        <label for="r5" class="check"><input type="checkbox" id="r5" name="rating" value="5" onchange="ratingStar(event)"/><i class="em em-sunglasses"></i></label>
                    </div>
                  </div>

                  <input type="hidden"  name="product_id" class="form-control" value="{{$product->id}}" placeholder="name">

                  <div class="comment-area">
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text"  name="name" id="name" class="form-control required"  placeholder="Name" required>
                    </div>
                    <div class="form-group">
                      <label for="comment">Comment:</label>
                      <textarea class="form-control required" rows="5" id="comment" name="comments" required></textarea>
                    </div>
                    <button type="submit"> Comment Now <i class="fa fa-commenting-o" aria-hidden="true"></i> </button>
                  </div>
                </div>
              </form>
              
              @if(count($product->reviews) > 0)
              <div class="comment-review-area">
                <div class="section-title">
                  <h4> Customer Review</h4>
                </div>
                  <div class="customer-review-contant">
                    @if(!empty($product))
                      @foreach($product->reviews as $key=> $value)
                        <div class="single-comment">
                          <div class="row">
                            <div class="col-md-2">
                              <div class="section-img"> 
                                <img class="mr-3" src="{{asset('assets/images/comment_icon.jpg')}}" alt="Generic placeholder image">
                              </div>
                            </div>
                            <div class="col-md-10">
                              <div class="section-contant">
                                <h5 class="mt-0">{{$value->name ?? '' }} </h5>
                                <p> {{$value->comments ?? ''}}</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    @endif 
                </div>
              </div>
              @endif

              <div class="hotel-system-policy">
                <div class="hotel-policies">
                  <div class="section-title">
                    <h4> Hotel Policies </h4>
                  </div>
                  <div class="hotel-policies-list">
                    <p>  {!!  substr(strip_tags($hotel_policy), 0, 200) !!} <a href=" #" type="button"  data-toggle="modal" data-target=".hotel-policy-modal"> Reed More </a></p>
                  </div>
                </div>
                <div class="guest-policies">
                  <div class="section-title">
                    <h4> Guest Policies </h4>
                  </div>
                  <div class="guest-policies-list">
                    <p> {!!  substr(strip_tags($guset_policy), 0, 200) !!}  <a href=" #" type="button"  data-toggle="modal" data-target=".geaust-policy-modal"> Reed More </a></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="property-details-right-side" id="property-details-right-side">
              <div class="quick-summary-box box-shadow mar-bot-20px">
                <div class="quick-summary-box">
                  <div class="section-title">
                    <h4> Quick Summary </h4>
                  </div>
                  <div class="booking-date">
                    <form action="{{route("property_details",$detailsId)}}" method="POST">
                      @csrf
                      <div class="form-group">
                        <input type="text"  id="daterange" name="daterange" class="form-control daterange" value="<?php echo $dateran ?? '';?>"/>
                        <button class="btn btn-success" id="searchForFilter" type="submit"><i class="fa fa-search"></i></button>
                      </div>
                    </form>
                  </div>
                  <div class="quick-summary-table">
                    <table class="table">
                      <tbody>
                        <tr>
                          <th>Number Of Bed <span>:</span></th>
                          <td>{!! $product->productDetails->number_of_bed ?? 0 !!}</td>
                        </tr>
                        <tr>
                          <th>Room No<span>:</span></th>
                          <td>{!! $product->productDetails->room_no ?? 0 !!}</td>
                        </tr>
                        <tr>
                          <th>Number of Person<span>:</span></th>
                          <td>{!! $product->productDetails->number_of_room ?? 0 !!}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="property-diicription">
                  <div class="section-title">
                    <h4> Room Description </h4>
                  </div>
                  {!!$product->description!!}
                </div>
              </div>
              <div class="quick-summary-box box-shadow mar-bot-20px">
                <div class="form-group">
                  <div class="booking-btn">
                    @if(!empty($roomStatus) && $roomStatus == 'show')
                       <a href="{{ route('book_now',$product->id)}}"  for="{{$product->id}}" class="btn btn-default btn-block search-now-btn"> Book Now</a>
                    @else 
                       <a href="#"   disabled class="btn btn-default btn-block search-now-btn"> Room Not Avaialble. Search Different Date</a>
                    @endif
                  </div>
                  {{-- <form  action="{{route('room_list')}}">
                    <input type="hidden" name="id" value="{{$product->id}}">
                    <button href="#" type="submit" class="btn btn-default btn-block search-now-btn">Book Now <i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                  </form> --}}
                </div>
              </div>
            </div>  
          </div>
        </div>
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
                      {!! stripslashes($hotel_policy) !!}
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
                {!! stripslashes($guset_policy) !!}
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
    <div class="container">
      <div class="row">
        <div class="col-md-12">
        @if(!empty($similar_product))
        
          <div class="quick-summary-box quick-summary-slider">
            <div class="section-title">
              <h4> Similar Room </h4>
            </div>
            <div class="similar-room-active">
              @foreach($similar_product as $similar_pro)
                <div>
                  <a href="{{ route('property_details',$similar_pro->id) }}">
										<div class="property-conent-box">
                      <div class="product-images">
                        @php 
                          $image = $similar_pro->productImages[0] ?? '';
                          $productImage =   str_replace("public/","",$image->image ?? '');
                          @endphp

                          @if(!empty($productImage))
                          <img src="{{ asset('storage/'.$productImage) }}" width="100%!important" class="{{$similar_pro->name}}">
                          @else 
                          <img src="https://ttg.com.bd/uploads/tours/hotels/306_02jpg.jpg" class="{{$similar_pro->name}}">
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
													<h6>{{$similar_pro->name}}</h4>
												</div>
												<div class="purchase-information">
													<div class="items-number">
														<h6>Number of Bed :{{$similar_pro->productDetails->number_of_bed ?? 0}}</h6>
													</div>
													<div class="items-price">
														<h6>৳ {{$similar_pro->sale_price}} </h6>
													</div>
												</div>
											</div>

											<div class="overlay">
                        <h3 class="property-title"><a href="{{ route('property_details',$similar_pro->id) }}">{{$similar_pro->name}}</a></h3>
                        <span><b>No of Bed : <span> {{$similar_pro->productDetails->number_of_bed ?? 0}}</span></b></span>,
                        <span><b>Room No: <span> {{$similar_pro->productDetails->room_no ?? 0}} </span> </b></span>
												<p class="price-tag"> {{$similar_pro->sale_price ?? 0}} </p>
												<div class="property-details">
                          <div class="hotel-service-info">
                            <?php 
                            if(!empty($similar_pro->productDetails->product_attributes)):
                                $room_attribute = explode(",",$similar_pro->productDetails->product_attributes);
                              ?>
                              @foreach($room_attribute as $attribute)
                                <p>{{$attribute}}</p>
                              @endforeach
                              <?php endif;?>
                          </div> 
												</div>
												<div class="view-details-btn">
                          <a href="{{ route('property_details',$similar_pro->id) }}" class="btn btn-default search-now-btn " style="float:right;"> View Details <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
												</div>
												<!-- <div class="stock-check hidden">
													<span> Stock Out </span>
												</div> -->
											</div>
										</div>
									</a>
                </div>
              @endforeach
            </div>
          </div>
          @else
          <div class="alert alert-danger">
            <strong>Warning!</strong> There  is no Success!!.
          </div>
          @endif
        </div>
      </div>
      </div>
    </div>
  </section>
@endsection
@section('scripts')

<script>

$(document).ready(function(){
    $(function() {
      $('input[name="daterange1"]').daterangepicker({
        opens: 'left',
        minDate:new Date(),
      }, function(start, end, label) {
        
      });
    });
  });






// $(function() {
//   $('input[name="daterange"]').daterangepicker({
//     opens: 'left',
//     startDate: '03/05/2005',
//      endDate: '03/06/2005',
//   }, function(start, end, label) {
//     console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
//   });
// });
</script>
@endsection
 