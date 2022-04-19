<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="evalybd eccommarce Template">
    <meta name="keywords" content="HTML,CSS,XML,JavaScript">
    <meta name="author" content="Nextpage Taem">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hotel Mohona')</title>
    @include('web.layouts.partials.styles')
    @yield('style')
</head>
<body>
    @include('web.layouts.common.header')
    <div class="content-wrapper">
        <section class="content">
            @yield('frontend-content')
        </section>
    </div>
    @include('web.layouts.common.footer')
    @include('web.layouts.partials.js')
    @include('errors.message')
    @yield('script')

</body>
</html>