@extends('backend.layouts.master')
@section('admin-content')

<section class="main-pos-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="pos-product-filter-section">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="pos-category-filter-btn">
                                <div class="btn-group-vertical group-button">
                                    <button type="button" class="btn"> 
                                        <form action="#">
                                            <input type="checkbox" id="All" name="All" value="All">
                                            <label for="All"> All </label>
                                        </form>
                                    </button>
                                    <button type="button" class="btn"> 
                                        <form action="#">
                                            <input type="checkbox" id="Electronics" name="Electronics" value="Electronics">
                                            <label for="Electronics"> Electronics </label>
                                        </form>
                                    </button>
                                    <button type="button" class="btn"> 
                                        <form action="#">
                                            <input type="checkbox" id="Crockeries" name="Crockeries" value="Crockeries">
                                            <label for="Crockeries"> Crockeries </label>
                                        </form>
                                    </button>
                                    <button type="button" class="btn"> 
                                        <form action="#">
                                            <input type="checkbox" id="Travel" name="Travel" value="Travel">
                                            <label for="Travel"> Travel </label>
                                        </form>
                                    </button>
                                    <button type="button" class="btn"> 
                                        <form action="#">
                                            <input type="checkbox" id="Chocolate" name="Chocolate" value="Chocolate">
                                            <label for="Chocolate"> Chocolate </label>
                                        </form>
                                    </button>
                                    <button type="button" class="btn"> 
                                        <form action="#">
                                            <input type="checkbox" id="Home-Decor" name="Home Decor" value="Home Decor">
                                            <label for="Home Decor"> Home Decor </label>
                                        </form>
                                    </button>
                                    <button type="button" class="btn"> 
                                        <form action="#">
                                            <input type="checkbox" id="Chocolate" name="Chocolate" value="Chocolate">
                                            <label for="Chocolate"> Chocolate </label>
                                        </form>
                                    </button>
                                    <button type="button" class="btn"> 
                                        <form action="#">
                                            <input type="checkbox" id="Chocolate" name="Chocolate" value="Chocolate">
                                            <label for="Chocolate"> Chocolate </label>
                                        </form>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="pos-filter-product">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="pos-search-bar">
                                            <form class="form-inline my-2 my-lg-0">
                                                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                                                <button class="btn my-2 my-sm-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="pos-select-filter">
                                            <select class="form-select" aria-label="pos select filter">
                                                <option selected> Select Your Product :)</option>
                                                <option value="1">Apple </option>
                                                <option value="2">Orange </option>
                                                <option value="3">Water</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="selespos-product-section">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="selespos-product">
                                                <a href="#">
                                                    <div class="card">
                                                        <img class="card-img-top" src="https://saleserpnew.bdtask.com/saleserp_v9.8_demo/my-assets/image/product/2020-10-24/2c8dbf383afb2c8178fc712cafd00a92.jpg" alt="Card image cap">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Backpack</h5>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="selespos-product">
                                                <a href="#">
                                                    <div class="card">
                                                        <img class="card-img-top" src="https://saleserpnew.bdtask.com/saleserp_v9.8_demo/my-assets/image/product/2020-10-24/2c8dbf383afb2c8178fc712cafd00a92.jpg" alt="Card image cap">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Backpack</h5>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="selespos-product">
                                                <a href="#">
                                                    <div class="card">
                                                        <img class="card-img-top" src="https://saleserpnew.bdtask.com/saleserp_v9.8_demo/my-assets/image/product/2020-10-24/2c8dbf383afb2c8178fc712cafd00a92.jpg" alt="Card image cap">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Backpack</h5>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="selespos-product">
                                                <a href="#">
                                                    <div class="card">
                                                        <img class="card-img-top" src="https://saleserpnew.bdtask.com/saleserp_v9.8_demo/my-assets/image/product/2020-10-24/2c8dbf383afb2c8178fc712cafd00a92.jpg" alt="Card image cap">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Backpack</h5>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="selespos-product">
                                                <a href="#">
                                                    <div class="card">
                                                        <img class="card-img-top" src="https://saleserpnew.bdtask.com/saleserp_v9.8_demo/my-assets/image/product/2020-10-24/2c8dbf383afb2c8178fc712cafd00a92.jpg" alt="Card image cap">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Backpack</h5>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="selespos-product">
                                                <a href="#">
                                                    <div class="card">
                                                        <img class="card-img-top" src="https://saleserpnew.bdtask.com/saleserp_v9.8_demo/my-assets/image/product/2020-10-24/2c8dbf383afb2c8178fc712cafd00a92.jpg" alt="Card image cap">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Backpack</h5>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="selespos-product">
                                                <a href="#">
                                                    <div class="card">
                                                        <img class="card-img-top" src="https://saleserpnew.bdtask.com/saleserp_v9.8_demo/my-assets/image/product/2020-10-24/2c8dbf383afb2c8178fc712cafd00a92.jpg" alt="Card image cap">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Backpack</h5>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="selespos-product">
                                                <a href="#">
                                                    <div class="card">
                                                        <img class="card-img-top" src="https://saleserpnew.bdtask.com/saleserp_v9.8_demo/my-assets/image/product/2020-10-24/2c8dbf383afb2c8178fc712cafd00a92.jpg" alt="Card image cap">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Backpack</h5>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="selespos-product">
                                                <a href="#">
                                                    <div class="card">
                                                        <img class="card-img-top" src="https://saleserpnew.bdtask.com/saleserp_v9.8_demo/my-assets/image/product/2020-10-24/2c8dbf383afb2c8178fc712cafd00a92.jpg" alt="Card image cap">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Backpack</h5>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="selespos-product">
                                                <a href="#">
                                                    <div class="card">
                                                        <img class="card-img-top" src="https://saleserpnew.bdtask.com/saleserp_v9.8_demo/my-assets/image/product/2020-10-24/2c8dbf383afb2c8178fc712cafd00a92.jpg" alt="Card image cap">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Backpack</h5>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="selespos-product">
                                                <a href="#">
                                                    <div class="card">
                                                        <img class="card-img-top" src="https://saleserpnew.bdtask.com/saleserp_v9.8_demo/my-assets/image/product/2020-10-24/2c8dbf383afb2c8178fc712cafd00a92.jpg" alt="Card image cap">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Backpack</h5>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="selespos-product">
                                                <a href="#">
                                                    <div class="card">
                                                        <img class="card-img-top" src="https://saleserpnew.bdtask.com/saleserp_v9.8_demo/my-assets/image/product/2020-10-24/2c8dbf383afb2c8178fc712cafd00a92.jpg" alt="Card image cap">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Backpack</h5>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="pos-product-add-datatable">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="pos-datatable-product-filter">
                                <form>
                                    <div class="form-row">
                                        <div class="col">
                                            <input type="search" class="form-control" placeholder="Barcode or QR-code scan here">
                                        </div>
                                            <label for="or">Or</label>
                                        <div class="col">
                                            <input type="search" class="form-control" placeholder="Manual Input barcode">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="pos-datatable-customar-add">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <form>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Walking Customer">
                                        <div class="input-group-prepend">
                                            <a href="#" class="btn btn-sm"> + </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="pos-invoice-id">
                                    <label for="#"> invoice id - <span> 0001 </span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="product-add-datatable">
                                <div class="table-responsive">          
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width:20%;">Item Information *</th>
                                                <th>Serial</th>
                                                <th>Av. Qnty.</th>
                                                <th>Qnty *</th>
                                                <th>Rate *</th>
                                                <th>Dis %</th>
                                                <th>Total</th>
                                                <th style="width:10%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input class="form-control product-name" type="text"  value="Sweet Chocolate- (100)" >
                                                </td>
                                                <td>
                                                    <form action="#">
                                                        <select name="serial" id="serial">
                                                            <option value="1">Volvo</option>
                                                            <option value="2">Saab</option>
                                                            <option value="3">Opel</option>
                                                            <option value="4">Audi</option>
                                                        </select>
                                                    </form>
                                                </td>
                                                <td>
                                                    <input class="form-control" type="number"  value="100" >
                                                </td>
                                                <td>
                                                    <input class="form-control" type="number"  value="100" >
                                                </td>
                                                <td>
                                                    <input class="form-control" type="number"  value="100" >
                                                </td>
                                                <td>
                                                    <input class="form-control" type="number"  value="100" >
                                                </td>
                                                <td>
                                                    <input class="form-control" type="number"  value="100" >
                                                </td>
                                                <td>
                                                    <div class="action">
                                                        <a href="#" class="btn btn-sm "> <i class="fa fa-eye" aria-hidden="true"></i> </a>
                                                        <a href="#" class="btn btn-sm "> <i class="fa fa-times" aria-hidden="true"></i> </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pos-amount-calculation">
                                <form class="form-horizontal" action="#">
                                    <div class="form-group row">
                                        <label class="control-label col-sm-8" for="number">Sale Discount:</label>
                                        <div class="col-sm-4">
                                            <input type="number" class="form-control" id="number" placeholder=".000">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-8" for="number">Total Discount:</label>
                                        <div class="col-sm-4">
                                            <input type="number" class="form-control" id="number" placeholder=".000">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-8" for="number">Total Tax:</label>
                                        <div class="col-sm-4">
                                            <input type="number" class="form-control" id="number" placeholder=".000">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-8" for="number">Shipping Cost:</label>
                                        <div class="col-sm-4">
                                            <input type="number" class="form-control" id="number" placeholder=".000">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-8" for="number">Grand Total:</label>
                                        <div class="col-sm-4">
                                            <input type="number" class="form-control" id="number" placeholder=".000">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-8" for="number">Previous:</label>
                                        <div class="col-sm-4">
                                            <input type="number" class="form-control" id="number" placeholder=".000">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-8" for="number">Change:</label>
                                        <div class="col-sm-4">
                                            <input type="number" class="form-control" id="number" placeholder=".000">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pos-footer-seciton">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="total-price">
                                <label for="#"> Net Total: <span> 125485 </span></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="control-label col-sm-4" for="number">Paid Amount:</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="number" placeholder=".000">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="due-amount">
                                <label for="#"> Due: <span> 125485 </span></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="footer-sumbit-btn">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn"> Full Paid </button>
                            <button type="button" class="btn"> Save Sale </button>
                            <button type="button" class="btn"> <i class="fa fa-calculator" aria-hidden="true"></i> </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection