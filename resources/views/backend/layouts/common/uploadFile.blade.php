
<div class="form-group row col-md-12 mb-12 ">
    <label for="validationCustom01"  class="col-sm-1 col-form-label">Upload Image:</label>
    <div class="col-sm-11">
       <div id="actions" class="row product-upload-images">
            <div class="col-md-12">
                <div class="btn-group w-100">
                <span class="btn btn-success col fileinput-button">
                    <i class="fas fa-plus"></i>
                    <span>Add files</span>
                </span>
                <button type="button" class="btn btn-primary col start">
                    <i class="fas fa-upload"></i>
                    <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning col cancel">
                    <i class="fas fa-times-circle"></i>
                    <span>Cancel upload</span>
                </button>
                </div>
            </div>
            <div class="col-md-12 d-flex align-items-center">
                <div class="fileupload-process w-100">
                <div id="total-progress" class="progress active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                </div>
                </div>
            </div>
        </div>
        <div class="table table-striped files  row col-md-12 mb-6" id="previews">
            <div id="template" class="row mt-2 col-md-12">
                <div class="attached_files"></div>
                    <div class="product-images">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="col-auto">
                                    <span class="preview"><img src="data:," alt="" data-dz-thumbnail /></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col d-flex align-items-center">
                                    <p class="mb-0">
                                    <span class="lead" data-dz-name></span>
                                    (<span data-dz-size></span>)
                                    </p>
                                    <strong class="error text-danger" data-dz-errormessage></strong>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="align-items-center">
                                    <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="align-items-right">
                                    <div class="btn-group file-action-btn">
                                        <button type="button" class="btn btn-primary start">
                                        <i class="fas fa-upload"></i>
                                        <span>Start</span>
                                        </button>
                                        <button type="button" data-dz-remove class="btn btn-warning cancel">
                                        <i class="fas fa-times-circle"></i>
                                        <span>Cancel</span>
                                        </button>
                                        <button type="button" data-dz-remove class="btn btn-danger delete">
                                        <i class="fas fa-trash"></i>
                                        <span>Delete</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        

    </div>
</div>

@section('scripts')
@if(!empty($images))

<script>

    
$(function() {


    <?php foreach($images as $key => $eachImage): 
            $demo_class =  helper::pImageUrl($eachImage->image);
            $demo_class = str_replace("/","_",$demo_class);
            $demo_class = str_replace(".","_",$demo_class);
    
    ?>
        var mockFile = { name: "Image"+<?php echo $key+1;?>,img_url: "<?php  echo helper::pImageUrl($eachImage->image);?>", size: "<?php  getimagesize(helper::pImageUrl($eachImage->image));?>" };
        myDropzone.options.addedfile.call(myDropzone, mockFile);
        myDropzone.options.thumbnail.call(myDropzone, mockFile, "/<?php  echo helper::pImageUrl($eachImage->image) ?>");
        mockFile.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        mockFile.previewElement.querySelector(".cancel").setAttribute("disabled", "disabled")
        mockFile.previewElement.querySelector(".delete").setAttribute("img_name", "<?php  echo helper::pImageUrl($eachImage->image);?>")
        document.querySelector("#total-progress .progress-bar").style.width = 100 + "%";

        $(".attached_files").after("<input type='hidden' class='<?php echo $demo_class?>' id='<?php echo $demo_class?>' name='attached_files[]' value='<?php echo helper::pImageUrl($eachImage->image)?>'/>");
         
    <?php endforeach;?>

})


</script>
@endif

@endsection

