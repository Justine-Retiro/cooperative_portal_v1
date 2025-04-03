@extends('layouts.app')
@section('title', 'Repositories')
@section('css')
<link rel="stylesheet" href="{{ asset('css/repositories.css') }}">
@endsection
@section('content')
<div id="page-content-wrapper">
    <div class="container-fluid xyz">
        <div class="row">
            <div class="col-lg-12">
                <h1>Add New Member</h1>
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.repositories') }}" class="text-decoration-none">Repositories</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add member</li>
                </ol>
                </nav>
                <hr>
                <div class="row mt-1">
                    <div class="row my-2" id="top-nav">
                        <div class="col-lg-12 d-flex flex-column flex-md-row gap-3 flex-start align-items-center">
                            <div class="col-md-6">
                                <label for="account-number" class="form-label">Account Number</label>
                                <div class="input-group account-field">
                                    <input type="text" class="form-control" id="account-number" value="{{ $account_number }}" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('#account-number')" title="Click the button to copy account number"><i class="bi bi-clipboard"></i></button>
                                </div>
                                {{-- <div class="form-text account-help">Click the button to copy your account number</div> --}}
                            </div>
                            <div class="col-md-6">
                                <label for="account-password" class="form-label">Account Default Password</label>
                                <div class="input-group account-field">
                                    <input type="text" class="form-control" id="account-password" value="{{ $password }}" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('#account-password')" title="Click the button to copy account default password"><i class="bi bi-clipboard"></i></button>
                                </div>
                                {{-- <div class="form-text account-help">Click the button to copy your account default password</div> --}}
                            </div>
                        </div>
                        <div class="container">
                            
                        </div>
                        <div class="pe-0">
                            <!-- Table -->
                            <form id="memberForm" action="{{ route('admin.store-repo') }}" method="post">
                                @csrf
                                @method('POST')                  
                                <div class="mt-3">
                                <input type="hidden" name="account_number" value="{{ $account_number }}">
                                <input type="hidden" name="password" value="{{ $password }}">
                                @if ($errors->any())
                                    <div class="alert alert-danger d-flex flex-column" style="list-style: none;">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li class="">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Row 1 -->
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="lastName" class="fw-medium">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" id="last_name" value="" placeholder="Enter last name" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="middle_name" class="fw-medium">Middle Name</label>
                                        <input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="Enter middle name">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="first_name" class="fw-medium">First Name</label>
                                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter first name"  required>
                                    </div>
                                </div>
                                
                                <!-- Row 2 -->
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="birth_date" class="fw-medium">Date of Birth</label>
                                        <input type="date" class="form-control" name="birth_date" id="birth_date" placeholder="Enter date of birth" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="birth_place" class="fw-medium">Place of Birth</label>
                                        <input type="text" class="form-control" name="birth_place" id="birth_place" placeholder="Enter place of birth" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="phone_num" class="fw-medium">Phone Number</label>
                                        <div class="input-group w-100">
                                            <span class="input-group-text">+63</span>
                                            <input type="number" class="form-control" name="phone_num" id="phone_num" oninput="if(this.value.length > 11) { this.value = this.value.slice(0,11); }" placeholder="Enter phone number" required>
                                        </div>
                                    </div>

                                    
                                    
                                </div>
                                
                                <!-- Row 3 -->
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="civil_status" class="fw-medium">Civil Status</label>
                                        <select class="form-control" name="civil_status" id="civil_status" required>
                                            <option value="" >Select one</option>  
                                            <option value="Single" >Single</option>
                                            <option value="Married" >Married</option>
                                            <option value="Divorced" >Divorced</option>
                                            <option value="Widowed" >Widowed</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="spouse_name" class="fw-medium">Name of Spouse</label>
                                        <input type="text" class="form-control" name="spouse_name" id="spouse_name" placeholder="Enter name of spouse" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="citizenship" class="fw-medium">Citizenship</label>
                                        <input type="text" class="form-control" name="citizenship" id="citizenship" placeholder="Enter citizenship" required>
                                    </div>
                                    
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="city_address" class="fw-medium">City Address</label>
                                        <input type="text" class="form-control" name="city_address" id="city_address" placeholder="Enter city address" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="provincial_address" class="fw-medium">Provincial Address</label>
                                        <input type="text" class="form-control" name="provincial_address" id="provincial_address" placeholder="Enter provincial address" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="mailing_address" class="fw-medium">Home Address</label>
                                        <input type="text" class="form-control" name="mailing_address" id="mailing_address" placeholder="Enter home address" required>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="position" class="fw-medium">Work Position</label>
                                        <input type="text" class="form-control" name="position" id="position" placeholder="Enter work position" required>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <label for="date_employed" class="fw-medium">Date of Employment</label>
                                        <input type="date" class="form-control" name="date_employed" id="date_employed" placeholder="Enter date of employment" required>
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="natureOf_work" class="fw-medium">Nature of Work</label>
                                        <select class="form-control" name="natureOf_work" id="natureOf_work"  required>
                                            <option value="Teaching" >Teaching</option>
                                            <option value="Non-Teaching">Non-Teaching</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="taxID_num" class="fw-medium">Tax ID Number</label>
                                        <input type="text" class="form-control" name="taxID_num" id="taxID_num" placeholder="Enter tax ID number" required>
                                    </div>
                                        
                                    <div class="col-lg-4">
                                        <label for="account_status" class="fw-medium">Account Status</label>
                                        <select class="form-control" name="account_status" id="account_status" required>
                                            <option value="Active">Active</option>
                                            <option value="Non-Active">Not Active</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="amountOf_share" class="fw-medium">Amount of shares</label>
                                        <input type="text" class="form-control" name="amountOf_share" id="amountOf_share" placeholder="Enter amount of shares" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label class="fw-medium">Credential Delivery Method</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="notification_method" id="notification_default" value="default" checked>
                                            <label class="form-check-label" for="notification_default">
                                                Default
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="notification_method" id="notification_email" value="email">
                                            <label class="form-check-label" for="notification_email">
                                                Email the credentials
                                            </label>
                                        </div>
                                        
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="email" class="form-label email_label fw-medium" style="display: none;">Email</label>
                                            <input type="email" class="form-control mb-3" name="email" id="email" style="display: none;" placeholder="Enter email">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="confirmemail" class="form-label email_label fw-medium" style="display: none;">Confirm Email</label>
                                            <input type="email" class="form-control mb-3" name="confirm_email" id="confirm_email" style="display: none;" placeholder="Enter email">
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-success btn-lg mt-3" id="toast-submit" type="submit" style="float: right;">Save</button>
                            </form>
                            <!-- /Table -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
<script>
$(document).ready(function() {
    @if(session('success'))
        toastr.success('{{ session('success') }}');
    @elseif(session('error'))
        toastr.error('{{ session('error') }}');
    @endif

    $('#civil_status').change(handleCivilStatusChange);
            
    function handleCivilStatusChange() {
        const status = $(this).val();
        const spouseInput = $('#spouse_name');
        if (['Married', 'Divorced', 'Widowed'].includes(status)) {
            spouseInput.val('').attr('readonly', false);
        } else {
            spouseInput.val(status === 'Single' ? 'None' : '').attr('readonly', true);
        }
    }

    $('#civil_status').change(function() {
        if ($(this).val() === 'Single') {
        $('#spouse_name').val('None');
        } else {
        $('#spouse_name').val('');
        }
    });

    $('#toast-submit').on('click', function(e) {
        e.preventDefault();
        $(this).prop('disabled', true);
        $(this).closest('form').submit();
    });

    $('#last_name, #middle_name,#first_name').on('input', function() {
        var maxLength = 15;
        if ($(this).val().length > maxLength) {
            $(this).val($(this).val().substring(0, maxLength));
            toastr.error('Input exceeded the maximum length of ' + maxLength + ' characters.');
        }
    });

    $('input[type="text"]').on('input', function() {
        var noNumbersOrSpecialCharsAllowed = ['#first_name', '#middle_name', '#last_name', '#city_address', '#provincial_address', 
                                              '#position', '#citizenship', '#spouse_name', '#birth_place', '#provincial_address', '#city_address'];

        if (noNumbersOrSpecialCharsAllowed.includes('#' + $(this).attr('id'))) {
            var originalValue = $(this).val();
            var filteredValue = originalValue.replace(/[^a-zA-Z\s]/g, ''); // Allow only letters and spaces
            if (originalValue !== filteredValue) {
                $(this).val(filteredValue);
                toastr.error('Numbers and special characters are not allowed.');
            }
        }
    });

    $('#position').on('input', function() {
        var maxLength = 10;
        if ($(this).val().length > maxLength) {
            $(this).val($(this).val().substring(0, maxLength));
        }
    });


    $('#taxID_num').on('input', function() {
    var taxId = $(this).val();
    if(taxId.length > 12) {
        $(this).val(taxId.substring(0, 12));
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

    $('#phone_num').on('input', function() {
        var phoneNum = $(this).val();
        if (phoneNum < 0) {
            $(this).val('');
            toastr.error('Phone number cannot be a negative value.');
        } 
    });

    $('input[type="number"]').on('wheel', function(e) {
        $(this).blur();

    });

    $('#email').on('input', function() {
        var email = $(this).val();
        var confirmEmail = $('#confirm_email').val();
        if(email !== confirmEmail) {
            $('#toast-submit').prop('disabled', true);
            $('#toast-submit').css('cursor', 'not-allowed');
            $('#emailMismatch').remove();
            $(this).after('<span id="emailMismatch" class="text-danger">Emails do not match.</span>');
        } else {
            $('#toast-submit').prop('disabled', false);
            $('#toast-submit').css('cursor', 'pointer');
            $('#emailMismatch').remove();
        }
    });

    $('#confirm_email').on('input', function() {
        var email = $('#email').val();
        var confirmEmail = $(this).val();
        if(email !== confirmEmail) {
            $('#toast-submit').prop('disabled', true);
            $('#toast-submit').css('cursor', 'not-allowed');
            $('#emailMismatch').remove();
            $(this).after('<span id="emailMismatch" class="text-danger">Emails do not match.</span>');
        } else {
            $('#toast-submit').prop('disabled', false);
            $('#toast-submit').css('cursor', 'pointer');
            $('#emailMismatch').remove();
        }
    });
    $('input[name="notification_method"]').change(function() {
        if ($(this).val() === 'default') {
            $('.email_label').hide();
            $('input[name="email"]').val('');
            $('input[name="email"]').hide();
            $('input[name="confirm_email"]').hide();
            $('input[name="confirm_email"]').val('');
            $('#toast-submit').prop('disabled', false);
            $('#toast-submit').css('cursor', 'pointer');
            $('#emailMismatch').remove();
        } else {
            $('.email_label').show();
            $('input[name="email"]').show();
            $('input[name="confirm_email"]').show();
        }
    });



});
function copyToClipboard(elementId) {
    var copyText = document.querySelector(elementId).value; // Use .value for input fields
    var textarea = document.createElement("textarea");
    textarea.textContent = copyText;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand("copy");
    document.body.removeChild(textarea);
    toastr.success('Copied to clipboard');
}
</script>
@endsection
@endsection