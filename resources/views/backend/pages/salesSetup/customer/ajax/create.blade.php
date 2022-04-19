<form class="needs-validation" id="modalForm" method="POST" action="" novalidate>
    @csrf
    @if(!empty($formInput) && is_array($formInput))
    <div class="form-row">
            @foreach ($formInput as $key => $eachInput)
            @php htmlform::formfiledForModal($eachInput, $errors ?? '',$input ?? '') @endphp
            @endforeach
    </div>
    <button class="btn btn-info" type="button" onclick="modalSave('<?php echo $saveRoute;?>')"><i class="fa fa-save"></i> &nbsp;Save</button>
    @else
    <div class="alert alert-default">
        <strong>Warning!</strong> Sorry you have no form access !!.
      </div>
    @endif
</form>

<script>


$(function() {
    //Initialize Select2 Elements
    $('.select2').select2();
});

</script>
