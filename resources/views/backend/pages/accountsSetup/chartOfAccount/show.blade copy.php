@extends('backend.layouts.master')
@section('title')
Accounts - {{$title}}
@endsection
@section('navbar-content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> Account </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    @if(helper::roleAccess('accountSetup.chartOfAccount.index'))
                    <li class="breadcrumb-item"><a href="{{ route('accountSetup.chartOfAccount.index') }}">Account List</a>
                    </li>
                    @endif
                    <li class="breadcrumb-item active"><span>Add New Account</span></li>
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
                <h3 class="card-title">Chart of Account</h3>
                <div class="card-tools">
                    @if(helper::roleAccess('accountSetup.chartOfAccount.index'))
                    <a class="btn btn-default" href="{{ route('accountSetup.chartOfAccount.index') }}"><i
                            class="fa fa-list"></i>
                            Account List</a>
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
                <script src="http://demo.expertphp.in/js/jquery.js"></script>
                <div class="row">
                    <div class="col-md-12">
                        {!! $tree !!}
                    </div>
                </div>
                 <hr/>
                 <script>
                    $(document).ready(function(){
                    $("#browser").treeview();
                    });
                 </script>
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
@endsection
