@extends('layouts.app')
@section('title', 'Loan')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/member/dashboard.css') }}">
@endsection
@section('content')
<div class="page-content-wrapper" >
    <input type="hidden" id="hasPendingLoan" value="{{ json_encode($hasPendingLoan) }}">
    <input type="hidden" id="hasUnpaidLoan" value="{{ json_encode($hasUnpaidLoan) }}">
    <div class="container-fluid xyz">
        <div class="row py-md-4 d-flex align-items-center">
            <div class="col-lg-12">
              <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('member.loan') }}" class="text-decoration-none">Loan</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Application</li>
                </ol>
              </nav>
              
              <h1 id="user-greet">Application for loan</h1>
              <div class="card p-3 bg-info-subtle">
                    <div class="">
                        <span>Please fill up the form below to apply a loan</span>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-lg-12">
            <form id="loanForm" action="{{ route('member.loan.request') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('POST')                    
                <div class=" mt-3">
                            <!-- Row 1 -->
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label for="name" class="fw-medium">Name</label>  
                                     <input type="text" class="form-control" name="customer_name" id="name" value="{{ $client->first_name }} {{ $client->middle_name }} {{ $client->last_name }}" required readonly>
                                </div>
                                
                                <div class="col-lg-4">
                                    <label for="college" class="fw-medium">College/Dept</label>  
                                    <input type="text" class="form-control" name="college" id="college" placeholder="College/Dept" value="{{ $client->department }}" required>
                                </div>
                                <div class="col-lg-4">
                                    <label for="contact" class="fw-medium">Contact No.</label>
                                    <div class="input-group">
                                        <span class="input-group-text">+63</span>
                                        <input type="number" class="form-control" name="contact" id="contact" placeholder="Contact No." value="{{ $client->phone_number }}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 2 -->
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label for="dob" class="fw-medium">Date of Birth</label>
                                    <input type="date" class="form-control" name="birth_date" id="birth_date" placeholder="Date of Birth" value="{{ $client->birth_date->format('Y-m-d') }}" required readonly>
                                </div>
                                <div class="col-lg-4">
                                    <label for="taxID_num" class="fw-medium">Tax Identification Number</label>
                                    <input type="text" class="form-control" name="taxid_num" id="taxid_num" value="{{ $client->tax_id_number }}" required>
                                </div>
                                <div class="col-lg-4">
                                    <label for="age" class="fw-medium">Age</label>
                                    <input type="number" class="form-control" name="age" id="age" placeholder="Age" min="1" value="{{ $client->age }}" required readonly>
                                </div>
                            </div>
                            
                            <!-- Row 3 -->
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label for="date_employed" class="fw-medium">Date of Employed</label>  
                                    <input type="date" class="form-control" name="date_employed" id="date_employed" placeholder="Date of Employed" value="{{ $client->date_employed->format('Y-m-d') }}" readonly required>
                                </div>
                                <div class="col-lg-4">
                                    <label for="retirement_year" class="fw-medium">Year of Retirement</label>  
                                    <input type="number" class="form-control" name="retirement_year" id="retirement_year" min="0" placeholder="Year of Retirement" value="{{ $client->retirement_date }}" required readonly>
                                </div>
                                <div class="col-lg-4">
                                    <label for="position" class="fw-medium">Work Position</label>  
                                    <input type="text" class="form-control" name="position" id="position" placeholder="Work Position" value="{{ $client->position }}" required>
                                </div>
                            </div>
                            
                            <!-- Row 4 -->
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label for="loan_type" class="fw-medium">Loan Type</label>
                                    <select class="form-control" id="loan_type" name="loan_type">
                                        <option value="Regular" selected>Regular</option>
                                        <option value="Regular renew">Regular w/ renewal</option>
                                        <option value="Providential">Providential</option>
                                        <option value="Providential renew">Providential w/ renewal</option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label for="application_date" class="fw-medium">Date of Application</label>  
                                    <input type="date" class="form-control" name="application_date" id="application_date" placeholder="Date of Application" value="{{ date('Y-m-d') }}" readonly required>
                                    
                                </div>
                                <div class="col-lg-4">
                                    <label for="loan_term_Type" class="fw-medium">Loan term Type</label>  
                                    <select class="form-control" id="loan_term_Type" name="loan_term_Type">
                                        <option value="">Select loan type</option>  
                                        <option value="month/s">Months</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Row 5 -->
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label for="time_pay" class="fw-medium">Loan Term</label>  
                                    <input type="number" class="form-control" name="time_pay" id="time_pay" id="time_pay" placeholder="Loan Term" min="1" oninput="calculateInterest()" disabled required>
                                </div>
                                <div class="col-lg-4">
                                    <label for="amount_before" class="fw-medium">Loan Amount</label>  
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" name="amount_before" id="specific_amount" placeholder="Specific Loan Amount" oninput="validateAndCalculateInterest();" max="{{ $client->amount_of_share * 2 }}" required>
                                    </div>
                                    <input type="hidden" name="" id="share-holdings" value="{{ $client->amount_of_share }}">
                                    <small class="float-end">Current share holdings: ₱{{ $client->amount_of_share }}</small>
                                </div>
                                <div class="col-lg-4">
                                    <label for="amount_after" class="fw-medium">Amount to be disbursed</label>
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="Amount to be given">
                                        <i class="bi bi-info-circle"></i>
                                    </span>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control fw-medium" name="amount_after" id="amount_after" oninput="calculateInterest()" readonly required>
                                    </div>
                                    <input type="hidden" name="hidden_share" value="" id="input_share">
                                    <div class="float-end" >
                                        <small class="d-none" id="estimate_text">Estimate new share holding: ₱<span class="estimate_share"></span></small>
                                    </div>
                                    <input type="hidden" name="monthly_pay" class="monthly_pay">
                                </div>
                            </div>
                    <div class="col-lg-12">
                      <br>
                      <h4 >Terms and agreement</h4>
                      <p>I hereby authorize the NEUST Community Credit Cooperative/NEUST Cashier to deduct
                        the monthly amortization of my loan from my pay slip. 
                        I AGREE THAT ANY LATE PAYMENT
                        WILL BE SUBJECTED TO A PENALTY OF 3% PER MONTH OF DELAY. Furthermore, default in
                        payments for three (3) months will be ground for the coop to take this matter into court and the
                        balance should be due and demandable.</p>
                        
                          <label for="signature" class="mb-2 fw-medium">Upload picture of signature (3 signatures)</label>  
                          <input type="file" class="form-control" name="signature" accept="image/jpeg, image/png, image/jpg" id="signature" required>
                        <br>
                          <label for="homepay_receipt" class="mb-2 fw-medium">Upload picture of take home pay receipt</label>
                          <input type="file" class="form-control" name="homepay_receipt"  accept="image/jpeg, image/png, image/jpg" id="homepay_receipt" required>
                        <br>
                        <button type="button" class="btn btn-primary" style="float: right;" id="applyButton" >Apply</button>
                    </div>
                </div>
                <div class="modal fade" id="confirmationModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationModalLabel">Confirm Application</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12 d-flex justify-content-between">
                                            <p>Financed Amount</p> <p>Php <span id="loan_amount"></span></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 d-flex justify-content-between">
                                            <p>Amount to be disbursed</p> <p>Php <span id="loan_amount_disbursed"></span></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 d-flex justify-content-between">
                                            <p>Term</p> <p><span id="term"></span></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 d-flex justify-content-between">
                                            <p>Monthly Installment</p> <p>Php <span id="monthly_pay"></span></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 d-flex justify-content-between">
                                            <p>Amount Shares</p>
                                            <div class="d-flex" style="font-size: 15px;">
                                                <p>Php {{ number_format($client->amount_of_share, 2) }}</p>
                                                <small class="text-success">+</small>
                                                <small class="text-success" id="cbu_share"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" id="confirmSubmit">Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
          </div>
      </div>
    </div>
    
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        @if (session('status'))
            toastr.success('{{ session('status') }}');
        @elseif (session('error'))
            toastr.error('{{ session('error') }}');
        @endif
    var hasPendingLoan = JSON.parse($('#hasPendingLoan').val());
    var hasUnpaidLoan = JSON.parse($('#hasUnpaidLoan').val());
    console.log(hasUnpaidLoan);
    function checkAndApplyLoanTypeConditions() {
        var selectedLoanType = $('#loan_type').val();
        if ((selectedLoanType === 'Regular' || selectedLoanType === 'Regular renew') && hasPendingLoan) {
            $('#applyButton').hide();
        } else if ((selectedLoanType === 'Regular' || selectedLoanType === 'Regular renew') && hasUnpaidLoan) {
            $('#applyButton').hide();
        } else {
            // Otherwise, make sure it's visible and enabled
            $('#loan_type').show().prop('disabled', false);
            $('#applyButton').show();
        }
    }

    $('#taxID_num').on('input', function() {
    var taxId = $(this).val();
    if(taxId.length > 12) {
        $(this).val(taxId.substring(0, 12));
    }
    });

    $('input[type="text"]').on('input', function() {
        var noNumbersOrSpecialCharsAllowed = ['#position', '#college'];

        if (noNumbersOrSpecialCharsAllowed.includes('#' + $(this).attr('id'))) {
            var originalValue = $(this).val();
            var filteredValue = originalValue.replace(/[^a-zA-Z\s]/g, ''); // Allow only letters and spaces
            if (originalValue !== filteredValue) {
                $(this).val(filteredValue);
                toastr.error('Numbers and special characters are not allowed.');
            }
        }
    });

    $('form').submit(function(e) {
        var fileInputSignature = $('#signature');
        var fileInputHomepay = $('#homepay_receipt');
        if ((fileInputSignature.length && fileInputHomepay.length) && fileInputSignature[0].files[0].size > 8388608) { // 8MB in bytes
            e.preventDefault();
            toastr.error('File size should be less than 8MB.');
        }
    });

    $('#specific_amount').on('input', function() {
        var specificAmount = $(this).val();
        var filteredAmount = specificAmount.replace(/[^0-9]/g, ''); // Remove any non-numeric characters
        if (filteredAmount < 1) {
            $(this).val('');
            toastr.error('Loan amount cannot be negative or contain special characters.');
        } else {
            $(this).val(filteredAmount); // Set the cleaned numeric value back to the input
        }
    });

    $('#time_pay').on('input', function() {
        var timePay = $(this).val();
        if (timePay < 1 || timePay > 150) {
            $(this).val('');
            toastr.error('Loan term must be between 1 and 150 months.');
        }
    });

    $('#contact').on('input', function() {
        var phoneNum = $(this).val();
        if (phoneNum < 0) {
            $(this).val('');
            toastr.error('Phone number cannot be a negative value.');
        } 
    });

    // Initial check when the page loads
    checkAndApplyLoanTypeConditions();

    // Re-check whenever the loan type changes
    $('#loan_type').change(checkAndApplyLoanTypeConditions);
});
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('loan_term_Type').onchange = function() {
        var loanTermField = document.getElementById('time_pay');
        loanTermField.disabled = this.value === "" ? true : false;
        if (!loanTermField.disabled) {
            loanTermField.oninput = calculateInterest;
        }
        calculateInterest();
    };
    $('[data-bs-toggle="tooltip"]').tooltip();
    $('form').on('focus', 'input[type=number]', function(e) {
        $(this).on('wheel.disableScroll', function(e) {
            e.preventDefault();
        });
    });

    $('form').on('blur', 'input[type=number]', function(e) {
        $(this).off('wheel.disableScroll');
    });

    document.getElementById('specific_amount').oninput = function() {
        validateAndCalculateInterest();
    };

    document.querySelector('#applyButton').addEventListener('click', function(event) {
        event.preventDefault(); 

        if (validateForm()) { 
            calculateInterest();
            updateModalContent();
            // Manually show the modal using Bootstrap's JavaScript API
            var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            confirmationModal.show();
        } else {
            alert('Please correct the errors in the form before applying.');
            return false;
        }
    });

    document.getElementById('confirmSubmit').addEventListener('click', function() {
        document.getElementById('loanForm').submit();
    });
});

function validateForm() {
    let isValid = true;
    const requiredFields = document.querySelectorAll('#loanForm [required]');

    document.querySelectorAll('#loanForm input[required], #loanForm select[required]').forEach(function(input) {
        if (!input.value.trim()) {
            isValid = false; 
            input.classList.add('is-invalid'); 
        } else {
            input.classList.remove('is-invalid'); 
        }
    });
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            isValid = false;
            field.classList.add('is-invalid'); // Add Bootstrap's is-invalid class to show validation error
        } else {
            field.classList.remove('is-invalid');
        }
    });

    const specificAmountInput = document.getElementById('specific_amount');
    const maxAmount = parseFloat(specificAmountInput.max);
    let specificAmount = parseFloat(specificAmountInput.value.replace(/,/g, ''));
    if (specificAmount > maxAmount) {
        alert('The loan amount exceeds the maximum allowed.');
        specificAmountInput.classList.add('is-invalid');
        isValid = false;
    }

    return isValid; 
}

function validateAndCalculateInterest() {
    const specificAmountInput = document.getElementById('specific_amount');
    const maxAmount = parseFloat(specificAmountInput.max);
    let specificAmount = parseFloat(specificAmountInput.value.replace(/,/g, ''));

    if (specificAmount > maxAmount) {
        alert('The loan amount exceeds the maximum allowed. It has been reset to the maximum.');
        specificAmountInput.value = maxAmount.toLocaleString();
    }

    calculateInterest();
}

function calculateInterest() {
    const principalInput = $('#specific_amount').val().replace(/,/g, '');
    const principal = parseFloat(principalInput);
    const interestRatePerMonth = 0.01; // 1% per month
    const cbu = 0.05 * principal; // Capital Build-Up is 5% of principal
    const incrementShare = principal - cbu;
    const loanable = principal - cbu; 
    const tTime = parseFloat($('#time_pay').val()); // Term in months
    const term = tTime * interestRatePerMonth;

    if (!isNaN(principal) && !isNaN(tTime) && tTime > 0) {
        const interest = principal * term; // Total interest
        const totalAmount = loanable + interest; // Total amount to be repaid
        const monthlyPayment = totalAmount / tTime; // Monthly salary deduction

        // Calculate new share holding
        const currentShares = parseFloat($('#share-holdings').val());
        const newShareHolding = currentShares + cbu; // New share holding after adding CBU

        $('#amount_after').val(loanable.toFixed(2));
        $('#monthly_pay').text(new Intl.NumberFormat('en-US', {style: 'decimal'}).format(monthlyPayment));
        $('#input_share').val(cbu.toFixed(2));
        $('.monthly_pay').val(monthlyPayment.toFixed(2));
        $('.estimate_share').text(newShareHolding.toLocaleString('en-US', {style: 'decimal'}));
        $('#cbu_share').text(cbu.toLocaleString('en-US', {style: 'decimal', maximumFractionDigits: 2}));
        $('#estimate_text').removeClass('d-none');
    } else {
        $('#amount_after').val('');
        $('#monthly_pay').text('');
        $('#estimate_share').text('');
    }
}

function updateModalContent() {
    const principal = parseFloat($('#specific_amount').val().replace(/,/g, ''));
    const totalAmount = parseFloat($('#amount_after').val().replace(/,/g, ''));
    const tTime = parseFloat($('#time_pay').val());
    const monthlyPayment = totalAmount / tTime;

    $('#loan_amount').text(new Intl.NumberFormat('en-US', {style: 'decimal'}).format(principal));
    $('#loan_amount_disbursed').text(new Intl.NumberFormat('en-US', {style: 'decimal'}).format(totalAmount));
    $('#term').text(`${tTime} ${tTime > 1 ? 'Months' : 'Month'}`);
    $('#monthly_pay').text(new Intl.NumberFormat('en-US', {style: 'decimal'}).format(monthlyPayment));
}
</script>
@endsection

