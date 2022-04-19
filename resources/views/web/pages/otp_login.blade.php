@extends('web.layouts.master')
@section('title')
OTP
@endsection

@section('frontend-content')
    
<style>

.login-form {
    background: #d4d9e6;
    padding: 50px;
    margin: 0 auto;
    width: 400px;
}

</style>
    
    
<section class="inner-banner login-form-section">
    <div class="login-form">
        <form id="room-service-items-section" action="{{route('otp_submit_login')}}" method="POST">
            @csrf
            <h2 class="text-center">One Time Password</h2>  
            <div class="input-group" style="margin-bottom:20px;">
                <span class="input-group-addon">00</span>
                <input type="text" class="form-control" name="otp" placeholder="OTP" required="required" autocomplete="off">				
                <input type="hidden" class="form-control" name="phone_number" placeholder="phone number" required="required" autocomplete="off" value="{{$number}}">
            </div>
            @if($errors->has('otp'))
            <div class="alert alert-danger">
                <ul>
                    <li>
                        <div class="error">{{ $errors->first('otp') }}</div>
                    </li>
                </ul>
            </div>
            @endif
            @if (\Session::has('otp_not_match'))
                <div class="alert alert-danger">
                    <ul>
                        <li>{!! \Session::get('otp_not_match') !!}</li>
                    </ul>
                </div>
            @endif

            @if (isset($otp_not_match))
                <div class="alert alert-danger">
                    <ul>
                        <li>{{ $otp_not_match }}</li>
                    </ul>
                </div>
            @endif
            <div class="form-group">
                <button type="submit" class="btn btn-primary login-btn btn-block">Login</button>
            </div>
        </form>
    </div>
</section>

@endsection
