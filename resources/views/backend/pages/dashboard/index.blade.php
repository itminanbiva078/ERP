@extends('backend.layouts.master')
@section('title')
Dashboard Page - Admin Panel
@endsection
@section('navbar-content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active"><a href="#">Dashboard</a></li>
          </ol>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('admin-content')
  <div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{$result->totalSale ?? 0.00}} Tk</h3>
          <p> Today Sale  </p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3> {{$result->totalSaleDue ?? 0.00}} Tk </h3>
          <p> Today Sale Due </p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3> {{$result->totalPurchases ?? 0.00}} Tk </h3>
          <p> Today Purchases </p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3> {{$result->totalPurchasesDue ?? 0.00}} </h3>
          <p> Today Purchases Due </p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{$result->totalBooking ?? 0.00}}</h3>
          <p>Today Booking </p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{$result->totalBookingDue ?? 0.00}}</h3>
          <p>Today Booking Due</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{$totalBookRoom ?? 0}}</h3>
          <p>Today Booked Room </p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>{{$freeRoom ?? 0}}</h3>
          <p>Available Room</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-6">
      <div class="cash-flow-chart">
        <div class="card">
          <div class="section-title">
            <h4> Cashflow </h4>
          </div>
          <div id="userChart">
          </div>
        </div>
      </div>

      @if(!empty($floors))
      <!-- /.card -->
      <div class="card">
        <div class="card-header border-0">
          <h4> Hotel Room Booking Chart</h4>
          <div class="card-tools">
            <a href="#" class="btn btn-tool btn-sm">
              <i class="fas fa-download"></i>
            </a>
            <a href="#" class="btn btn-tool btn-sm">
              <i class="fas fa-bars"></i>
            </a>
          </div>
        </div>
        <div class="card-body table-responsive p-0">

          @foreach($floors as $key => $eachFloor)
            @if(!empty($eachFloor->products) && count($eachFloor->products) > 0)

            <div class="floor-wise-room">

              <div class="section-title">
                <p> {{$eachFloor->name}} </p>
              </div>
              <div class="room-section">
                <ul class="seats">
                  @foreach($eachFloor->products as $key => $eachRoom)

                    @if(in_array($eachRoom->id,$allBookedRoom))

                      <li class="seat ">
                        <input type="checkbox" name="" id="101">
                        <label for="101"> {{$eachRoom->productDetails->room_no}} </label>
                      </li>

                    @else

                    <li class="seat active">
                      <input type="checkbox" name="" id="101">
                      <label for="101"> {{$eachRoom->productDetails->room_no}}</label>
                    </li>

                    @endif

                  @endforeach
                </ul>
              </div>
            </div>
           @endif

       @endforeach

        </div>
      </div>

      @endif
      <!-- /.card -->
    </div>
    <!-- /.col-md-6 -->
    <div class="col-lg-6">
      <div class="income-expance">
        <div class="card">
          <div class="section-title">
            <h4> Income Vs Expense </h4>
          </div>
          <div id="priceChart">
          </div>
        </div>
      </div>
      <!-- /.card -->
      @if(!empty($floors))
      <div class="card">
        <div class="card-header border-0">
          <h4 >Online Store Overview</h4>
          <div class="card-tools">
            <a href="#" class="btn btn-sm btn-tool">
              <i class="fas fa-download"></i>
            </a>
            <a href="#" class="btn btn-sm btn-tool">
              <i class="fas fa-bars"></i>
            </a>
          </div>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
            <p class="text-success text-xl">
              <i class="ion ion-ios-refresh-empty"></i>
            </p>
            <p class="d-flex flex-column text-right">
              <span class="font-weight-bold">
                <i class="ion ion-android-arrow-up text-success"></i> 12%
              </span>
              <span class="text-muted">CONVERSION RATE</span>
            </p>
          </div>
          <!-- /.d-flex -->
          <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
            <p class="text-warning text-xl">
              <i class="ion ion-ios-cart-outline"></i>
            </p>
            <p class="d-flex flex-column text-right">
              <span class="font-weight-bold">
                <i class="ion ion-android-arrow-up text-warning"></i> 0.8%
              </span>
              <span class="text-muted">SALES RATE</span>
            </p>
          </div>
          <!-- /.d-flex -->
          <div class="d-flex justify-content-between align-items-center mb-0">
            <p class="text-danger text-xl">
              <i class="ion ion-ios-people-outline"></i>
            </p>
            <p class="d-flex flex-column text-right">
              <span class="font-weight-bold">
                <i class="ion ion-android-arrow-down text-danger"></i> 1%
              </span>
              <span class="text-muted">REGISTRATION RATE</span>
            </p>
          </div>
          <!-- /.d-flex -->
        </div>
      </div>
      @endif
    </div>
    <!-- /.col-md-6 -->
  </div>
  <!-- /.row -->
@endsection
