@extends('layouts.app')
@section('title', 'Account')
@section('css')
  <link href="{{ asset('css/member/account/account.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/member/dashboard.css') }}">

  {{-- <link href="{{ asset('css/member/account/style.css') }}" rel="stylesheet"> --}}
  {{-- <link href="{{ asset('css/member/account/style.scss') }}" rel="stylesheet"> --}}
@endsection
@section('content')
<div id="page-content-wrapper">
    <div class="container-fluid xyz">
      <div class="row">
        <div class="col-lg-12">
          <h1 id="user-greet">
            Account Overview
          </h1>
          <div class="container-wrapper-contents px-0 w-auto">
            <div class="row mb-3">
              <div class="col mb-3 px-4 py-3 border border-dark-subtle rounded">
                <div class="row w-auto d-flex justify-content-between">
                      <div class="col-lg-3 pe-0 pt-0">
                        <div class="col-lg-11 d-flex align-items-center h-100 pe-3 ">
                          <div >
                            <p class="mb-1">Account Balance</p>
                            <span class="fw-normal fs-lg">₱{{ number_format($loanBalance, 2) }}</span>
                          </div>
                        </div>
                          
                      </div>
                      <div class="col-lg-2 pe-0 ps-auto ps-lg-0 pt-0 ">
                        <div class="col-lg-9 d-flex align-items-center h-100 ">
                          <div class="me-2">
                            <p class="mb-1">Remarks</p>
                            <span class="fw-normal fs-lg">{{ empty($remarks) ? 'No remarks' : ucfirst($remarks) }}</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-2 pe-0 ps-auto ps-lg-2 pt-0 ">
                        <div class="col-lg-12 d-flex align-items-center h-100 ">
                          <div class="mx-0 mx-lg-2">
                              <p class="mb-1">Amount of Shares</p>
                              <span class="fw-normal fs-lg">₱{{ number_format($amount_of_shares, 2) }}</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 d-flex ps-auto px-lg-3">
                        <div class="col-lg-12 d-flex align-items-center h-100 w-100">
                          <div class="me-2 pe-2">
                            <p class="mb-1">Latest Loan Application Status
                              @if($recentApplicationUpdateTimestamp)
                              <span data-bs-toggle="tooltip" data-bs-placement="top" title="Active for 
                              {{ $recentApplicationUpdateTimestamp->diffInDays(now()) > 0 ? $recentApplicationUpdateTimestamp->diffInDays(now()) . ' days' : 
                              ($recentApplicationUpdateTimestamp->diffInHours(now()) > 0 ? $recentApplicationUpdateTimestamp->diffInHours(now()) . ' hours' : 
                              $recentApplicationUpdateTimestamp->diffInMinutes(now()) . ' minutes') }}">
                                  <i class="bi bi-info-circle"></i>
                              </span>
                              @endif
                            </span></p>
                            <div id="loanStatusContainer" class="fw-normal">
                              @if($loanApplicationStatus == 'approved')
                                <span class="text-success fs-lg">{{ ucfirst($loanApplicationStatus) }}</span>
                              @elseif($loanApplicationStatus == 'rejected')
                                <span class="text-danger fs-lg">{{ ucfirst($loanApplicationStatus) }}</span>
                              @else
                                <span class="text-primary-emphasis fs-lg">{{ ucfirst($loanApplicationStatus) }}</span>
                              @endif
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
            </div>
          </div>
              <!-- Reports -->
          <div class="col-md-12 w-100 mt-3">
              <div class="row">
                  <div class="d-flex mb-3 justify-content-between align-items-center">
                    <h3 class="pt-2 mb-0">Accounting Trails</h3>
                  </div>
                  <div class="card">
                    <div class="">
                      <div class="p-3 px-0 pb-0">
                        <div class="d-flex justify-content-between">
                          <h4>Loan Payments Trail</h4>
                          <div class="dropdown">
                            <button type="button" class="btn btn-link p-0 refresh-btn-loan" data-target="loanPaymentsTrail">
                              <i class="bi bi-arrow-clockwise"></i>
                            </button>
                          </div>
                        </div>
                        
                        <hr>
                      </div>
                     
                      <div class="table-wrapper mx-0 mt-0">
                        <table class="table table-hover mx-0 mt-0 table-striped">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Payment Reference No.</th>
                              <th>Loan Reference No.</th>
                              <th>Date</th>
                              <th>Amount Paid</th>
                              <th>Remarks</th>
                              <th>Notes</th>
                            </tr>
                          </thead>
                          <tbody id="loanPaymentsTrail">
                            @forelse ($payments as $payment)
                              @foreach ($payment->payment_pivot as $pivot)
                                  <tr>
                                      <td>{{ $loop->parent->iteration }}</td>
                                      <td>{{ $payment->reference_no }}</td>
                                      <td>{{ $pivot->loanApplication->loan_reference }}</td>
                                      <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('D, M d, Y') }}</td>
                                      <td>{{ $payment->amount_paid }}</td>
                                      <td>{{ $pivot->remarks }}</td>
                                      @if($payment->note)
                                          <td><button class='btn btn-primary btn-sm w-100' data-bs-toggle='modal' data-bs-target='#noteModal' data-note="{{ $payment->note }}">Note</button></td>
                                      @else
                                          <td>N/A</td>
                                      @endif
                                  </tr>
                              @endforeach
                            @empty
                              <tr><td colspan="7" class="text-center">No records found.</td></tr>
                            @endforelse
                          </tbody>
                        </table>
                      </div>
                      @if($is_from_signup)
                      <hr>
                      <div class="p-3 px-0 pb-0">
                        <div class="d-flex justify-content-between">
                          <h4>Share Payments Trail</h4>
                          <div class="dropdown">
                            <button type="button" class="btn btn-link p-0 refresh-btn-share" data-target="sharePaymentsTrail">
                              <i class="bi bi-arrow-clockwise"></i>
                            </button>
                          </div>
                        </div>
                        <hr>
                      </div>
                      <div class="table-wrapper mx-0 mt-0">
                        <table class="table table-responsive mt-0 table-striped table-hover">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Payment Reference No.</th>
                              <th>Date</th>
                              <th>Amount Paid</th>
                              <th>Remarks</th>
                            </tr>
                          </thead>
                          <tbody id="sharePaymentsTrail">
                            @foreach ($sharePayments as $sharePayment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $sharePayment->payment->reference_no }}</td> 
                                <td>{{ \Carbon\Carbon::parse($sharePayment->payment->created_at)->format('D, M d, Y') }}</td>
                                <td>{{ $sharePayment->payment->amount_paid }}</td>
                                <td>{{ $sharePayment->remarks }}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                      @endif
                      
                  </div>
                  </div>
                  
              </div>
            </div>
            <div class="col-md-12 w-100 mt-3">
                <div class="row">
                  <div class="d-flex mb-3 justify-content-between align-items-center">
                      <h3 class="pt-2 mb-0">Recent Loan Trails</h3>
                      <div class="dropdown">
                        <button type="button" class="btn btn-link p-0 refresh-btn-recent " data-target="recentLoanTrail">
                          <i class="bi bi-arrow-clockwise"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                          <li><button class="dropdown-item" onclick="location.reload();">Refresh</button></li>
                        </ul>
                      </div>
                    </div>
                    <div class="card">
                      <div class="p-0 table-responsive">
                        <table class="table table-striped mt-0 table-hover ">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Loan Reference No.</th>
                              <th>Loan Type</th>
                              <th>Date Applied</th>
                              <th>Due Date</th>
                              <th>Loan Amount</th>
                              <th>Amount Disbursed</th>
                              <th>Installment Amount</th>
                            </tr>
                          </thead>
                          <tbody id="recentLoanTrail">
                            @if($recentLoanApplication->isEmpty())
                              <tr>
                                <td colspan="8" class="text-center">No recent loan records available.</td>
                              </tr>
                            @else
                              @foreach($recentLoanApplication as $loanApplication)
                              @php
                                $dueDate = \Carbon\Carbon::now()->addMonths($loanApplication->time_pay)->format('Y-m-d');
                              @endphp  
                              <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $loanApplication->loan_reference }}</td>
                                <td>{{ $loanApplication->loan_type }}</td>
                                <td>{{ \Carbon\Carbon::parse($loanApplication->created_at)->format('D, M d, Y') }}</td>
                                <td>{{ $loanApplication->due_date ? \Carbon\Carbon::parse($loanApplication->due_date)->format('D, M d, Y') : 'N/A' }}</td>
                                <td>{{ $loanApplication->financed_amount }}</td>
                                <td>{{ $loanApplication->finance_charge }}</td>
                                <td>{{ $loanApplication->monthly_pay }}/mo</td>
                              </tr>
                              @endforeach
                            @endif
                          </tbody>
                        </table>
                      </div>
                    </div>
                    
              </div>
            </div>
          </div>
            <!-- /Reports -->
            <!-- Modal -->
            <div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="noteModalLabel">View note</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id="noteModalBody">

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- End modal -->
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
<script>
  $(document).ready(function() {
    $('[data-bs-toggle="tooltip"]').tooltip();

    $('#noteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var note = button.data('note'); // Extract note from data-* attributes
        var modal = $(this);
        modal.find('.modal-body').text(note);
    });

    refreshTable('loanPaymentsTrail');

    function refreshTable(target) {
      var target = $(this).data('target'); // This identifies which table to update
      var url = "{{ route('refreshLoanPaymentsTrail') }}?table=" + target; // Correctly append as a query parameter

    // Show loading placeholder
      $('#' + target).html('<tr><td colspan="7" class="text-center">Loading...</td></tr>');
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                // Assuming 'response' contains the new HTML for the table
                $('#' + target).html(response);
            },
            error: function() {
                $('#' + target).html('<tr><td colspan="7" class="text-center">Error loading data</td></tr>');
            }
        });
    }

    $('.refresh-btn-loan').click(function() {
      var target = $(this).data('target'); // This identifies which table to update
      var url = "{{ route('refreshLoanPaymentsTrail') }}?table=" + target; // Correctly append as a query parameter

      // Show loading placeholder
      $('#' + target).html('<tr><td colspan="7" class="text-center">Loading...</td></tr>');
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                // Assuming 'response' contains the new HTML for the table
                $('#' + target).html(response);
            },
            error: function() {
                $('#' + target).html('<tr><td colspan="7" class="text-center">Error loading data</td></tr>');
            }
        });
    });
    $('.refresh-btn-share').click(function() {
      var target = $(this).data('target'); // This identifies which table to update
      var url = "{{ route('refreshSharePaymentsTrail') }}?table=" + target; // Correctly append as a query parameter

      // Show loading placeholder
      $('#' + target).html('<tr><td colspan="7" class="text-center">Loading...</td></tr>');
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                // Assuming 'response' contains the new HTML for the table
                $('#' + target).html(response);
            },
            error: function() {
                $('#' + target).html('<tr><td colspan="7" class="text-center">Error loading data</td></tr>');
            }
        });
    });
    $('.refresh-btn-recent').click(function() {
      var target = $(this).data('target'); // This identifies which table to update
      var url = "{{ route('refreshRecentLoanTrail') }}"; // Correctly append as a query parameter

      // Show loading placeholder
      $('#' + target).html('<tr><td colspan="8" class="text-center">Loading...</td></tr>');
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                // Assuming 'response' contains the new HTML for the table
                $('#' + target).html(response);
            },
            error: function() {
                $('#' + target).html('<tr><td colspan="8" class="text-center">Error loading data</td></tr>');
            }
        });
    });
});
</script>
@endsection