@extends('layouts.appauth')
@section('title', 'Register')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <style>
        #amount_of_share::-webkit-outer-spin-button,
        #amount_of_share::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        #amount_of_share[type=number] {
            -moz-appearance: textfield;
        }
    </style>
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
    <form action="{{ route('login.user') }}" method="post">
        @csrf
        @method('POST')
        <div class="row px-4">
            <div class="col-lg-11 px-md-5 w-100">
                @if(session()->has('message'))
                    <div class="alert alert-danger w-100" role="alert">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="d-flex flex-column">
                    <div class="d-flex mb-2 gap-3">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-circle" title="Back">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                        <h2 class="me-md-5 mb-0">Register</h2>
                    </div>
                    <div class="card p-3 bg-info-subtle">
                        <div class="">
                            <span>Please fill up the form below to register</span>
                        </div>
                    </div>
                   
                </div>
                
                
                <hr>
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="col-lg-12">
                            <!-- Table -->
                            <form id="memberForm" action="{{ route('admin.store-repo') }}" method="post">
                                @csrf
                                @method('POST')                  
                                <div class="container mt-3">                                
                                <!-- Row 1 -->
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="last_name" class="fw-medium">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name') }}" placeholder="Enter your last name" required>
                                        @error('last_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="middle_name" class="fw-medium">Middle Name</label>
                                        <input type="text" class="form-control" name="middle_name" id="middle_name" value="{{ old('middle_name') }}" placeholder="Enter your middle name" required>
                                        @error('middle_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="first_name" class="fw-medium">First Name</label>
                                        <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name') }}" placeholder="Enter your first name" required>
                                        @error('first_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Row 2 -->
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="birth_date" class="fw-medium">Date of Birth</label>
                                        <input type="date" class="form-control" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" placeholder="Enter your date of birth" required>
                                        @error('birth_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="birth_place" class="fw-medium">Place of Birth</label>
                                        <input type="text" class="form-control" name="birth_place" id="birth_place" value="{{ old('birth_place') }}" placeholder="Enter your place of birth" required>
                                        @error('birth_place')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <label for="phone_number" class="fw-medium">Phone Number</label>
                                        <input type="number" class="form-control" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" placeholder="Enter your phone number" oninput="if(this.value.length > 11) { alert('Phone number cannot exceed 11 digits.'); this.value = this.value.slice(0,11); }" required>
                                        @error('phone_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Row 3 -->
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="civil_status" class="fw-medium">Civil Status</label>
                                        <select class="form-control" name="civil_status" id="civil_status" value="{{ old('civil_status') }}" required>
                                            <option select>Select one</option>  
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Divorced">Divorced</option>
                                            <option value="Widowed">Widowed</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="spouse_name" class="fw-medium">Name of Spouse</label>
                                        <input type="text" class="form-control" name="spouse_name" id="spouse_name" value="{{ old('spouse_name') }}" placeholder="Enter your spouse name" required>
                                        @error('spouse_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="citizenship" class="fw-medium">Citizenship</label>
                                        <input type="text" class="form-control" name="citizenship" id="citizenship" value="{{ old('citizenship') }}" placeholder="Enter your citizenship" required>
                                        @error('citizenship')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                </div>
                                
                                <div class="row mb-3">
                                    
                                    <div class="col-lg-4">
                                        <label for="city_address" class="fw-medium">City Address</label>
                                        <input type="text" class="form-control" name="city_address" id="city_address" value="{{ old('city_address') }}" placeholder="Enter your city address" required>
                                        @error('city_address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="provincial_address" class="fw-medium">Provincial Address</label>
                                        <input type="text" class="form-control" name="provincial_address" id="provincial_address" value="{{ old('provincial_address') }}" placeholder="Enter your provincial address" required>
                                        @error('provincial_address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="mailing_address" class="fw-medium">Mailing Address</label>
                                        <input type="text" class="form-control" name="mailing_address" id="mailing_address" value="{{ old('mailing_address') }}" placeholder="Enter your mailing address" required>
                                        @error('mailing_address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    
                                    <div class="col-lg-4">
                                        <label for="email" class="fw-medium">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="confirm_email" class="fw-medium">Confirm Email</label>
                                        <input type="email" class="form-control" name="confirm_email" id="confirm_email" placeholder="Confirm your email" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="taxID_num" class="fw-medium">Tax Identification Number</label>
                                        <input type="text" class="form-control" name="tax_id_number" id="tax_id_number" value="{{ old('tax_id_number') }}" placeholder="Enter your tax identification number" required>
                                        @error('tax_id_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                   
                                    
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="position" class="fw-medium">Work Position</label>
                                        <input type="text" class="form-control" name="position" id="position" value="{{ old('position') }}" placeholder="Enter your position" required>
                                        @error('position')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="date_employed" class="fw-medium">Date of Employment</label>
                                        <input type="date" class="form-control" name="date_employed" id="date_employed" value="{{ old('date_employed') }}" placeholder="Enter your date of employment" required>
                                        @error('date_employed')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="natureOf_work" class="fw-medium">Nature of Work</label>
                                        <select class="form-control" name="natureOf_work" id="natureOf_work" required>
                                            <option>Teaching</option>
                                            <option>Non-Teaching</option>
                                            <option>Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3 w-100">
                                    <div class="w-50">
                                        <label for="amount_of_share" class="fw-medium">Amount of shares</label>
                                        <span data-bs-toggle="tooltip" data-bs-placement="right" title="Shares will be added to balance upon account approval.">
                                            <i class="bi bi-info-circle"></i>
                                        </span>
                                        <input type="number" class="form-control" name="amount_of_share" id="amount_of_share" min="2000" max="20000" value="{{ old('amount_of_share') }}" placeholder="Enter your amount of shares" required>
                                        <small class="text-secondary float-end">Minimum 2,000 shares, Maximum 20,000 shares</small>
                                        @error('amount_of_share')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="w-50">
                                        <label for="valid_id" class="fw-medium">Type of ID</label>
                                        <select class="form-control" name="valid_id" id="valid_id" required>
                                            <option value="">Select ID Type</option>
                                            <option value="passport">Passport</option>
                                            <option value="driver_license">Driver's License</option>
                                            <option value="national_id">National ID</option>
                                            <option value="voter_id">Voter ID</option>
                                            <option value="umid">UMID</option>
                                        </select>
                                        @error('valid_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="w-50">
                                        <label for="school_id_photo" class="fw-medium">Upload School id Photo</label>
                                        <input type="file" class="form-control" name="school_id_photo" id="school_id_photo" required>
                                        @error('school_id_photo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="w-50">
                                        <label for="valid_id_photo" class="fw-medium">Upload Valid ID Photo</label>
                                        <input type="file" class="form-control" name="valid_id_photo" id="valid_id_photo" required>
                                        @error('valid_id_photo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <button class="btn btn-success mt-3" id="toast-submit" type="submit" style="float: right;">Register</button>
                            </form>
                            <!-- /Table -->
                        </div>
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
$('[data-bs-toggle="tooltip"]').tooltip();
    $('#civil_status').change(function() {
        if ($(this).val() === 'Single') {
        $('#spouse_name').val('None');
        } else {
        $('#spouse_name').val('');
        }
    });
    $('#amount_of_share').focus(function() {
        if ($(this).val() === '') {
            $(this).val(2000); // Default value when the field is focused and empty
        }
    });
    $('#amount_of_share').on('wheel', function(e) {
        $(this).blur();
    });
    $('#amount_of_share').on('input', function () {
        let value = parseInt($(this).val(), 10);

        if (value < 2000) {
            $(this).val(2000);
        } else if (value > 20000) {
            $(this).val(20000);
        }
    });
});
</script>
@endsection