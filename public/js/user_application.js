$(document).ready(function() {
    // Assuming $hasPendingLoan is a boolean variable passed to the Blade template
    var hasPendingLoan = @json($hasPendingLoan);

    // Function to check and apply conditions
    function checkAndApplyLoanTypeConditions() {
        var selectedLoanType = $('#loan_type').val();
        // Check if the selected loan type is "Regular" or "Regular w/ renewal" and there is a pending loan
        if ((selectedLoanType === 'Regular' || selectedLoanType === 'Regular renew') && hasPendingLoan) {
            // Hide and disable the select element
            // $('#loan_type').hide().prop('disabled', true);
            $('#applyButton').hide();
        } else {
            // Otherwise, make sure it's visible and enabled
            $('#loan_type').show().prop('disabled', false);
            $('#applyButton').show();
        }
    }

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
        }
    });

    document.getElementById('confirmSubmit').addEventListener('click', function() {
        document.getElementById('loanForm').submit();
    });
});

function validateForm() {
    let isValid = true;
    document.querySelectorAll('#loanForm input[required], #loanForm select[required]').forEach(function(input) {
        if (!input.value.trim()) {
            isValid = false; 
            input.classList.add('is-invalid'); 
        } else {
            input.classList.remove('is-invalid'); 
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