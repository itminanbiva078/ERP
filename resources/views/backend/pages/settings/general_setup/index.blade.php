@extends('backend.layouts.master')
@section('title')
Settings - {{$title}}
@endsection

@section('styles')
<style>
.bootstrap-switch-large {
    width: 200px;
}
</style>
@endsection

@section('navbar-content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    Settings </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home') }}">Dashboard</a></li>
                    @if(helper::roleAccess('settings.generalSetup.index'))
                    <li class="breadcrumb-item"><a href="{{route('settings.generalSetup.index') }}">General Setup</a></li>
                    @endif
                    <li class="breadcrumb-item active"><span>General Setup List</span></li>
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
                <h3 class="card-title">General Setup List</h3>
                <div class="card-tools">
                {{-- @if(helper::roleAccess('settings.generalSetup.create'))
                    <a class="btn btn-default" href="{{ route('settings.generalSetup.create') }}"><i class="fas fa-plus"></i>Add New</a>
                @endif --}}
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
            @php
            $columns = Helper::getTableProperty();
            @endphp
            <div class="card-body">
                <div class="table-responsive">
                    <table id="systemDatatable" class="display table-hover table table-bordered table-striped">
                        <thead>
                            
                            <tr>
                                <th>SL</th>
                                <th>Action</th>
                                @foreach($columns as $key => $value)
                                <th>{{ucfirst($value)}}</th>
                                @endforeach
                            </tr>
                           
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                           
                                <th>SL</th>
                                <th>Action</th>
                                @foreach($columns as $key => $value)
                                <th>{{ucfirst($value)}}</th>
                                @endforeach
                               
                           
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">

            </div>
        </div>
    </div>
    <!-- /.col-->
</div>
@endsection
