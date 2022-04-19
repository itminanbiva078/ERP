@extends('web.layouts.master')
@section('style')
    <style>
        <style>
  /*--------------------------------------------------------------
  # Gallery
  --------------------------------------------------------------*/
  .gallery .gallery-wrap {
    transition: 0.3s;
    position: relative;
    overflow: hidden;
    z-index: 1;
    background: rgba(0, 0, 0, 0.5);
    height: 380px;
    border-radius: 5px;
  }
  .gallery .gallery-wrap::before {
    content: "";
    background: rgba(0, 0, 0, 0.3);
    position: absolute;
    left: 30px;
    right: 30px;
    top: 30px;
    bottom: 30px;
    transition: all ease-in-out 0.3s;
    z-index: 2;
    opacity: 0;
  }
  .gallery .gallery-wrap img {
    transition: 1s;
    width: 100%;
    height: 380px;
    object-fit: cover;
  }
  .gallery .gallery-wrap .gallery-info {
    opacity: 0;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    text-align: center;
    z-index: 3;
    transition: all ease-in-out 0.3s;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }
  .gallery .gallery-wrap .gallery-info::before {
    display: block;
    content: "";
    width: 48px;
    height: 48px;
    position: absolute;
    top: 35px;
    left: 35px;
    border-top: 3px solid rgba(251, 252, 253, 0.2);
    border-left: 3px solid rgba(251, 252, 253, 0.2);
    transition: all 0.5s ease 0s;
    z-index: 9994;
  }
  .gallery .gallery-wrap .gallery-info::after {
    display: block;
    content: "";
    width: 48px;
    height: 48px;
    position: absolute;
    bottom: 35px;
    right: 35px;
    border-bottom: 3px solid rgba(251, 252, 253, 0.2);
    border-right: 3px solid rgba(251, 252, 253, 0.2);
    transition: all 0.5s ease 0s;
    z-index: 9994;
  }
  .gallery .gallery-wrap .gallery-links a {
    color: #fff;
    background: #ED1D24;
    margin: 10px 2px;
    width: 36px;
    height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: 0.3s;
  }
  .gallery .gallery-wrap .gallery-links a i {
    font-size: 24px;
    line-height: 0;
  }
  .gallery .gallery-wrap .gallery-links a:hover {
    background: #ED1D24;
  }
  .gallery .gallery-wrap:hover img {
    transform: scale(1.1);
  }
  .gallery .gallery-wrap:hover::before {
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    opacity: 1;
  }
  .gallery .gallery-wrap:hover .gallery-info {
    opacity: 1;
  }
  .gallery .gallery-wrap:hover .gallery-info::before {
    top: 15px;
    left: 15px;
  }
  .gallery .gallery-wrap:hover .gallery-info::after {
    bottom: 15px;
    right: 15px;
  }
  /*--------------------------------------------------------------
  # Gallery Details
  --------------------------------------------------------------*/
  .gallery-details-slider img {
    width: 100%;
  }
  .gallery-details-slider .swiper-pagination {
    margin-top: 20px;
    position: relative;
  }
  .gallery-details-slider .swiper-pagination .swiper-pagination-bullet {
    width: 12px;
    height: 12px;
    background-color: #fff;
    opacity: 1;
    border: 1px solid #ED1D24;
  }
  .gallery-details-slider .swiper-pagination .swiper-pagination-bullet-active {
    background-color: #ED1D24;
  }
  .gallery-info {
    padding: 30px;
    box-shadow: 0px 0 30px rgba(1, 41, 112, 0.08);
  }
  /* Load More Button Css */
  .load-col{
    display: none;
    padding-bottom: 25px;
  }
  @media only screen and (min-width: 310px) and (max-width: 449.98px) {
    .gallery .gallery-wrap {
      height: 320px;
    } 
  }
    </style>
@endsection

@php
  use App\SM\SM;
  $galleries = SM::smGetThemeOption("galleries", "");
@endphp




@section('frontend-content')
<section class="gallery">
    <div class="container">
      <div class="row">
        @foreach ($galleries as $gallery_img)
        <div class="col-lg-4 col-md-6 col-item">
            @if(!empty($gallery_img))
            <div class="gallery-wrap ">
                <img src="{{ SM::sm_get_the_src($gallery_img['gallery_image'])}}" class="img-fluid" alt="gallery-img">
                <div class="gallery-info">
                  <div class="gallery-links">
                    <a href="{{ SM::sm_get_the_src($gallery_img['gallery_image'])}}" data-gallery="gallery-item" class="gallery-lightbox" title=""><i class="bi bi-plus"></i></a>
                  </div>
                </div>
              </div>
            @endif
        </div>
        @endforeach
      </div>
    </div>
  </section>
  <!-- End Gallery Section -->
@endsection
