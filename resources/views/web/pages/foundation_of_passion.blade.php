@extends('web.layouts.master')

@section('title')
Hotel Mohona
@endsection

<?php
  use App\SM\SM;
  $foundation_banar_image = SM::smGetThemeOption( "foundation_banar_image", "" );

  ?>

@section('frontend-content')
@if(!empty($foundation_banar_image))
<section class="common-page-breadcumb" style="background-image: url({!! SM::sm_get_the_src( $foundation_banar_image ) !!})">
  @else
  <section class="common-page-breadcumb" style="background-image: url({{asset('assets/images/common_banar-img.jpg')}})">
  @endif 
    <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="pagetitle-and-breadcumb wow slideInLeft" data-wow-duration="1s" data-wow-delay=".1s">
          <h3>{{$foundation_title}}</h3>
          <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li>{{$foundation_title}}</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ============================= -->
<section class="faund-pas-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="faundation-of-passion wow zoomIn" data-wow-duration="1s" data-wow-delay=".2s">
          <div class="row">
            <div class="col-md-6">
              @if(!empty($foundation_image))
              <div class="passion-cont-img">
                <img src="{{SM::sm_get_the_src($foundation_image)}}" class="img-responsive">
              </div>
              @else
              <div class="passion-cont-img">
                <img height="300" width="300" src="{{asset('assets/images/image-not-found.png')}}" class="img-responsive">
              </div>
              @endif
            </div>
            <div class="col-md-6">
              @if(!empty($foundation_description))
                <div class="passion-cont-pra">
                  <p>{!!$foundation_description!!}</p>
                </div>
               @else
               <div class="alert alert-danger">
                <strong>Warning!</strong> There  is no content!!.
              </div>
              @endif 
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection