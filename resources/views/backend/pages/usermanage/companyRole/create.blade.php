@extends('backend.layouts.master')

@section('title')
Settings - {{$title}}
@endsection
@section('navbar-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> Settings </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('company.resource.index') }}">Company Resource List</a>
                    </li>
                    <li class="breadcrumb-item active"><span>Add New Company Resource</span></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('admin-content')


<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3>
                <div class="card-tools">
                    <a class="btn btn-default" href="{{ route('company.resource.index') }}"><i class="fa fa-list"></i>
                        Resourse List</a>
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
                <form class="needs-validation " method="POST" action="{{ route('company.resource.store') }}" novalidate>
                    @csrf
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">Role Name * :
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" class="checkPermissionAll" id="checkPermissionAll">
                                    <label for="checkPermissionAll">
                                        All Check
                                    </label>
                                </div>
                            </label>
                            <select class="form-control select2" name="company_category">
                                <option value="" disabled>(:- Select Company Category-:)</option>
                                @foreach($companyCategory as $key => $value)
                                <option @if(!empty(old('company_category')) && old('company_category') == $value->id) selected @endif value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                            @error('company_category')
                            <span class=" error text-red text-bold">{{ $message }}</span>
                            @enderror
                            <br>
                            @error('permission')
                            <span class=" error text-red text-bold">{{ $message }}</span>
                            @enderror

                            <br>

                            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
                        </div>
                        <div class="col-md-6 mb-3 pull-right">
                            <br>
                            <button class="btn btn-info " type="submit"><i class="fa fa-save"></i> &nbsp;Save</button>

                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th withd="5%!important">#</th>
                                    <th width="20%!important;">Module</th>
                                    <th width="20%!important;">Menu</th>
                                    <th width="60%!important;">Permission</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($formProperty as $key1 => $value)
                                <tr>
                                    <td>{{$key1+2}}</td>
                                    <td>{{$value->navigation->label ?? ''}}</td>
                                    <td>{{ucfirst($value->table) ?? ''}}
                                        <br>
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox"
                                                class="submenu submenu_{{$key1}}{{$value->navigation_id}}{{$value->table}}"
                                                serial_id="{{$key1}}{{$value->navigation_id}}{{$value->table}}"
                                                id="sub_{{$value->navigation_id}}{{$key1}}">
                                            <label for="sub_{{$value->navigation_id}}{{$key1}}">
                                                Select All
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <table class="table table-bordered">
                                            @php
                                            $inputDetails = json_decode($value->input);
                                            @endphp
                                            @foreach($inputDetails as $key => $eachInput)
                                            <tr>
                                                <td>
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox"
                                                            name="permission[{{$value->navigation_id}}][{{$eachInput->name}}]"
                                                            value="{{json_encode($eachInput)}}"
                                                            class="child_menu_{{$key1}}{{$value->navigation_id}}{{$value->table}}"
                                                            id="child_{{$value->table}}{{$key1}}{{$eachInput->name}}{{$key}}">
                                                        <label for="child_{{$value->table}}{{$key1}}{{$eachInput->name}}{{$key}}">
                                                            {{$eachInput->name}}
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
@include('backend.pages.usermanage.userRole.script')
@endsection
