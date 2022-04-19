@extends('backend.layouts.master')

@section('title')
InventorySetup - {{$title}}
@endsection
@section('navbar-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> Inventory Setup </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    @if(helper::roleAccess('inventorySetup.warranty.index'))
                    <li class="breadcrumb-item"><a href="{{ route('inventorySetup.warranty.index') }}"> <i class="fa fa-list"></i> Warranty List</a></li>
                    @endif
                    <li class="breadcrumb-item active"><span>Add New Warranty</span></li>
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
                <h3 class="card-title">Add New Warranty</h3>
                <div class="card-tools">
                @if(helper::roleAccess('inventorySetup.warranty.index'))
                    <a class="btn btn-default" href="{{ route('inventorySetup.warranty.index') }}"><i class="fa fa-list"></i>
                     Warranty List</a>
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
                <form class="needs-validation" method="POST" action="{{ route('inventorySetup.warranty.store') }}" novalidate>
                    @csrf
                    @if(!empty($formInput) && is_array($formInput))
                    <div class="form-row">
                             @foreach ($formInput as $key => $eachInput)
                            @php htmlform::formfiled($eachInput, $errors, old()) @endphp
                            @endforeach
                    </div>
                    <button class="btn btn-info" type="submit"><i class="fa fa-save"></i> &nbsp;Save</button>
                    @else
                    <div class="alert alert-default">
                        <strong>Warning!</strong> Sorry you have no form access !!.
                      </div>
                    @endif
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