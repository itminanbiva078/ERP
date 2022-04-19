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
<form class="needs-validation" method="POST" action="{{ route('mailbox.sent.store') }}"
    novalidate>
    @csrf
<div class="row">
    <div class="col-md-3">
      <a href="{{ route('mailbox.sent.index') }}" class="btn btn-primary btn-block mb-3">Back to Inbox</a>

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
      <!-- /.card -->
      
      <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title">Compose New Message</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

          <div class="form-group">
            <select class="form-control select2 mail_type" placeholder="Type" name="mail_type">
              <option value="" selected="" disabled="" >(:-Select Type-:)</option>
              <option value="1" >Customer</option>
              <option value="2" >Supplier</option>
              <option value="3">Employee</option>
            </select>
            @error('mail_type')
          <span class=" error text-red text-bold">{{ $message }}</span>
          @enderror
          </div>

         
          <div class="form-group">
          <select class="form-control select2 to_email" multiple name="to_email[]" placeholder="Type">
            <option value="" selected="" disabled="" >(:-Select E-mail-:)</option>
           
          </select>
          @error('to_email')
          <span class=" error text-red text-bold">{{ $message }}</span>
          @enderror
          </div>

          <div class="form-group">
            <input class="form-control" placeholder="Subject:" value="{{ old('email_title') }}" name="email_title" >
            @error('email_title')
            <span class=" error text-red text-bold">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
              <textarea id="compose-textarea" class="form-control" rows="22"value="{{ old('email_body') }}" name="email_body">
            
              </textarea>
              @error('email_body')
              <span class=" error text-red text-bold">{{ $message }}</span>
              @enderror
          </div>
          <div class="form-group">
            <div class="btn btn-default btn-file">
              <i class="fas fa-paperclip"></i> Attachment
              <input type="file" name="attachment" value="{{ old('attachment') }}">
              @error('attachment')
              <span class=" error text-red text-bold">{{ $message }}</span>
              @enderror
            </div>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <div class="float-right">
            <button class="btn btn-primary" type="submit"><i class="far fa-envelope"></i> Send</button>
          </div>
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
</form>


@endsection
