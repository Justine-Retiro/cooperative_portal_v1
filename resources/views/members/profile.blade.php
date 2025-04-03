@extends('layouts.app')
@section('title', 'Profile')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/member/profile/style.css') }}">
@endsection
@section('content')
    <div id="page-content-wrapper">
        <div class="container-fluid xyz">
            <div class="row">
                <div class="col-lg-12">
                    <h1>
                        Profile
                    </h1>
                    <div class="d-flex align-items-center">
                        <span>Account Number</span><span
                            class="ms-2 rounded bg-body-secondary px-3 py-2">{{ $client->user->account_number }}</span>
                    </div>
                    <div class="row" style="margin-top: 2em;">
                    </div>
                    <!-- Table -->

                    <div class="">
                        <input type="hidden" name="account_number" value="">

                        <h3>Personal Details</h3>
                        <hr>
                        <div class="">
                        @if(session('info'))
                            <div class="alert alert-info">
                                {{ session('info') }}
                            </div>
                            <hr>
                        @endif
                        </div>
                        <form action="{{ route('member.profile.store') }}" method="post">
                            @csrf
                            @method('PUT')
                            <!-- Row 1 -->
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name"
                                        value="{{ $client->last_name }}" {{ $default_profile ? '' : 'readonly disabled' }} maxlength="25">
                                </div>
                                <div class="col-lg-4">
                                    <label for="middle_name">Middle Name</label>
                                    <input type="text" class="form-control" name="middle_name" id="middle_name"
                                        value="{{ $client->middle_name }}" {{ $default_profile ? '' : 'readonly disabled' }} maxlength="25">
                                </div>
                                <div class="col-lg-4">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name"
                                        value="{{ $client->first_name }}" {{ $default_profile ? '' : 'readonly disabled' }} maxlength="25">
                                </div>
                            </div>

                            <!-- Row 2 -->
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label for="birth_date">Date of Birth</label>
                                    <input type="date" class="form-control" name="birth_date" id="birth_date"
                                        value="{{ $client->birth_date ? $client->birth_date->format('Y-m-d') : old('birth_date') }}" required>
                                </div>
                                <div class="col-lg-4">
                                    <label for="age">Age</label>
                                    <input type="text" class="form-control" name="age" id="age" placeholder="Enter your age"
                                        value="{{ $client->age }}" required>
                                </div>
                                <div class="col-lg-4">
                                    <label for="birth_place">Place of Birth</label>
                                    <input type="text" class="form-control" name="birth_place" id="birth_place"
                                        value="{{ $client->birth_place }} " required>
                                </div>
                            </div>

                            <!-- Row 3 -->
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label for="department">Department</label>
                                    <input type="text" class="form-control" name="department" id="department" placeholder="Enter your department"
                                        value="{{ $client->department }}" required>
                                </div>
                                <div class="col-lg-4">
                                    <label for="position">Work Position</label>
                                    <input type="text" class="form-control" name="position" id="position"
                                        value="{{ $client->position }} " required>
                                </div>
                                <div class="col-lg-4">
                                    <label for="civil_status">Civil Status</label>
                                    <select class="form-control" name="civil_status" id="civil_status">
                                        <option value="">Select one</option>
                                        <option value="Single" {{ $client->civil_status == 'Single' ? 'selected' : '' }}>
                                            Single</option>
                                        <option value="Married" {{ $client->civil_status == 'Married' ? 'selected' : '' }}>
                                            Married</option>
                                        <option value="Divorced"
                                            {{ $client->civil_status == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                        <option value="Widowed" {{ $client->civil_status == 'Widowed' ? 'selected' : '' }}>
                                            Widowed</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Row 4-->
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label for="spouse_name">Name of Spouse</label>
                                    <input type="text" class="form-control" name="spouse_name" id="spouse_name"
                                        value="{{ $client->spouse_name }} " required>
                                </div>
                                <div class="col-lg-4">
                                    <label for="provincial_address">Provincial Address</label>
                                    <input type="text" class="form-control" name="provincial_address"
                                        id="provincial_address" value="{{ $client->provincial_address }}" maxlength="25" required>
                                </div>
                                <div class="col-lg-4">
                                    <label for="citizenship">Citizenship</label>
                                    <input type="text" class="form-control" name="citizenship" maxlength="25" id="citizenship"
                                        value="{{ $client->citizenship }} " required>
                                </div>
                            </div>
                            <!-- Row 5-->
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label for="city_address">City Address</label>
                                    <input type="text" class="form-control" name="city_address" id="city_address"
                                        value="{{ $client->city_address }}" maxlength="25" required>
                                </div>
                                <div class="col-lg-4">
                                    <label for="phone_num">Phone Number</label>
                                    <input type="text" class="form-control" name="phone_num" id="phone_num"
                                        value="{{ $client->phone_number }}" required>
                                </div>
                                <div class="col-lg-4">
                                    <label for="taxID_num">Tax Identification Number</label>
                                    <input type="text" class="form-control" name="taxID_num" id="taxID_num"
                                        value="{{ $client->tax_id_number }}" required>
                                </div>
                            </div>
                            <!-- Row 6-->
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label for="natureOf_work">Nature of Work</label>
                                    <select class="form-control" name="natureOf_work" id="natureOf_work"
                                        value="{{ $client->nature_of_work }}">
                                        <option>Teaching</option>
                                        <option>Non-Teaching</option>
                                        <option>Others</option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label for="date_employed">Date of Employment</label>
                                    <input type="date" class="form-control" name="date_employed" id="date_employed"
                                        value="{{ $client->date_employed->toDateString() }}" readonly disabled>
                                </div>
                                <div class="col-lg-4">
                                    <label for="retirementDate">Date of Retirement</label>
                                    <input type="text" class="form-control" name="retirementDate" id="retirementDate" 
                                        value="{{ $client->retirement_date }}" {{ $default_profile ? '' : 'readonly disabled' }}>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <button class="btn btn-success float-end changeprofile" type="submit">Save profile</button>
                                </div>
                            </div>
                        </form>
                        <h3>Email</h3>
                        <hr>
                        <form action="{{ route('member.email.change') }}" method="post">
                            @csrf
                            @method('POST')
                            <div class="row d-flex">
                                <div class="col-lg-4">
                                    <div class="">
                                        <div class="row w-auto">
                                            <div class="col-lg-12 mb-3">
                                                <label for="email">New Email</label>
                                                <input type="email" class="form-control email-input" name="email"
                                                    id="email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="row w-auto">
                                            <div class="col-lg-12 mb-3">
                                                <label for="confirm_email">Confirm Email</label>
                                                <input type="email" class="form-control email-input"
                                                    name="confirm_email" id="confirm_email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="row w-auto">
                                            <div class="w-100 mb-3">
                                                <label for="current_password">Current Password</label>
                                                <input type="password" class="form-control" name="current_password"
                                                    id="current_password_email">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="row w-auto">
                                            <div class="col mt-2">
                                                <input type="checkbox" id="show_password_email">
                                                <label for="show_password_email">Show Password</label>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-lg-4 mb-2">
                                    <div class="w-auto">
                                        <div class="alert alert-danger w-100 d-none d-flex align-items-center"
                                            style=" height: 100%;" role="alert" id="alert_email">
                                            <!-- Container for error -->
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-4 ">
                                    <div class="w-auto mb-3">
                                        <div>Current email: <div class="text-success">{{ $client->user->email }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <button class="btn btn-success mt-3 float-end changeemail"
                                        type="submit">Confirm</button>
                                </div>
                            </div>
                        </form>


                        <h3>Password</h3>
                        <hr>
                        <form action="{{ route('member.password.validate') }}" method="post">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="row w-auto">
                                        <input type="hidden" name="account_number" value=" ">
                                        <div class="col-lg-12 mb-3">
                                            <label for="current_password">Current Password</label>
                                            <input type="password" class="form-control password-input"
                                                name="current_password" id="current_password">
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <label for="new_password">New Password</label>
                                            <input type="password" class="form-control password-input"
                                                name="new_password" id="new_password">
                                        </div>
                                    </div>
                                    <div class="row w-auto">
                                        <div class="col-lg-12 mb-3">
                                            <label for="confirm_password">Confirm Password</label>
                                            <input type="password" class="form-control password-input"
                                                name="confirm_password" id="confirm_password">
                                            <div class="invalid-feedback"></div>
                                            <!-- This will display the error message -->
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <input type="checkbox" id="show_password">
                                        <label for="show_password">Show Password</label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="alert alert-danger d-none d-flex align-items-center"
                                        style=" max-width: 350px; height: 100%;" role="alert" id="alert_password">
                                        <!-- Container for error -->
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button class="btn btn-success mt-5 float-end changepassword" type="submit">Change
                                        password</button>
                                </div>
                            </div>
                        </form>
                        <!-- /Table -->
                    </div>

                    <!-- Email Verification Modal -->

                    <div class="modal fade" id="confirmModal" data-bs-backdrop="static" tabindex="-1"
                        aria-labelledby="confirmModalLabel" aria-hidden="true">
                        <form id="code_verify" action="{{ route('member.email.verify') }}" method="post">
                            @csrf
                            @method('POST')
                            <div class="modal-dialog modal-dialog-centered ">
                                <div class="modal-content ">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="confirmModalLabel">Verify Email</h1>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="account_number" value=" ">
                                        <div class="col-lg-12 mb-2">
                                            <label for="text">Verification Code</label>
                                            <input type="text" class="form-control code-input"
                                                name="verification_code" id="code">
                                            <small id="success-message" class="text-success"></small>
                                            <small id="error-message" class="text-danger"></small>
                                            <input type="hidden" id="resend_countdown" value="60">
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <p> Didn't get the code?
                                                <span id="resend_code" class="text-primary" disabled>Resend <span
                                                        id="resend_timer"></span></span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id="code_verify" class="btn btn-primary">Verify</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal fade" id="confirmModalPassword" data-bs-backdrop="static" tabindex="-1"
                        aria-labelledby="confirmModalLabel" aria-hidden="true">
                        <form id="code_verify_password" action="{{ route('member.password.verify') }}" method="post">
                            @csrf
                            @method('POST')
                            <div class="modal-dialog modal-dialog-centered ">
                                <div class="modal-content ">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="confirmModalLabel">Code Verification</h1>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="account_number" value=" ">
                                        <div class="col-lg-12 mb-2">
                                            <label for="text">Verification Code</label>
                                            <input type="text" class="form-control code-input"
                                                name="verification_code" id="code-pw">
                                            <small id="success-message-pw" class="text-success"></small>
                                            <small id="error-message-pw" class="text-danger"></small>
                                            <input type="hidden" id="resend_countdown" value="60">
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <p> Didn't get the code?
                                                <span id="resend_code_password" class="text-primary" disabled>Resend <span
                                                        id="resend_timer"></span></span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id="code_verify_password"
                                            class="btn btn-primary">Verify</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>


                    <!-- /Table -->
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#show_password_email').change(function() {
                if ($(this).is(":checked")) {
                    $('#current_password_email').attr('type', 'text');

                } else {
                    $('#current_password_email').attr('type', 'password');
                }
            });
            $('input[type="text"]').on('input', function() {
                var noNumbersOrSpecialCharsAllowed = ['#first_name', '#middle_name', '#last_name', '#city_address', '#provincial_address', 
                                                    '#position', '#citizenship', '#spouse_name', '#birth_place', '#provincial_address', '#city_address'];

                if (noNumbersOrSpecialCharsAllowed.includes('#' + $(this).attr('id'))) {
                    var originalValue = $(this).val();
                    var filteredValue = originalValue.replace(/[^a-zA-Z\s]/g, ''); // Allow only letters and spaces
                    $(this).val(filteredValue);
                    if (originalValue !== filteredValue) {
                        toastr.error('Numbers and special characters are not allowed.');
                    }
                }
            });

            $('#age').on('input', function() {
                var age = $(this).val();
                if (age < 0) {
                    $(this).val('');
                    toastr.error('Age cannot be negative.');
                } else if (age > 150) {
                    $(this).val('');
                    toastr.error('Age cannot be greater than 150.');
                } 
            });

            $('#show_password').change(function() {
                if ($(this).is(":checked")) {
                    $('#current_password').attr('type', 'text');
                    $('#new_password').attr('type', 'text');
                    // Corrected to use the updated ID for confirm password field
                    $('#confirm_password').attr('type', 'text');
                } else {
                    $('#current_password').attr('type', 'password');
                    $('#new_password').attr('type', 'password');
                    // Corrected to use the updated ID for confirm password field
                    $('#confirm_password').attr('type', 'password');
                }
            });
            @if (session('success'))
                toastr.success("{{ session('success') }}");
            @elseif (session('error'))
                toastr.error("{{ session('error') }}");
            @endif

            var timer;
            var countdown = 350;
            startResendTimer();

            $('#resend_code').click(function() {
                if ($(this).prop('disabled')) {
                    return;
                }
                $.ajax({
                    url: '{{ route('member.resend.code') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        $('#success-message').text(response.message).show().delay(20000)
                            .fadeOut();
                        startResendTimer(); // Restart the timer after resending
                    },
                    error: function() {
                        $('#error-message').text(response.message).show().delay(20000)
                            .fadeOut();
                    }
                });
            });

            $('#resend_code_password').click(function() {
                if ($(this).prop('disabled')) {
                    return;
                }
                $.ajax({
                    url: '{{ route('member.password.resend') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        $('#success-message-pw').text(response.message).show().delay(20000)
                            .fadeOut();
                        startResendTimer(); // Restart the timer after resending
                    },
                    error: function() {
                        $('#error-message-pw').text(response.message).show().delay(20000)
                            .fadeOut();
                    }
                });
            });

            $('.email-input').on('input', function() {
                var email = $('#email').val();
                var confirmEmail = $('#confirm_email').val();

                if (email && confirmEmail && email === confirmEmail) {
                    $('#alert_email').removeClass('d-none alert-danger').addClass('alert-success').text(
                        'Emails match!');
                } else if (email || confirmEmail) {
                    $('#alert_email').removeClass('d-none alert-success').addClass('alert-danger').text(
                        'Emails do not match.');
                } else {
                    $('#alert_email').addClass('d-none').text('');
                }
            });

             $('.password-input').on('input', function (){
                var password = $('#new_password').val();
                var confirmPassword = $('#confirm_password').val();
                var passwordRegex = /^(?=.*[0-9])(?=.*[\W_])[a-zA-Z0-9\W_]{8,}$/;
            
                if (password && confirmPassword) {
                    if (password === confirmPassword) {
                        if (passwordRegex.test(password)) {
                            $('#alert_password').removeClass('d-none alert-danger').addClass('alert-success').text('Password is matched and valid!');
                        } else {
                            $('#alert_password').removeClass('d-none alert-success').addClass('alert-danger').text('Password must be at least 8 characters long and include at least one number and one special character.');
                        }
                    } else {
                        $('#alert_password').removeClass('d-none alert-success').addClass('alert-danger').text('Passwords do not match.');
                    }
                } else {
                    $('#alert_password').addClass('d-none').text('');
                }
            });


            $('.changepassword').click(function(event) {
                event.preventDefault();
                var currentPassword = $('#current_password').val();
                var newPassword = $('#new_password').val();
                var confirmPass = $('#confirm_password').val();

                if (currentPassword && newPassword && confirmPass && newPassword === confirmPass) {
                    $.ajax({
                        url: '{{ route('member.password.validate') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            current_password: currentPassword,
                            new_password: newPassword,
                            confirm_password: confirmPass
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                toastr.success(response.message);
                                $('#confirmModalPassword').modal('show');
                            } else {
                                toastr.error(response.message);
                                $('#current_password').addClass('is-invalid');
                                $('#current_password').next('.invalid-feedback').html(response
                                    .message).show();
                            }
                        },
                        error: function(xhr) {
                            toastr.error('An error occurred. Please try again.');
                        }
                    });
                } else {
                    // Handle validation error for password mismatch or empty fields
                    toastr.error('Please check your inputs.');
                }
            });

            $('#date_employed').on('change', function() {
                var birthDate = $('#birth_date').val();
                var dateEmployed = $(this).val();
                if (new Date(dateEmployed) < new Date(birthDate)) {
                    $(this).val('');
                    toastr.error('Date employed cannot be before birth date.');
                }
            });

            // Show modal only if email inputs are filled and submission is successful
            $('.changeemail').click(function(event) {
                event.preventDefault();
                var email = $('#email').val();
                var confirmEmail = $('#confirm_email').val();
                var currentPassword = $('#current_password_email').val(); // Get the current password

                if (email && confirmEmail && email === confirmEmail) {
                    $.ajax({
                        url: '{{ route('member.email.change') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            email: email,
                            confirm_email: confirmEmail,
                            current_password: currentPassword // Include the current password in the request
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                toastr.success(response.message);
                                $('#confirmModal').modal('show');
                            } else {
                                toastr.error(response.message);
                                $('#current_password_email').addClass('is-invalid');
                                $('#current_password_email').next('.invalid-feedback').html(
                                    response.message).show();
                            }
                        },
                        error: function(xhr) {
                            toastr.error('An error occurred. Please try again.');
                        }
                    });
                } else {
                    toastr.error('Please check your inputs.');
                }
            });

            $('#code_verify').submit(function(event) {
                event.preventDefault();
                var verificationCode = $('#code')
                    .val(); // Assuming the input field for the code has an id of 'code'

                $.ajax({
                    url: '{{ route('member.email.verify') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        code: verificationCode
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#confirmModal').modal('hide'); // Close the modal
                            setTimeout(function() {
                                location
                                    .reload(); // Refresh the page after a short delay
                            }, 1000); // Adjust the delay as needed
                        } else {
                            toastr.error(response.message);
                            $('#code').addClass('is-invalid');
                            $('#error-message').text(response.message).show().delay(20000)
                                .fadeOut();
                        }
                    },
                    error: function(xhr) {
                        toastr.error('An error occurred. Please try again.');
                    }
                });
            });
            $('#code_verify_password').submit(function(event) {
                event.preventDefault();
                var code = $('#code-pw').val(); // Assuming the input field for the code has an id of 'code'

                $.ajax({
                    url: '{{ route('member.password.verify') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        code: code
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#confirmModalPassword').modal('hide'); // Close the modal
                            setTimeout(function() {
                                location
                                    .reload(); // Refresh the page after a short delay
                            }, 1000); // Adjust the delay as needed
                        } else {
                            toastr.error(response.message);
                            $('#code-pw').addClass('is-invalid');
                            $('#error-message-pw').text(response.message).show().delay(20000)
                                .fadeOut();
                        }
                    },
                    error: function(xhr) {
                        toastr.error('An error occurred. Please try again.');
                    }
                });
            });

            function startResendTimer() {
                var countdown = 350;
                $('#resend_code').text('Resend in ' + countdown + 's').prop('disabled', true).css('pointer-events',
                    'none');

                timer = setInterval(function() {
                    countdown--;
                    if (countdown > 0) {
                        $('#resend_code').text('Resend in ' + countdown + 's');
                    } else {
                        clearInterval(timer);
                        $('#resend_code').prop('disabled', false).css('pointer-events', 'auto');
                        $('#resend_code').text('Resend');
                    }
                }, 1000);
            }
        });
    </script>
@endsection
