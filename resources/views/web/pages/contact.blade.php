@extends('web.layouts.master')

@section('title')
Hotel Mohona
@endsection

<?php
  use App\SM\SM;
  $business_contact = SM::smGetThemeOption( "business_contact", "" );
  $business_address = SM::smGetThemeOption( "business_address", "" );
  $business_mail = SM::smGetThemeOption( "business_mail", "" );
  $contact_banner_image = SM::smGetThemeOption( "contact_banner_image", "" );

?>

@section('frontend-content')
@if(!empty($contact_banner_image))
<section class="common-page-breadcumb" style="background-image: url({!! SM::sm_get_the_src( $contact_banner_image ) !!})">
  @else
  <section class="common-page-breadcumb" style="background-image: url({{asset('assets/images/common_banar-img.jpg')}})">
  @endif
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="pagetitle-and-breadcumb">
          <h3>Contact Us</h3>
          <ul class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li>Contact Us</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ============================= -->
<section class="who-we-content-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="our-contact-content-box">
          <div class="row">
            <div class="col-md-6">
              <div class="contact-information">
                <h3>Our address</h3>
                <ul class="">
                  <li><a href="tel: {{$business_contact}} "><i class="fa fa-phone" aria-hidden="true"></i>{{$business_contact}}</a></li>
                  <li><i class="fa fa-map-marker" aria-hidden="true"></i>{{$business_address}}</li>
                  <li><a href="mailto:{{ $business_mail }}"><i class="fa fa-envelope-o" aria-hidden="true"></i>{{$business_mail}}</a></li>
                </ul>
              </div>
            </div>
            <div class="col-md-6">
              <div class="contact-information">
                <h3>CONTACT US</h3>
                <div class="contact-form-info">
                  <form  method="POST" action="{{ route('contactSubmit') }}">
                    @csrf
                    <div class="form-group">
                      <label for="full-name">Full Name</label>
                      <input type="text" class="form-control" id="full-name" name="name" required>
                    </div>
                    <div class="row"> 
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="email">Email address:</label>
                          <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                      <div class="form-group">
                        <label for="pho">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="textarea" required>Messege</label>
                    <textarea rows="6" class="form-control" name="messege"></textarea>
                  </div>
                  <button  type="submit"  class="btn btn-default">Submit <i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="google-maps">
          <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d14594.230790359608!2d90.40310325!3d23.86983495!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1578717092635!5m2!1sen!2sbd" style="width: 100%; height: 350px;" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
        </div>
      </div>
    </div>
  </div> 
</div>
</section>
@endsection