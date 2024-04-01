@extends('layouts.appauth')
@section('title', 'Add Email')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection 
@section('content')
<div class="p-2">
    <div class="row-auto">
        <div class="col-auto">
            <img class="img-fluid" src="{{ asset('assets/logo.png') }}" alt="" width="10%" height="auto">
            <span>NEUST Cooperative Partners </span>
        </div>
    </div>
</div>
<div class="container-fluid body-login d-flex flex-column justify-content-center align-items-center">
    <form method="POST" action="{{ route('forgot.password.post') }}">
        @csrf
        @method('POST')
        <div class="container d-flex justify-content-center">
            <div class="col-lg-12 w-100">
                <h2 class="me-md-5 mb-0">Forgot password</h2>                
                <div class="row justify-content-center" >
                    <div class="col-lg-12 col-md-12 mx-5 my-2">
                        <label for="user_email">Email</label>
                        <input type="email" class="form-control " placeholder="Enter your email" name="email" id="user_email">
                        @if ($errors->has('email'))
                            <small class="text-danger mt-3">
                                {{ $errors->first('email') }}
                            </small>
                        @endif
                        <button type="submit" class="btn btn-success mt-3 w-100">Send Reset Code</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection