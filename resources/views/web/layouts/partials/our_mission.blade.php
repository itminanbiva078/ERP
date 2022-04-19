@php
  use App\SM\SM;
  $our_mission = SM::smGetThemeOption( "our_mission_new", "" );
  $our_vission = SM::smGetThemeOption( "our_vission", "" );
  $our_mission_img = SM::smGetThemeOption( "our_mission_image", "" );
  $our_vission_img = SM::smGetThemeOption( "our_vision_image", "" );
@endphp

{{-- <section class="ourmissin-vissiom ourmissinVission">
    <div class="backgound-bg-overlay">
        <div class="container">
            <h2 class="text-center pb-4">Our Visison & Mission</h2>
            <div class="row">
                @if(!empty($our_mission))
                    <div class="col-md-12">
                        <div class="our-mission">
                            <div class="row">
                                <div class="col-md-6 padding-zero">
                                    <div class="section-contant">
                                        <h2 class="our-mission-title">Our Mission</h2>
                                        <p> {!!$our_mission!!} </p>
                                    </div>
                                </div>
                                <div class="col-md-6 padding-zero">
                                    <div class="mission-img d-flex justify-content-center align-items-center" style="background-image: url({!! SM::sm_get_the_src( $our_mission_img ) !!}); height:100%;">
                                        @if(!empty($our_mission_img))
                                        <img src="" alt="">
                                        @else
                                        <img height="500" width="500" src="{{asset('assets/images/image-not-found.png')}}" alt="">
                                        @endif

                                        <h3 class="text-light">Our Mission</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if(!empty($our_vission))
                    <div class="col-md-12">
                        <div class="our-vission">
                            <div class="row">
                                <div class="col-md-6 padding-zero">
                                    <div class="vission-img d-flex justify-content-center align-items-center" style="background-image: url({!! SM::sm_get_the_src( $our_vission_img ) !!}); height:100%;">
                                        @if(!empty($our_vission_img))
                                        <img src="{!! SM::sm_get_the_src( $our_vission_img ) !!}" alt="">
                                        @else
                                        <img height="500" width="500" src="{{asset('assets/images/image-not-found.png')}}" alt="">
                                        @endif
                                        <h3 class="text-light">Our Vission</h3>
                                    </div>
                                </div>
                                <div class="col-md-6 padding-zero">
                                    <div class="section-contant">
                                        <h2 class="our-vission-title text-right">Our Vission</h2>
                                        <p>{!!$our_vission!!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section> --}}
<section id="product-preview">
	<div class="product-preview">
		<div>
			<img src="{{ $our_vission_img != null ? SM::sm_get_the_src($our_vission_img) : asset('default-image/default-gallery.jpg') }}" alt="" class="img-fluid"> 
		</div>
		<div class="product-content">
			<h3 class="pb-3">Our Vission</h3>
			<p class="text-center">{!! $our_vission !!}</p>
			{{-- <div class="seemoreBtn">
				<a href="javascript:void(0)" class="btn btn-sm">Check Room</a>
			</div> --}}
		</div>
	</div>
	<div class="product-preview">
		<div class="product-content">
			<h3 class="pb-3">Our Mission</h1>
			<p class="text-center">{!! $our_mission !!}</p>
			{{-- <div class="seemoreBtn">
				<a href="javascript:void(0)" class="btn btn-sm">Check Room</a>
			</div> --}}
		</div>
		<div>
			<img src="{{ $our_mission_img != null ? SM::sm_get_the_src($our_mission_img) : asset('default-image/default-gallery.jpg') }}" alt="" class="img-fluid"> 
		</div>
	</div>
</section>