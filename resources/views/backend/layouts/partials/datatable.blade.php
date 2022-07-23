@if(!empty($datatableRoute))
@php
$columns = helper::getQueryPropertyForDataTable($customDatatableRoute=null);

@endphp

<script type="text/javascript">

    let table = $('#systemDatatable').DataTable({
        "pageLength": "{{helper::getGeneralData('default_datatable_list_number')}}",
        "processing": true,
        "serverSide": true,
        "autoWidth": false,
        "responsive": true,
        "ajax": {
           // "url": "{{ route('inventorySetup.product.dataProcessingProduct') }}",
            "url": "{{ route($datatableRoute) }}",
            "dataType": "json",
            "type": "GET",
            "data": {
                "_token": "<?= csrf_token() ?>"
            }
        },
            "columns": [{
                "data": "id",
                "orderable": true
            },
            {
                "data": "action",
                "class": 'text-nowrap',
                "searchable": false,
                "orderable": false
            },
            <?php foreach($columns as $key => $value): 
                if($value == "mrr_status"): 
                    if(helper::mrrIsActive()):
                    ?>
                    {
                    "data": "<?php echo $value;?>",
                    "orderable": true
                  },
                    <?php 
                    endif;
                else: 
            ?>
            {
                "data": "<?php echo $value;?>",
                "orderable": true
            },
            <?php endif; endforeach; ?>
           
        ],
    
        "fnDrawCallback": function() {
            $("[name='my-checkbox']").bootstrapSwitch({
                size: "small",
                onColor: "success",
                offColor: "danger"
            });
        },
    
    });
    var buttons = new $.fn.dataTable.Buttons(table, {
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
            'print',
        ]
    }).container().appendTo($('#buttons'));
    </script>
@endif