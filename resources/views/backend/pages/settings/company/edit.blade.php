@extends('backend.layouts.master')

@section('title')
Settings - {{$title}}
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
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    @if(helper::roleAccess('settings.company.index'))
                    <li class="breadcrumb-item"><a href="{{route('settings.company.index')}}">Company List</a></li>
                    @endif
                    <li class="breadcrumb-item active"><span>Update Company</span></li>
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
                <h3 class="card-title">Update Company</h3>
                <div class="card-tools">

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

                <form class="needs-validation" method="POST"  action="{{ route('settings.company.update',$editInfo->id) }}" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3"> Company Name * :</label>
                        <div class="col-sm-7">
                            <input type="text" name="company_name" class="form-control" id="validationCustom01"
                                placeholder="Name" value="{{ $editInfo->name }}">
                            @error('company_name')
                            <span class=" error text-red text-bold">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3">Email * :</label>
                        <div class="col-sm-7">
                            <input type="text" name="email" class="form-control" id="validationCustom01"
                                placeholder="Email" value="{{ $editInfo->email  }}" required>
                            @error('email')
                            <span class=" error text-red text-bold">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3">Phone * :</label>
                        <div class="col-sm-7">
                            <input type="text" name="phone" class="form-control" id="validationCustom01"
                                placeholder="phone" value="{{ $editInfo->phone  }}" required>
                            @error('phone')
                            <span class=" error text-red text-bold">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3">Address * :</label>
                        <div class="col-sm-7">
                            <textarea name="address" class="form-control" id="validationCustom01"
                                placeholder="Address">{{$editInfo->address}}</textarea>
                            @error('address')
                            <span class=" error text-red text-bold">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3">Website * :</label>
                        <div class="col-sm-7">
                            <input type="text" name="website" class="form-control" id="validationCustom01"
                                placeholder="website" value="{{ $editInfo->website  }}" required>
                            @error('website')
                            <span class=" error text-red text-bold">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3"> Logo * :</label>
                        <div class="col-sm-7">
                            <input type="file" name="logo" class="form-control" id="validationCustom02"  placeholder="Logo"  required>
                            @error('logo')
                            <span class=" error text-red text-bold">{{ $message }}</span>
                            @enderror
                            <br>
                            <img src="<?php echo helper::imageUrl($editInfo->logo)?>" class="img img-thumbnail"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3">Invoice Logo * :</label>
                        <div class="col-sm-7">
                            <input type="file" name="invoice_logo" class="form-control" id="validationCustom01"  placeholder="Logo"  required>
                            @error('invoice_logo')
                            <span class=" error text-red text-bold">{{ $message }}</span>
                            @enderror
                            <br>
                            <img src="<?php echo helper::imageUrl($editInfo->invoice_logo)?>" class="img img-thumbnail"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3">Favicon * :</label>
                        <div class="col-sm-7">
                            <input type="file" name="favicon" class="form-control" id="validationCustom01"  placeholder="Favicon"  required>
                            @error('favicon')
                            <span class=" error text-red text-bold">{{ $message }}</span>
                            @enderror
                            <br>
                            <img src="<?php echo helper::imageUrl($editInfo->favicon)?>" class="img img-thumbnail"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3">Identification Number * :</label>
                        <div class="col-sm-7">
                            <input type="text" name="task_identification_number" class="form-control"
                                id="validationCustom01" placeholder="Identification Number"
                                value="{{ $editInfo->task_identification_number  }}" required>
                            @error('task_identification_number')
                            <span class=" error text-red text-bold">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <button class="btn btn-info" type="submit"><i class="fa fa-save"></i>&nbsp;Update</button>
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