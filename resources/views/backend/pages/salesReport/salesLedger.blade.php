@extends('backend.layouts.master')
@section('title')
General Ledger Report
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
                <h1 class="m-0"> Sales Report</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><span>Sales Ledger</span></li>
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
                <form class="needs-validation" method="POST"  action="{{ route('salesReport.saleStockLedger') }}" novalidate>
                    @csrf
                    @if(!empty($formInput) && is_array($formInput))
                    <div class="form-row">
                        @foreach ($formInput as $key => $eachInput)
                          @php htmlform::formfiled($eachInput, $errors, $oldValue ?? '') @endphp
                        @endforeach
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group"><br>
                                <button class="btn btn-info btn-block" type="submit"><i class="fa fa-search"></i> &nbsp;Search</button>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-default">
                        <strong>Warning!</strong> Sorry you have no form access !!.
                    </div>
                    @endif
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        @if(!empty($opening) || !empty($reports))
        <div class="card card-default">
            <div class="card-header">
                <div class="card-tools">
                    <span id="buttons"></span>
                    <a class="btn btn-tool btn-default" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </a>
                    <a class="btn btn-tool btn-default" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
                @include('backend.layouts.common.reportHeader',['reportTitle' => $reportTitle,'from_date' =>$from_date,'to_date' => $to_date])
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-12 table-responsive">
                        @if($report_type == "Sales Ledger")
                            @include('backend.pages.salesReport.salesReportPartials.salesLedger',['opening' => $opening,'reports' =>$reports,'supplier_id' => $product_id])
                         @elseif($report_type == "Sales Return Ledger")
                            @include('backend.pages.salesReport.salesReportPartials.salesReturn',['opening' => $opening,'reports' =>$reports,'supplier_id' => $product_id])
                        @elseif($report_type == "Top Product Sales")
                           @include('backend.pages.salesReport.salesReportPartials.topProductSales',['opening' => $opening,'reports' =>$reports,'supplier_id' => $product_id])
                        @elseif($report_type == "Top Customer Sales")

                           @include('backend.pages.salesReport.salesReportPartials.topCustomerSales',['opening' => $opening,'reports' =>$reports,'supplier_id' => $product_id])
                        @else 
                        <div class="alert alert-default" role="alert">
                            Sorry Result not found!!
                          </div>
                        @endif
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <!-- /.col-->
</div>

@endsection

