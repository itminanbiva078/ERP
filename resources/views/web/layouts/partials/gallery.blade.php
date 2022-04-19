@php
  use App\SM\SM;
  $galleries = SM::smGetThemeOption("galleries", "");
@endphp
<!-- ======= Gallery Section ======= -->
<section id="gallery" class="gallery py-5">
	<div class="container" data-aos="fade-up">
		<div class="section-title pb-4">
			<div class="services-section-title" data-wow-duration="1s"  >
				<h3>Gallery</h3>
			</div>
		</div>
	</div>
	<div class="container-fluid" data-aos="fade-up" data-aos-delay="100">
		<div class="row g-0">
			@if(!empty($galleries[0]))
				@foreach ($galleries as $gallery_img)
				<div class="col-lg-3 col-md-4 p-0">
					@if(!empty($gallery_img))
					<div class="gallery-item">
						<a href="{{ SM::sm_get_the_src($gallery_img['gallery_image'])}}" class="gallery-lightbox" data-gall="gallery-item">
							<img src="{{ SM::sm_get_the_src($gallery_img['gallery_image'])}}" alt="" class="img-fluid">
						</a>
					</div>
					@endif
				</div>
				@endforeach
			@endif
		</div>
	</div>
</section>
<!-- End Gallery Section -->