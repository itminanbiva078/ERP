@extends('backend.layouts.master')

@section('title')
ProductSetup - {{$title}}
@endsection
@section('navbar-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> Product Manage</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    @if(helper::roleAccess('inventorySetup.product.index'))
                    <li class="breadcrumb-item"><a href="{{ route('inventorySetup.product.index') }}">Product  List</a></li>
                    @endif
                    <li class="breadcrumb-item active"><span>Add New Product </span></li>
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
                <h3 class="card-title">Add New Product </h3>
                <div class="card-tools">
                    <div class="btn btn-sm btn-success" onclick="loadModal('inventory-setup-load-import-form','inventorySetup.product.import','Import Product List','Import Product List','/backend/assets/excelFormat/inventorySetup/product/product.csv','2'" data-toggle="modal" data-target="#modal-default"><i class="fa fa-upload"></i> Import</div>
                    <div class="btn btn-sm btn-default" ><a href="{{route('inventorySetup.product.explode')}}"><i class="fa fa-download"></i> Expload</a></div>
                @if(helper::roleAccess('inventorySetup.product.index'))
                    <a class="btn btn-default" href="{{ route('inventorySetup.product.index') }}"><i class="fa fa-list"></i>
                    Product  List</a>
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
                <form class="needs-validation" method="POST" action="{{ route('inventorySetup.product.store') }}" novalidate>
                    @csrf
                    @if(!empty($formInput) && is_array($formInput))
                            <div class="form-row">
                                @foreach ($formInput as $key => $eachInput)
                                    @php 
                                        htmlform::formfiled($eachInput, $errors, old()) 
                                    @endphp
                                @endforeach



                                @foreach ($formInputDetails as $key => $eachInput)
                                    @php htmlform::formfiled($eachInput, $errors, old()) @endphp
                                @endforeach


                            
                            @include('backend.layouts.common.uploadFile')
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