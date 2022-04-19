@extends('backend.layouts.master')
@section('title')
SalesTransaction - {{$title}}
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
                Sales Transaction </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home') }}">Dashboard</a></li>
                    @if(helper::roleAccess('salesTransaction.salePayment.index'))
                    <li class="breadcrumb-item"><a href="{{route('salesTransaction.salePayment.create') }}"><i class="fas fa-plus">  Add New</i> </a></li>
                    @endif
                    <li class="breadcrumb-item active"><span> List</span></li>
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
                <h3 class="card-title">Sales Payment List</h3>
                <div class="card-tools">
                @if(helper::roleAccess('salesTransaction.salePayment.create'))
                    <a class="btn btn-default" href="{{ route('salesTransaction.salePayment.create') }}"><i class="fas fa-plus"></i>Add New</a>
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
                                @if($value =='credit')
                                  <th>Payment</th>
                                @else 
                                  <th>{{ucfirst($value)}}</th>
                                @endif
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
                                @if($value =='credit')
                                   <th>Payment</th>
                                @else 
                                    <th>{{ucfirst($value)}}</th>
                                @endif
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
<script>


$(document).on('click', '.transaction_approved2', function(e) {
        e.preventDefault();
       

        Swal.fire({
  title: 'Login Form',
  html: `<input type="text" id="login" class="swal2-input" placeholder="Username">
  <input type="password" id="password" class="swal2-input" placeholder="Password">`,
  confirmButtonText: 'Sign in',
  focusConfirm: false,
  preConfirm: () => {
    const login = Swal.getPopup().querySelector('#login').value
    const password = Swal.getPopup().querySelector('#password').value
    if (!login || !password) {
      Swal.showValidationMessage(`Please enter login and password`)
    }
    return { login: login, password: password }
  }
}).then((result) => {
  Swal.fire(`
    Login: ${result.value.login}
    Password: ${result.value.password}
  `.trim())
})

    
    });


</script>



@endsection

