<form class="needs-validation" method="POST" action="{{route($importRoute)}}" novalidate="" enctype="multipart/form-data">
   @csrf                                   
    <div class="form-row">
       <div class="form-group row col-md-12 mb-6   div_name">
          <label for="inputEmail3" class="col-sm-2 col-form-label">Upload File:</label>
          <div class="col-sm-5">
             <input type="file" id="fileUpload" name="importFile" class="form-control">
             <span id="lblError" style="color: red;"></span>
          </div>
          <div class="col-sm-2"><button class="btn btn-info btn-sm" onclick="return ValidateExtension()" type="submit"><i class="fa fa-upload"></i> &nbsp;Upload File</button></div>
          <div class="col-sm-3"><a class="btn btn-info btn-sm" href="{{$downloadUrl}}"><i class="fa fa-download"></i> &nbsp;Download Format</a></div>
       </div>
    </div>
 </form>
     <script type="text/javascript">
        function ValidateExtension() {
            var allowedFiles = [".xlsx", ".xlsm", ".csv"];
            var fileUpload = document.getElementById("fileUpload");
            var lblError = document.getElementById("lblError");
            var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");
            if (!regex.test(fileUpload.value.toLowerCase())) {
                lblError.innerHTML = "Please upload files having extensions: <b>" + allowedFiles.join(', ') + "</b> only.";
                return false;
            }
            lblError.innerHTML = "";
            return true;
        }
</script>
