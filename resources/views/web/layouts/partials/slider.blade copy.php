<?php
  use App\SM\SM;
  $sliders = SM::smGetThemeOption( "slider_images", "" );
?>
<div id="myCarousel" class="  slide">
    <div class="owl-carousel main-slider-active owl-theme">
        @if(!empty($sliders))
            @foreach($sliders as $key => $slider)
                <div class="item {{$key == 0 ? 'active' : '' }}">
                    <div class="fill" style="background-image:url('{{SM::sm_get_the_src($slider['slider_image'])}}');"></div>
                    <div class="carousel-caption">
                        <h2 class="animated fadeInLeft">{{$slider['slider_title']}}</h2>
                        <p class="animated fadeInUp">{{$slider['slider_sub_title']}}</p>
                        <p class="animated fadeInUp"><a target="_blank" href="{{$slider['slider_link']}}" class="btn btn-transparent btn-rounded btn-large">Learn More</a></p>
                    </div>
                </div>
            @endforeach
        @endif
    </div> 
</div>


<script>
    $('.main-slider-active').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})
</script>