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
                <h1>Members Details</h1>
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.repositories') }}" class="text-decoration-none">Repositories</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit member</li>
                </ol>
                </nav>
                <div class="row mt-1">
                    <div class="row my-2" id="top-nav">
                        <div class="col-lg-12 d-flex flex-column flex-md-row gap-3 flex-start align-items-center">
                            <p class="mb-1">Account Number</p>
                            <!-- Auto generated -->
                            <div class="d-flex justify-content-between">
                                <div id="acc-number" class="p-1 ps-3 d-flex align-items-center">{{ $user->user->account_number }}
                                    <button class="btn" onclick="copyToClipboard('#acc-number')"><i class="bi bi-clipboard"></i></button>
                                </div>
                            </div>
                            
                        </div>

                        <div class="col-lg-12">
                            <!-- Table -->
                            <form id="memberForm" action="{{ route('admin.update-repo', $user->id) }}" method="post">
                                @csrf
                                @method('PUT')                  
                                <div class="mt-3">
                                <input type="hidden" name="_method" value="PUT">
                                
                                <!-- Row 1 -->
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="lastName" class="fw-medium">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}" required maxlength="15">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="middle_name" class="fw-medium">Middle Name</label>
                                        <input type="text" class="form-control" name="middle_name" id="middle_name" value="{{ old('middle_name', $user->middle_name) }}" required maxlength="15">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="first_name" class="fw-medium">First Name</label>
                                        <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" required maxlength="25">
                                    </div>
                                </div>
                                
                                <!-- Row 2 -->
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="birth_date" class="fw-medium">Date of Birth</label>
                                        <input type="date" class="form-control" name="birth_date" id="birth_date" value="{{ $user->birth_date->format('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="birth_place" class="fw-medium">Place of Birth</label>
                                        <input type="text" class="form-control" name="birth_place" id="birth_place" value="{{ $user->birth_place }}" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="phone_num" class="fw-medium">Phone Number</label>
                                        <input type="number" class="form-control" name="phone_num" id="phone_num" value="{{ $user->phone_number }}" oninput="if(this.value.length > 11) { alert('Phone number cannot exceed 11 digits.'); this.value = this.value.slice(0,11); }" required>
                                    </div>

                                    
                                    
                                </div>
                                
                                <!-- Row 3 -->
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="civil_status" class="fw-medium">Civil Status</label>
                                        <select class="form-control" name="civil_status" id="civil_status">
                                            <option value="" {{ $user->civil_status == '' ? 'selected' : '' }}>Select one</option>  
                                            <option value="Single" {{ $user->civil_status == 'Single' ? 'selected' : '' }}>Single</option>
                                            <option value="Married" {{ $user->civil_status == 'Married' ? 'selected' : '' }}>Married</option>
                                            <option value="Divorced" {{ $user->civil_status == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                            <option value="Widowed" {{ $user->civil_status == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="spouse_name" class="fw-medium">Name of Spouse</label>
                                        <input type="text" class="form-control" name="spouse_name" id="spouse_name" value="{{ $user->spouse_name }}" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="citizenship" class="fw-medium">Citizenship</label>
                                        <input type="text" class="form-control" name="citizenship" id="citizenship" value="{{ $user->citizenship }}" required>
                                    </div>
                                    
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="city_address" class="fw-medium">City Address</label>
                                        <input type="text" class="form-control" name="city_address" id="city_address" value="{{ $user->city_address }}" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="provincial_address" class="fw-medium">Provincial Address</label>
                                        <input type="text" class="form-control" name="provincial_address" id="provincial_address" value="{{ $user->provincial_address }}" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="mailing_address" class="fw-medium">Mailing Address</label>
                                        <input type="text" class="form-control" name="mailing_address" id="mailing_address" value="{{ $user->mailing_address }}" required>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="position" class="fw-medium">Work Position</label>
                                        <input type="text" class="form-control" name="position" id="position" value="{{ $user->position }}" required>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <label for="date_employed" class="fw-medium">Date of Employment</label>
                                        <input type="date" class="form-control" name="date_employed" id="date_employed" value="{{ $user->date_employed->format('Y-m-d') }}" required>
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="natureOf_work" class="fw-medium">Nature of Work</label>
                                        <select class="form-control" name="natureOf_work" id="natureOf_work" required>
                                            <option value="Teaching" {{ $user->nature_of_work == 'Teaching' ? 'selected' : '' }} >Teaching</option>
                                            <option value="Non-Teaching"{{ $user->nature_of_work == 'Non-Teaching' ? 'selected' : '' }} >Non-Teaching</option>
                                            <option value="Others" {{ $user->nature_of_work == 'Others' ? 'selected' : '' }} >Others</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="taxID_num" class="fw-medium">Tax ID Number</label>
                                        <input type="text" class="form-control" name="taxID_num" id="taxID_num" value="{{ $user->tax_id_number }}" required>
                                    </div>
                                        
                                    <div class="col-lg-4">
                                        <label for="account_status" class="fw-medium">Account Status</label>
                                        <select class="form-control" name="account_status" id="account_status" required>
                                            <option value="Active" {{ $user->account_status == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Non-Active" {{ $user->account_status == 'Non-Active' ? 'selected' : '' }}>Not Active</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="amountOf_share" class="fw-medium">Amount of shares</label>
                                        <input type="text" class="form-control" name="amountOf_share" id="amountOf_share" value="{{ $user->amount_of_share }}" disabled>
                                    </div>
                                </div>
                                <button class="btn btn-success btn-lg mt-3" id="toast-submit" type="submit" style="float: right;">Save</button>
                            </form>
                            <!-- /Table -->
                        </div>
                    

                        <!-- Toaster -->
                        <div class="toast-container position-fixed bottom-0 end-0 p-3">
                            <div id="clipboard" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header">
                                <span class="rounded bg-success px-1 me-2"><i class="bi bi-check2 text-success"></i></span>
                                <strong class="me-auto">Clipboard</strong>
                                <small id="timestamp"></small>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                Copied successfully
                                </div>
                            </div>
                        </div>
                        <!-- /Toaster -->

                        <!-- Toaster -->
                        <div class="toast-container position-fixed bottom-0 end-0 p-3">
                            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header">
                                <span class="rounded bg-success px-1 me-2"><i class="bi bi-check2 text-success"></i></span>
                                <strong class="me-auto">Form</strong>
                                <small id="timestamp"></small>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                Entry has been successfully recorded
                                </div>
                            </div>
                        </div>
                        <!-- /Toaster -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
<script>
$(document).ready(function() {
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



    $('#civil_status').on('change', function() {
        if ($(this).val() === 'Single') {
            $('#spouse_name').val('None');
        } else {
            $('#spouse_name').val('');
        }
    });

    $('#position').on('input', function() {
        var maxLength = 10;
        if ($(this).val().length > maxLength) {
            $(this).val($(this).val().substring(0, maxLength));
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


    $('#toast-submit').on('click', function(e) {
        e.preventDefault();
        var allInputsFilled = true;
        $('input').each(function() {
            if ($(this).val() === '') {
                allInputsFilled = false;
                return false; // break out of the loop
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
    });
});
</script>
@endsection
@endsection