@extends('backend.layouts.master')

@section('title')
{{-- Mailbox - {{$title}} --}}
@endsection
@section('navbar-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> mailbox </h1>
            </div><!-- /.col -->
            <!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('admin-content')

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <a href="{{ route('mailbox.inbox.index') }}" class="btn btn-primary btn-block mb-3">Back to Inbox</a>

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Folders</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item active">
                  <a href="{{ route('mailbox.inbox.index') }}" class="nav-link">
                    <i class="fas fa-inbox"></i> Sent Mail
                    <span class="badge bg-primary float-right"></span>
                  </a>
                </li>
               
               
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
         
        </div>
        <!-- /.col -->
      <div class="col-md-9">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Read Mail</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-read-info">
              <h2>{{$details->email_title ?? ''}}</h2>

                @foreach(explode(',', $details->to_email) as $info)
                    <h6 class="btn btn-secondary"> {{$info}}</h6>
                @endforeach

                <span class="mailbox-read-time float-right">{{$details->date ?? ''}}</span></h6>
              
            </div>
            
            <div class="mailbox-read-message">
                {!! stripslashes($details->email_body) !!}
            </div>
            <!-- /.mailbox-read-message -->
          </div>
         
          <div class="card-footer">
            <div class="float-right">
              <button type="button" class="btn btn-default"><i class="fas fa-reply"></i> Reply</button>
              <button type="button" class="btn btn-default"><i class="fas fa-share"></i> Forward</button>
            </div>
            <button type="button" class="btn btn-default"><i class="far fa-trash-alt"></i> Delete</button>
            <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  
  @endsection
