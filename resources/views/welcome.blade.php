@extends('web.layouts.master')
@section('title')
	Hotel Mohona
@endsection
@section('style')
	<style>
		.main-slider-section .slider-contant input {
			border: 1px solid #dfb251;
			height: 68px;
		}
		.main-slider-section .slider-contant select {
			border: 1px solid #dfb251;
			background: black !important;
			height: 68px;
			opacity: 0.8;
		}
		.main-slider-section .slider-contant {
			background: transparent;
		}
		.slider-contant input{
			background: black;
		}
		/* .slider-contant option{
			background: black;
		} */
		.main-slider-section .slider-contant form button{
			outline: none;
			border-radius: 0px;
			cursor: pointer;
			height: 68px;
		}
		.main-slider-section .slider-contant {
			width: 68%;
		}
		.main-slider-section img {
			height: 600px;
			object-fit: cover;
		}
		#product-preview{
			background: rgb(253 248 236);
		}
		#product-preview img{
			width: 100%;
    		height: 100%;
		}
		.product-preview{
			display: grid;
			grid-template-columns: 50% 50%;
		}
		.product-content{
			display: flex;
			justify-content: center;
			align-items: center;
			flex-direction: column;
			padding: 50px;
		}
		.gallery-item img{
			width: 100%;
			height: 300px;
			object-fit: cover;

		}
		@media only screen and (min-width: 320px) and (max-width: 767.98px) {
			.product-preview{
				display: grid;
				grid-template-columns: 100%;
			}
		}
		.services-box img{
			width: 100px;
			height: 100px;
		}


		@media only screen and (min-width: 1200px) and (max-width: 1599.98px) {
			.main-slider-section .slider-contant {
				width: 95%;
			}
			.main-slider-section .slider-contant input {
				font-size: 20px;
			}
			.main-slider-section .slider-contant select {
				font-size: 20px;
			}
		}
		@media only screen and (min-width: 992px) and (max-width: 1199.98px) {

		}
		@media only screen and (min-width: 768px) and (max-width: 991.98px) {

		}
	</style>
@endsection

@php
  use App\SM\SM;
  $about_hotel = SM::smGetThemeOption( "wwr_description", "" );
  $home_promo_video = SM::smGetThemeOption( "home_promo_video", "" );
  $total_project = SM::smGetThemeOption( "total_project", "" );
  $testimonials = SM::smGetThemeOption("testimonials", "");
  $product_title = SM::smGetThemeOption("product_title", "");
  $product_des = SM::smGetThemeOption("product_des", "");
  $product_image = SM::smGetThemeOption("product_image", "");
  $product_title2 = SM::smGetThemeOption("product_title2", "");
  $product_des2 = SM::smGetThemeOption("product_des2", "");
  $product_image2 = SM::smGetThemeOption("product_image2", "");
  $luxuries = SM::smGetThemeOption("luxuries", "");
@endphp

@section('frontend-content')
@include('web.layouts.partials.slider')
@include('web.layouts.partials.category_product')
<section id="product-preview">
	<div class="product-preview">
		<div>
			<img src="{{ $product_image != null ? SM::sm_get_the_src($product_image) : asset('default-image/default-gallery.jpg') }}" alt="" class="img-fluid"> 
		</div>
		<div class="product-content">
			<h3>{{ $product_title }}</h2>
			<p class="text-center">{{ $product_des }}</p>
			<div class="seemoreBtn">
				<a href="javascript:void(0)" class="btn btn-sm">Check Room</a>
			</div>
		</div>
	</div>
	<div class="product-preview">
		<div class="product-content">
			<h3>{{ $product_title2 }}</h3>
			<p class="text-center">{{ $product_des2 }}</p>
			<div class="seemoreBtn">
				<a href="javascript:void(0)" class="btn btn-sm">Check Room</a>
			</div>
		</div>
		<div>
			<img src="{{ $product_image != null ? SM::sm_get_the_src($product_image2) : asset('default-image/default-gallery.jpg') }}" alt="" class="img-fluid"> 
		</div>
	</div>
</section>
@include('web.layouts.partials.service')
@include('web.layouts.partials.our_mission')
<div class="wow slideInLeft welcome-video-section" data-wow-duration="1s" data-wow-delay=".1s">
	<div class="container">
	    <div class="row">
			<div class="col-md-6">
				<div class="welcome-massage">
					<div class="section-title">
						<h2> Welcome to Hotel Mohona </h2>
					</div>
					@if(!empty($about_hotel))
					<div class="section-contant">
						<p>{!!$about_hotel!!} </p>
					</div>
					@else
					<div class="alert alert-danger text-center">
						<strong>Warning!</strong> There  is no content!!.
					</div>
					@endif
				</div>
			</div>
			@if(!empty($home_promo_video))
				<div class="col-md-6">
					<iframe  src="{!!$home_promo_video!!}" style="width:100%; height:400px; border: 1px solid black; "></iframe>
				</div>
			@else
			<div class="col-md-6">
				<iframe  src="https://www.youtube.com/embed/8XP9VgxuthU" style="width:100%; height:400px; border: 1px solid black; "></iframe>
			</div>
			@endif
		</div>
	</div>
</div>
<section class="our-testimonial-section" style="background-image: url('{{asset('assets/images/testimonial-bg.jpg')}}');">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="our-testimonial-box">
					<div class="testimonial-slider">
						@if(!empty($testimonials))
							@foreach($testimonials as $row)
								@if($row)
									<div>
										<div class="testimonial-items">	
											<div class="section-img">
												<img src="{{SM::sm_get_the_src($row['testimonial_image'])}}" alt="">
											</div>
											<div class="seciton-contant">
												<div class="customer-name">
													<h4> {{ $row['title']}} </h4>
												</div>
												<article>
													<p style="color:#fff"><blockquote> {{ strip_tags($row['description']) }}</blockquote> </p>
												</article>
											</div>
										</div>
									</div>
								@endif
							@endforeach
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@include('web.layouts.partials.gallery')
@include('web.layouts.partials.construction')
@endsection

@section('script')

@endsection