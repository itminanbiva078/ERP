<?php



$asset = (PHP_SAPI === 'cli') ? false : asset('/');

$site = (PHP_SAPI === 'cli') ? false : url('/');

return [

    'smSite' => $site,

//admin slug and url

    'smAdminSlug' => 'admin',

    'smAdminUrl' => $site . '/admin/',

//pagination

    'smPagination' => 10,

    'smPaginationMedia' => 49,

    'smFrontPagination' => 10,

    'cachingTimeInMinutes' => 10,

    'popupHideTimeInMinutes' => 24 * 60,

    'popupHideTimeInMinutesForSubscriber' => 30 * 24 * 60,

//image upload directory and url

    'smUploadsDir' => 'uploads/',

    'smUploads' => $asset . 'uploads/',

    'smUploadsUrl' => $asset . 'uploads/',

//image size: width and height

//1: logo

//2-4:gallery

//5:manage page

//6:manage page

//7:author small

//8-10:blog

//11-11: sliders

//12 team

//13 testimonial logo

    'smPostMaxInMb' => 5,



//galary (600x400, 112x112 not crop resized)

    'smImgWidth' => [

        30, // fav icon=

        84, //header logo=

        1920, //slider image=

        50, //top header cart & cart page product image=

        600, //product detail main image=

        67, //product detail msmallimage=

        33, //category small icon=

        200, //home page best sales product image=

        379, //search page product image=

//---------

        79, //footer top brand image=
        80,
        146, //testimonials image=

        400, //home page footer top add image=

        100, //payment method image

        //        -------admin panel-----

        165,  //featured-image

        112, //media small image

        80, //lists image

        600,

        1000,
        624//banar



    ],

    'smImgHeight' => [

        30, // fav icon=

        46, //header logo=

        750, //slider image=

        56, //top header cart & cart page product image=

        600, //product detail main image=

        67, //product detail small image=

        34, //category small icon=

        200, //home page best sales product image=

        379, //search page product image=

//---------

        91, //footer top brand image=
        80,
        146, //testimonials image=

        100, //home page footer top add image=

        30, //payment method image

        //        -------admin panel-----

        165, //featured-image-

        112, //media small image-

        80, //lists image-

        400,

        1000,
        260//banar

    ],

    //               1    2    3    4     5   6   7    8    9    10  11  12    13   14   15   16  17



];