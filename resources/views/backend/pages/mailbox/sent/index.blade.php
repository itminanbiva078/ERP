@extends('backend.layouts.master')

@section('title')
Mailbox - {{$title}}
@endsection
@section('navbar-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> Mailbox </h1>
            </div><!-- /.col -->
            <!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('admin-content')

<section class="content">
  <div class="row">
    <div class="col-md-3">
      <a href="{{ route('mailbox.sent.create') }}" class="btn btn-primary btn-block mb-3">Compose</a>

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
              <a href="{{ route('mailbox.sent.index') }}" class="nav-link">
                <i class="fas fa-inbox"></i> Sent Mail
                <span class="badge bg-primary float-right"></span>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('mailbox.sent.create') }}" class="nav-link">
                <i class="far fa-envelope"></i> Compose Mail
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
          <h3 class="card-title">Inbox</h3>

          <div class="card-tools">
           
          </div>
          <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
          
          <div class="table-responsive mailbox-messages">
            <table class="table table-hover table-striped">
              <tbody>
             @foreach ($result as $value)
                <tr>
                <td> {{ $value->date}} </td>
                <td>  <span class="badge bg-warning float-right">{{ $value->total_mail }}</span> </td>
                <td class="mailbox-name"><a href="{{ route('mailbox.sent.show',$value->id) }}">{{ $value->email_title}}</a></td>
                <td class="mailbox-subject">{!!stripslashes(substr($value->email_body, 0 , 150)) !!} </td>
                <td class="mailbox-attachment"><i @if($value->attachment)  class="fas fa-paperclip" @else   @endif ></i></td>
                <td class="mailbox-date">{{ $value->created_at->diffForHumans()}}</td>
              </tr>
              @endforeach
             
              </tbody>
            </table>
            <!-- /.table -->
          </div>
          <!-- /.mail-box-messages -->
        </div>
        
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
@endsection
