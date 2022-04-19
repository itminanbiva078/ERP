@extends('layouts.app')

@section('content')
<div class="container">
    <div class="reset-password-section">
        <div class="row">
            <div class="col-md-12">
                <div class="reset-password-item">
                    <div class="reset-password-box">
                        <div class="section-header">
                            <div class="company-logo">
                                <a href="#"><img src="https://nextpagetl.com/storage/uploads/nextpage-logo.png" alt=""></a>
                            </div>
                            <h4> {{ __('Reset Password') }} </h4>
                        </div>
                        <div class="section-contant">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                    <div class="">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="submit-btn">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Send Password Reset Link') }}
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
@endsection
