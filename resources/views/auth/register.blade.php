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
    <div class="row px-4">
        <div class="col-lg-11 px-md-5 w-100">
            <div class="d-flex flex-column">
                <div class="d-flex mb-2 gap-3">
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary rounded-circle" title="Back">
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
            <div class="card" style="margin-bottom: 5em">
                <div class="card-body">
                    <div class="col-lg-12">
                        <!-- Table -->
                        <form id="memberForm" action="{{ route('register.user') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')                  
                            <div class="container mt-3">                                
                            <!-- Row 1 -->
                            @if ($errors->any())
                                <div class="alert alert-danger d-flex flex-column" style="list-style: none;">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li class="">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                   
                                    <label for="last_name" class="fw-medium">Last Name</label>
                                    <small class="text-danger" title="This field is required">*</small>
                                    <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name') }}" placeholder="Enter your last name" maxlength="15" required>
                                    @error('last_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label for="middle_name" class="fw-medium">Middle Name</label>
                                    <input type="text" class="form-control" name="middle_name" id="middle_name" value="{{ old('middle_name') }}" placeholder="Enter your middle name" maxlength="15">
                                    @error('middle_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label for="first_name" class="fw-medium">First Name</label>
                                    <small class="text-danger" title="This field is required">*</small>
                                    <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name') }}" placeholder="Enter your first name" maxlength="25" required>
                                    @error('first_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Row 2 -->
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label for="birth_date" class="fw-medium">Date of Birth</label>
                                    <small class="text-danger" title="This field is required">*</small>
                                    <input type="date" class="form-control" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" placeholder="Enter your date of birth" required>
                                    @error('birth_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label for="birth_place" class="fw-medium">Place of Birth</label>
                                    <small class="text-danger" title="This field is required">*</small>
                                    <input type="text" class="form-control" name="birth_place" id="birth_place" value="{{ old('birth_place') }}" placeholder="Enter your place of birth" required>
                                    @error('birth_place')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="col-lg-4">
                                    <label for="phone_number" class="fw-medium">Phone Number</label>
                                    <small class="text-danger" title="This field is required">*</small>
                                    <div class="input-group">
                                        <span class="input-group-text">+63</span>
                                        <input type="number" class="form-control" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" placeholder="Enter your phone number" oninput="if(this.value.length > 11) { alert('Phone number cannot exceed 11 digits.'); this.value = this.value.slice(0,11); }" required>
                                    </div>
                                    @error('phone_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Row 3 -->
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label for="civil_status" class="fw-medium">Civil Status</label>
                                    <small class="text-danger" title="This field is required">*</small>
                                    <select class="form-control" name="civil_status" id="civil_status" value="{{ old('civil_status') }}" required>
                                        <option value="">Select one</option>  
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Widowed">Widowed</option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label for="spouse_name" class="fw-medium">Name of Spouse</label>
                                    <small class="text-danger" title="This field is required">*</small>
                                    <input type="text" class="form-control" name="spouse_name" id="spouse_name" value="{{ old('spouse_name') }}" placeholder="Enter your spouse name" required readonly>
                                    @error('spouse_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label for="citizenship" class="fw-medium">Citizenship</label>
                                    <small class="text-danger" title="This field is required">*</small>
                                    <input type="text" class="form-control" name="citizenship" id="citizenship" value="{{ old('citizenship') }}" placeholder="Enter your citizenship" maxlength="20" required>
                                    @error('citizenship')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                            </div>
                            
                            <div class="row mb-3">
                                
                                <div class="col-lg-4">
                                    <label for="city_address" class="fw-medium">City Address</label>
                                    <small class="text-danger" title="This field is required">*</small>
                                    <select class="form-control" name="city_address" id="city_address" required>
                                        <option value="">Select your city</option>
                                        @foreach(collect(json_decode(file_get_contents(public_path('storage/refcitymun.json')), true)['RECORDS'])->sortBy('citymunDesc') as $city)
                                            <option value="{{ $city['citymunDesc'] }}">{{ $city['citymunDesc'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('city_address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label for="provincial_address" class="fw-medium">Provincial Address</label>
                                    <small class="text-danger" title="This field is required">*</small>
                                    <select class="form-control" name="provincial_address" id="provincial_address" required>
                                        <option value="">Select your province</option>
                                        @foreach(collect(json_decode(file_get_contents(public_path('storage/refprovince.json')), true)['RECORDS'])->sortBy('provDesc') as $province)
                                            <option value="{{ $province['provDesc'] }}">{{ $province['provDesc'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('provincial_address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label for="mailing_address" class="fw-medium">Home Address</label>
                                    <small class="text-danger" title="This field is required">*</small>
                                    <input type="text" class="form-control" name="mailing_address" id="mailing_address" value="{{ old('mailing_address') }}" placeholder="Enter your mailing address" required>
                                    @error('mailing_address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                
                                <div class="col-lg-4">
                                    <label for="email" class="fw-medium">Email</label>
                                    <small class="text-danger" title="This field is required">*</small>
                                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label for="confirm_email" class="fw-medium">Confirm Email</label>
                                    <small class="text-danger" title="This field is required">*</small>
                                    <input type="email" class="form-control" name="confirm_email" id="confirm_email" placeholder="Confirm your email" required>
                                </div>
                                <div class="col-lg-4">
                                    <label for="taxID_num" class="fw-medium">Tax Identification Number</label>
                                    <small class="text-danger" title="This field is required">*</small>
                                    <input type="number" class="form-control" name="tax_id_number" id="tax_id_number" value="{{ old('tax_id_number') }}" placeholder="Enter your tax identification number" required>
                                    @error('tax_id_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label for="position" class="fw-medium">Work Position</label>
                                    <small class="text-danger" title="This field is required">*</small>
                                    <input type="text" class="form-control" name="position" id="position" value="{{ old('position') }}" placeholder="Enter your position" maxlength="40" required>
                                    @error('position')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label for="date_employed" class="fw-medium">Date of Employment</label>
                                    <small class="text-danger" title="This field is required">*</small>
                                    <input type="date" class="form-control" name="date_employed" id="date_employed" value="{{ old('date_employed') }}" placeholder="Enter your date of employment" required>
                                    @error('date_employed')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label for="nature_of_work" class="fw-medium">Nature of Work</label>
                                    <small class="text-danger" title="This field is required">*</small>
                                    <select class="form-control" name="nature_of_work" id="nature_of_work" required>
                                        <option>Teaching</option>
                                        <option>Non-Teaching</option>
                                        <option>Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3 w-auto">
                                <div class="col-lg-6">
                                    <div class="w-100">
                                        <label for="amount_of_share" class="fw-medium">Amount of shares</label>
                                        <small class="text-danger" title="This field is required">*</small>
                                        <span data-bs-toggle="tooltip" data-bs-placement="right" title="Shares will be added to balance upon account approval.">
                                            <i class="bi bi-info-circle"></i>
                                        </span>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">₱</span>
                                            <input type="number" class="form-control" name="amount_of_share" id="amount_of_share" value="{{ old('amount_of_share') }}" placeholder="Enter your amount of shares" required>
                                            
                                        </div>
                                        <div class="">
                                            @error('amount_of_share')
                                                <small class="text-danger float-end">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <small class="text-secondary float-end">Minimum ₱2,000.00 shares, Maximum ₱20,000.00 shares</small>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="w-100">
                                        <label for="valid_id_type" class="fw-medium">Type of ID</label>
                                        <small class="text-danger" title="This field is required">*</small>
                                        <select class="form-control" name="valid_id_type" id="valid_id_type" required>
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
                            </div>

                            <div class="row mb-3 d-md-flex flex-md-row flex-column">
                                <div class="col-lg-6">
                                    <div class="w-100">
                                        <label for="school_id_photo" class="fw-medium">Upload School id Photo</label>
                                        <small class="text-danger" title="This field is required">*</small>
                                        <input type="file" class="form-control" name="school_id_photo" id="school_id_photo" accept="image/jpeg, image/png, image/jpg" required>
                                        <small class="text-secondary float-end">Maximum of 8MB</small>
                                        @error('school_id_photo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="w-100">
                                        <label for="valid_id_photo" class="fw-medium">Upload Valid ID Photo</label>
                                        <small class="text-danger" title="This field is required">*</small>
                                        <input type="file" class="form-control" name="valid_id_photo" id="valid_id_photo" accept="image/jpeg, image/png, image/jpg" required>
                                        <small class="text-secondary float-end">Maximum of 8MB</small>
                                        @error('valid_id_photo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <span class="text-secondary mb-2">Please check the box below to confirm that the information given in this form is true, complete and accurate.</span>
                                    <div class="card p-2 bg-info-subtle rounded" >
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="confirmation" name="confirmation" required>
                                            <label class="form-check-label" for="confirmation">
                                                I confirm that the information given in this form is true, complete and accurate
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-success" id="toast-submit" type="submit" style="float: right;">Register</button>
                        </form>
                        <!-- /Table -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>

$(document).ready(function() {
    @if(session()->has('success'))
        toastr.success('{{ session('success') }}');
    @endif
    @if(session()->has('message'))
        toastr.error('{{ session('message') }}');
    @endif

    
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    $('#confirmation').change(function() {
        toggleCivilStatusValidity();
    });
    
    $('#civil_status').change(handleCivilStatusChange);

    $('#date_employed').change(validateEmploymentDate);

    $('#amount_of_share').focus(setDefaultShareAmount);
    
    $('#tax_id_number').on('input', enforceTaxIdLength);

    $('input[type="number"]').on('input', filterNumericInput);

    $('form').submit(validateFormSubmission);

    $('#email, #confirm_email').on('input', validateEmailMatch);

    $('input[type="text"]').on('input', filterTextInputs);

    $('#confirmation').change(toggleSubmitButtonState);

    $('#amount_of_share').on('wheel', function(e) {
        $(this).blur();
    });

    $('#amount_of_share').on('input', validateShareAmount);

    $('#toast-submit').on('click', validateAllInputsBeforeSubmission);

    toggleSubmitButtonState();
    function toggleCivilStatusValidity() {
        if ($('#civil_status').val() === '') {
            $('#civil_status').addClass('is-invalid');
        } else {
            $('#civil_status').removeClass('is-invalid');
        }
    }

    function handleCivilStatusChange() {
        const status = $(this).val();
        const spouseInput = $('#spouse_name');
        if (['Married', 'Divorced', 'Widowed'].includes(status)) {
            spouseInput.val('').attr('readonly', false);
            spouseInput.prop('required', true);
        } else {
            spouseInput.val(status === 'Single' ? 'None' : '').attr('readonly', true);
        }
    }

    function validateEmploymentDate() {
        const birthDate = $('#birth_date').val();
        const dateEmployed = $(this).val();
        if (new Date(dateEmployed) < new Date(birthDate)) {
            $(this).val('');
            toastr.error('Date employed cannot be before birth date.');
        }

        if (new Date(dateEmployed) > new Date()) {
            $(this).val('');
            toastr.error('Date employed cannot exceed the current date.');
        }
    }

    function setDefaultShareAmount() {
        if ($(this).val() === '') {
            $(this).val(2000); 
        }
    }

    function enforceTaxIdLength() {
        const taxId = $(this).val();
        if (taxId.length > 12) {
            $(this).val(taxId.substring(0, 12));
        }
    }

    function filterNumericInput() {
        const noCharactersAllowed = ['#phone_number', '#amount_of_share', '#tax_id_number'];
        const id = '#' + $(this).attr('id');
        if (noCharactersAllowed.includes(id)) {
            const originalValue = $(this).val();
            const filteredValue = originalValue.replace(/[^0-9]/g, '');
            $(this).val(filteredValue);
            if (originalValue !== filteredValue) {
                toastr.error('Only numbers are allowed.');
            }
        }
    }

    function validateFormSubmission(e) {
        const fileInputSchool = $('#school_id_photo')[0];
        const fileInputValid = $('#valid_id_photo')[0];
        if (fileInputSchool && fileInputValid && fileInputSchool.files[0].size > 8388608) {
            e.preventDefault();
            toastr.error('File size should be less than 8MB.');
        }
        if (!$('#confirmation').is(':checked')) {
            e.preventDefault();
            toastr.error('You must confirm before submitting.');
        }
    }

    function validateEmailMatch() {
        const email = $('#email').val();
        const confirmEmail = $('#confirm_email').val();
        if (email !== confirmEmail) {
            $('#emailMismatch').remove();
            $(this).after('<span id="emailMismatch" class="text-danger">Emails do not match.</span>');
        } else {
            $('#emailMismatch').remove();
        }
    }

    function filterTextInputs() {
        const noNumbersOrSpecialCharsAllowed = ['#first_name', '#last_name', '#city_address', '#provincial_address', 
                                                '#position', '#citizenship', '#spouse_name', '#birth_place', '#provincial_address', '#city_address'];
        const id = '#' + $(this).attr('id');
        if (noNumbersOrSpecialCharsAllowed.includes(id)) {
            const originalValue = $(this).val();
            const filteredValue = originalValue.replace(/[^a-zA-Z\s]/g, '');
            $(this).val(filteredValue);
            if (originalValue !== filteredValue) {
                toastr.error('Numbers and special characters are not allowed.');
            }
        }
    }

    function toggleSubmitButtonState() {
        if ($(this).is(':checked')) {
            $('#toast-submit').prop('disabled', false).css('cursor', 'pointer');
        } else {
            $('#toast-submit').prop('disabled', true).css('cursor', 'not-allowed');
        }
    }

    function validateShareAmount() {
        let value = parseInt($(this).val(), 10) || 0;
        if (value < 2000) {
            toastr.error('Minimum ₱2,000.00 shares, Maximum ₱20,000.00 shares');
        }
        $(this).val(Math.min(Math.max(value, 0), 20000));
    }

    function validateAllInputsBeforeSubmission(e) {
        e.preventDefault();
        let allInputsFilled = true;
        $('input').not('#middle_name').each(function() {
            if ($(this).val() === '') {
                allInputsFilled = false;
                return false;
            }
        });

        if (!allInputsFilled) {
            toastr.error('Please fill in all fields.');
            $('input').each(function() {
                if ($(this).val() === '') {
                    $(this).addClass('is-invalid');
                }
            });
            return;
        }
        
        $(this).prop('disabled', true);
        $(this).closest('form').submit();
    }
});
</script>
@endsection