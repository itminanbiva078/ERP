@extends('web.layouts.master')

@section('title')
Hotel Mohona
@endsection
<?php
  use App\SM\SM;
  $team_banner_image = SM::smGetThemeOption( "team_banner_image", "" );

  ?>
@section('frontend-content')
@if(!empty($team_banner_image))
<section class="common-page-breadcumb" style="background-image: url({!! SM::sm_get_the_src( $team_banner_image ) !!})">
  @else
  <section class="common-page-breadcumb" style="background-image: url({{asset('assets/images/common_banar-img.jpg')}})">
  @endif 
    <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="pagetitle-and-breadcumb wow slideInLeft" data-wow-duration="1s" data-wow-delay=".1s">
          <h3>Board Of Management</h3>
          <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li>Board Of Director</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ======================================= -->
<section class="faund-pas-section">
  <div class="container">

    <div class="">
   <div class=" row faundation-of-passion pad-lr wow zoomIn" data-wow-duration="1s" data-wow-delay=".2s">
@if(!empty($teams))
    @foreach($teams as $team)
    @if($team)
      @if($team['department']=="management")
        <div class="col-md-6">
          <div class="management-box">
            <div class="row">
              <div class="col-md-6">
                <div class="user-profile-box">
                  <img src="{{SM::sm_get_the_src($team['team_image'])}}" class="img-responsive">
                </div>
              </div>
              <!-- ---------------- -->
              <div class="col-md-6">
                <div class="user-profile-content-box">
                  <h3>{{$team['title']}}</h3>
                  <p>{{$team['designation']}}</p>
                  <ul class="social-icons-ql pull-left">
                     <li><a href="{{$team['facebook']}}"><i class="fa fa-facebook"></i></a></li>
                     <li><a href="{{$team['twitter']}}"><i class="fa fa-twitter"></i></a></li>
                     <li><a href="{{$team['linkedin']}}"><i class="fa fa-linkedin"></i></a></li>
                     <li><a href="{{$team['google_plus']}}"><i class="fa fa-google-plus"></i></a></li>
                   </ul>
                </div>
              </div>
              <!-- ----------------- -->
            </div>
            <!-- --------------------------- -->
          </div>
        </div>
       
      @endif
      @endif
    @endforeach
    @else
      <div class="alert alert-danger">
          <strong>Warning!</strong> There  is no content!!.
      </div>
    @endif
</div>
</div>
</div>
</section>
@endsection