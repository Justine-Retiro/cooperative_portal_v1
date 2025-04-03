@extends('layouts.app')
@section('title', 'View Repositories')
@section('css')
<link rel="stylesheet" href="{{ asset('css/repositories.css') }}">
@endsection
@section('content')
<div id="page-content-wrapper">
    <div class="container-fluid xyz">
        <div class="row">
            <div class="col-lg-12">
                <h1>Members Details</h1>
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.repositories') }}" class="text-decoration-none">Repositories</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View member</li>
                </ol>
                </nav>
                <hr>
                <div class="row mt-1">
                    <div class="col-lg-12 my-2" id="top-nav">
                        <div class="d-flex w-100 justify-content-between flex-column flex-md-row">
                            <div class="col-lg-5 d-flex flex-column flex-md-row gap-3 flex-start align-items-center">
                                <div class="mb-3 w-100">
                                    <label for="account-number" class="form-label fw-medium">Account Number</label>
                                    <div class="input-group account-number-field">
                                        <input type="text" class="form-control" id="account-number" value="{{ $client->user->account_number }}" readonly>
                                        <button class="btn btn-outline-secondary" type="button" id="copyBtn" title="Click the button to copy account number"><i class="bi bi-clipboard"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-lg-center align-items-center align-items-md-start">
                                <div class="btn-group" role="group" aria-label="Horizontal radio toggle button group">
                                    <input type="radio" class="btn-check" name="mode" id="view_mode" autocomplete="off" checked>
                                    <label class="btn btn-outline-primary" for="view_mode">View Mode</label>
                                    <input type="radio" class="btn-check" name="mode" id="edit_mode" autocomplete="off">
                                    <label class="btn btn-outline-success" for="edit_mode">Edit Mode</label>
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="col-lg-12">
                            <!-- Table -->
                            <form id="memberForm" action="{{ route('admin.update-repo', $client->id) }}" method="post">
                                @csrf
                                @method('PUT')                  
                                <div class="mt-3">
                                <input type="hidden" name="_method" value="PUT">
                                
                                <!-- Row 1 -->
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="lastName" class="fw-medium">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name', $client->last_name) }}" required maxlength="25">

                                    </div>
                                    <div class="col-lg-4">
                                        <label for="middle_name" class="fw-medium">Middle Name</label>
                                        <input type="text" class="form-control" name="middle_name" id="middle_name" value="{{ old('middle_name', $client->middle_name) }}" required maxlength="25">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="first_name" class="fw-medium">First Name</label>
                                        <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name', $client->first_name) }}" required maxlength="25">
                                    </div>
                                </div>
                                
                                <!-- Row 2 -->
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="birth_date" class="fw-medium">Date of Birth</label>
                                        <input type="date" class="form-control" name="birth_date" id="birth_date" value="{{ old('birth_date', $client->birth_date->format('Y-m-d')) }}" disabled required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="birth_place" class="fw-medium">Place of Birth</label>
                                        <input type="text" class="form-control" name="birth_place" id="birth_place" value="{{ old('birth_place', $client->birth_place) }}" disabled required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="phone_number" class="fw-medium">Phone Number</label>
                                        <div class="input-group w-100">
                                            <span class="input-group-text">+63</span>
                                            <input type="number" class="form-control" name="phone_number" id="phone_num" value="{{ old('phone_numer', $client->phone_number) }}" oninput="if(this.value.length > 11) { this.value = this.value.slice(0,11); }" disabled required>
                                        </div>
                                    </div>

                                    
                                    
                                </div>
                                
                                <!-- Row 3 -->
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="civil_status" class="fw-medium">Civil Status</label>
                                        <select class="form-control" name="civil_status" id="civil_status" disabled required>
                                            <option value="" {{ $client->civil_status == '' ? 'selected' : '' }}>Select one</option>  
                                            <option value="Single" {{ $client->civil_status == 'Single' ? 'selected' : '' }}>Single</option>
                                            <option value="Married" {{ $client->civil_status == 'Married' ? 'selected' : '' }}>Married</option>
                                            <option value="Divorced" {{ $client->civil_status == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                            <option value="Widowed" {{ $client->civil_status == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="spouse_name" class="fw-medium">Name of Spouse</label>
                                        <input type="text" class="form-control" name="spouse_name" id="spouse_name" value="{{ old('spouse_name', $client->spouse_name) }}" disabled required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="citizenship" class="fw-medium">Citizenship</label>
                                        <input type="text" class="form-control" name="citizenship" id="citizenship" value="{{ old('citizenship', $client->citizenship) }}" disabled required>
                                    </div>
                                    
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="city_address" class="fw-medium">City Address</label>
                                        <input type="text" class="form-control" name="city_address" id="city_address" value="{{ old('city_address', $client->city_address) }}" disabled required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="provincial_address" class="fw-medium">Provincial Address</label>
                                        <input type="text" class="form-control" name="provincial_address" id="provincial_address" value="{{ old('provincial_address', $client->provincial_address) }}" disabled required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="mailing_address" class="fw-medium">Home Address</label>
                                        <input type="text" class="form-control" name="mailing_address" id="mailing_address" value="{{ old('mailing_address', $client->mailing_address) }}" disabled required>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="position" class="fw-medium">Work Position</label>
                                        <input type="text" class="form-control" name="position" id="position" value="{{ old('position', $client->position) }}" disabled>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <label for="date_employed" class="fw-medium">Date of Employment</label>
                                        <input type="date" class="form-control" name="date_employed" id="date_employed" value="{{ old('date_employed', $client->date_employed->format('Y-m-d')) }}" disabled>
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="natureOf_work" class="fw-medium">Nature of Work</label>
                                        <select class="form-control" name="natureOf_work" id="natureOf_work" disabled>
                                            <option value="Teaching" {{ $client->nature_of_work == 'Teaching' ? 'selected' : '' }} >Teaching</option>
                                            <option value="Non-Teaching"{{ $client->nature_of_work == 'Non-Teaching' ? 'selected' : '' }} >Non-Teaching</option>
                                            <option value="Others" {{ $client->nature_of_work == 'Others' ? 'selected' : '' }} >Others</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="tax_id_number" class="fw-medium">Tax ID Number</label>
                                        <input type="text" class="form-control" name="tax_id_number" id="taxID_num" oninput="if(this.value.length > 12) { alert('Tax ID number cannot exceed 12 digits.'); this.value = this.value.slice(0,12); }" value="{{ old('taxID_num', $client->tax_id_number) }}" disabled>
                                    </div>
                                        
                                    <div class="col-lg-4">
                                        <label for="account_status" class="fw-medium">Account Status</label>
                                        <select class="form-control" name="account_status" id="account_status" disabled>
                                            <option value="Active" {{ $client->account_status == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Non-Active" {{ $client->account_status == 'Non-Active' ? 'selected' : '' }}>Not Active</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="amountOf_share" class="fw-medium">Amount of shares</label>
                                        <input type="text" class="form-control" name="amountOf_share" id="amountOf_share" value="{{ $client->amount_of_share }}" disabled>
                                        <input type="hidden" class="form-control d-none" name="amountOf_share" id="amountOf_share" value="{{ $client->amount_of_share }}">
                                    </div>
                                </div>
                                <button class="btn btn-success mt-3 btn-submit" id="toast-submit" type="button" data-bs-toggle="modal" data-bs-target="#confirmationSaveModal" style="float: right;">Save Details</button>
                                
                                <div class="modal fade" id="confirmationSaveModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure do you want to save this?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary" id="confirmSubmit" >Confirm</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- /Table -->
                            <button class="btn btn-danger mt-3 btn-submit" id="toast-submit" type="button" data-bs-toggle="modal" data-bs-target="#reset_password" style="float: left;">Reset Password</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="reset_password" tabindex="-1" aria-labelledby="resetLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="resetLabel">Reset Password</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="">
            <form action="{{ route('admin.reset-password', $client->id) }}" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" name="_method" value="PUT">
                <div class="mb-3">
                    <label for="emailOption" class="fw-medium">Email Option</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="emailOption" id="currentEmail" value="current" checked>
                        <label class="form-check-label" for="currentEmail">
                            Use Current Email
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="emailOption" id="newEmail" value="new">
                        <label class="form-check-label" for="newEmail">
                            Use New Email
                        </label>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="email" class="form-label email_label fw-medium" style="display: none;">Email</label>
                            <input type="email" class="form-control mb-3" name="email" id="email" style="display: none;" placeholder="Enter email">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="confirmemail" class="form-label email_label fw-medium" style="display: none;">Confirm Email</label>
                            <input type="email" class="form-control mb-3" name="confirm_email" id="confirm_email" style="display: none;" placeholder="Enter email">
                        </div>
                    </div>
                </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-success modal-reset-password" id="toast-submit" type="submit" style="float: right;">Reset Password</button>
        </div>
        </form>
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
    function toggleFormFields(disabled) {
        $('#memberForm input, #memberForm select').not('#amountOf_share').prop('disabled', disabled);
    }
    
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

    $('#citizenship').on('input', function() {
        var maxLengthCitizenship = 50;
        if ($(this).val().length > maxLengthCitizenship) {
            $(this).val($(this).val().substring(0, maxLengthCitizenship));
            toastr.error('Citizenship should not exceed 50 characters.');
        }
    });

    
    $('#birth_place').on('input', function() {
        var maxLengthBirthPlace = 45;
        if ($(this).val().length > maxLengthBirthPlace) {
            $(this).val($(this).val().substring(0, maxLengthBirthPlace));
            toastr.error('Birth place should not exceed 45 characters.');
        }
    });
    $('#taxID_num').on('input', function() {
        var maxLengthTaxID = 12;
        if ($(this).val().length > maxLengthTaxID) {
            $(this).val($(this).val().substring(0, maxLengthTaxID));
            toastr.error('Tax ID number should not exceed 12 characters.');
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

    $('input[type="number"]').on('input', function() {
        var noCharactersAllowed = ['#phone_number', '#taxID_num'];

        if (noCharactersAllowed.includes('#' + $(this).attr('id'))) {
            var originalValue = $(this).val();
            var filteredValue = originalValue.replace(/[^0-9]/g, ''); // Allow only numbers
            $(this).val(filteredValue);
            if (originalValue !== filteredValue) {
                toastr.error('Only numbers are allowed.');
            }
        }
    });

    $('#position').on('input', function() {
        var maxLength = 10;
        if ($(this).val().length > maxLength) {
            $(this).val($(this).val().substring(0, maxLength));
        }
    });

    $('#spouse_name').on('input', function() {
        var maxLengthSpouse = 45;
        var spouseNameValue = $('#spouse_name').val();
        if (spouseNameValue.length > maxLengthSpouse) {
            $('#spouse_name').val(spouseNameValue.substring(0, maxLengthSpouse));
            toastr.error('Spouse name should not exceed 45 characters.');
        }
    });
    $('#civil_status').change(function() {
        switch ($(this).val()) {
            case 'Single':
                $('#spouse_name').val('None');
                $('#spouse_name').attr('readonly', true);
                break;
            case 'Married':
            case 'Divorced':
            case 'Widowed':
                $('#spouse_name').val('');
                $('#spouse_name').attr('readonly', false);

                var spouseName = $('#spouse_name').val();
                var filteredSpouseName = spouseName.replace(/[^a-zA-Z\s]/g, '');
                $('#spouse_name').val(filteredSpouseName);
                if (spouseName !== filteredSpouseName) {
                    toastr.error('Numbers and special characters are not allowed.');
                } 

                
               
                break;
            default:
                $('#spouse_name').val('');
                $('#spouse_name').attr('readonly', true);
                break;
        }
    });


    // $('#toast-submit').on('click', function(e) {
    //     e.preventDefault();
    //     var allInputsFilled = true;
    //     $('input').each(function() {
    //         if ($(this).val() === '') {
    //             allInputsFilled = false;
    //             return false; // break out of the loop
    //         }
    //     });

    //     if (!allInputsFilled) {
    //         toastr.error('Please fill in all fields.');
    //         $('input').each(function() {
    //             if ($(this).val() === '') {
    //                 $(this).addClass('is-invalid');
    //             }
    //         });
    //         return;
    //     }
    //     $(this).prop('disabled', true);
    //     $(this).closest('form').submit();
    // });

    $('input[name="emailOption"]').change(function() {
        if ($(this).val() === 'current') {
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

    $('#copyBtn').click(function() {
        var copyText = $("#account-number").val();
        var tempInput = $('<input>'); 
        $('body').append(tempInput); 
        tempInput.val(copyText).select(); 
        document.execCommand("copy"); 
        tempInput.remove(); 
        toastr.success('Copied successfully');
    });
    $('input[name="mode"]').change(function() {
        if ($('#view_mode').is(':checked')) {
        toggleFormFields(true);
        $('.btn-submit').hide();
        } else if ($('#edit_mode').is(':checked')) {
        toggleFormFields(false);
        $('.btn-submit').show();
        }
    });
    
    if ($('#view_mode').is(':checked')) {
        toggleFormFields(true);
        $('.btn-submit').hide();
    } else if ($('#edit_mode').is(':checked')) {
        toggleFormFields(false);
        $('.btn-submit').show();
    }

});
</script>
@endsection
@endsection