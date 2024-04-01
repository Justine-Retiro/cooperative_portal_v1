@extends('layouts.appauth')
@section('title', 'Code Verification')
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
    <form action="{{ route('forgot.verify.code') }}" method="post">
        @csrf
        @method('POST')
        <div class="container d-flex justify-content-center">
            <div class="col-lg-12 w-100">
                <h2 class="me-md-5 mb-1">Email Verification</h2>
                    <p class="mb-0">  
                        <small> Did not receive the code? Check your spam folder. </small>
                    </p>

                <div class="row justify-content-center">
                    <div class="col-lg-12 my-1">                        
                        <label class="mb-" for="code">Enter the verification code</label>
                        <input type="text" class="form-control mb-1" placeholder="Verification code" name="code" id="code">
                        <input type="hidden" id="resend_countdown" value="60">
                        <small id="success-message" class="text-success"></small>
                        <small id="error-message" class="text-danger"></small>
                        <div class="col-lg-12">
                            <p class="mb-0"> Didn't get the code?
                            <span id="resend_code" class="text-primary" disabled>Resend <span id="resend_timer"></span></span>
                        </p>
                    </div>
                        <button class="btn btn-primary mt-3 w-100" type="submit">Verify Code</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('script')
<script>
$(document).ready(function() {
    // Display success message if present
    if('{{ session()->has('success') }}') {
        $('#success-message').text('{{ session('success') }}').show().delay(20000).fadeOut();
    }

    var timer;
    // var countdown = 120; // Set the initial countdown value in seconds
    var countdown = 60; // Set the initial countdown value in seconds

    startResendTimer(); // Start the resend timer on page load

    $('#resend_code').click(function() {
        if ($(this).prop('disabled')) {
            return; // Prevent action if the button is disabled
        }
        $.ajax({
            url: '{{ route('forgot.password.resend.code') }}', // Use Laravel's route helper to generate the URL
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // Include CSRF token for security
            },
            success: function(response) {
                $('#success-message').text(response.message).show().delay(20000).fadeOut();
                startResendTimer(); // Restart the timer after resending
            },
            error: function(xhr) {
                // Parse the JSON response
                var response = JSON.parse(xhr.responseText);
                $('#error-message').text(response.message).show().delay(20000).fadeOut();
            }
        });
    });

    function startResendTimer() {
        countdown = 60; // Reset the countdown

        // countdown = 120; // Reset the countdown
        $('#resend_code').text('Resend in ' + countdown + 's').prop('disabled', true).css('pointer-events', 'pointer');

        timer = setInterval(function() {
            countdown--;
            if (countdown > 0) {
                $('#resend_code').text('Resend in ' + countdown + 's');
            } else {
                clearInterval(timer);
                $('#resend_code').prop('disabled', false).css('pointer-events', 'auto').text('Resend');
            }
        }, 1000); // Update the countdown every second
    }
});
</script>
@endsection