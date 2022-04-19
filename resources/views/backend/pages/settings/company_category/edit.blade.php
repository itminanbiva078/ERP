
@extends('backend.layouts.master')
@section('title')
Settings - {{$title}}
@endsection
@section('navbar-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> Company Category </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.companyCategory.index') }}">Company Category List</a>
                    </li>
                    <li class="breadcrumb-item active"><span>Edit Company Category</span></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
@section('admin-content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3>
                <div class="card-tools">
                    <a class="btn btn-default" href="{{ route('settings.companyCategory.index') }}"><i
                            class="fa fa-list"></i> Company Category List</a>
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
                <form class="needs-validation" method="POST"
                    action="{{ route('settings.companyCategory.update',$editInfo->id) }}" novalidate>
                    @csrf
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">Company Category * :
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" class="checkPermissionAll" value="" id="checkPermissionAll">
                                    <label for="checkPermissionAll">
                                        All Check
                                    </label>
                                </div>
                            </label>
                        </div>
                       
                        <div class="form-row">
                            @foreach ($formInput as $key => $eachInput)
                            @if(isset($eachInput->inputShow) && $eachInput->inputShow == false)
                            {{-- //login input heare --}}
                            @else
                            @php htmlform::formfiled($eachInput, $errors, $editInfo) @endphp
                            @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th withd="5%!important">#</th>
                                        <th width="20%!important;">Menu</th>
                                        <th width="60%!important;">Submenu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($companyCategory as $key1 => $value)
                                        <tr>
                                            <td>{{$key1+2}}</td>
                                            <td>{{$value['label']}}
                                                <br>
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" class="submenu submenu_{{$key1}}" name="module[]"
                                                        serial_id="{{$key1}}" id="sub_{{$value['label']}}{{$key1}}">
                                                    <label for="sub_{{$value['label']}}{{$key1}}">
                                                        Select All
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <table class="table table-bordered">
                                                    @foreach($value['sub_menu'] as $key => $submenu)
                                                        <tr>
                                                            <td>
                                                                <div class="icheck-primary d-inline">
                                                                    <input @if(in_array($submenu['id'],$navigation_info)) checked
                                                                        @endif type="checkbox" name="module_details[]"
                                                                        value="{{$submenu['id']}}-{{$submenu['parent_id']}} " class="child_menu_{{$key1}}"
                                                                        id="child_{{$value['sub_menu']}}{{$key}}">
                                                                    <label for="child_{{$value['sub_menu']}}{{$key}}">
                                                                        {{$submenu['label']}}
                                                                    </label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <button class="btn btn-info" type="submit"><i class="fa fa-save"></i> &nbsp;Save</button>
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
@section('scripts')
@include('backend.pages.settings.company_category.script')
@endsection
