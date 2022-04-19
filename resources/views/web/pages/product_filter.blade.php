@if(!empty($product))
              <div class="product_filter">
                      <div class="related-product-box">
                        <div class="section-title">
                          <h4> <span> Related Room </span></h4>
                        </div>
                @foreach($product as $value)
                  <div class="filter-product-card">
                  <div class="row">
                    <div class="col-md-4">
                        <div class="room-gallary-section">
                          <div class="main">
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
                          <div class="product-info">
                            <div class="price-items">
                              <span class="regular-price"> Price : {{$value->sale_price}} Tk </span> 
                              <div class="hotel-service-info">
                                  <?php 
                                    $room_attribute = explode(",",$value->productDetails->product_attributes);
                                    ?>
                                    @foreach($room_attribute as $attribute)
                                    <p> <i class="fa fa-television" aria-hidden="true"></i> {{$attribute}} </p>
                                  @endforeach
                              </div>
                            </div>
                          </div> 
                          <div class="cart-info">
                            <div class="booking-btn">
                              <a href="{{ route('property_details',$value->id) }}" class="btn btn-sm view-details "> View Details </a>
                              <a href="{{ route('book_now', $value->id)}}"  for="{{$value->id}}" class="btn btn-sm booking-now "> Book Now</a>
                            </div>
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
<script type="text/javascript">
    var numSlick = 0;
$('.slider-products').each( function() {
  numSlick++;
  $(this).addClass( 'slider-' + numSlick ).slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    fade: true,
    prevArrow:"<div class='left-arrow'> <i class='fa fa-angle-double-left'></i> </div>",
    nextArrow:"<div class='right-arrow'> <i class='fa fa-angle-double-right'></i> </div>",
    asNavFor: '.slider-nav.slider-' + numSlick
  });
});

numSlick = 0;
$('.slider-nav').each( function() {
  numSlick++;
  $(this).addClass( 'slider-' + numSlick ).slick({
    vertical: false,
    slidesToShow: 4,
    slidesToScroll: 1,
    asNavFor: '.slider-products.slider-' + numSlick,
    arrow: false,
    focusOnSelect: true,
    prevArrow:"<div class='left-arrow'> <i class='fa fa-angle-double-left'></i> </div>",
    nextArrow:"<div class='right-arrow'> <i class='fa fa-angle-double-right'></i> </div>",
    responsive: [
      {
        breakpoint: 800,
        settings: {
          slidesToShow: 3,
         }
      }
    ]
  });
});
</script>