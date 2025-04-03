@extends('layouts.app')
@section('title', 'Loan')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/member/account/account.css') }}">
    <link rel="stylesheet" href="{{ asset('css/member/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/member/account/style.css')}}">
@endsection
@section('content')
<div class="page-content-wrapper">
  
    <div class="container-fluid xyz p-4">
        <div class="row d-flex align-items-center">
            <div class="col-lg-9 py-3">
                <h1 id="user-greet">Loan Overview</h1>
            </div>
        </div>
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
        <div class="row d-flex flex-column ">
            <div class="w-100 d-flex flex-column flex-lg-row border rounded px-0 p-2">
                <!--Apply btn-->
                <div class="col-lg-auto px-3 mb-lg-0 mb-1 d-flex align-items-center border-md-end-0 border-end">
                  <a class="btn btn-primary my-2 " href="{{ route('member.loan.apply') }}" role="button">
                      <i class="bi bi-credit-card-2-front"></i> &nbsp;Apply loan
                  </a>
                </div>
                <div class="col-lg-4 h-auto w-auto mx-3 d-flex align-items-center flex-row justify-content-start border-lg-top-0 border-top" >
                  <div class="py-1 pt-lg-0 pt-2 row-gap-1 w-100 d-flex justify-content-between flex-column flex-sm-row">
                        <div class="col-md-3 pt-0 w-auto pe-0 pe-sm-3 border-md-end-0 border-end border-sm-bottom-0 border-bottom pb-sm-0 pb-2">
                            <span class="text-primary text-start w-100 filter-btn fw-medium" data-status="all">All <small>{{$totalLoans}}</small></span>
                        </div>
                        <div class="col-md-3 pt-0 w-auto px-0 px-sm-3 border-md-end-0 border-end border-sm-bottom-0 border-bottom pb-sm-0 pb-2">
                            <span class="text-primary-emphasis text-start w-100 filter-btn fw-medium" data-status="pending">Pending <small>{{$totalPendingLoans}}</small></span>
                        </div>
                        <div class="col-md-3 pt-0 px-0 px-sm-3 w-auto border-md-end-0 border-end border-sm-bottom-0 border-bottom pb-sm-0 pb-2">
                            <span class="text-success text-start w-100 filter-btn fw-medium" data-status="accepted">Accepted <small>{{$totalApprovedLoans}}</small></span>
                        </div>
                        {{-- <span class="ps-2 border-sm-end border-end"></span> --}}
                        <div class="col-md-3 pt-0 w-auto px-0 px-sm-3">
                            <span class="text-danger text-start w-100 filter-btn fw-medium" data-status="rejected">Rejected <small>{{$totalRejectedLoans}}</small></span>
                        </div>
                    </div>
                </div>
            </div>
            <!--Main Content-->
          <div class="w-100 mt-lg-5 mt-3 px-0">
            <div class="">
              <div class="d-flex mb-3 px-3 justify-content-between align-items-center">
                  <div>
                    <h3 class="pt-2 mb-0">Loan Trails</h3>
                  </div>
                  
                  <div class="dropdown">
                    <button type="button" class="btn btn-link p-0 refresh-btn-loan" data-target="loanTrails">
                      <i class="bi bi-arrow-clockwise"></i>
                    </button>
                  </div>
                </div>
                <div class="card">
                  <div class="table-wrapper">
                    <table class="table table-hover m-0 table-striped">
                      <thead>
                        <tr class="fw-medium">
                          <th>#</th>
                          <th>Loan Reference</th>
                          <th>Loan Type</th>
                          <th>Date Applied</th>
                          <th>Due Date</th>
                          <th>Loan Amount</th>
                          <th>Amount Disbursed</th>
                          <th>Installment Amount</th>
                          <th>Remarks</th>
                          <th>Loan status</th>
                          <th>Notes</th>
                        </tr>
                      </thead>
                      <tbody id="loanTrails">
                        @if($loanApplications->isEmpty())
                          <tr>
                              <td colspan="10" class="text-center">No loan records available</td>
                          </tr>
                      @else
                          @foreach($loanApplications as $loanApplication)
                            @php
                              $createdDate = \Carbon\Carbon::parse($loanApplication->created_at);
                            @endphp  
                            <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $loanApplication->loan_reference }}</td>
                              <td>{{ $loanApplication->loan_type }}</td>
                              <td>{{ \Carbon\Carbon::parse($loanApplication->created_at)->format('D, M d, Y') }}</td>
                              <td>{{ \Carbon\Carbon::parse($loanApplication->due_date)->format('D, M d, Y') }}</td>
                              <td>Php {{ number_format($loanApplication->financed_amount, 2) }}</td>
                              <td>Php {{ number_format($loanApplication->finance_charge, 2) }}</td>
                              <td>{{ $loanApplication->monthly_pay }}/mo</td>
                              <td class="align-middle fs-6">
                                <span class="@if($loanApplication->application_status == 'pending') text-primary-emphasis bg-primary-subtle fw-medium @elseif($loanApplication->application_status == 'approved') text-success bg-success-subtle fw-medium @elseif($loanApplication->application_status == 'rejected') text-danger-emphasis bg-danger-subtle fw-medium @endif px-2 py-1 rounded">{{ ucfirst($loanApplication->application_status) }}</span>
                              </td>
                              <td class="align-middle fs-6">
                                <span class="@if($loanApplication->remarks == 'Unpaid' || $loanApplication->remarks == 'unpaid') text-danger-emphasis bg-danger-subtle fw-medium @elseif($loanApplication->remarks == 'paid' || $loanApplication->remarks == 'Paid') text-success bg-success-subtle fw-medium @endif px-2 py-1 rounded">{{ ucfirst($loanApplication->remarks) }}</span>
                              </td>
                              @if($loanApplication->note)
                                <td><button class='btn btn-primary btn-sm w-100' data-bs-toggle='modal' data-bs-target='#noteModal' data-note="{{ $loanApplication->note }}">Note</button></td>
                                @else
                                  <td>N/A</td>
                                @endif
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
@section('script')
<script>
$(document).ready(function() {
  $('#noteModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var note = button.data('note') // Extract info from data-* attributes
    var modal = $(this)
    modal.find('.modal-body').text(note)
  })
  setTimeout(function() {
  $('#success-alert').fadeOut('slow');
}, 30000); 

setTimeout(function() {
    $('#error-alert').fadeOut('slow');
  }, 30000); 
  $('.refresh-btn-loan').click(function() {
      var target = $(this).data('target'); // This identifies which table to update
      var url = "{{ route('refreshLoanTrail') }}"; // Correctly append as a query parameter

      // Show loading placeholder
      $('#' + target).html('<tr><td colspan="10" class="text-center">Loading...</td></tr>');
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                // Assuming 'response' contains the new HTML for the table
                $('#' + target).html(response);
            },
            error: function() {
                $('#' + target).html('<tr><td colspan="10" class="text-center">Error loading data</td></tr>');
            }
        });
    });
});

</script>
@endsection
@endsection
