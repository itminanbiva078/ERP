<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/animate.css')}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/typography.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/icofont/icofont.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/font-awesome/css/font-awesome.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/slick/slick/slick-theme.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/slick/slick/slick.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/glightbox.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/swiper-bundle.min.css') }}" >
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/owl.carousel.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/owl.theme.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css')}}">
<link rel="shortcut icon" href="assets/images/right.png">
<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<style>
    .curtain {
        margin: 0 auto;
        width: 100%;
        height: 100vh;
        overflow: hidden;
        position: fixed;
        bottom: 0;
        z-index: 9;
    }
    .curtain__wrapper {
        width: 100%;
        height: 100%;
    }
    .curtain__wrapper input[type=checkbox] {
        position: absolute;
        cursor: pointer;
        width: 100%;
        height: 100%;
        z-index: 100;
        opacity: 0;
        top: 0;
        left: 0;
    }
    .curtain__wrapper input[type=checkbox]:checked ~ div.curtain__panel--left {
        transform: translateX(0);
    }
    .curtain__wrapper input[type=checkbox]:checked ~ div.curtain__panel--right {
        transform: translateX(0);
    }
    .curtain__panel {
        display: flex;
        align-items: center;
        background: #5aabcc;
        color: #fff;
        float: left;
        position: relative;
        width: 50%;
        height: 100vh;
        transition: all 2s ease-out;
        z-index: 2;
    }
    .curtain__panel--left {
        justify-content: flex-end;
        transform: translateX(-100%);
    }
    .curtain__panel--right {
        justify-content: flex-start;
        transform: translateX(100%);
    }
    .curtain__content {
        align-items: center;
        background: #222;
        color: #fff;
        display: flex;
        flex-direction: column;
        height: 100vh;
        justify-content: center;
        padding: 1rem 0;
        position: absolute;
        text-align: center;
        z-index: 1;
        width: 100%;
    }
    .curtain__content img {
        width: 20%;
    }
    .display_none{
        display:none;
    }

    body {
        background-color: #fbfbfb;
        font-family: 'Open Sans', serif;
        font-size: 14px
    }
    .container-fluid {
        margin-top: 70px
    }
    .card-body {
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        padding: 1.40rem
    }
    .img-sm {
        width: 80px;
        height: 80px
    }
    .itemside .info {
        padding-left: 15px;
        padding-right: 7px
    }
    .table-shopping-cart .price-wrap {
        line-height: 1.2
    }
    .table-shopping-cart .price {
        font-weight: bold;
        margin-right: 5px;
        display: block
    }
    .text-muted {
        color: #969696 !important
    }
    a {
        text-decoration: none !important
    }
    .card {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, .125);
        border-radius: 0px
    }
    .itemside {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        width: 100%
    }
    .dlist-align {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex
    }
    [class*="dlist-"] {
        margin-bottom: 5px
    }
    .coupon {
        border-radius: 1px
    }
    .price {
        font-weight: 600;
        color: #212529
    }
    .btn.btn-out {
        outline: 1px solid #fff;
        outline-offset: -5px
    }
    .btn-main {
        border-radius: 2px;
        text-transform: capitalize;
        font-size: 15px;
        padding: 10px 19px;
        cursor: pointer;
        color: #fff;
        width: 100%
    }
    .btn-light {
        color: #ffffff;
        background-color: #F44336;
        border-color: #f8f9fa;
        font-size: 12px
    }
    .btn-light:hover {
        color: #ffffff;
        background-color: #F44336;
        border-color: #F44336
    }
    .btn-apply {
        font-size: 11px
    }
</style>