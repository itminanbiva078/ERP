
// ============Preloader================
$('.counter').each(function() {
  var $this = $(this),
      countTo = $this.attr('data-count');
  
  $({ countNum: $this.text()}).animate({
    countNum: countTo
  },

  {

    duration: 8000,
    easing:'linear',
    step: function() {
      $this.text(Math.floor(this.countNum));
    },
    complete: function() {
      $this.text(this.countNum);
      //alert('finished');
    }

  });  

});
// ========================
$('.client-logo').slick({
  dots: false,
  infinite: true,
  speed: 300,
  // autoplay:true,
  slidesToShow: 1,
  arrows: true,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});
// ===========================================

$(document).ready(function(){

    $(".filter-button").click(function(){
        var value = $(this).attr('data-filter');
        
        if(value == "all")
        {
            //$('.filter').removeClass('hidden');
            $('.filter').show('5000');
        }
        else
        {
//            $('.filter[filter-item="'+value+'"]').removeClass('hidden');
//            $(".filter").not('.filter[filter-item="'+value+'"]').addClass('hidden');
            $(".filter").not('.'+value).hide('8000');
            $('.filter').filter('.'+value).show('8000');
            
        }
    });


    $('.category-wise-product-active').slick({
      dots: false,
      infinite: true,
      speed: 300,
      // autoplay:true,
      slidesToShow: 4,
      arrows: true,
      slidesToScroll: 1,
      prevArrow:"<div class='left-arrow'> <i class='fa fa-angle-double-left'></i> </div>",
      nextArrow:"<div class='right-arrow'> <i class='fa fa-angle-double-right'></i> </div>",
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });


    $('.service-section-active').slick({
      dots: false,
      infinite: true,
      speed: 300,
      autoplay:true,
      slidesToShow: 6,
      arrows: true,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 6,
            slidesToScroll: 6,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });












    
    // $('.category-wise-product-active').owlCarousel({
    //   loop:true,
    //   margin:10,
    //   nav:true,
    //   autoPlay: 5000,
    //   stopOnHover: true,
    //   responsive:{
    //       0:{
    //           items:1
    //       },
    //       600:{
    //           items:3
    //       },
    //       1000:{
    //           items:4
    //       }
    //   }
    // });

    $('.similar-room-active').slick({
      dots: false,
      infinite: true,
      speed: 300,
      autoplay:true,
      slidesToShow: 4,
      arrows: true,
      slidesToScroll: 1,
      prevArrow:"<div class='left-arrow'> <i class='fa fa-angle-double-left'></i> </div>",
      nextArrow:"<div class='right-arrow'> <i class='fa fa-angle-double-right'></i> </div>",
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 1,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });


    $('.main-slider').slick({
      dots: false,
      infinite: true,
      speed: 300,
      autoplay:true,
      slidesToShow: 1,
      arrows: true,
      slidesToScroll: 1,
      prevArrow:"<div class='left-arrow'> <i class='fa fa-angle-double-left'></i> </div>",
      nextArrow:"<div class='right-arrow'> <i class='fa fa-angle-double-right'></i> </div>",
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });


    $('.testimonial-slider').slick({
      dots: false,
      infinite: true,
      speed: 300,
      autoplay:true,
      slidesToShow: 1,
      arrows: true,
      slidesToScroll: 1,
      prevArrow:"<div class='left-arrow'> <i class='fa fa-angle-double-left'></i> </div>",
      nextArrow:"<div class='right-arrow'> <i class='fa fa-angle-double-right'></i> </div>",
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });


    // $('.slider-for').slick({
    //   slidesToShow: 1,
    //   slidesToScroll: 1,
    //   arrows: true,
    //   fade: true,
    //   asNavFor: '.slider-nav'
    // });

    // $('.slider-nav').slick({
    //   slidesToShow: 4,
    //   slidesToScroll: 1,
    //   asNavFor: '.slider-for',
    //   dots: false,
    //   arrows: false,
    //   focusOnSelect: true
    // });


    var numSlick = 0;
$('.slider-products').each( function() {
  numSlick++;
  $(this).addClass( 'slider-' + numSlick ).slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    prevArrow:"<div class='left-arrow'> <i class='fa fa-angle-double-left'></i> </div>",
    nextArrow:"<div class='right-arrow'> <i class='fa fa-angle-double-right'></i> </div>",
    arrows: true,
    fade: true,
    asNavFor: '.slider-nav.slider-' + numSlick
  });
});

numSlick = 0;
$('.slider-nav').each( function() {
  numSlick++;
  $(this).addClass( 'slider-' + numSlick ).slick({
    vertical: false,
    slidesToShow: 4,
    slidesToScroll: 1,
    prevArrow:"<div class='left-arrow'> <i class='fa fa-angle-double-left'></i> </div>",
    nextArrow:"<div class='right-arrow'> <i class='fa fa-angle-double-right'></i> </div>",
    asNavFor: '.slider-products.slider-' + numSlick,
    arrow: false,
    focusOnSelect: true,
    responsive: [
      {
        breakpoint: 800,
        settings: {
          slidesToShow: 3,
         }
      }
    ]
  });
});


    (function() {

      var parent = document.querySelector(".range-slider");
      if(!parent) return;
    
      var
        rangeS = parent.querySelectorAll("input[type=range]"),
        numberS = parent.querySelectorAll("input[type=number]");
    
      rangeS.forEach(function(el) {
        el.oninput = function() {
          var slide1 = parseFloat(rangeS[0].value),
              slide2 = parseFloat(rangeS[1].value);
    
          if (slide1 > slide2) {
            [slide1, slide2] = [slide2, slide1];
            // var tmp = slide2;
            // slide2 = slide1;
            // slide1 = tmp;
          }
    
          numberS[0].value = slide1;
          numberS[1].value = slide2;
        }
      });
    
      numberS.forEach(function(el) {
        el.oninput = function() {
          var number1 = parseFloat(numberS[0].value),
              number2 = parseFloat(numberS[1].value);
          
          if (number1 > number2) {
            var tmp = number1;
            numberS[0].value = number2;
            numberS[1].value = tmp;
          }
    
          rangeS[0].value = number1;
          rangeS[1].value = number2;
    
        }
      });
    
    })();

    
    $('.main-slider-active').owlCarousel({
      loop:true,
      margin:10,
      nav:true,
      autoPlay: 5000,
      stopOnHover: true,
      singleItem: true,
      navigation: true,
      navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
      responsive:{
          0:{
              items:1
          },
          600:{
              items:1
          },
          1000:{
              items:1
          }
      }
    });
    
    $('.property-discription-active').owlCarousel({

      loop:true,
      margin:10,
      nav:false,
      dots:false,
      autoPlay: 5000,
      stopOnHover: true,
      singleItem: true,
      responsive:{
          0:{
              items:1
          },
          600:{
              items:1
          },
          1000:{
              items:1
          }
      }
    });


    $('.projectscaro-slide').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
    });
    
    $("#owl-demo").owlCarousel({
      navigation : true
    });
      
    if ($(".filter-button").removeClass("active")) 
    {
      $(this).removeClass("active");
    }
    else
    {
      $(this).addClass("active");
    }
      


});


var div_top = $('.property-details-right-side').offset().top;

$(window).scroll(function() {
    var window_top = $(window).scrollTop() - 0;
    if (window_top > div_top) {
        if (!$('.property-details-right-side').is('.sticky-property-details')) {
            $('.property-details-right-side').addClass('sticky-property-details');
        }
    } else {
        $('.property-details-right-side').removeClass('sticky-property-details');
    }
});


// (function(d, s, id) {
//   var js, fjs = d.getElementsByTagName(s)[0];
//   if (d.getElementById(id)) return;
//   js = d.createElement(s); js.id = id;
//   js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
//   fjs.parentNode.insertBefore(js, fjs);
// }(document, 'script', 'facebook-jssdk')); FB.XFBML.parse();
 

$('.superbox-list').click(function(){
  if($(this).hasClass('active')){
      $(this).removeClass('active')
  } else {
      $(this).addClass('active')
  }
});
