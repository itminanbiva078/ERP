<script>
function loadModal(route,idName,title,errors=null,input=null){
    if(input == "2"){
       $.ajax({
           "url": route,
           "dataType": "json",
           "type": "GET",
           "data": {
               "_token": "<?= csrf_token() ?>",
               "importRoute": idName,//import save route
               "downloadUrl": errors,//download url
           }
           }).done(function(data) {
               $('.modal-title').text(title);
               $("#loadModalResult").html(data.html);
           });
   }else{

       $.ajax({
           "url": route,
           "dataType": "json",
           "type": "GET",
           "data": {
               "_token": "<?= csrf_token() ?>",
               "errors": errors,
               "input": input,
               "route": route,
           }
       }).done(function(data) {
           $('#temporary_route').val(route);
           $('#temporary_id').val(idName);
           $('#temporary_title').val(title);
           $('.modal-title').text(title);
           $("#loadModalResult").html(data.html);

       });
   }

  
}

function loadModalView(route,id,title){

  
       $.ajax({
           "url": route,
           "dataType": "json",
           "type": "GET",
           "data": {
               "_token": "<?= csrf_token() ?>",
               "details_id": id,
           }
       }).done(function(data) {
           console.log("test by alamin");
           console.log(data);
         
           $('#temporary_title').val(title);
           $('.modal-title').text(title);
           $("#modalViewResult").html(data.html);
       });  
}



function loadVoucher(title,image){
    var html = '<img src="/'+image+'" class="img-thumbnail" alt="title"/>';
    $('.modal-title').text('Voucher Documents of '+title);
    $("#loadModalResult").html(html);
}


function modalSave(route){
   $.ajax({
       "url": route,
       "dataType": "json",
       "type": "post",
       "data": $('#modalForm').serialize(),
   }).done(function(data) {
       if(data.success == false){
           Swal.fire('Warning!', 'Validation Error.', 'warning')
           loadModal($('#temporary_route').val(),$('#temporary_id').val(),$('#temporary_title').val(),data.errors,data.message);
       }else{
           var newOption = new Option(data.data.name, data.data.id, true, true);
           $('#'+$('#temporary_id').val()).append(newOption).trigger('change');
           $('#modal-default').modal('hide');
           Toast.fire({icon: 'success',title: 'Successfully Created!!'})
       }
   });
}

</script>



<div class="modal fade" id="modal-default">
<div class="modal-dialog modal-xl">
 <div class="modal-content">
   <div class="modal-header">
     <h4 class="modal-title">Default Modal</h4>
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </button>
   </div>
   <div class="modal-body">
       <div class="row">
           <div class="col-md-1"></div>
           <div class="col-md-10">
               <input type="hidden" id="temporary_route" value=""/>
               <input type="hidden" id="temporary_id" value=""/>
               <input type="hidden" id="temporary_title" value=""/>
               <div id="loadModalResult"></div>
               <div id="modalViewResult"></div>
             
           </div>
       </div>
   </div>
   <div class="modal-footer justify-content-between">
   </div>
 </div>
 <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>