@extends('web.layouts.master')

@section('title')
  Hotel Mohona
@endsection

<?php
  use App\SM\SM;
  $service_banar_image = SM::smGetThemeOption( "service_banar_image", "" );
?>

@section('frontend-content')
  @if(!empty($service_banar_image))
  <section class="common-page-breadcumb" style="background-image: url({!! SM::sm_get_the_src( $service_banar_image ) !!})">
  @else
  <section class="common-page-breadcumb" style="background-image: url({{asset('assets/images/common_banar-img.jpg')}})">
  @endif 
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="pagetitle-and-breadcumb wow slideInLeft" data-wow-duration="1s" data-wow-delay=".1s">
            <h3>Services</h3>
            <ul class="breadcrumb">
              <li><a href="/">Home</a></li>
              <li>Services</li>
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
          <div class="services-section-title wow slideInLeft" data-wow-duration="1s" data-wow-delay=".1s">
            <h3 class="text-white">{{$features_title}}</h3>
            <p>{{$features_title}}</p>
          </div> 
        </div>
      </div>
      <div class="row">
        @if(!empty($features))
          @foreach($features as $feature)
            @if($feature)
              <div class="col-md-3">
                <div class="service-content-box wow slideInLeft" data-wow-duration="1s" data-wow-delay=".2s">
                  <div class="images-box">
                    <img src="{{SM::sm_get_the_src($feature['feature_image'])}}" class="img-responsive"> 
                  </div>
                  <div class="service-box">
                    <h2 class="service-title">{{$feature['feature_title']}}</h2>
                  </div>
                </div>
              </div>
            @endif
          @endforeach
        @else
        <div class="alert alert-danger text-center">
          <strong>Warning!</strong> There  is no content!!.
        </div>
        @endif
      </div>
    </div>
  </section>
@endsection