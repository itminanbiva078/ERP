<?php
  use App\SM\SM;
  $testimonial_title = SM::smGetThemeOption( "testimonial_title", "" );
  $testimonial_description = SM::smGetThemeOption( "testimonial_description", "" );
  $testimonials = SM::smGetThemeOption( "testimonials", "" );
  $about_banner_subtitle = SM::smGetThemeOption( "about_banner_subtitle", "" );
 
  $business_contact = SM::smGetThemeOption( "business_contact", "" );
  $business_address = SM::smGetThemeOption( "business_address", "" );
  $business_mail = SM::smGetThemeOption( "business_mail", "" );
  $social_setting__social_facebook = SM::smGetThemeOption( "social_setting__social_facebook", "" );
  $social_setting__social_twitter = SM::smGetThemeOption( "social_setting__social_twitter", "" );
  $social_setting__social_linkedin = SM::smGetThemeOption( "social_setting__social_linkedin", "" );
  $social_setting__social_google_plus = SM::smGetThemeOption( "social_setting__social_google_plus", "" );
  $social_setting__social_pinterest = SM::smGetThemeOption( "social_setting__social_pinterest", "" );
  $social_setting__social_instagram = SM::smGetThemeOption( "social_setting__social_instagram", "" );
?>


<section class="big-footer" style="background-image: url('{{asset('assets/images/World Map.svg')}}');">
  <div class="backgound-bg-overlay">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <div class="fotter-content-box">
          <h2 class="foter-title">Short About</h2>
          <p>{{$about_banner_subtitle}}</p>
          <ul class="social">
            @empty(!SM::smGetThemeOption("social_facebook"))
            <li><a href="{{ SM::smGetThemeOption("social_facebook") }}"><i class="fa fa-facebook"></i></a></li>
            @endempty
            @empty(!SM::smGetThemeOption("social_twitter"))
            <li><a href="{{ SM::smGetThemeOption("social_twitter") }}"><i class="fa fa-twitter"></i></a></li>
            @endempty
            @empty(!SM::smGetThemeOption("social_linkedin"))
            <li><a href="{{ SM::smGetThemeOption("social_linkedin") }}"><i class="fa fa-linkedin"></i></a></li>
            @endempty
            @empty(!SM::smGetThemeOption("social_google_plus"))
            <li><a href="{{ SM::smGetThemeOption("social_google_plus") }}"><i class="fa fa-google-plus"></i></a></li>
            @endempty
          </ul>
        </div>
      </div>
      <div class="col-md-3"> 
        <div class="fotter-content-box">
          <h2 class="foter-title">quick links</h2>
          <ul> 
            <li> <a href="/"> <i class="fa fa-link" aria-hidden="true"></i>  Home </a></li>
            <li> <a href="/service"> <i class="fa fa-link" aria-hidden="true"></i> Service </a></li>
            <li> <a href="/who_we_are"> <i class="fa fa-link" aria-hidden="true"></i> About </a></li>
            <li> <a href="/rooms"> <i class="fa fa-link" aria-hidden="true"></i> Rooms </a></li>
            <li> <a href="/contact"> <i class="fa fa-link" aria-hidden="true"></i> Contact </a></li>
          </ul>
        </div>
      </div>
      <div class="col-md-3">
        <div class="fotter-content-box">
          <h2 class="foter-title">Address Here</h2>
          <ul class="importantlink">
            <li><a href="tel:{{ $business_contact }}"><i class="fa fa-phone" aria-hidden="true"></i> <span> {{$business_contact}} </span> </a></li>
            <li><a href="mailto:{{ $business_mail }}"><i class="fa fa-envelope-o" aria-hidden="true"></i> <span> {{ $business_mail }} </span> </a></li>
            <li>  <i class="fa fa-map-marker" aria-hidden="true"> </i> <span> {{$business_address}} </span> </li>
          </ul>
          <form class="form footet-form" method="POST" action="{{ route('subscribeEmail') }}">
            @csrf
            <div class="newslatter-btn">
              <div class="input-group">
                <input id="msg" type="email" class="form-control" name="email" placeholder="Submit Your Email" required>
                <button type="submit" class="submit-btn">Newsleter</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-3">
        <div class="fotter-content-box">
          <h2 class="foter-title">get in touch</h2>
          <div class="social-meida">
          <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fhotelmohonainternationalltd&tabs=timeline&width=340&height=140&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="100%" height="140" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>
<footer class="stcky-footer">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="copyright-text">
          <p class="footer-copyright"> @ {{ date('Y') }} <a target="_blank" href="https://nextpagetl.com/">Next Page Technology Ltd.</a> All rights reserved.</p>
        </div>
      </div>
      <div class="col-md-6">
        <ul class="social-icons-ql">
         
          @empty(!SM::smGetThemeOption("social_facebook"))
          <li><a href="{{ SM::smGetThemeOption("social_facebook") }}"><i class="fa fa-facebook"></i></a></li>
          @endempty
          @empty(!SM::smGetThemeOption("social_twitter"))
          <li><a href="{{ SM::smGetThemeOption("social_twitter") }}"><i class="fa fa-twitter"></i></a></li>
          @endempty
          @empty(!SM::smGetThemeOption("social_linkedin"))
          <li><a href="{{ SM::smGetThemeOption("social_linkedin") }}"><i class="fa fa-linkedin"></i></a></li>
          @endempty
          @empty(!SM::smGetThemeOption("social_google_plus"))
          <li><a href="{{ SM::smGetThemeOption("social_google_plus") }}"><i class="fa fa-google-plus"></i></a></li>
          @endempty
        </ul>
      </div>
    </div>
  </div>
</footer> 