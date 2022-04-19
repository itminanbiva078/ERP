<script type="text/javascript" src="{{ asset('assets/js/jquery.min.js')}}" ></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="{{ asset('assets/js/particles.min.js')}}" ></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery-rates.js')}}" ></script>
<script type="text/javascript" src="{{ asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/stats.min.js')}}" ></script>
<script type="text/javascript" src="{{ asset('assets/bootstrap/js/moment.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/daterangepicker.min.js')}}" ></script>
<script type="text/javascript" src="{{ asset('assets/js/wow.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/slick/slick/slick.js')}}"></script>
<script type="text/javascript" src="{{ asset('backend/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/owl.carousel.min.js')}}" ></script>
<script src="{{ asset('assets/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/js/isotop.min.js') }}"></script>
<script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/main.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/script.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


<script type="text/javascript">
  $(window).load(function() {
    $(".loader").delay(2000).fadeOut("slow");
    $("#overlayer").delay(2000).fadeOut("slow");
  })
  $(document).ready(function(){
    $("#curtain__wrapper").click(function(){
      setTimeout(
        function() {
          $(".curtain ").addClass("display_none");
        },  2000);
      });
  });
  new WOW().init();

  $(document).ready(function(){
    $(function() {
      $('input[name="daterange"]').daterangepicker({
        opens: 'left',
        minDate:new Date(),
      }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
      });
    });
  });


  particlesJS("particles-js", {"particles":{"number":{"value":70,"density":{"enable":true,"value_area":800}},"color":{"value":"#dfb251"},"shape":{"type":"circle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"img/github.svg","width":100,"height":0,}},"opacity":{"value":0.5,"random":false,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},"size":{"value":3,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},"line_linked":{"enable":true,"distance":150,"color":"#ffffff","opacity":0.4,"width":1},"move":{"enable":true,"speed":6,"direction":"none","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":true,"mode":"bubble"},"onclick":{"enable":true,"mode":"push"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":267.9854800594439,"size":20.301930307533627,"duration":3.5731397341259186,"opacity":8,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true}); update = function() { stats.begin(); stats.end(); if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) { count_particles.innerText = window.pJSDom[0].pJS.particles.array.length; } requestAnimationFrame(update); }; requestAnimationFrame(update);;
    const galleryLightbox = GLightbox({
    selector: '.gallery-lightbox'
  });



  function ratingStar(event){
    var checkValue = document.querySelectorAll(".smileybox input");
    console.log(checkValue)
    var checkStar = document.querySelectorAll(".smileybox label");
    var checkSmiley = document.querySelectorAll(".smileybox i");
    var checkCount = 0;

    for(var i=0; i<checkValue.length; i++){
        if(checkValue[i]==event.target){
            checkCount = i+1;
        }
    }

    for(var j=0; j<checkCount; j++){
        checkValue[j].checked = true;
        checkStar[j].className = "rated";
        checkSmiley[j].style.display = "none";
    }
    
    for(var k=checkCount; k<checkValue.length; k++){
        checkValue[k].checked = false;
        checkStar[k].className = "check"
        checkSmiley[k].style.display = "none";	
    }
    if(checkCount == 1){
        document.querySelectorAll(".smileybox i")[0].style.display = "block";
    }
    if(checkCount == 2){
        document.querySelectorAll(".smileybox i")[1].style.display = "block";
    }
    if(checkCount == 3){
        document.querySelectorAll(".smileybox i")[2].style.display = "block";
    }
    if(checkCount == 4){
        document.querySelectorAll(".smileybox i")[3].style.display = "block";
    }
    if(checkCount == 5){
        document.querySelectorAll(".smileybox i")[4].style.display = "block";
    }
  }


  var dateToday = new Date();    




 


</script>
