@extends('backend.layouts.master')

@section('title')
SMS - {{$title}}
@endsection
@section('navbar-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> SMS </h1>
            </div><!-- /.col -->
            <!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('admin-content')
<form class="needs-validation" method="POST" action="{{ route('sms.sms.store') }}"
    novalidate>
    @csrf
<div class="row">
    <div class="col-md-3">
      <a href="{{ route('sms.sms.index') }}" class="btn btn-primary btn-block mb-3">Back to Inbox</a>

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
              <a href="{{ route('sms.sms.index') }}" class="nav-link">
                <i class="fas fa-inbox"></i> Sent SMS
                <span class="badge bg-primary float-right"></span>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('sms.sms.create') }}" class="nav-link">
                <i class="far fa-envelope"></i> Compose SMS
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
            <select class="form-control select2 sms_type" placeholder="Type" name="sms_type">
              <option value="" selected="" disabled="" >(:-Select Type-:)</option>
              <option value="1" >Customer</option>
              <option value="2" >Supplier</option>
              <option value="3">Employee</option>
            </select>
            @error('sms_type')
          <span class=" error text-red text-bold">{{ $message }}</span>
          @enderror
          </div>

         
          <div class="form-group">
          <select class="form-control select2 user_phone" multiple name="user_phone[]" placeholder="Type">
            <option value="" selected="" disabled="" >(:-Select Phone-:)</option>
           
          </select>
          @error('user_phone')
          <span class=" error text-red text-bold">{{ $message }}</span>
          @enderror
          </div>

          <div class="form-group">
              <textarea id="compose-textarea" class="form-control" rows="22"value="{{ old('sms_body') }}" name="sms_body">
            
              </textarea>
              @error('sms_body')
              <span class=" error text-red text-bold">{{ $message }}</span>
              @enderror
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


<!-- profile design  -->
<div class="admin-profile-design">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="admin-profile-header">
          <div class="profile-background-images">

          </div>
          <div class="profile-info">
            <div class="profile-picture">
              <img src="https://www.postplanner.com/hs-fs/hub/513577/file-2886416984-png/blog-files/facebook-profile-pic-vs-cover-photo-sq.png?width=250&height=250&name=facebook-profile-pic-vs-cover-photo-sq.png" alt="">
            </div>
            <div class="profile-details">
              <div class="profile-name">
                <h4> Nahid Hassan  </h4>
                <p> Frontend Developer </p>
              </div>
              <div class="profile-email">
                <p><span> Email : </span> </p>
                <p>nahid@nextpagetl.com</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="admin-profile-info">
          <div class="row">
            <div class="col-3">
              <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="v-pills-Profile-Settings-tab" data-toggle="pill" href="#v-pills-Profile-Settings" role="tab" aria-controls="v-pills-Profile-Settings" aria-selected="true">Profile Settings</a>
                <a class="nav-link" id="v-pills-Education-tab" data-toggle="pill" href="#v-pills-Education" role="tab" aria-controls="v-pills-Education" aria-selected="false">Education</a>
                <a class="nav-link" id="v-pills-Location-tab" data-toggle="pill" href="#v-pills-Location" role="tab" aria-controls="v-pills-Location" aria-selected="false">Location</a>
                <a class="nav-link" id="v-pills-Description-tab" data-toggle="pill" href="#v-pills-Description" role="tab" aria-controls="v-pills-Description" aria-selected="false">Description</a>
              </div>
            </div>
            <div class="col-9">
              <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-Profile-Settings" role="tabpanel" aria-labelledby="v-pills-Profile-Settings-tab">
                  <div class="profile-setting-info">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="pills-profile-info-tab" data-toggle="pill" href="#pills-profile-info" role="tab" aria-controls="pills-profile-info" aria-selected="true">profile info </a>
                      </li>
                      <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-password-setting-tab" data-toggle="pill" href="#pills-password-setting" role="tab" aria-controls="pills-password-setting" aria-selected="false">password setting </a>
                      </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                      <div class="tab-pane fade show active" id="pills-profile-info" role="tabpanel" aria-labelledby="pills-profile-info-tab">
                        <div class="profile-edite-form">
                        <form>
                          <div class="form-row">
                            <div class="form-group row col-md-6">
                              <label for="fristName" class="col-sm-2 col-form-label">Frist Name : </label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="fristName" placeholder="Frist Name">
                              </div>
                            </div>
                            <div class="form-group row col-md-6">
                              <label for="lastName" class="col-sm-2 col-form-label">Last Name : </label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="lastName" placeholder="Last Name">
                              </div>
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group row col-md-6">
                              <label for="Designation" class="col-sm-2 col-form-label">Designation : </label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="Designation" placeholder="Designation">
                              </div>
                            </div>
                            <div class="form-group row col-md-6">
                              <label for="Gender" class="col-sm-2 col-form-label">Gender : </label>
                              <div class="col-sm-10">
                                <select id= "Gender">
                                  <option selected > (:-- Select Gender --:)</option>
                                  <option value="1"> Male </option>
                                  <option value="2"> Female </option>
                                  <option value="3"> Common </option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group row col-md-6">
                              <label for="nidCard" class="col-sm-2 col-form-label">NID Card : </label>
                              <div class="col-sm-10">
                                <input type="number" class="form-control" id="nidCard" placeholder="NID Card">
                              </div>
                            </div>
                            <div class="form-group row col-md-6">
                              <label for="Education" class="col-sm-2 col-form-label">Education : </label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="Education" placeholder="Education">
                              </div>
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group row col-md-6">
                              <label for="permanentAddress" class="col-sm-2 col-form-label">Permanent Address : </label>
                              <div class="col-sm-10">
                                <input type="number" class="form-control" id="permanentAddress" placeholder="Permanent Address">
                              </div>
                            </div>
                            <div class="form-group row col-md-6">
                              <label for="presentAddress" class="col-sm-2 col-form-label">Present Address : </label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="presentAddress" placeholder="Present Address">
                              </div>
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group row col-md-6">
                              <label for="Description" class="col-sm-2 col-form-label">Description : </label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="Description" placeholder="Description">
                              </div>
                            </div>
                            <div class="form-group row col-md-6">
                              <label for="profilePicture" class="col-sm-2 col-form-label">Profile Picture : </label>
                              <div class="col-sm-10">
                                <input type="file" class="form-control" id="profilePicture">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="sumbit-form">
                                <button type="submit"> save file </button>
                              </div>
                            </div>
                          </div>
                        </form>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="pills-password-setting" role="tabpanel" aria-labelledby="pills-password-setting-tab">
                        <div class="password-setting-info">
                          <form>
                            <div class="form-row">
                              <div class="form-group row col-md-6">
                                <label for="oldPassword" class="col-sm-2 col-form-label">Old Password : </label>
                                <div class="col-sm-10">
                                  <input type="password" class="form-control" id="oldPassword" placeholder="Old Password">
                                </div>
                              </div>
                              <div class="form-group row col-md-6">
                                <label for="newPassword" class="col-sm-2 col-form-label">New Password : </label>
                                <div class="col-sm-10">
                                  <input type="password" class="form-control" id="newPassword" placeholder="New Password">
                                </div>
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group row col-md-6">
                                <label for="confirmPassword" class="col-sm-2 col-form-label">Confirm Password : </label>
                                <div class="col-sm-10">
                                  <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="sumbit-form">
                                  <button type="submit"> save file </button>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="v-pills-Education" role="tabpanel" aria-labelledby="v-pills-Education-tab">
                  <div class="profile-education">

                  </div>
                </div>
                <div class="tab-pane fade" id="v-pills-Location" role="tabpanel" aria-labelledby="v-pills-Location-tab">
                  <div class="profile-location">

                  </div>
                </div>
                <div class="tab-pane fade" id="v-pills-Description" role="tabpanel" aria-labelledby="v-pills-Description-tab">
                  <div class="profile-description">

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>





@endsection
