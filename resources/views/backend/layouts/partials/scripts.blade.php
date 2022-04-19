<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!--  Flatpickr  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('backend/assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('backend/assets/dist/js/admin.js') }}"></script>
<script src="{{ asset('backend/assets/dist/js/SimpleCalculadorajQuery.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('backend/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('backend/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<!-- <script src="{{ asset('backend/assets/plugins/sparklines/sparkline.js') }}"></script> -->
<!-- JQVMap -->
<script src="{{ asset('backend/assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('backend/assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('backend/assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('backend/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
</script>
<!-- Summernote -->
<script src="{{ asset('backend/assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('backend/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('backend/assets/dist/js/adminlte.js') }}"></script>
<script src="{{ asset('backend/assets/dist/js/apexcharts.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('backend/assets/dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- Select2 -->
<script src="{{ asset('backend/assets/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{ asset('backend/assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('backend/assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<!-- date-range-picker -->
<!-- bootstrap color picker -->
<script src="{{ asset('backend/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<!-- Bootstrap Switch -->
<script src="{{ asset('backend/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<!-- BS-Stepper -->
<script src="{{ asset('backend/assets/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<!-- dropzonejs -->
<script src="{{ asset('backend/assets/plugins/dropzone/min/dropzone.min.js') }}"></script>
<script src="{{ asset('backend/assets/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('backend/assets/dist/js/bootstrap-timepicker.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('backend/assets/dist/js/demo.js') }}"></script>
<!-- Page specific script -->
<script src="{{ asset('backend/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('backend/assets/dist/js/demo.js') }}"></script>
<script src="{{ asset('backend/assets/dist/js/pages/dashboard3.js') }}"></script>
<?php 
use App\Helpers\Helper;
?>


<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>

<script>

$('form').submit(function(e){

        var spinner = $('#loader');
        spinner.show();
        $(this).find(':input[type=submit]').prop('disabled', true);
    });
    
    
    $(document).on({
       
        ajaxStart: function(){
            $('#loader').fadeIn(300);
        },
        ajaxStop: function(){ 
            $('#loader').fadeOut(300);
            
        }    
    });


$(function() {
  
    //Initialize Select2 Elements
    $('.select2').select2()



    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
    })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', {
        'placeholder': 'mm/dd/YYYY'
    })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date picker
  
    // $('.datepick').datetimepicker({
        //format: 'YYYY-MM-DD'
    //     format:"{{ Helper::get_js_date_format() }}",
    // });

    // $('.datepick').datetimepicker({
        //format: 'YYYY-MM-DD'
    //     format:"{{ Helper::get_js_date_format() }}",
    // });

    $('.datepick').datepicker({
        // format:"{{ Helper::get_js_date_format() }}",
        autoclose: true
    })

    //Date and time picker
    $('#reservationdatetime').datetimepicker({
        icons: {
            time: 'far fa-clock'
        }
    });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
            format: 'YYYY-MM-DD'
        }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker({
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                    .endOf('month')
                ]
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment()
        },
        function(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
    )


 



    //Timepicker
    $('#timepicker').datetimepicker({
        format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
        $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })

    $("input[data-bootstrap-switch]").each(function() {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

})
// BS-Stepper Init

<?php if(Route::currentRouteName() != "theme.appearance.media" && (Route::currentRouteName() == "inventorySetup.product.create" || Route::currentRouteName() == "inventorySetup.product.edit")): ?>
// DropzoneJS Demo Code Start
Dropzone.autoDiscover = false

// Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
var previewNode = document.querySelector("#template")
previewNode.id = "";
var previewTemplate = previewNode.parentNode.innerHTML
previewNode.parentNode.removeChild(previewNode)

var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
  url: "{{route('inventorySetup.product.uploadProduct')}}", // Set the url
  headers: {
            'x-csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
  thumbnailWidth: 80,
  thumbnailHeight: 80,
  parallelUploads: 20,
  previewTemplate: previewTemplate,
  autoQueue: false, // Make sure the files aren't queued until manually added
  previewsContainer: "#previews", // Define the container to display the previews
  clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
 
})

myDropzone.on("removedfile", function(file) {
  // Hookup the start button
 
  console.log(file.img_url);
  try{
   
       $("#"+file.upload.uuid).val('');
   }catch(e){
   var img_url = file.img_url;
  var img2=  img_url.replace("/", "_").replace("/", "_").replace("/", "_").replace("/", "_").replace(".", "_");  
            $("."+img2).val('');
            $("."+img2).val('');
        
  }






   
  //$("#"+file.upload.uuid).val('');

  

})

myDropzone.on("addedfile", function(file) {
  // Hookup the start button
  file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
})


// Update the total progress bar
myDropzone.on("totaluploadprogress", function(progress) {
  document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
})

myDropzone.on("sending", function(file) {
  // Show the total progress bar when upload starts
  document.querySelector("#total-progress").style.opacity = "1"

  
  // And disable the start button
  file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
   let fileReader = new FileReader();
    fileReader.readAsDataURL(file);
    fileReader.onloadend = function() {
        let content = fileReader.result;
        $(".attached_files").after(
        "<input type='hidden' id="+file.upload.uuid+" name='attached_files[]' value="+content+" />"
        );
    }
})
// Hide the total progress bar when nothing's uploading anymore
myDropzone.on("queuecomplete", function(progress) {
  document.querySelector("#total-progress").style.opacity = "0"
})

// Setup the buttons for all transfers
// The "add files" button doesn't need to be setup because the config
// `clickable` has already been specified.
document.querySelector("#actions .start").onclick = function() {
  myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
}
document.querySelector("#actions .cancel").onclick = function() {
  myDropzone.removeAllFiles(true)
}


$(function () {
    //Add text editor
    $('#compose-textarea').summernote()
})
    



<?php endif;?>

$( document ).ready(function() {
    $(".basicDate").flatpickr({
    });
});

// main slide bar active 

let mainSidebar = document.getElementById('main-sidebar-section');
let slidebarLi = mainSidebar.querySelectorAll(".nav li");

for (var i = 0, length = slidebarLi.length; i < length; i++) {

    slidebarLi[i].onclick = function() {
        var activeMenu = mainSidebar.querySelector(".nav li.active");
        if (activeMenu) activeMenu.classList.remove("active");
        this.classList.add('active');
    };
}

let subSidebar = document.getElementById('main-sidebar-section');
let subslidebarLi = subSidebar.querySelectorAll(".nav-treeview li");

for (var i = 0, length = subslidebarLi.length; i < length; i++) {

    subslidebarLi[i].onclick = function(event) {
        var subActiveMenu = this.classList.add('active');
        if (subActiveMenu) subActiveMenu.classList.remove("active");
        this.classList.add('active');
    };
}

window.onload = subslidebarLi[i];
</script>



 



