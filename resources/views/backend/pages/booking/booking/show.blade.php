@extends('backend.layouts.master')
@section('title')
Booking - {{$title}}
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
                Booking </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home') }}">Dashboard</a></li>
                    @if(helper::roleAccess('booking.booking.create'))
                    <li class="breadcrumb-item"><a href="{{route('booking.booking.create') }}">Add Booking </a></li>
                    @endif
                    @if(helper::roleAccess('booking.booking.index'))
                    <li class="breadcrumb-item"><a href="{{route('booking.booking.index') }}">Booking</a></li>
                    @endif
                    <li class="breadcrumb-item active"><span>Booking</span></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('admin-content')

@php 

//dd($details);

@endphp

  <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="https://picsum.photos/seed/picsum/200/300"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{$details->customer->name ?? ''}}</h3>


                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Email : </b> <span> {{$details->customer->email ?? ''}}</span>
                  </li>
                  <li class="list-group-item">
                    <b>Phone : </b> <span> {{$details->customer->phone ?? ''}}</span>
                  </li>
                  <li class="list-group-item">
                    <b>Address : </b> <span> {{$details->customer->address ?? ''}}</span>
                  </li>

                  @if($details->booking_status == "Pending")
                    <button type="button" approved_url="{{route("booking.booking.approved",['booking_status_id' => $details->id,'status' =>"Approved"])}}"  class="btn btn-info float-right journal transaction_approved" style="margin-right: 5px;">
                    <i class="fas fa-check"></i> &nbsp;Approved ?
                  </button>
                 @else 
                 <button type="button"   class="btn btn-success float-right" style="margin-right: 5px;">
                  <i class="fas fa-check"></i> &nbsp;Approved
                </button>

                 @endif
                </ul>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Room Feature</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong> Booking Price : </strong>
                  {{ $details->grand_total ?? ''}}
                <hr>
              
                <strong> Total Paid: </strong>
                {{ $details->paid_amount ?? ''}}
                <hr>

                <strong> Due Amount : </strong>
                {{ $details->due_amount ?? ''}}
                <hr>
                <strong> Adult : </strong>
                {{ $details->bookingDetails->adult ?? ''}}
                <hr>
                <strong> Child : </strong>
                {{ $details->bookingDetails->child ?? ''}}
                <hr>
                <strong> Number of Bed : </strong>
                {{ $details->bookingDetails->product->productDetails->number_of_bed  ?? ''}}
                <hr>
                <strong> Room No : </strong>
                {{ $details->bookingDetails->product->productDetails->room_no  ?? ''}}
                <hr>
                <strong> Features : </strong>
                {{ $details->bookingDetails->product->productDetails->product_attributes  ?? ''}}
                <hr>
                



              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#timeline" data-toggle="tab">Timeline</a></li>
                  {{-- <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li> --}}
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Payment Ledger</a></li>
                </ul>
              </div>
            <!-- /.card-header -->
              

            <div class="card-body">
              <div class="tab-content">
                 
                 <div class="tab-pane active" id="timeline">
                    <div class="timeline timeline-inverse">
                      
                       
                       <div class="time-label">
                          <span class="bg-success">
                          {{$details->bookingDetails->entry_date}}
                          </span>
                       </div>
                       <div>
                          <i class="fas fa-camera bg-purple"></i>
                          <div class="timeline-item">
                             <span class="time"><i class="far fa-clock"></i> 2 days ago</span>
                             <h3 class="timeline-header"><a href="#">Entry Date</a> </h3>
                             <div class="timeline-body">
                              
                             </div>
                          </div>
                       </div>
                       <div class="time-label">
                          <span class="bg-success">
                            {{$details->bookingDetails->exit_date}}
                          </span>
                       </div>
                       <div>
                          <i class="fas fa-camera bg-purple"></i>
                          <div class="timeline-item">
                             <span class="time"><i class="far fa-clock"></i> 2 days ago</span>
                             <h3 class="timeline-header"><a href="#">Exit Date</a></h3>
                             <div class="timeline-body">
                               
                             </div>
                          </div>
                       </div>
                       <div>
                          <i class="far fa-clock bg-gray"></i>
                       </div>
                    </div>
                 </div>
                 <div class="tab-pane" id="settings">
                    
                    <table id="example" class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Voucher No</th>
                          <th>Payment Type</th>
                          <th>Payable</th>
                          <th>Paid</th>
                          <th>Balance</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php 
                          $payable=0;
                          $paid=0;
                        @endphp
                        @foreach($details->payments as $key => $eachPayment)
                        @php 
                          $payable+=$eachPayment->debit;
                          $paid+=$eachPayment->credit;
                        @endphp
                        <tr>
                          <td>{{$eachPayment->date}}</td>
                          <td>{{$eachPayment->voucher_no}}</td>
                          <td>{{$eachPayment->payment_type ?? 'Booking Amount'}}</td>
                          <td>{{$eachPayment->debit}}</td>
                          <td>{{$eachPayment->credit}}</td>
                          <td>{{$payable -$paid }}</td>
                        
                         
                        </tr>
                        @endforeach
                      </tbody>

                    </table>

                 </div>
              </div>
           </div>





              
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  

@endsection

