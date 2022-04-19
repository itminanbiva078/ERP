<?php
  use App\SM\SM;
    $logos = SM::smGetThemeOption( "payment_method_image", "" );
    $social_facebook = SM::smGetThemeOption( "social_facebook", "" );
    $social_twitter = SM::smGetThemeOption( "social_twitter", "" );
    $social_linkedin = SM::smGetThemeOption( "social_linkedin", "" );
    $social_instagram = SM::smGetThemeOption( "social_instagram", "" );
    $business_name = SM::smGetThemeOption( "business_name", "" );
    $business_contact = SM::smGetThemeOption( "business_contact", "" );
  ?>
<?php

$entry_date = date('m/d/Y');
$date = date('M d, Y');
$date = strtotime($date);
$date = strtotime("+7 day", $date);
$exit_date = date('m/d/Y', $date);
$date_range = $entry_date.' - '.$exit_date;

if(Session::has('entry_date') && Session::has('exit_date'))
  {
    $entry_date = Session::get('entry_date');
    $entry_date = date_create($entry_date);
    $entry_date = date_format($entry_date,"m/d/Y");

    $exit_date = Session::get('exit_date');
    $exit_date = date_create($exit_date);
    $exit_date = date_format($exit_date,"m/d/Y");
    $date_range = $entry_date.' - '.$exit_date;
  }
?>

<section class="topbar-section" id="main">
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-xs-12">
        <div class="topaddressbar">
          <ul>
            <li><a href="/"><i class="fa fa-home"></i> {{$business_name}}</a></li>
            <li><a href="tel:{{ $business_contact }}"><i class="fa fa-phone"></i> {{$business_contact}}</a></li>
          </ul>
        </div>
      </div>
      <div class="col-md-4 col-xs-12" style="color: #fff;">
        <i class="fa fa-shield" aria-hidden="true"></i> 24 HOURS SECURITY SERVICE 
      </div>
      <div class="col-md-4 col-xs-12">
        <div class="topsocialaddress">
          <ul>
            @if (Route::has('login'))
              <li>
                @auth
                  <a href="{{ route('profile') }}" class="text-sm text-gray-700 underline">Profile</a>
                  <a href="{{ route('logout_customer') }}"  class="text-sm text-gray-700 underline">Logout</a>
                @else
                  <a href="{{ route('otp') }}" class="text-sm text-gray-700 underline">Login</a>
              </li>
              <li>
                @if (Route::has('register'))
                  <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline" style="display:none;">Register</a>
                @endif
                @endauth
              </li>
            @endif
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>


<header class="header">
  <a class="navbar-brand mobile-logo d-md-none" href="{{ route('welcome') }}">
    @if(!empty($logos))
    <img src="{{SM::sm_get_the_src($logos)}}" class="img-responsive">
    @else
  
    <img src="{{ URL::to('/') }}/assets/image/logo/hotel_mohona.png" alt="logo">
    @endif
  </a>
  <i class='bx bx-menu header__toggle' id="header-toggle"></i>
  <nav class="nav" id="nav-menu">
      <div class="nav__content container">
          <a href="" class="nav__perfil">
            <div class="nav__img">
              <a class="navbar-brand" href="{{ route('welcome') }}">
                @if(!empty($logos))
                  <img src="{{SM::sm_get_the_src($logos)}}" class="img-responsive">
                @else
                <img src="{{ URL::to('/') }}/assets/image/logo/hotel_mohona.png" alt="logo">
                  {{-- <img src="{{asset('assets/image/logo/hotel_mohona.png')}}" alt=""> --}}
                @endif
              </a>
            </div>
          </a>
          <div class="nav__menu">
              <ul class="nav__list">
                  <li class="nav__item"><a href="{{ route('welcome') }}" class="nav__link {{ Request::is('/') ? 'active' : '' }}">Home</a></li>
                  <li class="nav__item dropdown">
                      <a href="#" class="nav__link dropdown__link"> About <i class='bx bx-chevron-down dropdown__icon'></i></a>
                      <ul class="dropdown__menu">
                          <li class="dropdown__item"><a href="{{ route('who_we_are') }}" class="nav__link "> Who We Are </a></li>
                          <li class="dropdown__item"><a href="{{ route('foundation_of_passion') }}" class="nav__link"> Foundation Of Passion </a></li>
                          <li class="dropdown__item"><a href="{{ route('board_of_director') }}" class="nav__link"> Board Of Director </a></li>
                          <li class="dropdown__item"><a href="{{ route('company_management') }}" class="nav__link"> Company Management </a></li>
                      </ul>
                  </li>
                  <li class="nav__item"><a href="{{ route('service') }}" class="nav__link {{ Request::is('service') ? 'active' : '' }}"> Service </a></li>
                  <li class="nav__item"><a href="{{ route('rooms') }}" class="nav__link {{ Request::is('rooms') ? 'active' : '' }}">Rooms</a></li>
                  <li class="nav__item"><a href="{{ route('contact') }}" class="nav__link {{ Request::is('contact') ? 'active' : '' }}">Contact</a></li>
                  @if(Route::current()->getName()=='welcome' || Route::current()->getName()=='room_list')
                  @endif
              </ul>
          </div>
      </div>
  </nav>
</header>

{{-- <script>

  $(window).scroll(function(){
    if($(this).scrollTop() > 100){
      $('.navbar').addClass('sticky')
    } else{
      $('.navbar').removeClass('sticky')
    }
  });

</script> --}}