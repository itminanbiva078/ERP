@extends('web.layouts.master')
@section('title')
Booking Cancel
@endsection
@section('style')
<style>
    .jumbotron{
        background: #FFF3CD;
        
    }
</style>
@endsection

@section('frontend-content')
    <section class="py-5 mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 ">
                    <div class="jumbotron jumbotron-fluid">
                        <div class="container">
                          <h2 class="display-4 text-center">You have canceled the booking 🚫 !!</h2>
                          <p class="lead text-center">If you have any query please <a href="{{ route('contact') }}" style="font-size: 20px; font-weight:500;"><strong>Contact</strong></a> the authority</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
