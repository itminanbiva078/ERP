@php
    use App\SM\SM;
    $total_guest_serve = SM::smGetThemeOption( "total_guest_serve", "" );
    $total_active_client = SM::smGetThemeOption( "total_active_client", "" );
    $total_project = SM::smGetThemeOption( "total_project", "" );
    $total_success_rate = SM::smGetThemeOption( "total_success_rate", "" );
    $total_commitment = SM::smGetThemeOption( "total_commitment", "" );
@endphp 

<div class="ourmissin-vissiom background-images">
    <div class="ourmission-vission-overlay">
        <div class="container">
            <div class="row pb-4">
                <div class="col-md-12">
                    <div class="services-section-title wow slideInLeft" data-wow-duration="1s" data-wow-delay=".1s">
                        <h3 class="text-white">Our Success Story</h3>
                    </div> 
                </div>
            </div>

            <!-- Service Box -->
            <div class="row justify-content-center">
                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="services-box text-center">
                        <img src="{{ asset('assets/images/service/guest.png') }}" alt="">
                        <h5 class="my-3">TOTAL GUEST SERVE</h5>
                        <h3 class="counter" data-count="{{$total_project}}"></h3>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="services-box text-center">
                        <img src="{{ asset('assets/images/service/mechanic.png') }}" alt="">
                        <h5 class="my-3">TOTAL SERVICE MAN</h5>
                        <h3 class="counter" data-count="{{$total_active_client }} "> </h3>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="services-box text-center">
                        <img src="{{ asset('assets/images/service/review.png') }}" alt="">
                        <h5 class="my-3">TOTAL SUCCESS STORIES</h5>
                        <h3 class="counter" data-count="{{$total_success_rate}}"></h3>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="services-box text-center">
                        <img src="{{ asset('assets/images/service/storytelling.png') }}" alt="">
                        <h5 class="my-3">TOTAL 5* REVIEWS</h5>
                        <h3 class="counter" data-count="{{$total_commitment}}"></h3>
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="counter-box wow slideInLeft" data-wow-duration="1s" data-wow-delay=".1s">
                        <h2>Total Guest Serve</h2>
                        <h3 class="counter" data-count="{{$total_project}}"> </h3>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="counter-box wow slideInLeft" data-wow-duration="1s" data-wow-delay=".1s">
                        <h2>Total Service Man</h2>
                        <h3 class="counter" data-count="{{$total_active_client}}"> </h3>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="counter-box wow slideInLeft" data-wow-duration="1s" data-wow-delay=".1s">
                        <h2>Total Success Stories</h2>
                        <h3 class="counter" data-count="{{$total_success_rate}}"> </h3>
                    </div>
                </div>
                
                    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="counter-box wow slideInLeft" data-wow-duration="1s" data-wow-delay=".1s">
                        <h2>Total 5* Reviews</h2>
                        <h3 class="counter" data-count="{{$total_commitment}}"></h3>
                    </div>
                </div>
                @php 
                @endphp 
            </div> --}}
        </div>
    </div>
</div>







