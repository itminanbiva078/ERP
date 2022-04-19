
@extends('backend.layouts.master')
@section('title')
TaskSetup - {{$title}}
@endsection
@section('navbar-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> Task Setup</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    @if(helper::roleAccess('taskSetup.taskCategory.index'))
                    <li class="breadcrumb-item"><a href="{{ route('taskSetup.taskCategory.index') }}">Configure Theme Options</a></li>
                    @endif
                    <li class="breadcrumb-item active"><span>Configure Theme Options</span></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('admin-content')
<?php 
  use App\SM\SM;
?>
<?php
$files = SM::sm_get_media_files(config("constant.smPaginationMedia"));
?>
<!-- Button trigger modal -->
<div class="modal fade" id="sm_media_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     data-backdrop="static" data-keyboard="false" style="z-index: 9999999">
    <div class="modal-dialog modal-mizan modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{SM::sm_get_site_name()}} Media Library</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul id="sm_media_tab" class="nav nav-tabs bordered">
                    <li class="">
                        <a href="#media_library_tab" data-toggle="tab">Media Library</a>
                    </li>
                    <?php
                    $upload = SM::check_this_method_access( 'media', 'upload' ) ? 1 : 0;
                    if ($upload === 1)
                    {
                    ?>
                    <li class="active">
                        <a href="#upload_media_tab" data-toggle="tab">Upload Files</a>
                    </li>
                    <?php
                    }
                    ?>
                </ul>

                <div id="sm_media_tab_content" class="tab-content bge5 padding-10">
                    <div class="tab-pane fade" id="media_library_tab">
                        @include(('backend/layouts/media/files'))
                    </div>
                    <?php
                    if ($upload)
                    {
                    ?>
                    <div class="tab-pane fade in active" id="upload_media_tab">
                        <form action="{{ route('theme.appearance.media_upload') }}" class="dropzone"
                              id="mydropzone">
                            <label style="color: #ff0000; font-size: 20px;display: none"><input id="is_private" name="is_private" value="1"
                                                                                  type="checkbox"> Is private file?
                            </label><br>
                            {!! csrf_field() !!}
                        </form>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i> Close</span>
                </button>
                <button input_holder="image" img_holder="first_ph" img_width="165" media_width="165" is_multiple="0"
                        type="button" class="btn btn-primary" id="media_insert"><i class="fa fa-plus"></i> Insert
                </button>
            </div>
        </div>
    </div>
</div>




<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Configure Theme Options</h3>
                <div class="card-tools">
                    <div class="btn btn-sm btn-success" onclick="loadModal('inventory-setup-load-import-form','taskSetup.taskCategory.import','Import Task Category List','/backend/assets/excelFormat/taskSetup/taskCategory/taskCategory.csv','2')" data-toggle="modal" data-target="#modal-default"><i class="fa fa-upload"></i> Import</div>
                    <div class="btn btn-sm btn-default" ><a href="{{route('taskSetup.taskCategory.explode')}}"><i class="fa fa-download"></i> Expload</a></div>
                    @if(helper::roleAccess('taskSetup.taskCategory.index'))
                    <a class="btn btn-default" href="{{ route('taskSetup.taskCategory.index') }}"><i class="fa fa-list"></i>
                    Theme Options List</a>
                        @endif
                    <span id="buttons"></span>

                    <a class="btn btn-tool btn-default" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </a>
                    <a class="btn btn-tool btn-default" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="needs-validation" method="post" action="{{ route('theme.appearance.saveThemeOption') }}" novalidate>
                    @csrf
                        <?php
                        if (isset($smThemeOptions) && is_array($smThemeOptions) && count($smThemeOptions) > 0) 
                        {
                            foreach ($smThemeOptions as $sectionId => $sectionValue) 
                            {
                                SM::smSwitchToType($sectionValue, $sectionId);
                            }
                        }
                        ?>
                    
                   <div class="col-sm-12 text-right">
                    <button type="submit"
                            class="btn btn-primary margin-bottom-10  margin-top-10 sm_theme_option_save"
                            id="sm_theme_option_save"><i class="fa fa-save"></i> Save
                    </button>
                    <a class="btn btn-primary btn-danger"
                       href="{!! url(SM::smAdminSlug("flush-cache")) !!}">
                        <i class="fa fa-trash-o"></i>
                        Flush Cache
                    </a>
                    <button type="button"
                            class="btn btn-default margin-bottom-10  margin-top-10 sm_theme_option_move_to_top"
                            id="sm_theme_option_save"><i class="fa fa-arrow-up"></i> Move To Top
                    </button>
                </div>
                  
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
            </div>
        </div>
    </div>
    <!-- /.col-->
</div>
@endsection
@section('style')
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/summernote/summernote-bs4.min.css') }}">

@endsection
@section('scripts')
<script src="{{ asset('backend/assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/superbox/superbox.min.js') }}"></script>

<script>




    $(function () {
      // Summernote
      $('.summernote').summernote()
    })

    if ($('.close_modal').length > 0) {
        $('.close_modal').on('click', function () {
            var close = $(this).data('close');
            $('#' + close).modal('hide');
        });
    }

    Dropzone.autoDiscover = false;
        $("#mydropzone").dropzone({
            addRemoveLinks: false,
            maxFilesize: 100,
            dictResponseError: 'Error uploading file!',
            success: function (file, response) {
                if ($(".superbox").length > 0) {
                    $(".superbox").prepend(response);
                    $(".dz-progress").fadeOut();
                    $(".dz-success-mark").fadeIn();
                }
            }
        });

        function get_the_file_width(str, width) {
            return str.replace('112x112', width + 'x' + width);
        }


        /**
     * Media library functionality
     */

    if ($('#sm_media_tab_content').length > 0) {
        $('#sm_media_tab_content').on('click', '.sm_media_file_delete', function () {
            var selector = $(this).parent('span').siblings('.sm_galay_file_meta');
            var id = selector.find('#file_id').val();
            swal({
                title: "Warning?",
                text: 'Are you sure delete this file?',
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    var _token = $('#table_csrf_token').val();
                    $.ajax({
                        type: 'post',
                        url: '/admin/' + 'media/delete',
                        data: {_token: _token, id: id},
                        success: function (response) {
                            $('#sm_media_tab_content .sm_file_' + id).remove();
                            $('.superbox-show').slideUp();
                        },
                        error: function (error) {
                            //console.log(error);
                        }
                    });
                } else {
                    swal({
                        type: 'warning',
                        icon: "warning",
                        title: 'Delete Cancelled',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });

        });
        $('#sm_media_tab_content').on('click', '.sm_media_file_download', function () {
            var selector = $(this).parent('span').siblings('.sm_galay_file_meta');
            var id = selector.find('#file_id').val();
            window.location.href = '/admin/' + 'media/download/' + id;
        });
        $('#sm_media_tab_content').on('click', '.sm_media_file_copy', function () {
            var selector = $(this).attr("copy");
            var copyText = document.getElementById(selector);
            copyText.select();
            document.execCommand("Copy");
            swal({
                type: 'success',
                icon: 'success',
                title: 'Successfully Copied!',
                showConfirmButton: false,
                timer: 2000
            });
            return false;
        });
        $('#sm_media_tab_content').on('click', '#sm_galary_meta_save', function () {
            var selector = $(this).parent('.sm_galay_file_meta');
            var id = selector.find('#file_id').val();
            var title = selector.find('#file_title').val();
            var alt = selector.find('#file_alt').val();
            var caption = selector.find('#file_caption').val();
            var description = selector.find('#file_description').val();
            var _token = $('#table_csrf_token').val();
            $.ajax({
                type: 'post',
                url: '/admin/' + 'media/update',
                data: {_token: _token, id: id, title: title, alt: alt, caption: caption, description: description},
                success: function (response) {
                    swal({
                        type: 'success',
                        icon: "success",
                        title: "Success!",
                        text: 'File Meta Saved successfully!',
                        showConfirmButton: false,
                        timer: 3000
                    });
                },
                error: function (error) {
                    //console.log(error);
                }
            });

        });

        $("#sm_media_load_more").on('click', function (e, $affected) {
            var $this = $(this);
            var btnHtml = $this.html();
            $this.html('<i class="fa fa-refresh fa-spin"></i> Loading..');

            var loaded = $this.data("loaded");
            var need_to_load = $this.data("need_to_load");
            $.ajax({
                type: 'get',
                url: '/admin/' + 'media/' + loaded,
                success: function (response) {
                    var data = JSON.parse(response);
                    loaded = data.load;
                    $('.superbox').find('.superbox-float').before(data.media);
                    loaded = $this.data("loaded", loaded);
                    $this.html(btnHtml);
                    // console.log("need_to_load = "+need_to_load+" data.count ="+data.count);
                    if (need_to_load > data.count) {
                        $this.fadeOut();
                    }
                }
            });

        });

    }
    if ($('#sm_media_modal').length > 0) {
        $('#media_library_tab .superbox').on('click', '.superbox-list', function () {

            var is_multiple = parseInt($('#media_insert').attr('is_multiple'));
            if (is_multiple == 0) {
                $('#media_library_tab .superbox').find('.sm_media_selected').removeClass('sm_media_selected');
                $(this).addClass('sm_media_selected');
            } else {
                if ($(this).hasClass('sm_media_selected')) {
                    $(this).removeClass('sm_media_selected');
                } else {
                    $(this).addClass('sm_media_selected');
                }
            }
        });
        $('body').on('click', '.sm_media_modal_show', function () {
            var input_holder = $(this).attr('input_holder');
            var img_holder = $(this).attr('img_holder');
            var is_multiple = parseInt($(this).attr('is_multiple'));
            $('#media_insert').attr('input_holder', input_holder);
            $('#media_insert').attr('img_holder', img_holder);
            $('#media_insert').attr('is_multiple', is_multiple);
            if ($(this).attr('media_width')) {
                $('#media_insert').attr('media_width', $(this).attr('media_width'));
            }
            if ($(this).attr('img_width')) {
                $('#media_insert').attr('img_width', $(this).attr('img_width'));
            }
            $('#sm_media_modal').modal('show');
        });


        $('#media_insert').on('click', function () {
            var input_holder = $(this).attr('input_holder');
            var img_holder = $(this).attr('img_holder');
            var is_multiple = parseInt($(this).attr('is_multiple'));
            var media_width = parseInt($(this).attr('media_width'));

           
            var img_width = parseInt($(this).attr('img_width'));
            if (is_multiple === 0) {
                var selector = $('#media_library_tab .superbox').find('.sm_media_selected').find('img');
                var id = selector.attr('img_id');
                var img_slug = selector.attr('img_slug');
                var src = get_the_file_width(selector.attr('src'), media_width);


                $('#' + input_holder).val(img_slug);
                //$('#' + img_holder + ' .media_img').attr('src', src);
                $('#' + img_holder).html('<img class="media_img" src="' + src + '" width="' + img_width + 'px" />');
            } else {
                var id = '', images = '', slug = '';
                $('#media_library_tab .superbox .sm_media_selected').each(function (index) {
                    var selector = $(this).find('img');
                    if (index > 0) {
                        id += ',';
                        slug += ',';
                    }
                    var img_id = selector.attr('img_id');
                    var img_slug = selector.attr('img_slug');
                    id += img_id;
                    slug += img_slug;
                    var src = get_the_file_width(selector.attr('src'), media_width);
                    images += '<span class="gl_img"><img class="" src="' + src + '" width="' + img_width + 'px" /><span class="displayNone remove"><i class="fa fa-times-circle remove_img" data-img="' + img_slug + '"  data-input_holder="' + input_holder + '"></i></span></span>';
                });
                var old_ids = $('#' + input_holder).val();
                //console.log('old=' + old_ids);
                if (old_ids.trim() == '') {
                    $('#' + input_holder).val(slug);
                } else {
                    $('#' + input_holder).val(old_ids + ',' + slug);
                }

                $('#' + img_holder).html($('#' + img_holder).html() + images);
            }
            $('#sm_media_modal').modal('hide');
        });
    }


        /* sm theme option js start */
    if ($(".smThemeAddablePopUp").length > 0) {

        $(".smThemeOptionPopupModal .col-md-7").each(function () {
            $(this).addClass("col-md-12").removeClass("col-md-7");
        });
        $(".smThemeOptionPopupModal .col-md-9").each(function () {
            $(this).addClass("col-md-10").removeClass("col-md-9");
        });
        $(".smThemeAddablePopUp").on("click", ".sm_theme_remove_popup_item", function () {
            //console.log("sm_theme_edit_popup_item clicked");
            $(this).parent("li").remove();
        });
        $(".smThemeAddablePopUp").on("click", ".add_more_popup", function () {

            var info = $(this).attr('data-info');
            var modal = $(this).data("target");
            var formattedvalue = $(this).attr('data-formattedvalue');
            // console.log("info = " + info + " modal = " + modal);
            var saveId = 'save_sm_theme_popup';
            
       
            if ($("#" + modal).find(".update_sm_theme_popup").length) {
                saveId = 'update_sm_theme_popup';
            }

           
            $("#" + modal).find('.sortable').html('');
            $("#" + modal + ' .sm_theme_popup_field').each(function () {
                var type = $(this).attr('type');
                if (type !== 'radio' && type !== 'checkbox') {
                    $(this).val('');
                    $(this).removeAttr('name');
                }
            });
            // $("#" + modal).find('.sm_theme_popup_field').removeAttr('name');
            $("#" + modal).find("." + saveId).attr('data-formattedvalue', formattedvalue);
            $("#" + modal).find("." + saveId).attr('data-value', "");
            $("#" + modal).find("." + saveId).attr('data-info', info);
            if (saveId == 'update_sm_theme_popup') {
                $("#" + modal).find(".update_sm_theme_popup").addClass("save_sm_theme_popup").removeClass("update_sm_theme_popup");
            }
            $("#" + modal).modal("show");
            return false;
        });
        $(".smThemeAddablePopUp").on("click", ".sm_theme_edit_popup_item", function () {
            //console.log("sm_theme_edit_popup_item clicked");
            var info = $(this).attr('data-info');
            var mainid = $(this).data("mainid");
            var children = $(this).data("children");
            var modal = mainid + "_Modal";
            var value = $(this).siblings('.sm_theme_popup_field').val();
            value = typeof value == 'string' ? value : JSON.stringify(value);
            var formattedvalue = $(this).siblings('.sm_theme_popup_field').attr('data-formattedvalue');
            formattedvalue = typeof formattedvalue == 'string' ? formattedvalue : JSON.stringify(formattedvalue);
            //console.log("mainId = " + mainid + " modal = " + modal + " value = " + value + " formattedValue= " + formattedvalue);
            remove_sm_theme_option_active_sortable(children);
            $(this).parent(".ui-state-default").addClass("sm_theme_option_active_sortable" + children);
            $("#" + modal).find('.sortable').html('');
            $("#" + modal).find(".save_sm_theme_popup").attr('data-value', value);
            $("#" + modal).find(".save_sm_theme_popup").attr('data-formattedvalue', formattedvalue);

            value = typeof value === 'string' ? JSON.parse(value) : value;
            // console.log(value);
            formattedvalue = typeof formattedvalue == 'string' ? JSON.parse(formattedvalue) : formattedvalue;
            // console.table(formattedvalue);
            for (var index in formattedvalue) {
                // for (var infoId in formattedvalue[index]) {
                var single = formattedvalue[index];
                // var single = formattedvalue[index][infoId];
                // console.log("loop index "+index+" single = "+JSON.stringify(single));
                var id = single["id"];
                var type = single["type"];
                var val = single["value"];
                var name = single["name"];
                var selector = single["selector"];


                // console.log("modal = " + modal + " type = " + type + " id = " + id + " val = " + val + " name = " + name + " selector = " + selector);

                if (type !== undefined && type.length > 0) {
                    if (type === "upload") {
                        mrksGetImageResponse(modal, selector, val);
                    } else if (type === 'radio' || type === 'checkbox') {
                        $("#" + modal).find(".sm_theme_popup_" + id).each(function () {
                            var currentVal = $(this).val();
                            // console.log("val = "+val+" currentVal = "+currentVal);
                            if (val === currentVal) {
                                // console.log("ok");
                                $(this).prop("checked", true);
                            } else {
                                $(this).prop("checked", false);
                            }
                        });
                    } else if (type === 'addable-popup') {
                        // console.log('addable-popup');
                        var itemTemplate = $('#' + mainid + "_" + id + '__add_more').data('template');
                        // console.log("id = " + id + " mainid = " + mainid + " itemTemplate = " + itemTemplate + " value = " + value);
                        console.table(val);
                        var html = '';
                        if (val != '') {
                            for (var pIndes in val) {
                                // console.log("val "+JSON.stringify(val));
                                var jsonformattedvalue = val[pIndes];
                                var newValue = typeof value == 'string' ? JSON.parse(value) : value;
                                var jsonvalue = newValue[id][pIndes];
                                // console.log("itemTemplate = " + itemTemplate + " jsonvalue = " + jsonvalue);

                                jsonvalue = typeof jsonvalue == 'string' ? JSON.parse(jsonvalue) : jsonvalue;

                                var title = jsonvalue[itemTemplate] || "title";
                                html += '<li class="ui-state-default">\n' +
                                    '<i class="fa fa-sort"></i>';

                                var jsonvalue = typeof jsonvalue === 'string' ? jsonvalue : JSON.stringify(jsonvalue);
                                var jsonformattedvalue = typeof jsonformattedvalue === 'string' ? jsonformattedvalue : JSON.stringify(jsonformattedvalue);

                                html += generateInput('<input type="hidden" ' +
                                    'value="" ' +
                                    'data-formattedvalue="" ' +
                                    'class="sm_theme_popup_field sm_theme_popup_' + id + ' ' + mainid + "_" + id + '_value" ' +
                                    'data-selector="' + selector + '" ' +
                                    'data-info="' + id + '" ' +
                                    '>', jsonvalue, jsonformattedvalue);


                                html += '<span class="sm_theme_popup_title"> ' + title + '</span>';
                                html += '<a href="javascript:void(0)" class="btn btn-xs btn-danger btn-popup sm_theme_remove_popup_item">\n' +
                                    '<i class="fa fa-times"></i>\n' +
                                    '</a>\n' +
                                    '<a href="javascript:void(0)" class="btn btn-xs btn-success btn-popup sm_theme_edit_popup_item"\n' +
                                    ' data-children="2"\n' +
                                    ' data-template="' + id + '"\n' +
                                    ' data-info="' + id + '"\n' +
                                    ' data-mainid="' + mainid + "_" + id + '_">\n' +
                                    '<i class="fa fa-pencil"></i>\n' +
                                    '</a>\n' +
                                    '</li>';
                            }
                        }
                        $("#" + modal).find('.sortable').html(html);

                    } else {
                        $("#" + modal).find(".sm_theme_popup_" + id).val(val);
                    }
                } else {
                    $("#" + modal).find(".sm_theme_popup_" + id).val(val);
                }
                // }
            }

            $("#" + modal).find(".save_sm_theme_popup").data('info', info);
            $("#" + modal).find(".save_sm_theme_popup").addClass("update_sm_theme_popup").removeClass("save_sm_theme_popup");
            $("#" + modal).modal("show");
            return false;
        });

        $(".smThemeAddablePopUp").on("click", ".update_sm_theme_popup", function () {
            var template = $(this).data("template");
            var children = $(this).data("children");
            var modal = $(this).data("insert");
            var formattedvalue = $(this).data("formattedvalue");
            var value = $(this).data("value");

            value = typeof value == 'string' ? JSON.parse(value) : value;
            formattedvalue = typeof formattedvalue == 'string' ? JSON.parse(formattedvalue) : formattedvalue;
            // console.log("template = " + template + " modal = " + modal + " value = " + value + " formattedValue= " + formattedvalue);
            // console.table(value);
            var pcReturn = processPopUpInfo(modal, formattedvalue, template, children);
            // console.table(pcReturn);

            var jsonvalue = typeof pcReturn.value === 'string' ? pcReturn.value : JSON.stringify(pcReturn.value);
            var jsonformattedvalue = typeof pcReturn.formattedvalue === 'string' ? pcReturn.formattedvalue : JSON.stringify(pcReturn.formattedvalue);
            $('.sm_theme_option_active_sortable' + children).find(".sm_theme_popup_field").val(jsonvalue);
            $('.sm_theme_option_active_sortable' + children).find(".sm_theme_popup_field").attr('data-formattedvalue', jsonformattedvalue);
            $(this).addClass("save_sm_theme_popup").removeClass("update_sm_theme_popup");
            remove_sm_theme_option_active_sortable(children);
            $("#" + modal + "_Modal").modal("hide");
            return false;
        });


        $(".smThemeAddablePopUp").on("click", ".save_sm_theme_popup", function () {
            // console.log("save_sm_theme_popup");
            var id = $(this).data("insert");
            var info = $(this).attr("data-info");
            var children = $(this).data("children");
            var inputname = $(this).data("inputname");
            var template = $(this).data("template");
            var iteration = $(this).data("formattedvalue");
            var count = parseInt($("#" + id + "_count").val());
            var title = "Title";
            // console.log(iteration);
            // console.log("template " + template + " save_sm_theme_popup " + id + " info =" + info);

            var html = '<li class="ui-state-default">\n' +
                '                            <i class="fa fa-sort"></i>';
            var value = {}, formattedvalue = [], parentname;


            var pcReturn = processPopUpInfo(id, iteration, template, children);

            var jsonvalue = typeof pcReturn.value === 'string' ? pcReturn.value : JSON.stringify(pcReturn.value);
            var jsonformattedvalue = typeof pcReturn.formattedvalue === 'string' ? pcReturn.formattedvalue : JSON.stringify(pcReturn.formattedvalue);
            // console.log('\n\njsonvalue ' + jsonvalue);
            // console.log('jsonformattedvalue ' + jsonformattedvalue);
            var nameFiled = '';
            if (children == 1) {
                nameFiled = 'name="' + inputname + '"';
            }
            // console.log("info = "+info);
            html += generateInput('<input type="hidden" ' +
                'value="" ' +
                'data-formattedvalue="" ' +
                'class="sm_theme_popup_field sm_theme_popup_' + info + ' ' + id + 'value" ' +
                'data-selector="' + id + '" ' +
                'data-info="' + info + '" ' +
                nameFiled + '>', jsonvalue, jsonformattedvalue);


            html += '<span class="sm_theme_popup_title"> ' + pcReturn.title + '</span>';
            html += '<a href="javascript:void(0)" class="btn btn-xs btn-danger btn-popup sm_theme_remove_popup_item">\n' +
                '<i class="fa fa-times"></i>\n' +
                '</a>\n' +
                '<a href="javascript:void(0)" class="btn btn-xs btn-success btn-popup sm_theme_edit_popup_item"\n' +
                ' data-children="' + children + '"\n' +
                ' data-template="' + template + '"\n' +
                ' data-info="' + info + '"\n' +
                ' data-mainid="' + id + '">\n' +
                '<i class="fa fa-pencil"></i>\n' +
                '</a>\n' +
                '                        </li>';
            $("#" + id + "_count").val(++count);
            $("#" + id).find('.sortable').append(html);
            $("#" + id + "_Modal").modal("hide");
            return false;
        });


        

        $(".sm_theme_option_save").on("click", function () {
            sorting_position_change();
            $("#smThemeOptionPopupModal").remove();
            for (var instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            // $("#sm_theme_option_form").submit();
            var formData = $("#sm_theme_option_form").serialize();
            var action = $("#sm_theme_option_form").attr('action');
            $.ajax({
                url: action,
                data: formData,
                type: 'post',
                success: function (response) {
                    swal({
                        type: 'success',
                        icon: "success",
                        title: response,
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });
            return false;
        });


    }



    function mrksGetImageResponse(modal, selector, val) {
        var imagePlaceholder = selector + "_ph";
        var _token = $('#table_csrf_token').val();
        $("#" + modal).find("#" + selector).val(val);
        $.ajax({
            url: '/admin/' + "get_image_src",
            data: {is_upload: 1, ids: val, _token: _token},
            type: 'post',
            success: function (response) {
                $("#" + modal).find(".smthemesingleimagediv#" + imagePlaceholder).html(response);
            }
        });
    }


    function imagePrev(imageID, imageHolder) {
    var imgPath = $('#' + imageID)[0].value;
    var extn = imgPath.substring(imgPath.lastIndexOf(".") + 1).toLowerCase();
//        alert(imageID + " " + imageHolder + " " + imgPath + " " + extn);
    if (extn === "gif" || extn === "png" || extn === "jpg" || extn === "jpeg") {
        if (typeof (FileReader) !== "undefined") {
            var image_holder = $("#" + imageHolder);
            image_holder.empty();

            var reader = new FileReader();
            reader.onload = function (e) {
                $("<img />", {
                    "src": e.target.result,
                    "class": "image-prev"
                }).appendTo(image_holder);

            };
            image_holder.show();
            reader.readAsDataURL($('#' + imageID)[0].files[0]);
        } else {
            alert("This browser does not support FileReader.");
        }
    } else {
        alert("Pls select only images");
    }
}


    function processPopUpInfo(id, iteration, template, children) {
        var title = "Title";
        console.log("iteration");
        console.log(iteration);
        console.log("template");
        console.log(template);
        console.log("children");
        console.log(children);
        var value = {}, formattedvalue = {}, parentname;
        for (var index in iteration) {
            var single = iteration[index];

            var newformattedvalue = {}, newformattedvalue2 = {};


            console.log("single.type "+single.type);
            if (single.type !== 'addable-popup') {

                parentname = single.name;
                if (single.type == 'radio') {
                    var $this = $("#" + id + "_Modal").find('.sm_theme_popup_' + single.id + ':checked');
                } else {
                    var $this = $("#" + id + "_Modal").find('.sm_theme_popup_' + single.id);
                }
                var name = $this.data("name");
                var selector = $this.data("selector");
                var val = $this.val();
                if (single.type === 'checkbox') {
                    if ($this.is(':checked')) {
                        val = $this.val();
                    } else {
                        val = "";
                    }
                }
                // $(this).val("");
                if (template === single.id) {
                    title = val;
                    $(".sm_theme_option_active_sortable" + children).find(".sm_theme_popup_title").text(val);
                }
                value[single.id] = val;
                newformattedvalue.id = single.id;
                newformattedvalue.type = single.type;
                newformattedvalue.name = name;
                newformattedvalue.value = val;
                newformattedvalue.selector = selector;
                // newformattedvalue2[single.id] = newformattedvalue;

                formattedvalue[single.id] = (newformattedvalue);

                // console.log("in loop info = "+info+" type = "+single.type+" name = "+name+" val= "+val+" selector = "+selector+" newformattedvalue2 ="+JSON.stringify(newformattedvalue2));
                //console.log("in loop value =" + JSON.stringify(value));
                //console.log("in loop newformattedvalue2 =" + JSON.stringify(newformattedvalue2));
            } else {
                var newInput = [];
                var newFormatttedValue = [];
                $("#" + id + "_Modal .sm_theme_popup_" + single.id).each(function () {
                    var singleInfo = $(this).val();
                    // console.log("singleInfo "+singleInfo);
                    var singleFV = $(this).attr('data-formattedvalue');
                    newInput.push(singleInfo);
                    newFormatttedValue.push(singleFV);
                });


                parentname = single.name;
                var name = single.name;
                var selector = single.selector + "__" + single.id + "_";
                var val = newInput;
                // $(this).val("");
                if (template === single.id) {
                    title = val;
                    $(".sm_theme_option_active_sortable" + children).find(".sm_theme_popup_title").text(val);
                }
                value[single.id] = val;
                newformattedvalue.id = single.id;
                newformattedvalue.type = single.type;
                newformattedvalue.name = name;
                newformattedvalue.value = newFormatttedValue;
                newformattedvalue.selector = selector;
                // newformattedvalue2[single.id] = newformattedvalue;

                formattedvalue[single.id] = (newformattedvalue);

                // console.log("in loop id = " + single.id + " type = " + single.type + " name = " + name + " val= " + val + " selector = " + selector + " newformattedvalue2 =" + JSON.stringify(newformattedvalue2));
                // console.log("in loop else single =" + JSON.stringify(value));
                // console.log("in loop else newformattedvalue2 =" + JSON.stringify(newformattedvalue2));
                // console.log("in loop "+"#" + id + "_Modal .sm_theme_popup_" + single.id);
                // console.table(newFormatttedValue);
            }

        }
        var fnReturun = {};
        fnReturun.title = title;
        fnReturun.value = value;
        fnReturun.parentname = parentname;
        fnReturun.formattedvalue = formattedvalue;
        return fnReturun;
    }

    window.onload = function () {
//Check File API support
    if (window.File && window.FileList && window.FileReader) {

        var filesInput = document.getElementById("userfile");
        if (filesInput != null) {
            filesInput.addEventListener("change", function (event) {

                var files = event.target.files; //FileList object
                var output = document.getElementById("result");
                $('#result li').remove();
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    //Only pics
                    if (!file.type.match('image'))
                        continue;
                    var picReader = new FileReader();
                    picReader.addEventListener("load", function (event) {

                        var picFile = event.target;
                        var div = document.createElement("li");
                        div.innerHTML = "<img class='thumbnail' src='" + picFile.result + "'" +
                            "title='" + picFile.name + "'/>";
                        output.insertBefore(div, null);
                    });
                    //Read the image
                    picReader.readAsDataURL(file);
                }

            });
        }
    } else {
        console.log("Your browser does not support File API");
    }

}

    function remove_sm_theme_option_active_sortable(children) {
        $(".sm_theme_option_active_sortable" + children).each(function () {
            $(this).removeClass("sm_theme_option_active_sortable" + children);
        });
    }

    function sorting_position_change() {
        $(".smThemeAddablePopUp ul").each(function () {
            var loop = 0;
            $(this).children("li").each(function () {
                $(this).children(".sm_theme_popup_input").each(function () {
                    var id = $(this).data("id");
                    var basename = $(this).data("basename");
                    if (basename.length > 0) {
                        //console.log("basename = " + basename + "[" + loop + "]" + "[" + id + "]");
                        $(this).attr("name", basename + "[" + loop + "]" + "[" + id + "]");
                    }
                });
                loop++;
            });
        });
    }

    $(".sm_post_save_process").on("click", function () {
        sorting_position_change();
    });
    $('.colorpicker').colorpicker({
        colorSelectors: {
            'black': '#000000',
            'white': '#ffffff',
            'red': '#FF0000',
            'default': '#777777',
            'primary': '#337ab7',
            'success': '#5cb85c',
            'info': '#5bc0de',
            'warning': '#f0ad4e',
            'danger': '#d9534f'
        }
    });


    /* end sm theme option js */


    /**
     * Generate slug
     */
    function checkSlug($this) {
        // console.log("checkSlug");
        var slug = $this.val();
        var table = $this.data("table");
        var current_info_id = $('#current_info_id').val();
        var _token = $('#table_csrf_token').val();
        if (slug.length != '' && table.length != '') {
            $.ajax({
                type: 'post',
                url: '/admin/' + "check-slug",
                data: {slug: slug, table: table, 'current_info_id': current_info_id, _token: _token},
                success: function (response) {
                    $("#slug").val(response);
                }
            });
        }
    }

    if ($(".sm-title-section").length > 0) {
        $("#slug").on("change", function () {
            checkSlug($(this));
        });
        $("#title").on("change", function () {
            checkSlug($(this));
        });
    }

    if ($('#smpagination_links').length > 0) {
        $("#smpagination_links").on('click', 'a', function () {
            $(this).html('<i class="fa fa-refresh fa-spin"></i>');
            var href = $(this).attr('href');
            $.ajax({
                type: 'get',
                url: href,
                success: function (response) {
                    $("#dataBody").html(response.data);
                    $("#smpagination_links").html(response.smPagination);
                },
                error: function (err) {
                    console.log("AJAX Error");
                }
            });
            return false;
        });
    }

    function generateInput(html, value, formattedValue) {
        $("body").append('<div id="mrks">' + html + '</div>>');
        $("#mrks").find("input").val(value);
        $("#mrks").find("input").attr('data-formattedvalue', formattedValue);
        var returnval = $("#mrks").html();
        $("#mrks").remove();
        return returnval;
    }


  </script>
@endsection





