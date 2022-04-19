@extends('web.layouts.master')
@section('title')
Payment Failed
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
                          <h2 class="display-4 text-center">Your transaction Failed 🚫 !!</h2>
                          <h4 class="text-center pt-3">Please Try Again</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
