@extends('web.layouts.master')

@section('title')
  Hotel Mohona
@endsection

<?php
  use App\SM\SM;
  $about_banner_image = SM::smGetThemeOption( "about_banner_image", "" );
  $foundation_banar_image = SM::smGetThemeOption( "foundation_image", "" );
?>

@section('frontend-content')
  @if(!empty($about_banner_image))
  <section class="common-page-breadcumb" style="background-image: url({!! SM::sm_get_the_src( $about_banner_image ) !!})">
  @else
  <section class="common-page-breadcumb" style="background-image: url({{asset('assets/images/common_banar-img.jpg')}})">
  @endif 
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="pagetitle-and-breadcumb">
            <h3>{{$about_banner_title}}</h3>
            <ul class="breadcrumb">
              <li><a href="/">Home</a></li>
              <li>{{$about_banner_title}}</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="who-we-content-section">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="who-we-are-content wow zoomIn" data-wow-duration="1s" data-wow-delay=".1s">
            <div class="row">
              <div class="col-md-6">
                @if(!empty($foundation_banar_image))
                  <div class="who-we-are-img wow slideInLeft" data-wow-duration="1s" data-wow-delay=".2s">
                    <img src="{{SM::sm_get_the_src($foundation_banar_image)}}" style="width:100%" class="img-responsive">
                  </div>
                @else
                  <div class="who-we-are-img wow slideInLeft" data-wow-duration="1s" data-wow-delay=".2s">
                    <img  src="{{asset('assets/images/image-not-found.png')}}" class="img-responsive">
                  </div>
                @endif
              </div>
              <div class="col-md-6">
                @if(!empty($wwr_subtitle ))
                  <div class="who-we-are-content wow slideInRight" data-wow-duration="1s" data-wow-delay=".2s">
                    <h3>{{$wwr_subtitle}}</h3>
                    <p>{!!$wwr_description!!}</p>
                  </div>
                @else
                  <div class="alert alert-danger text-center">
                    <strong>Warning!</strong> There  is no content!!.
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="services-section-title wow slideInLeft" data-wow-duration="1s" data-wow-delay=".3s">
            <h3 class="text-white" style="font-size: 25px;">{{$history_title}}</h3>
            {{-- <p class="text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit</p> --}}
          </div> 
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          @if(!empty($history))
            <div class="main-timeline wow slideInUp" data-wow-duration="1s" data-wow-delay=".3s">
              @foreach($history as $value)
                @if($value)
                  <div class="timeline">
                    <a href="" class="timeline-content">
                      <div class="timeline-year">
                          <span>{{$value['history_feature_title']}}</span>
                      </div>
                      <p class="description">{!!$value['history_feature_description']!!}</p>
                    </a>
                  </div>
                @endif
              @endforeach
            </div>
            @else
            <div class="alert alert-danger text-center">
              <strong>Warning!</strong> There  is no content!!.
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>
@endsection