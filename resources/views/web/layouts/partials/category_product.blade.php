@php
  	use App\SM\SM;
@endphp
<section class="services-us-section background-images " id="back-image">
	<div class="services-section-overlay">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="services-section-title wow slideInLeft" data-wow-duration="1s" data-wow-delay=".1s">
						<h3>Our Rooms</h3>
					</div> 
				</div>
			</div>
			@if($category->isNotEmpty())
			<div class="row">
				@foreach($category as $value_category)
				<div class="col-md-12">
					<div class="section-title">
						<h3>{{$value_category->name}}</h3>
					</div>
				</div>
				<div class="col-md-12">
					<div class="category-wise-product-active">
						@foreach($product as $value_product)
							@if($value_product->category_id == $value_category->id)
								<div>
									<a href="{{ route('property_details',$value_product->id) }}">
										<div class="property-conent-box">
											<div class="product-images">
												<img src="{{ asset(helper::imageUrl($value_product->productImages[0]->image ?? '')) }}" width="100%!important" class="{{$value_product->name}}">
												<!-- <div class="booking-status">	
													<div class="booking-status-contant">
														<img src="{{asset('assets/images/blob.svg')}}" alt="">
														<b> Booked </b>
													</div>
												</div> -->
											</div>
											<div class="product-info">
												<div class="product-name d-flex justify-content-between">
													<h6>{{$value_product->name}}</h6>
													<div class="smileybox">	
														<label for="r1" class="check"><input type="checkbox" id="r1" name="rating" value="1" onchange="ratingStar(event)"><i class="em em-weary"></i></label>
														<label for="r2" class="check"><input type="checkbox" id="r2" name="rating" value="2" onchange="ratingStar(event)"><i class="em em-worried"></i></label>
														<label for="r3" class="check"><input type="checkbox" id="r3" name="rating" value="3" onchange="ratingStar(event)"><i class="em em-blush"></i></label>
														<label for="r4" class="check"><input type="checkbox" id="r4" name="rating" value="4" onchange="ratingStar(event)"><i class="em em-smiley"></i></label>
														<label for="r5" class="check"><input type="checkbox" id="r5" name="rating" value="5" onchange="ratingStar(event)"><i class="em em-sunglasses"></i></label>
													</div>
												</div>
												<div class="purchase-information">
													<div class="items-number">
														<h6>Number of Bed :{{$value_product->productDetails->number_of_bed ?? 0}}</h6>
													</div>
													<div class="items-price">
														<h6>৳ {{$value_product->sale_price}}</h6>
													</div>
												</div>
											</div>
											<div class="overlay">
												<h3 class="property-title"><a href="{{ route('property_details',$value_product->id) }}">{{$value_product->name}}</a></h3>
												<span>No of Bed : {{$value_product->productDetails->number_of_bed ?? 0}}</span>,
												<span>Room No:  {{$value_product->productDetails->room_no ?? 0}}</span>
												<p class="price-tag">৳ {{$value_product->sale_price ?? 0}} </p>
												<div class="property-details">
													<div class="hotel-service-info">
														<?php 
															$room_attribute = explode(",",$value_product->productDetails->product_attributes ?? '');
														?>
														@foreach($room_attribute as $attribute)
															<p>{{$attribute}}</p>
														@endforeach
													</div>		
												</div>
												<div class="view-details-btn">
													<a href="{{ route('property_details',$value_product->id) }}" class="btn btn-default search-now-btn "> View Details <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>

												</div>
												<!-- <div class="stock-check hidden">
													<span> Stock Out </span>
												</div> -->
											</div>
											
										</div>
									</a>
									
								</div>
								
							@endif
						@endforeach
					</div>
				</div>
				<div class="col-md-12">
					<div class="seemoreBtn">
						<a href="{{ route('category_product',$value_category->id) }}" class="btn btn-sm"> View All <i class="fa fa-caret-right" aria-hidden="true"></i> </a>
					</div>
				</div>
				@endforeach
			</div>
			@else
			<div class="alert alert-danger text-center">
				<strong>Warning!</strong> There  is no content!!.
			  </div>
			@endif
		</div>
	</div>
</section>
