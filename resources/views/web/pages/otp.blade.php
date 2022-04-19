@extends('web.layouts.master')
@section('title')
OTP 
@endsection
@section('style')
    <style>
        .btn-primary {
            color: #fff;
            background-color: #e6c886;
            border-color: #e6c886;
        }
        .btn-primary:hover {
            color: #fff;
            background-color: #e6c886;
            border-color: #e6c886;
        }
        .login-form {
            background: #d4d9e6;
            padding: 50px;
            margin: 0 auto;
            width: 400px;
        }
        .btn-primary:not(:disabled):not(.disabled):active, .show>.btn-primary.dropdown-toggle {
            color: #fff;
            background-color: #e6c886;
            border-color: #e6c886;
        }
        .btn-primary:not(:disabled):not(.disabled):active:focus, .show>.btn-primary.dropdown-toggle:focus {
            box-shadow: none;
        }
    </style>
@endsection


@section('frontend-content')
<section class="inner-banner login-form-section">
    <div class="login-form">
        <form id="room-service-items-section" action="{{route('otp_submit')}}">
            <h2 class="text-center">Sign in</h2>   
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">+88</span>
                    <input type="text" class="form-control" name="phone_number" placeholder="Phone Number" required="required" autocomplete="off">
                    @if($errors->has('phone_number'))
                        <div class="error">{{ $errors->first('phone_number') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary login-btn btn-block">Sign Up/Login</button>
            </div>
        </form>
    </div>
</section>
@endsection
