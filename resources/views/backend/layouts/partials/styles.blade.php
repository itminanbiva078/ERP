<link rel="stylesheet" href="{{ asset('backend/assets/dist/css/flatpickr.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/dist/css/dark.css') }}">

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/fontawesome-free/css/all.min.css') }}">

<!-- Ionicons -->
{{-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/toastr/toastr.min.css') }}">
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- JQVMap -->
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/jqvmap/jqvmap.min.css') }}">
<!-- Theme style -->

<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/daterangepicker/daterangepicker.css') }}">
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/summernote/summernote-bs4.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">

<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
<!-- BS Stepper -->
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/bs-stepper/css/bs-stepper.min.css') }}">
<!-- dropzonejs -->
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/dropzone/min/dropzone.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('backend/assets/dist/css/adminlte.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/dist/css/SimpleCalculadorajQuery.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/dist/css/bootstrap-timepicker.min.css') }}">

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/dist/css/skins/all-skins.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/dist/css/style.css') }}">


@php 
use App\Models\TheamColor;
$themeColor =  TheamColor::company()->first();
@endphp

<style>
.hide {
    display: none !important;
}

textarea .form-control{
    height: auto!important;
}

#loader {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  width: 100%;
  background: rgba(0,0,0,0.75) url({{asset("backend/assets/image/spinner.gif")}}) center no-repeat;
  z-index: 10000;
}
:root {
    --header-height: 3.5rem;
    /*========== Colors ==========*/

    --hue: 152;
    --main-theme-background:<?php echo $themeColor->themes_bg_color ?? "#eeeeee";?>;
    --sidebar-background-color: <?php echo $themeColor->sidebar_bg_color ?? "#87af4b";?>;
    --sidebar-secound-color:  <?php echo $themeColor->sidebar_drop_bg_color ?? "#8ab34d ";?>;
    --menu-font-color: <?php echo $themeColor->menu_font_color ?? "#ffffff ";?>;
    --main-font-color: <?php echo $themeColor->main_font_color ?? "#212730 ";?>;
    --light-font-color: hsl(0, 0%, 100%);
    --rad-color: <?php echo $themeColor->red_color ?? " #ff1500 ";?>;
    --green-color: <?php echo $themeColor->success_color ?? " #1c7847 ";?>;
    --border-color: <?php echo $themeColor->border_color ?? " #e4e4e4 ";?>;
    --main-block-color: <?php echo $themeColor->block_color ?? "#ffffff";?>;
    --icon-color-dark: <?php echo $themeColor->icon_color ?? " #ffffff ";?>;
    --button-bg-color: <?php echo $themeColor->button_bg_color ?? " #87af4b ";?>;
    --button-font-color: <?php echo $themeColor->button_font_color ?? " #ffffff ";?>;
    --plaseholder-color: <?php echo $themeColor->placeholder_color ?? " #dddddd ";?>;
    --read-only-bg: <?php echo  $themeColor->readonly_color ?? "#1C658C" ;?>;  
    --input-filed-bg :<?php echo  $themeColor->input_background_color ?? "#fff" ;?> ; 
    --input-filed-color:<?php echo  $themeColor->input_text_color ?? "#ddd" ;?>; 

    /*========== Font and typography ==========*/
    --body-font: 'Poppins', sans-serif;
    --title-font-size: 1.5rem;
    --menu-font-size: 1.1rem;
    --regular-font-size: 1rem;
    --smaller-font-size: .75rem;

    /*========== Font weight ==========*/
    --font-medium: 500;
    --font-semi-bold: 600;

    /*========== Margenes Bottom ==========*/
    --mb-0-5: .5rem;
    --mb-0-75: .75rem;
    --mb-1: 1rem;
    --mb-1-5: 1.5rem;
    --mb-2: 2rem;
    --mb-2-5: 2.5rem;

    /*========== z index ==========*/
    --z-tooltip: 10;
    --z-fixed: 100;
}

</style>
<aside class="color-dynamic-sidebar">
    <div class="sidebar-color" id="colorDynamicContainer">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><i class="fas fa-palette"></i> <span> Color </span> </a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><i class="fas fa-font"></i> <span> Font </span></a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <form method="POST"  action="{{ route('settings.theam.store') }}" >
          @csrf
          <div class="form-group">
            <label for="favcolor"> Theme Background </label>
            <input type="color" id="favcolor" value="<?php echo $themeColor->themes_bg_color ?? "#eeeeee";?>" name="themes_bg_color" >
          </div>
          <div class="form-group">
            <label for="favcolor"> Sidebar Background </label>
            <input type="color" id="favcolor" name="sidebar_bg_color" value="<?php echo $themeColor->sidebar_bg_color ?? "#87af4b";?>">
          </div>
          <div class="form-group">
            <label for="favcolor"> Sidebar Dropdown BG </label>
            <input type="color" id="favcolor" name="sidebar_drop_bg_color" value="<?php echo $themeColor->sidebar_drop_bg_color ?? "#8ab34d ";?>" >
          </div>
          <div class="form-group">
            <label for="favcolor"> Menu Font Color </label>
            <input type="color" id="favcolor" name="menu_font_color" value="<?php echo $themeColor->menu_font_color ?? "#ffffff ";?>" >
          </div>
          <div class="form-group">
            <label for="favcolor"> Main Font Color </label>
            <input type="color" id="favcolor" name="main_font_color" value="<?php echo $themeColor->main_font_color ?? "#212730 ";?>" >
          </div>
          <div class="form-group">
            <label for="favcolor"> Warning Color  </label>
            <input type="color" id="favcolor" name="red_color" value="<?php echo $themeColor->red_color ?? " #ff1500 ";?>" >
          </div>
          <div class="form-group">
            <label for="favcolor"> Success Color  </label>
            <input type="color" id="favcolor" name="success_color" value="<?php echo $themeColor->success_color ?? " #1c7847 ";?>" >
          </div>
          <div class="form-group">
            <label for="favcolor"> Border Color  </label>
            <input type="color" id="favcolor" name="border_color" value="<?php echo $themeColor->border_color ?? " #e4e4e4 ";?>" >
          </div>
          <div class="form-group">
            <label for="favcolor"> Block Color  </label>
            <input type="color" id="favcolor" name="block_color" value="<?php echo $themeColor->block_color ?? "#ffffff";?>" >
          </div>
          <div class="form-group">
            <label for="favcolor"> Icon Color  </label>
            <input type="color" id="favcolor" name="icon_color" value="<?php echo $themeColor->icon_color ?? " #ffffff ";?>" >
          </div>
          <div class="form-group">
            <label for="favcolor"> Button Backgoround Color </label>
            <input type="color" id="favcolor" name="button_bg_color" value="<?php echo $themeColor->button_bg_color ?? " #87af4b ";?>" >
          </div>
          <div class="form-group">
            <label for="favcolor"> Button Font Color  </label>
            <input type="color" id="favcolor" name="button_font_color" value="<?php echo $themeColor->button_font_color ?? " #ffffff ";?>" >
          </div>
          <div class="form-group">
            <label for="favcolor"> Plaseholder Color  </label>
            <input type="color" id="favcolor" name="placeholder_color" value="<?php echo $themeColor->placeholder_color ?? " #dddddd ";?>" >
          </div>
          <div class="form-group">
            <label for="favcolor"> Readonly  Color </label>
            <input type="color" id="favcolor" name="readonly_color" value="<?php echo $themeColor->readonly_color ?? " #1C658C ";?>" >
          </div>
          <div class="form-group">
            <label for="favcolor"> Input Backgoround Color  </label>
            <input type="color" id="favcolor" name="input_background_color" value="<?php echo $themeColor->input_background_color ?? " #fff ";?>" >
          </div>
          <div class="form-group">
            <label for="favcolor">Input Text Color  </label>
            <input type="color" id="favcolor" name="input_text_color" value="<?php echo $themeColor->input_text_color ?? " #ddd ";?>" >
          </div>
          <div class="color-submit-btn">
            <button type="submit" >Submit</button>  
          </div>
        </form> 
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          <div id="chcp_font_size" class="input-group">
            <span class="input-group-btn">
              <button id="btn-decrease" class="btn btn-default" type="button"><i class="fa fa-font" aria-hidden="true"></i>-</button>
              <button id="btn-orig" class="btn btn-default" type="button"><i class="fa fa-font" aria-hidden="true"></i></button>
              <button id="btn-increase" class="btn btn-default" type="button"><i class="fa fa-font" aria-hidden="true"></i>+</button>
            </span>
          </div>
        </div>
      </div>
    </div>
  </aside>


