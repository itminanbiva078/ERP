@extends('backend.layouts.master')

@section('title')
PurchasesTransaction - {{$title}}
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
                <h1 class="m-0"> Purchases Transaction</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    @if(helper::roleAccess('inventoryTransaction.purchasesReturn.index'))
                    <li class="breadcrumb-item"><a
                            href="{{ route('inventoryTransaction.purchasesReturn.index') }}"><i class="fas fa-list"> List</i></a>
                    </li>
                    @endif
                    <li class="breadcrumb-item active"><span>Add New Purchases Return</span></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
@section('admin-content')
<div class="row">
    <div class="col-md-12">
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
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3>
                <div class="card-tools">
                    @if(helper::roleAccess('inventoryTransaction.purchasesReturn.index'))
                    <a class="btn btn-default" href="{{ route('inventoryTransaction.purchasesReturn.index') }}"><i
                            class="fa fa-list"></i>
                        Purchases Return List</a>
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

                <form class="needs-validation" method="POST"  action="" novalidate>



                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form action="simple-results.html">
                                <div class="input-group">
                                    <input type="search" id="search" class="form-control form-control-lg" placeholder="Type Invoice ID">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-lg btn-default">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <br>
                        <hr>
                    </div>
                </form>
               
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <form enctype="multipart/form-data" class="needs-validation"  onsubmit="return ValidationEvent()"  method="POST"  action="{{ route('inventoryTransaction.purchasesReturn.store') }}" novalidate>
                    @csrf
                <div class="row">
                    <br>
                    <div class="loadPurchasesInvoice"></div>
                    <button class="btn btn-info sbtn" style="display: none!important" disabled type="submit"><i class="fa fa-save"></i> &nbsp;Save</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <!-- /.col-->
</div>

@endsection

@section('scripts')

<script type="text/javascript">

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

      $( "#search" ).autocomplete({
        source: function( request, response ) {
          // Fetch data
          $.ajax({
            url:"{{route('inventoryTransaction.purchasesReturn.autocomplete')}}",
            type: 'get',
            dataType: "json",
            data: {
               _token: CSRF_TOKEN,
               search: request.term
            },
            success: function( data ) {
               response(data.data);
            }
          });
        },
        select: function (event, ui) {
         
           $('#search').val(ui.item.label); // display the selected text
           $('#employeeid').val(ui.item.value); // save selected id to input

           $.ajax({
            url:"{{route('inventoryTransaction.purchases.details')}}",
            type: 'get',
            dataType: "json",
            data: {
               _token: CSRF_TOKEN,
               purchases_id: ui.item.value
            },
            success: function(data) {
              $('.loadPurchasesInvoice').html(data.html);
            }
          });
           return false;
        }
      });

    });
    </script>


@endsection



