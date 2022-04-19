@extends('backend.layouts.master')

@section('title')
TaskTransaction - {{$title}}
@endsection
@section('navbar-content')



<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> Them Editor </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    @if(helper::roleAccess('taskTransaction.taskCreate.index'))
                    <li class="breadcrumb-item"><a href="{{ route('taskTransaction.taskCreate.index') }}">Task Create List</a></li>
                    @endif
                    <li class="breadcrumb-item active"><span>Add New Task Create</span></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('admin-content')

<section id="widget-grid" class="">
    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="jarviswidget" id="wid-editor-list-dir"
                 data-widget-deletebutton="false">
                <!-- widget options:
                   usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

                   data-widget-colorbutton="false"
                   data-widget-editbutton="false"
                   data-widget-togglebutton="false"
                   data-widget-deletebutton="false"
                   data-widget-fullscreenbutton="false"
                   data-widget-custombutton="false"
                   data-widget-collapsed="true"
                   data-widget-sortable="false"

                -->
                <header class="section-title">
                    <span class="widget-icon"> <i class="fa fa-road"></i> </span>
                    <h4>Directory & files</h4>
                </header>
                <div>
                    <div class="jarviswidget-editbox">
                        <input class="form-control" type="search">
                    </div>
                    <div class="widget-body no-padding" id="mrks_js_tree">
                    </div>
                </div>
            </div>
        </article>
        <article class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="jarviswidget" id="wid-editor"
                 data-widget-deletebutton="false">
                <!-- widget options:
                   usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

                   data-widget-colorbutton="false"
                   data-widget-editbutton="false"
                   data-widget-togglebutton="false"
                   data-widget-deletebutton="false"
                   data-widget-fullscreenbutton="false"
                   data-widget-custombutton="false"
                   data-widget-collapsed="true"
                   data-widget-sortable="false"

                -->
                <header class="section-title">
                    <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                    <h4>Editor</h4>

                </header>
                <div>
                    <div class="jarviswidget-editbox">
                        <input class="form-control" type="search">
                    </div>
                    <div class="widget-body">
                        <ul id="mrks_editor_ul" class="nav nav-tabs in">
                        </ul>
                        <div id="mrks_editor_tab_content" class="tab-content">
                            <div class="alert alert-info alert-editor">
                                <i class="fa fa-info"></i> Please select a file to edit!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>

@endsection
@section("styles")
 <link rel="stylesheet" href="{{ asset('backend/assets/theme/jstree/themes/default/style.min.css') }}"/>
 <link rel="stylesheet" href="{{ asset('backend/assets/theme/css/admin.css') }}"/>

@endsection
@section("scripts")
    <script src="{{ asset('backend/assets/theme/smartwidgets/jarvis.widget.min.js') }}"></script>
    <script src="{{ asset('backend/assets/theme/jstree/jstree.min.js') }}"></script>
    <script src="{{ asset('backend/assets/theme/ace-editor/ace.js') }}"></script>
    <script type="application/javascript">
        $(function () {
            /**
             * Initialize JS tree
             */
            $('#mrks_js_tree').jstree({
                'core': {
                    'data': {
                        'url': "<?php echo route('theme.appearance.edit'); ?>",
                        'data': function (node) {
                            if (node.data != undefined) {
                                return {'id': node.id, isDirectory: node.data.isDir, directory: node.data.dir};
                            } else {
                                return {'id': node.id};
                            }
                        }
                    }
                }
            });

            /**
             * JS tree click show select file info or children directory
             */
            var editorTabCount = 1;
            $('#mrks_js_tree').on("click", '.jstree-node', function (e) {
                $this = $(this);
                var isDir = $this.data('is-dir');
                if (isDir == 1) {
                    $this.children(".jstree-icon").click();
                } else {
                    var iswritable = $this.data('iswritable');
                    var dir = $this.data('dir');
                    var type = $this.data('type');
                    var filename = $this.data('filename');
                    var _token = $('#table_csrf_token').val();
                    if (iswritable == 1) {
                        $.ajax({
                            type: 'post',
                            'url': "<?php echo route('theme.appearance.edit'); ?>",
                            data: { "_token": "<?= csrf_token() ?>", dir: dir, filename: filename},
                            success: function (resp) {
                                if (resp.isSuccess == 1) {
                                    var liClass = '';
                                    var liClass = '';
                                    if (editorTabCount == 1) {
                                        liClass = 'active';
                                    }
                                    $(".alert-editor").fadeOut();
                                    var filenameMod = filename.replace(/\./g, '_');
                                    if ($("." + filenameMod).length > 0) {
                                        $("." + filenameMod).click();
                                    } else {
                                        $("#mrks_editor_ul").append('<li class="' + liClass + '">\n' +
                                            '<a class="mrks_editor_tab_link_' + editorTabCount + " " + filenameMod + '" ' +
                                            'href="#mrks_editor_tab_' + editorTabCount + '" data-toggle="tab">' + filename +
                                            '<span class="mrks_editor_tab_remove" ' +
                                            'data-id="' + editorTabCount + '"><i class="fa fa-times"></i></span>' +
                                            '</a>' +
                                            '</li>');
                                        $("#mrks_editor_tab_content").append('<div class="tab-pane fade in ' + liClass +
                                            '" id="mrks_editor_tab_' + editorTabCount + '">\n' +
                                            '<div id="mrks_editor_' + editorTabCount + '" style="height: 415px"></div>\n' +
                                            '<button class="btn btn-primary margin-top-15 mrks-editor-save"\n' +
                                            'type="button" ' +
                                            'id="mrks-editor' + editorTabCount + '" ' +
                                            'data-id="' + editorTabCount + '" ' +
                                            'data-dir="' + dir + '" ' +
                                            'data-filename="' + filename + '" ' +
                                            '><i class="fa fa-save"></i> Save File\n' +
                                            '</button><span><span>\n' +
                                            '</div>');
                                        $("#mrks_editor_" + editorTabCount).text(resp.contents);
                                        var editor = ace.edit("mrks_editor_" + editorTabCount);
                                        // use setOptions method to set several options at once
                                        editor.setOptions({
                                            autoScrollEditorIntoView: true,
                                            copyWithEmptySelection: true,
                                            fontSize: '18px'
                                        });
                                        editor.commands.addCommand({
                                            name: 'Save',
                                            bindKey: {win: 'Ctrl-S',  mac: 'Command-S'},
                                            exec: function(editor) {
                                                $("#mrks-"+editor.id).click();
                                            },
                                            readOnly: true
                                        });
                                        editor.resize();
                                        editor.setTheme("ace/theme/monokai");
                                        editor.session.setMode("ace/mode/" + type);
                                        $(".mrks_editor_tab_link_" + editorTabCount).click();
                                        $("#mrks-editor-save").fadeIn();
                                        editorTabCount++;
                                    }
                                } else {

                                    Swal.fire('Warning!',resp.message ,'warning');

                                 
                                }
                            },
                            error: function (err) {

                                Swal.fire('Warning!',err.message ,'warning');

                            }
                        });
                    } else {

                        Swal.fire('Warning!','We dont support this file edit!', 'warning');
                       
                    }
                }
                return false;
            });


            /**
             * Save edited data after click
             */
            $("#mrks_editor_tab_content").on('click', '.mrks-editor-save', function () {
                var $this = $(this);
                var id = $this.data("id");
                var dir = $this.data("dir");
                var filename = $this.data("filename");
                var editor = ace.edit("mrks_editor_" + id);
                var content = editor.getValue();
                if (content.length > 0) {
                    var btnHtml = $this.html();
                    $this.html('<i class="fa fa-refresh fa-spin"></i> Saving...');
                    $.ajax({
                        type: 'post',
                        url: "<?php echo route('theme.appearance.edit.save'); ?>",
                        data: { "_token": "<?= csrf_token() ?>", dir: dir, filename: filename, content: content},
                        success: function (resp) {
                            if (resp.isSuccess == 1) {
                                Swal.fire('Success!',resp.message,'success');
                            } else {
                                Swal.fire('warning!',resp.message,'warning');
                            }
                            $this.html(btnHtml);
                        },
                        error: function (err) {
                            console.log(err);
                            Swal.fire('warning!', err.responseText,'warning');
                         
                            $this.html(btnHtml);
                        }
                    });
                } else {
                    Swal.fire('warning!', 'Empty Content. Please write some code.','warning');
                   
                }
                return false;
            });


            /**
             * Delete editor tab
             */
            $("#mrks_editor_ul").on('click', '.mrks_editor_tab_remove', function () {
                var id = $(this).data("id");
                $(".mrks_editor_tab_link_" + id).remove();
                $("#mrks_editor_tab_" + id).remove();
                if ($("#mrks_editor_ul li:first-child a").length > 0) {
                    $("#mrks_editor_ul li:first-child a").click();
                } else {
                    $("#mrks_editor_tab_content").html('<div class="alert alert-info alert-editor">\n' +
                        '                                    <i class="fa fa-info"></i> Please select a file to edit!\n' +
                        '                                </div>');
                }
            });
        })

    </script>
    <!-- /.col-->

@endsection