@extends('layouts.app')
@section('title', 'Loan Payment')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/payment/edit.css') }}">
@endsection
@section('content')
<div id="page-content-wrapper">
    <div class="container-fluid xyz">
        <div class="row">
        <div class="col-lg-12">
            <h1>
            Members Details
            </h1>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.payment') }}" class="text-decoration-none">Payment Repositories</a></li>
                <li class="breadcrumb-item active" aria-current="page">Member Payment</li>
            </ol>
            </nav>
            <div class="row" style="margin-top: 2em;">
                <div class="my-2">
                    @if(session('message'))
                    <div class="alert alert-success" role="alert" id="success-alert">
                      {{ session('message') }}
                    </div>
                  @elseif($errors->any())
                    <div class="alert alert-danger" role="alert" id="error-alert">
                      @foreach($errors->all() as $error)
                        {{ $error }}<br>
                      @endforeach
                    </div>
                  @endif
                  </div>
            <div class="col-lg-4" id="acc-nav">
                <p>Account Number</p>
                <!-- Auto generated -->
                <p class="mb-0" id="acc-number">
                    <span>{{ $client->user->account_number }}</span>
                    <button class="btn" onclick="copyToClipboard('#acc-number')"><i class="bi bi-clipboard"></i></button>
                </p>
            </div>

            <!-- Table Loan -->
            <div class="d-flex justify-content-between">
                <h2 class="my-2">Trails</h2>
                <div class="d-flex">
                    <button class="btn btn-primary float-end mb-3" onclick="printTable()"><i class="bi bi-printer"></i>&nbsp;Print Table </button>
                    <button class="btn btn-success float-end mx-2 mb-3" onclick="exportTableToExcel('{{ $client->last_name . '_' . $client->first_name }}')"><i class="bi bi-card-text"></i>&nbsp;Export to Excel</button>
                </div>
            </div>
            
            <div class="table-wrapper" id="table-container">
                <table id="loan_trails" class="table table-hover table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" class="fw-semibold">Reference number</th>
                            <th scope="col" class="fw-semibold">Customer name</th>
                            <th scope="col" class="fw-semibold">Loan type</th>
                            <th scope="col" class="fw-semibold">Date of applying</th>
                            <th scope="col" class="fw-semibold">Loan Amount</th>
                            <th scope="col" class="fw-semibold">Amount disbursed</th>
                            <th scope="col" class="fw-semibold">Balance</th>
                            <th scope="col" class="fw-semibold">Monthly Installment</th>
                            <th scope="col" class="fw-semibold">Application status</th>
                            <th scope="col" class="fw-semibold">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loans as $loan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $loan->loan_reference }}</td>
                            <td>{{ $loan->customer_name }}</td>
                            <td>{{ $loan->loan_type }}</td>
                            <td>{{ \Carbon\Carbon::parse($loan->application_date)->format('m/d/Y') }}</td>
                            <td>{{ $loan->financed_amount }}</td>
                            <td>{{ $loan->finance_charge }}</td>
                            <td>{{ $loan->balance }}</td>
                            <td>{{ $loan->monthly_pay }}</td>
                            <td>{{ ucfirst($loan->application_status) }}</td>
                            <td>{{ ucfirst($loan->remarks) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination Links -->
            {{-- <div>
                {{ $loans->appends(request()->except('page'))->links() }}
            </div> --}}
            <!-- /Table Loan -->
            
            <!-- Table -->
            <form action="{{ route('admin.payment.store') }}" method="post" id="payment-form">              
                @csrf
                @method('POST')    
            <div class="row my-3">
                <h2>Accounting</h2>
                    <p>Loan reference number:</p>
                    <div class="col-md-4 mb-3">
                        <input type="text" class="form-control" id="loanNo" name="loanNo">
                        <div class="w-auto my-2">
                        <label for="currentBalance">Current Overall Balance</label>
                        <input type="text" class="form-control" id="currentBalance" value="{{$client->balance}}" disabled readonly>
                            <input type="hidden" id="updated-balance" name="updatedBalance">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="row d-flex">
                            <div class="col-lg-6 mb-3">
                            <label for="loanBalance">Loan Balance</label>
                            <input type="text" class="form-control" id="loanBalance" value="" disabled readonly>
                            </div>
                            <div class="col-lg-6">
                            <label for="balance">Amount</label>
                            <input type="number" class="form-control" step="0.01" min="0" name="amount" id="amount" required>
                        </div>
                            
                        <div class="col-lg-6">
                            <label for="totalBalance">Total Loan Balance</label>
                            <input type="text" class="form-control" name="" id="totalBalance" readonly required>
                        </div>
                        <div class="col-lg-6">
                            <label for="note">Notes</label>
                            <input type="text" class="form-control" name="note" rows="3" id="note"></input>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="remarks">Loan Application Remarks</label>
                        <select class="form-control" name="" id="remarks" disabled>
                            <option value="Paid">Paid</option>
                            <option value="Unpaid" >Unpaid</option>
                        </select>
                    </div>
                    
                    <input type="hidden" name="remarks" id="remarks_hidden">
                    <button class="btn btn-success btn-lg" type="submit" style="float: right; margin-top: 10px;">Save</button>
                    </div>

                    <div class="modal fade" id="confirmationRejectModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure do you want to save this?</p>
                                    <p>This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" type="submit" class="btn btn-primary" id="confirmSubmit" onclick="document.getElementById('rejectForm').submit();">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <!-- /Table -->
            </div>
        </div>
    </div>
</div>
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script>
$(document).ready(function() {
    var loanNo = $('#loanNo').val();
    
    $("#payment-form").on("submit", function(event) {
        var isValid = true;
        $("#payment-form input[required]:not([readonly]), #payment-form textarea[required]").each(function() {
            var trimmedValue = $(this).val().trim();
            $(this).val(trimmedValue); // Set the trimmed value back to the input/textarea

            if (!trimmedValue) {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!isValid) {
            event.preventDefault();
            alert('Please fill in all required fields without leading or trailing spaces.');
            return false;
        } else {
            $('#confirmationRejectModal').modal('show');
            event.preventDefault(); 
        }
    });

    $("input, textarea").on("input", function() {
        var inputValue = $(this).val().trim();
        if (inputValue) {
            $(this).removeClass('is-invalid');
        }
    });

    $("#confirmSubmit").click(function() {
        $("#payment-form").off("submit").submit();
    });

    function fetchLoanDetails() {
        var userId = "{{ $client->id }}";
        var loanNo = $('#loanNo').val();

        $.ajax({
            url: `/admin/payment/edit/${userId}/${loanNo}`,
            type: 'GET',
            success: function(response) {
                if (response.error) {
                    console.error(response.error);
                    alert('Failed to fetch loan details.');
                    return;
                }
                $('#loanBalance').val(response.balance);
                $('#totalBalance').val(response.balance);
                $('#currentBalance').val(response.currentBalance);
                $('#amount').attr('max', response.balance);
                initializeBalances(parseFloat(response.balance), parseFloat(response.currentBalance));
                // Automatically set remarks based on total balance
                updateRemarksAutomatically(parseFloat(response.balance));
            },
            error: function(xhr, status, error) {
                console.error("Error fetching loan details:", error);
                alert('Error fetching loan details.');
            }
        });
    }

    function initializeBalances(maxBalance, originalCurrentBalance) {
        var amount = $("#amount");
        var totalBalance = $("#totalBalance");
        var currentBalance = $("#currentBalance");

        amount.attr('max', maxBalance);

        amount.on("input", function() {
            var amount = parseFloat($(this).val()) || 0;
            if (amount > maxBalance) {
                $(this).val(maxBalance.toFixed(2));
                alert("Amount cannot exceed the loan balance.");
                amount = maxBalance;
            }
            var updatedTotalBalance = maxBalance - amount;
            totalBalance.val(updatedTotalBalance.toFixed(2));

            var updatedCurrentBalance = originalCurrentBalance - amount;
            updatedCurrentBalance = Math.max(updatedCurrentBalance, 0);
            currentBalance.val(updatedCurrentBalance.toFixed(2));

            updateRemarksAutomatically(updatedTotalBalance);
        });
    }

    function updateRemarksAutomatically(totalBalance) {
        var remarksValue = totalBalance === 0 ? 'Paid' : 'Unpaid';
        $('#remarks').val(remarksValue);
        $('#remarks_hidden').val(remarksValue);
        $('#remarks').prop('disabled', true);
    }

    if (loanNo) {
        fetchLoanDetails();
    }

    $('#loanNo').change(function() {
        loanNo = $(this).val();
        fetchLoanDetails();
    });

    $("#payment-form").on("submit", function(event) {
        var balance = $("#amount");
        var amount = parseFloat(balance.val());
        var maxAmount = parseFloat(balance.attr('max')); 

        if (amount > maxAmount) {
            event.preventDefault();
            alert("Amount cannot exceed the loan balance.");
        }
    });

});
</script>
<script>
    function printTable() {
        var divToPrint = document.getElementById("loan_trails"); // replace with your table id
        newWin = window.open("");
        newWin.document.write(divToPrint.outerHTML);
        newWin.print();
        newWin.close();
    }
    function exportTableToExcel(fileName) {
    console.log("Exporting table to Excel with fileName:", fileName);
    var table = document.getElementById("loan_trails");
    if (!table) {
        console.error("Table #loan_trails not found.");
        return;
    }
    var workbook = XLSX.utils.table_to_book(table, {sheet: "Sheet JS"});
    XLSX.writeFile(workbook, fileName + '_loan_trails.xlsx');
}
</script>
@endsection
@endsection