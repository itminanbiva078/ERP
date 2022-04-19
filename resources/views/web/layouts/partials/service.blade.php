@php
  use App\SM\SM;
  $features = SM::smGetThemeOption( "features", "" );
@endphp

<section class="services-us-section" id="back-image" >
    <div class="service-section-overlay">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="services-section-title wow slideInLeft" data-wow-duration="1s" data-wow-delay=".1s">
                        <h3>Our Services</h3>
                    </div> 
                </div>
            </div>
            <div class="row ">
                @if(!empty($features))
                @foreach($features as $feature)
                    <div class="col-md-3 col-lg-2">
                        @if(!empty($feature))
                            <div class="service-section">
                                <div class="service-content-box wow slideInLeft" data-wow-duration="1s" data-wow-delay=".2s">
                                    <div class="images-box">
                                        <img src="{{SM::sm_get_the_src($feature['feature_image'])}}" class="img-responsive"> 
                                    </div>
                                    <div class="service-box">
                                        <h2 class="service-title">{{$feature['feature_title']}}</h2>
                                        <!-- <a href="#"> {!!$feature['feature_description']!!} </a> -->
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- <div class="alert alert-danger text-center">
                                <strong>Warning!</strong> There  is no Sevice!!.
                            </div> --}}
                        @endif
                    </div>
                @endforeach
                @endif
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="seemoreBtn">
                        <a href="{{ route('service') }}" class="btn btn-sm"> View All <i class="fa fa-caret-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 
