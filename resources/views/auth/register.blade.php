@extends('layouts.app')
@section('content')

<div class="user-authentication-section">
    <div class="user-authentication-bg" style="background-image: url({{asset("backend/assets/image/login.jpg")}})">
        <div class="background-color">
            <div class="container">
                <div class="row">
                    <div class="col-md-7"> 
                        <div class="authentication-content">
                            <div class="product-name">
                                <h1> Master Accounting Software </h1>
                            </div>
                            <div class="product-discription">
                                <p> Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolores vero necessitatibus ex ipsam tempore dolorem, 
                                    neque nemo architecto suscipit omnis officia fuga, libero incidunt unde. Ad eius accusantium eaque excepturi! </p>
                            </div>
                            <div class="registration-btn">
                                <a href="{{ route('login') }}" type="button" class="btn"> Login Now <span> <i class="fas fa-sign-in"></i> </span> </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="login-section">
                            <div class="login-item-box">
                                <div class="section-header">
                                    <div class="company-logo">
                                        <a href="#"> <img src="https://nextpagetl.com/storage/uploads/nextpage-logo.png" alt=""> </a>
                                    </div>
                                    <h4> {{ __('Register') }} </h4>
                                </div>
                                <div class="section-contant">
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name" class="col-form-label text-md-right">{{ __('Name') }}</label>
                                            <div class="">
                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                            <div class="">
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>
                                            <div class="">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label for="password-confirm" class=" col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                            <div class="">
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="submit-btn">
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Register') }}
                                                </button>
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
    </div>
</div>






@endsection
