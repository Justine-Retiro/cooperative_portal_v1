@extends('layouts.app')
@section('title', 'Edit Repository')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/payment/edit.css') }}">
    <style>
        #amount::-webkit-outer-spin-button,
        #amount::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        #amount[type=number] {
            -moz-appearance: textfield;
        }
    </style>
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
            <hr>
            <div class="row">
                
                @if(session()->has('message') || $errors->any())
                <div class="my-2">
                    @if(session()->has('message'))
                    <div class="alert alert-success" role="alert" id="success-alert">
                      {{ session('message') }}
                    </div>
                    @endif
                    @if($errors->any())
                    <div class="alert alert-danger" role="alert" id="error-alert">
                      @foreach($errors->all() as $error)
                        {{ $error }}<br>
                      @endforeach
                    </div>
                    @endif
                </div>
                @endif
            <div class="col-lg-12" id="acc-nav">
                <div class="w-100 d-flex justify-content-between">
                    <div class="mb-3">
                        <label for="account-number" class="form-label fw-medium">Account Number</label>
                        <div class="input-group account-number-field">
                            <input type="text" class="form-control" id="account-number" value="{{ $client->user->account_number }}" readonly>
                            <button class="btn btn-outline-secondary" type="button" id="copyBtn" title="Click the button to copy account number"><i class="bi bi-clipboard"></i></button>
                        </div>
                    </div>                                                                                                                                                                                               
                    <div class="mb-3">
                        <label for="statement" class="form-label fw-medium">Account Statement</label>
                        <div class="d-flex justify-content-between">
                            <div class="input-group statement-field me-2">
                                <button class="btn btn-outline-success" type="button" id="exportStatementBtn" title="Click the button to download statement" onclick="downloadStatement()"><i class="bi bi-file-earmark-arrow-down"></i>Download as PDF</button>
                            </div>
                            <div class="input-group statement-field">
                                <button class="btn btn-outline-secondary" type="button" id="printStatementBtn" title="Click the button to print statement"><i class="bi bi-printer"></i></button>
                            </div>
                            
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="d-flex justify-content-between p-3">
                        <h2 class="my-2">Loan Trails</h2>
                        <div class="d-flex my-1">
                            <button class="btn btn-primary float-end " onclick="printTable()"><i class="bi bi-printer"></i>&nbsp;Print Table </button>
                            <button class="btn btn-success float-end ms-2" onclick="exportTableToExcel('{{ $client->last_name . '_' . $client->first_name }}')"><i class="bi bi-card-text"></i>&nbsp;Export to Excel</button>
                        </div>
                    </div>
                    
                    <div class="table-wrapper px-0 mt-0" id="table-container">
                        <table id="loan_trails" class="table table-hover table-striped my-0">
                            <thead class="table-primary">
                                <tr class="border border-dark-subtle">
                                    <th class="fw-medium border border-dark-subtle">#</th>
                                    <th class="fw-medium border border-dark-subtle">Reference number</th>
                                    <th class="fw-medium border border-dark-subtle">Customer name</th>
                                    <th class="fw-medium border border-dark-subtle">Loan type</th>
                                    <th class="fw-medium border border-dark-subtle">Date of applying</th>
                                    <th class="fw-medium border border-dark-subtle">Loan Amount</th>
                                    <th class="fw-medium border border-dark-subtle">Amount disbursed</th>
                                    <th class="fw-medium border border-dark-subtle">Balance</th>
                                    <th class="fw-medium border border-dark-subtle">Monthly Installment</th>
                                    {{-- <th class="fw-medium">Due date</th> --}}
                                    <th class="fw-medium border border-dark-subtle">Application status</th>
                                    <th class="fw-medium border border-dark-subtle">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($loans as $loan)
                                <tr class="border border-dark">
                                    <td class="border border-dark-subtle">{{ $loop->iteration }}</td>
                                    <td class="border border-dark-subtle">{{ $loan->loan_reference }}</td>
                                    <td class="border border-dark-subtle">{{ $loan->customer_name }}</td>
                                    <td class="border border-dark-subtle">{{ $loan->loan_type }}</td>
                                    <td class="border border-dark-subtle">{{ \Carbon\Carbon::parse($loan->application_date)->format('m/d/Y') }}</td>
                                   
                                    <td class="border border-dark-subtle">{{ $loan->financed_amount }}</td>
                                    <td class="border border-dark-subtle">{{ $loan->finance_charge }}</td>
                                    <td class="border border-dark-subtle">{{ $loan->balance }}</td>
                                    <td class="border border-dark-subtle">{{ $loan->monthly_pay }}</td>
                                    {{-- <td class="border border-dark-subtle">{{ \Carbon\Carbon::parse($loan->due_date)->format('m/d/Y') }}</td> --}}
                                    <td class="border border-dark-subtle">{{ ucfirst($loan->application_status) }}</td>
                                    <td class="border border-dark-subtle">{{ ucfirst($loan->remarks) }}</td>
                                    {{-- <td class="border border-dark-subtle">
                                        <a href="{{ route('admin.payment.statement', ['loan_id' => $loan->id]) }}" class="btn btn-outline-primary" target="_blank"><i class="bi bi-eye"></i>&nbsp;View Statement</a>
                                    </td> --}}
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="11" class="text-center">No records available</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Table Loan -->
                {{-- <div>
                    {{ $loans->appends(request()->except('page'))->links() }}
                </div> --}}
                <!-- /Table Loan -->
                @if($user->is_from_signup && !$user->is_share_paid)
                    <div class="d-flex justify-content-end align-items-center mt-3">
                        <div class="btn-group" role="group" aria-label="Horizontal radio toggle button group">
                            <input type="radio" class="btn-check" name="mode" id="loan_payment" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="loan_payment">Loan Payment</label>
                            <input type="radio" class="btn-check" name="mode" id="share_payment" autocomplete="off">
                            <label class="btn btn-outline-success" for="share_payment">Share Payment</label>
                        </div>
                    </div>  
                
                    <!-- Table -->
                    <form action="{{ route('admin.payment.store') }}"  method="post" id="loan-payment-form">              
                        @csrf
                        @method('POST')                      
                        <div class="row my-3" id="loan-payment-form">
                            <h2>Loan Accounting</h2>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="loanNo" class="fw-medium">Enter Loan reference number</label>
                                        <input type="text" class="form-control" id="loanNo" name="loanNo">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="loanBalance" class="fw-medium">Remaining Loan Balance</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">₱</span>
                                            <input type="text" class="form-control" id="loanBalance" value="" disabled readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="currentAccountBalance" class="fw-medium">Current Account Balance</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">₱</span>
                                            <input type="text" class="form-control" id="currentAccountBalance" value="{{$client->balance}}" disabled readonly>
                                        </div>
                                        <input type="hidden" class="updatedAccountBalance">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        
                                        <label for="amount" class="fw-medium">Payment Amount</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">₱</span>
                                            <input type="number" class="form-control" step="0.01" min="0" name="amount" value="" id="amount" disabled required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="note" class="fw-medium">Payment Notes</label>
                                        <input type="text" class="form-control" name="note" rows="3" id="note"></input>
                                    </div>
                                </div>
                                <h4>Updated Balances</h4>
                                <div class="card p-2">
                                    <div class="row ">  
                                        <div class="col-lg-6">
                                            <label for="totalBalance" class="fw-medium">Loan Balance After Payment</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon1">₱</span>
                                                <input type="text" class="form-control" name="" id="totalBalance" value="" readonly required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="updatedAccountBalance" class="fw-medium">Account Balance After Payment</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon1">₱</span>
                                                <input type="text" class="form-control updatedAccountBalance" name="updatedAccountBalance" id="updatedAccountBalanceId" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-lg-6">
                                        <label for="remarks" class="fw-medium">Status of Loan Application Remarks</label>
                                        <select class="form-control" name="" id="remarks" disabled>
                                            <option value="Paid">Paid</option>
                                            <option value="Unpaid" >Unpaid</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="remarks" class="fw-medium">Status of Account Remarks</label>
                                        <select class="form-control" name="" id="remarksAccount" disabled>
                                            <option value="Paid">Paid</option>
                                            <option value="Unpaid" >Unpaid</option>
                                        </select>
                                    </div>
                                </div>
                            
                                <input type="hidden" name="remarks" id="remarks_hidden">
                                <input type="hidden" name="remarksAccount" id="remarksAccount_hidden">
                                <button type="button" id="loan-payment-btn" class="btn btn-success btn-lg" style="float: right; margin-top: 10px;" data-bs-toggle="modal" data-bs-target="#confirmationLoanModal" disabled>Save</button>
                            </div>

                            <div class="modal fade" id="confirmationLoanModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="confirmationModalLabel" aria-hidden="true">
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
                                            <button type="submit" class="btn btn-primary" id="confirmSubmit" >Confirm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <span>{{ $error }}</span>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </form>
                    <form action="{{ route('admin.payment.storeshare', ['user_id' => $client->user->id]) }}" method="post" id="share-payment-form">
                        @csrf
                        @method('POST')    
                        <div class="row my-3" id="loan-payment-form">
                            <h2>Share Holding Accounting</h2>
                            <div class="col-lg-12">
                                <div class="row">
                                    {{-- <div class="col-md-4 mb-3">
                                        <label for="loanNo" class="fw-medium">Enter Loan reference number</label>
                                        <input type="text" class="form-control" id="loanNo" name="loanNo">
                                    </div> --}}
                                    <div class="col-md-4 mb-3">
                                        <label for="shareBalance" class="fw-medium">Remaining Share Balance</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">₱</span>
                                            <input type="text" class="form-control" id="shareBalance" value="{{ $client->memberApplication->balance }}" disabled readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="currentAccountBalance" class="fw-medium">Current Account Balance</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">₱</span>
                                            <input type="text" class="form-control" id="currentAccountBalance" value="{{ $client->balance }}" disabled readonly>
                                        </div>
                                        <input type="hidden" class="updatedAccountBalance">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        
                                        <label for="paymentShareAmount" class="fw-medium">Payment Amount</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">₱</span>
                                            <input type="number" class="form-control" step="0.01" min="0" name="paymentShareAmount" value="{{ $client->memberApplication->balance }}" id="paymentShareAmount" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        {{-- <label for="note" class="fw-medium">Payment Notes</label>
                                        <input type="text" class="form-control" name="note" rows="3" id="note"></input> --}}
                                    </div>
                                </div>
                                <h4>Updated Balances</h4>
                                <div class="card p-2">
                                    <div class="row ">  
                                        <div class="col-lg-6">
                                            <label for="totalShareBalance" class="fw-medium">Share Balance After Payment</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon1">₱</span>
                                                <input type="text" class="form-control" name="" id="totalShareBalance" value="" readonly required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="updatedAccountShareBalance" class="fw-medium">Account Balance After Payment</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon1">₱</span>
                                                <input type="text" class="form-control updatedAccountShareBalance" name="updatedAccountShareBalance" id="updatedAccountShareBalanceId" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-lg-6">
                                        <label for="remarksAccountShareOption" class="fw-medium">Status of Account Remarks</label>
                                        <select class="form-control" name="" id="remarksAccountShareOption" disabled>
                                            <option value="Paid">Paid</option>
                                            <option value="Unpaid" >Unpaid</option>
                                        </select>
                                    </div>
                                </div>
                            
                                <input type="hidden" name="remarksAccountShare" id="remarksAccountShare_hidden">
                                <button type="button" class="btn btn-success btn-lg" style="float: right; margin-top: 10px;" data-bs-toggle="modal" data-bs-target="#confirmationModal">Save</button>
                            </div>

                            <div class="modal fade" id="confirmationModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="confirmationModalLabel" aria-hidden="true">
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
                                            <button type="submit" class="btn btn-primary" id="confirmSubmit">Confirm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <span>{{ $error }}</span>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>
                    @elseif ($user->is_from_signup && $user->is_share_paid)
                    <form action="{{ route('admin.payment.store') }}"  method="post" id="loan-payment-form">              
                        @csrf
                        @method('POST')                      
                        <div class="row my-3" id="loan-payment-form">
                            <h2>Loan Accounting</h2>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="loanNo" class="fw-medium">Enter Loan reference number</label>
                                        <input type="text" class="form-control" id="loanNo" name="loanNo">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="loanBalance" class="fw-medium">Remaining Loan Balance</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">₱</span>
                                            <input type="text" class="form-control" id="loanBalance" value="" disabled readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="currentAccountBalance" class="fw-medium">Current Account Balance</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">₱</span>
                                            <input type="text" class="form-control" id="currentAccountBalance" value="{{$client->balance}}" disabled readonly>
                                        </div>
                                        <input type="hidden" class="updatedAccountBalance">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        
                                        <label for="amount" class="fw-medium">Payment Amount</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">₱</span>
                                            <input type="number" class="form-control" step="0.01" min="0" name="amount" value="" id="amount" disabled required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="note" class="fw-medium">Payment Notes</label>
                                        <input type="text" class="form-control" name="note" rows="3" id="note"></input>
                                    </div>
                                </div>
                                <h4>Updated Balances</h4>
                                <div class="card p-2">
                                    <div class="row ">  
                                        <div class="col-lg-6">
                                            <label for="totalBalance" class="fw-medium">Loan Balance After Payment</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon1">₱</span>
                                                <input type="text" class="form-control" name="" id="totalBalance" value="" readonly required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="updatedAccountBalance" class="fw-medium">Account Balance After Payment</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon1">₱</span>
                                                <input type="text" class="form-control updatedAccountBalance" name="updatedAccountBalance" id="updatedAccountBalanceId" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-lg-6">
                                        <label for="remarks" class="fw-medium">Status of Loan Application Remarks</label>
                                        <select class="form-control" name="" id="remarks" disabled>
                                            <option value="Paid">Paid</option>
                                            <option value="Unpaid" >Unpaid</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="remarks" class="fw-medium">Status of Account Remarks</label>
                                        <select class="form-control" name="" id="remarksAccount" disabled>
                                            <option value="Paid">Paid</option>
                                            <option value="Unpaid" >Unpaid</option>
                                        </select>
                                    </div>
                                </div>
                            
                                <input type="hidden" name="remarks" id="remarks_hidden">
                                <input type="hidden" name="remarksAccount" id="remarksAccount_hidden">
                                <button type="button" id="loan-payment-btn" class="btn btn-success btn-lg" style="float: right; margin-top: 10px;" data-bs-toggle="modal" data-bs-target="#confirmationLoanModal" disabled>Save</button>
                            </div>

                            <div class="modal fade" id="confirmationLoanModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="confirmationModalLabel" aria-hidden="true">
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
                                            <button type="submit" class="btn btn-primary" id="confirmSubmit" >Confirm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <span>{{ $error }}</span>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </form>
                    @else
                    <form action="{{ route('admin.payment.store') }}"  method="post" id="loan-payment-form">              
                        @csrf
                        @method('POST')                      
                        <div class="row my-3" id="loan-payment-form">
                            <h2>Loan Accounting</h2>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="loanNo" class="fw-medium">Enter Loan reference number</label>
                                        <input type="text" class="form-control" id="loanNo" name="loanNo">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="loanBalance" class="fw-medium">Remaining Loan Balance</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">₱</span>
                                            <input type="text" class="form-control" id="loanBalance" value="" disabled readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="currentAccountBalance" class="fw-medium">Current Account Balance</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">₱</span>
                                            <input type="text" class="form-control" id="currentAccountBalance" value="{{$client->balance}}" disabled readonly>
                                        </div>
                                        <input type="hidden" class="updatedAccountBalance">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        
                                        <label for="amount" class="fw-medium">Payment Amount</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">₱</span>
                                            <input type="number" class="form-control" step="0.01" min="0" name="amount" value="" id="amount" disabled required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="note" class="fw-medium">Payment Notes</label>
                                        <input type="text" class="form-control" name="note" rows="3" id="note"></input>
                                    </div>
                                </div>
                                <h4>Updated Balances</h4>
                                <div class="card p-2">
                                    <div class="row ">  
                                        <div class="col-lg-6">
                                            <label for="totalBalance" class="fw-medium">Loan Balance After Payment</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon1">₱</span>
                                                <input type="text" class="form-control" name="" id="totalBalance" value="" readonly required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="updatedAccountBalance" class="fw-medium">Account Balance After Payment</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon1">₱</span>
                                                <input type="text" class="form-control updatedAccountBalance" name="updatedAccountBalance" id="updatedAccountBalanceId" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-lg-6">
                                        <label for="remarks" class="fw-medium">Status of Loan Application Remarks</label>
                                        <select class="form-control" name="" id="remarks" disabled>
                                            <option value="Paid">Paid</option>
                                            <option value="Unpaid" >Unpaid</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="remarks" class="fw-medium">Status of Account Remarks</label>
                                        <select class="form-control" name="" id="remarksAccount" disabled>
                                            <option value="Paid">Paid</option>
                                            <option value="Unpaid" >Unpaid</option>
                                        </select>
                                    </div>
                                </div>
                            
                                <input type="hidden" name="remarks" id="remarks_hidden">
                                <input type="hidden" name="remarksAccount" id="remarksAccount_hidden">
                                <button class="btn btn-success btn-lg" style="float: right; margin-top: 10px;" data-bs-toggle="modal" data-bs-target="#confirmationLoanModal">Save</button>
                            </div>

                            <div class="modal fade" id="confirmationLoanModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="confirmationModalLabel" aria-hidden="true">
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
                                            <button type="submit" class="btn btn-primary" id="confirmSubmit">Confirm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                    @endif
                    <!-- /Table -->
                </div>
            </div>
        </div>
    </div>

</div>
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script>
$(document).ready(function() {

    // Display toastr notifications
    function displayToastrNotifications() {
        @if(session()->has('success'))
            toastr.success('{{ session('success') }}');
        @endif
        @if(session()->has('error'))
            toastr.error('{{ session('error') }}');
        @endif
    }

    // Copy account number to clipboard
    function setupCopyButton() {
        $('#copyBtn').click(function() {
            var copyText = $("#account-number").val(); 
            navigator.clipboard.writeText(copyText).then(function() {
                toastr.success('Copied successfully');
            }, function() {
                toastr.error('Failed to copy');
            });
        });
    }

    // Toggle payment forms based on selected mode
    function setupPaymentModeToggle() {
        $('input[name="mode"]').change(function() {
            if ($('#loan_payment').is(':checked')) {
                $('#loan-payment-form').show();
                $('#share-payment-form').hide();
            } else if ($('#share_payment').is(':checked')) {
                $('#loan-payment-form').hide();
                $('#share-payment-form').show();
                $('#paymentShareAmount').trigger('input');
            }
        }).filter(':checked').trigger('change');
    }

    // Setup share payment validation and calculations
    function setupSharePaymentValidation() {
        @if($user->is_from_signup && !$user->is_share_paid)
            var shareBalance = parseFloat("{{ $client->memberApplication->balance }}");
            var totalShareBalance = shareBalance || 0;
            var accountBalance = parseFloat("{{ $client->balance }}") || 0;

            $('#paymentShareAmount').attr('max', shareBalance).on('input', function() {
                var amount = parseFloat($(this).val()) || 0;
                if (amount > shareBalance) {
                    $(this).val(shareBalance.toFixed(2));
                    alert("Amount cannot exceed the share balance.");
                }
                updateShareBalances(amount);
            });

            $('#totalShareBalance').val(totalShareBalance.toFixed(2)).trigger('change');
            $('#currentAccountBalance').val(accountBalance.toFixed(2)).trigger('change');

            function updateShareBalances(sharePaymentAmount) {
                var updatedShareBalance = totalShareBalance - sharePaymentAmount;
                var updatedAccountBalance = accountBalance - sharePaymentAmount;

                $('#totalShareBalance').val(updatedShareBalance.toFixed(2)).trigger('change');
                $('#updatedAccountShareBalanceId').val(updatedAccountBalance.toFixed(2)).trigger('change');
                updateRemarks(updatedShareBalance, updatedAccountBalance);
            }

            function updateRemarks(updatedShareBalance, updatedAccountBalance) {
                var shareRemarks = updatedShareBalance > 0 ? "Unpaid" : "Paid";
                var accountRemarks = updatedAccountBalance > 0 ? "Unpaid" : "Paid";

                $('#remarksAccountShareOption').prop('disabled', false).val(accountRemarks).trigger('change').prop('disabled', true);
                $('#remarksAccountShare_hidden').val(accountRemarks);
            }
        @endif
    }

    // Prevent scrolling on input fields
    function preventScrollOnInputs() {
        $('#paymentShareAmount, #amount').on('wheel', function(e) {
            e.preventDefault();
        });
    }

    // Fetch loan details
    function fetchLoanDetails() {
        var userId = "{{ $client->id }}";
        var loanNo = $('#loanNo').val();

        $.ajax({
            url: `/admin/payment/edit/${userId}/${loanNo}`,
            type: 'GET',
            success: function(response) {
                if (!response.error) {
                    highlightLoanDetails(loanNo, response);
                    updateLoanForm(response);
                } else {
                    toastr.error('Failed to fetch loan details.');
                }
            },
            error: function() {
                toastr.error('Failed to fetch loan details.');
            }
        });
    }

    // Highlight loan details in the table
    function highlightLoanDetails(loanNo, response) {
        $('#table-container tbody tr').each(function() {
            var row = $(this);
            var currentLoanNo = row.find('td:eq(1)').text();

            if (currentLoanNo === loanNo) {
                row.addClass('table-warning').find('td:eq(7), td:eq(8)').addClass('table-info');
                $('#table-container thead th:eq(7), #table-container thead th:eq(8)').addClass('fw-bold');
            } else {
                row.removeClass('table-warning').find('td:eq(7), td:eq(8)').removeClass('table-info');
                $('#table-container thead th:eq(7), #table-container thead th:eq(8)').removeClass('fw-bold');
            }
        });
    }

    // Update loan form with fetched details
    function updateLoanForm(response) {
        $('#loanBalance').val(response.balance);
        $('#currentAccountBalance').val(response.currentAccountBalance);

        if (response.balance == 0) {
            $('#amount, #note').prop('disabled', true).val(0);
            $('#loan-payment-btn').prop('disabled', true);
        } else {
            $('#amount, #note').prop('disabled', false).val(response.monthly_pay);
            $('#loan-payment-btn').prop('disabled', false);
        }

        $('#amount').attr('max', response.balance).trigger('input');
    }

    // Update loan and account balances
    function updateBalances() {
        var paymentAmount = parseFloat($('#amount').val()) || 0;
        var remainingLoanBalance = parseFloat($('#loanBalance').val()) || 0;
        var currentAccountBalance = parseFloat($('#currentAccountBalance').val()) || 0;

        var updatedLoanBalance = remainingLoanBalance - paymentAmount;
        var updatedAccountBalance = currentAccountBalance - paymentAmount;

        if (paymentAmount > remainingLoanBalance) {
            alert("Payment amount cannot exceed the remaining loan balance.");
            $('#amount').val(remainingLoanBalance.toFixed(2));
            paymentAmount = remainingLoanBalance;
        }

        $('#totalBalance').val(updatedLoanBalance.toFixed(2));
        $('#updatedAccountBalanceId').val(updatedAccountBalance.toFixed(2));

        updateRemarksAutomatically(updatedLoanBalance, updatedAccountBalance);
        updateLoanPaymentBtn(updatedLoanBalance, paymentAmount);
    }

    // Update remarks automatically
    function updateRemarksAutomatically(updatedLoanBalance, updatedAccountBalance) {
        var loanRemarksValue = updatedLoanBalance === 0 ? 'Paid' : 'Unpaid';
        var accountRemarksValue = updatedAccountBalance === 0 ? 'Paid' : 'Unpaid';

        $('#remarks').val(loanRemarksValue);
        $('#remarksAccount').val(accountRemarksValue);
        $('#remarksAccount_hidden').val(accountRemarksValue);
    }

    // Enable or disable loan payment button
    function updateLoanPaymentBtn(loanBalance, amount) {
        $('#loan-payment-btn').prop('disabled', amount > loanBalance);
    }

    // Validate form before submission
    function validateFormBeforeSubmit() {
        $("#payment-form").on("submit", function(event) {
            var isValid = true;
            $("#payment-form input[required]:not([readonly]), #payment-form textarea[required]").each(function() {
                var trimmedValue = $(this).val().trim();
                $(this).val(trimmedValue);

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
    }

    // Initialize all functions
    function initialize() {
        displayToastrNotifications();
        setupCopyButton();
        setupPaymentModeToggle();
        setupSharePaymentValidation();
        preventScrollOnInputs();
        validateFormBeforeSubmit();

        var loanNo = $('#loanNo').val();
        if (loanNo) {
            fetchLoanDetails();
        }
        $('#loanNo').change(fetchLoanDetails);
        $('#amount').on('input', updateBalances);
    }

    initialize();
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

    function downloadStatement() {
        
    }

    function exportTableToExcel(fileName) {
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