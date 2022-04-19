@extends('backend.layouts.master')

@section('title')
Settings - {{$title}}
@endsection
@section('navbar-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> Company Role </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('company.resource.index') }}">Company Role List</a>
                    </li>
                    <li class="breadcrumb-item active"><span>Update Company ROle</span></li>
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
                        Role List</a>
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
                <form class="needs-validation" method="POST" action="{{ route('company.resource.update',$company_id) }}" novalidate>
                    @csrf
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">Company Category * :
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" class="checkPermissionAll" id="checkPermissionAll">
                                    <label for="checkPermissionAll">
                                        All Check
                                    </label>
                                </div>
                            </label>
                            <select class="form-control select2 company_category" name="company_category">
                                <option>(:- Select Company Category-:)</option>
                                @foreach($companyCategory as $key => $value)
                                <option @if($company_id == $value->id) selected @endif value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                            @error('role_name')
                            <span class=" error text-red text-bold">{{ $message }}</span>
                            @enderror
                            @error('child_menu')
                            <span class=" error text-red text-bold">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <button class="btn btn-info" type="submit"><i class="fa fa-save"></i> &nbsp;Save</button>
                            
                        </div>
                    </div>
                   

            {{-- load html content as per as logic --}}
                <div id="loadContent"></div>
            {{-- load html content as per as logic --}}     
                  
                   
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
@include('backend.pages.usermanage.companyRole.script')
@endsection