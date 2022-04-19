@extends('backend.layouts.master')

@section('title')
SalesTransaction - {{$title}}
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
                <h1 class="m-0"> Sales Transaction</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    @if(helper::roleAccess('salesTransaction.sales.pendingCheque.index'))
                    <li class="breadcrumb-item"><a href="{{ route('salesTransaction.sales.pendingCheque.index') }}">Supplier Payment  List</a>  </li>
                    @endif
                    <li class="breadcrumb-item active"><span>Add New Supplier Payment</span></li>
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
                    @if(helper::roleAccess('salesTransaction.sales.pendingChequePayment.index'))
                    <a class="btn btn-default" href="{{ route('salesTransaction.sales.pendingChequePayment.index') }}"><i
                            class="fa fa-list"></i>
                        Supplier Payment List</a>
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
            <form class="needs-validation" method="POST"  action="{{ route('salesTransaction.sales.pendingChequePayment.store') }}" novalidate>
            <!-- /.card-header -->
            <div class="card-body">
                    @if(!empty($formInput) && is_array($formInput))
                    <div class="form-row">
                        @foreach ($formInput as $key => $eachInput)
                            @if($eachInput->name !="credit")
                               @php htmlform::formfiled($eachInput, $errors, old()) @endphp
                            @endif
                        @endforeach
                        {{-- <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group"><br>
                                <button class="btn btn-info btn-block" type="submit"><i class="fa fa-search"></i> &nbsp;Search</button>
                            </div>
                        </div> --}}
                    </div>
                    @else
                    <div class="alert alert-default">
                        <strong>Warning!</strong> Sorry you have no form access !!.
                    </div>
                    @endif
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
               
                    @csrf
                    <div id="loadDueVoucher"></div>
              
             </div>
            </form>    
        </div>
    </div>
    <!-- /.col-->
</div>

@endsection
@section("scripts")
<script>
    $(document).on('change', '.supplier_id', function() {
        let supplier_id = $(this).val();
        $.ajax({
                "url": '<?php echo route("salesTransaction.sales.pendingChequePayment.dueVoucherList"); ?>',
                "dataType": "json",
                "type": "GET",
                "data": {
                    "_token": "<?= csrf_token() ?>",
                    "supplier_id": supplier_id,//import save route
                }
                }).done(function(data) {
                    if(data.success == true){
                        $("#loadDueVoucher").empty();
                        $("#loadDueVoucher").html(data.html);
                    }
                    
        })

    });
</script>
@endsection

