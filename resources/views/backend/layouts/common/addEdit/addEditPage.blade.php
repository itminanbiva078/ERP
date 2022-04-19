@extends('backend.layouts.master')
@section('title')
 {{$title}}
@endsection
@section('navbar-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> @php $headingInfo =  explode("|",$title);echo $headingInfo[0];   @endphp</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    @if(helper::roleAccess($listRoute))
                    <li class="breadcrumb-item"><i class="fa fa-list"></i><a href="{{ route($listRoute) }}">@php $headingInfo =  explode("-",$title); echo $headingInfo[1];  @endphp List</a></li>
                    @endif
                    <li class="breadcrumb-item active"><span>@php $headingInfo =  explode("|",$title); echo $headingInfo[1];   @endphp</span></li>
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
                <h3 class="card-title">@php $headingInfo =  explode("|",$title); echo $headingInfo[1];  @endphp</h3>
                <div class="card-tools">
                    @if(!empty($implodeModal))
                    <div class="btn btn-sm btn-success" onclick="loadModal(@php echo $implodeModal @endphp)" data-toggle="modal" data-target="#modal-default"><i class="fa fa-upload"></i> Import</div>
                    @endif
                    @if(!empty($explodeRoute))
                    <div class="btn btn-sm btn-default" ><a href="{{route($explodeRoute)}}"><i class="fa fa-download"></i> Expload</a></div>
                    @endif
                    @if(helper::roleAccess($listRoute))
                        <a class="btn btn-default" href="{{ route($listRoute) }}"><i class="fa fa-list"></i>
                            @php $headingInfo =  explode("-",$title); echo $headingInfo[1];  @endphp List
                        </a>
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
                @if(empty($editInfo->id))
                  <form class="needs-validation" method="POST" action="{{ route($storeRoute) }}" novalidate enctype="multipart/form-data">
                @else 
                  <form class="needs-validation" method="POST" action="{{ route($storeRoute,$editInfo->id) }}" novalidate enctype="multipart/form-data">
                @endif
                    @csrf
                    @if(!empty($formInput) && is_array($formInput))
                    <div class="form-row">
                        @foreach ($formInput as $key => $eachInput)
                        @if(empty($editInfo->id))
                         @php htmlform::formfiled($eachInput, $errors, old()) @endphp
                        @else 
                         @php htmlform::formfiled($eachInput, $errors,$editInfo) @endphp
                        @endif
                        @endforeach
                    </div>
                    @if(!empty($formInputDetails))
                    <div class="form-row">
                        @foreach ($formInputDetails as $key => $eachInput)
                        @if(empty($editInfo->id))
                         @php htmlform::formfiled($eachInput, $errors, old()) @endphp
                        @else 
                         @php htmlform::formfiled($eachInput, $errors,$detailsEditInfo) @endphp
                        @endif
                        @endforeach

                    </div>
                    @endif
                    {{-- <img src="{{ asset('storage/uploads/284/1638307876.jpeg') }}" alt="test" title="" /> --}}

                    @if(empty($editInfo->id))
                    <button class="btn btn-info" type="submit"><i class="fa fa-save"></i> &nbsp;Save</button>
                    @else 
                    <button class="btn btn-info" type="submit"><i class="fa fa-save"></i> &nbsp;Update</button>
                    @endif
                    @else
                    <div class="alert alert-default">
                        <strong>Warning!</strong> Sorry you have no form access !!.
                      </div>
                    @endif
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                @if(!empty($categories))
                <div class="col-md-12">
                    <ul id="tree1">
                        @foreach($categories as $category)
                            <li>
                                {{ $category->name }}
                                @if(count($category->childs))
                                    @include('backend.pages.accountsSetup.chartOfAccount.manageChild',['childs' => $category->childs])
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- /.col-->
</div>
@endsection