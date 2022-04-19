@extends('backend.layouts.master')

@section('title')
DeliveryChallan - {{$title}}
@endsection

@section('styles')
<style>
table#show_item tr td {
    padding: 2px !important;
}
</style>
@endsection

@section('navbar-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> Delivery Challan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    @if(helper::roleAccess('salesTransaction.deliveryChallan.index'))
                    <li class="breadcrumb-item"><a
                            href="{{ route('salesTransaction.deliveryChallan.index') }}">Delivery Challan List</a>
                    </li>
                    @endif
                    <li class="breadcrumb-item active"><span>Add New Delivery Challan</span></li>
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
                    @if(helper::roleAccess('salesTransaction.deliveryChallan.index'))
                    <a class="btn btn-default" href="{{ route('salesTransaction.deliveryChallan.index') }}"><i
                            class="fa fa-list"></i>
                            Delivery Challan List</a>
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
                <form   onsubmit="return ValidationEvent()" class="needs-validation" method="POST"  action="{{ route('salesTransaction.deliveryChallan.update',$editInfo->id) }}" novalidate>
                    @csrf
                    @if(!empty($formInput) && is_array($formInput))
                    <div class="form-row">
                        @foreach ($formInput as $key => $eachInput)
                        @if($eachInput->inputShow == true)
                        
                        @if($eachInput->name == 'branch_id')
                       {{-- branch form --}}
                               @if(helper::isBranchEnable() && helper::branchIsActive())
                                  @php htmlform::formfiled($eachInput, $errors, old()) @endphp
                               @endif
                       @elseif( $eachInput->name == 'store_id')
                       {{-- store form --}}
                           @if(helper::isStoreEnable() && helper::storeIsActive())
                              @php htmlform::formfiled($eachInput, $errors, old()) @endphp
                           @endif
                       @else
                       {{-- normal form --}}
                           @php htmlform::formfiled($eachInput, $errors, old()) @endphp
                       @endif

                       @endif
                        @endforeach
                    </div>

                    @include('backend.layouts.common.tableAppend')

                    <button class="btn btn-info" type="submit"><i class="fa fa-save"></i> &nbsp;Update</button>
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

