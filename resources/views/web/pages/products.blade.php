
<?php
use App\SM\SM;
?>
  <div class="container">
    <div class="row">
      @if(!empty($product))
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
                      <h5>Number of Bed :{{$value->productDetails->number_of_bed}}</h5>
                    </div>
                    <div class="items-price">
                      <h5>Price : Tk {{$value->sale_price}}</h5>
                    </div>
                  </div>
                </div>
                <div class="overlay">
                  <h3 class="property-title"><a href="{{ route('property_details',$value->id) }}">{{$value->name}}</a></h3>
                  <span><b>No of Bed : {{$value->productDetails->number_of_bed}}<span> </span></b></span>,
                  <span><b>Room No: <span> {{$value->productDetails->room_no}} </span> </b></span>
                  <p class="price-tag">Tk {{$value->sale_price}} </p>
                  <div class="property-details">
                    <div class="hotel-service-info">
                      <?php 
                          $room_attribute = explode(",",$value->productDetails->product_attributes);
                          ?>
                          @foreach($room_attribute as $attribute)
                          <p>{{$attribute}}</p>
                          @endforeach
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
