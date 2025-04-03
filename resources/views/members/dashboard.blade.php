@extends('layouts.app')
@section('title', 'Dashboard')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/member/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/member/account/style.css') }}">
    <style>
        .text-wrap {
            display: inline-block;
            max-width: 100%; 
            word-wrap: break-word; 
            white-space: normal; 
        }
        .w-100 {
            overflow-wrap: break-word;
        }
    </style>
@endsection
@section('content')

<div id="page-content-wrapper">
    <div class="container-fluid xyz p-0 pe-res">
        <div class="col-lg-12 w-100">
            <div class="col-sm-12">
                <div id="user-greet" class="w-100">
                    <h1>Hi, <span class="text-wrap">{{ $client->first_name }}!</span>
                    </h1>
                  </div>
              </div>
            <h1>
                Dashboard Overview
            </h1>
            <div class="row" style="margin-top: 2em;">
            <!-- Chart -->
            <div class="col-lg-12 w-100 h-100">
                <div class="h-100 p-4 px-0 pt-3">
                    <div class="d-flex justify-content-between h-100 flex-lg-row flex-column" id="card-title">
                        <div class="d-flex flex-grow-1 flex-lg-row flex-column h-auto w-100 me-lg-3 me-0"> <!-- Adjusted for flex-grow -->
                            <div class="d-flex flex-column flex-grow-1"> <!-- Adjusted for flex-grow -->
                                <h3 class="mb-3">Account Balance</h3>
                                <div class="card h-100">
                                    <div>
                                        <div class="p-3">
                                            <table>
                                                <tr>
                                                    <td>Total remaining balance:</td>
                                                </tr>
                                                <tr>
                                                    <th style="font-size: 25px;">₱ {{ number_format($balance, 2) }}</th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mb-2">
                                <h3>Account Share Holdings</h3>
                                <div class="h-100 card">
                                    <div>
                                        <div class="p-3">
                                            <table>
                                                <tr>
                                                    <td>Total Share Holdings:</td>
                                                </tr>
                                                <tr>
                                                    <th style="font-size: 25px;">₱ {{ number_format($client->amount_of_share, 2) }}</th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        

                        <div class="h-100 w-100 flex-grow-1">
                            <h3 class="mb-3 mt-3 mt-lg-0 font-header">Ongoing Loan Application</h3>
                            <div class="w-100 card h-25 p-2">
                                <div class="border rounded scroll-snap-container" style="max-height: 400px; overflow-y: auto;">
                                    @if($loanApplications->where('application_status', 'approved')->where('remarks', 'unpaid')->isNotEmpty())
                                    @foreach($loanApplications->where('application_status', 'approved')->where('remarks', 'unpaid') as $loanApplication)
                                        <div class="mx- {{ $loop->last ? '' : 'border-bottom' }} loan-apps">
                                            <div class="card-body p-3 px-3">
                                                <div class="d-flex flex-column flex-xl-row justify-content-between">
                                                    <span class="card-title ">Reference No: #<span class="fw-medium">{{ $loanApplication->loan_reference }}</span>
                                                    </span>
                                                    <span>Loan Type: <span class="fw-medium">{{ $loanApplication->loan_type }}</span></span>
                                                </div>
                                                @php
                                                  $createdDate = \Carbon\Carbon::parse($loanApplication->created_at);
                                                  $dueDate = $createdDate->copy()->addMonths($loanApplication->time_pay);
                                                @endphp
                                                <div class="d-flex mt-1 flex-column flex-xl-row justify-content-between">
                                                    <span class="card-text me-2">Monthly Payment: ₱ <span class="fw-medium">{{ number_format($loanApplication->monthly_pay, 2) }}</span></span>
                                                    <span>Due on <span class="fw-medium">{{ $loanApplication->due_date ? \Carbon\Carbon::parse($loanApplication->due_date)->format('D, M d, Y') : 'N/A' }}</span></span>                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="card">
                                        <div class="card-body p-3"> <!-- Apply padding here for consistency -->
                                            @if(Auth::user()->default_profile)
                                                <p class="card-text">Complete your profile before applying for a loan.</p>
                                            @else
                                                <p class="card-text">No ongoing loan application found.</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                </div>
                               
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <!-- Reports -->
            <div class="col-md-12 mt-md-5">
                <div class="">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="pt-2">Last Transactions</h3>
                </div>
                {{-- <hr class="px-2 my-0"> --}}
                <div class="card">
                    <div class="p-2 table-responsive">
                        <table class="table table-striped table-hover m-0">
                            <thead>
                            <tr>
                            <th>Transaction</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($transactionHistories as $transaction)
                            <tr>
                                <td>{{ $transaction->audit_description }}</td>
                                <td>{{ $transaction->transaction_type }}</td>
                                <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('D, M d, Y') }}</td>
                                <td>{{ $transaction->transaction_status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No transactions found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                        </table>
                    </div>
                </div>
                
                </div>
            </div>            
            <!-- /Reports -->
        </div>
        </div>
    </div>
</div>


@endsection