@extends('layouts.app')
@section('title', 'Payment')
@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/payment/payment.css') }}">
@endsection
@section('content')
<div id="page-content-wrapper">
    <div class="container-fluid xyz">
      <div class="row">
        <div class="col-lg-12">
          <h1>
            Payment Repositories
          </h1>
          <div class="row pt-3  card" style="margin-top: 2em;">
            <!-- Table -->
            <div class="row">
              
              <div class="col-lg-12">
                <div class="row">
                  <div class="row">
                    <div class="col-lg-11">
                      <div class="col-lg-3" id="search-top-bar">
                        <div class="input-group" >
                          <form action="{{ route('admin.payment.search') }}" method="GET">
                            <div class="">
                                <input class="form-control" type="search" placeholder="Search" id="search-input" aria-describedby="button-addon1">
                            </div>
                        </form>
                        </div>
                    </div>
                    </div>
                  </div>
                  
                </div>
                  <div class="table-responsive" id="payment-repositories">
                    <table class="table table-hover table-fixed table-bordered table-lock-height" style="font-size: large;" >
                          <thead>
                          <tr>
                              <th class='fw-medium'>#</th>
                              <th class='fw-medium'>Account Number</th>
                              <th class='fw-medium'>Name</th>
                              <th class='fw-medium'>Balance</th>
                              <th class='fw-medium'>Remarks</th>
                              <th class='fw-medium'>Status</th>
                              <th class='fw-medium'>Actions</th>
                          </tr>
                          </thead>
                          <tbody>
                          {{-- For loop --}}
                            @foreach ($payments as $payment)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle"> <a class="text-decoration-none fw-medium" href="{{ route('admin.payment.edit', $payment->user_id) }}">{{ $payment->user->account_number }}</a></td>
                                <td class="align-middle">{{ ucfirst($payment->first_name . ' ' . $payment->last_name) }}</td>
                                <td class="align-middle">Php {{ number_format($payment->balance, 2) }}</td>
                                <td class="align-middle">{{ ucfirst($payment->remarks) }}</td>
                                <td class="fw-medium align-middle fs-6 w-auto">
                                    <span class="{{ $payment->account_status == 'Active' ? 'text-success-emphasis bg-success-subtle' : 'text-danger-emphasis bg-danger-subtle' }} px-2 py-1 rounded fw-medium no-wrap">{{ $payment->account_status }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.payment.edit', $payment->user_id) }}" class="btn btn-primary">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                          </tbody>
                    </table>
                  </div>
              </div>
          </div>
          <div id="pagination">
          </div>
            <!-- /Table -->
        </div>
      </div>
    </div>
  </div>

  @endsection  
  @section('script')
  <script>
  $(document).ready(function() {
    var currentSort = 'id';
    var currentDirection = 'asc';
    var currentSearch = '';
    var currentPage = 1;
    fetchAndUpdate();

    function fetchAndUpdate() {
      var url = `{{ route('admin.payment') }}?search=${encodeURIComponent(currentSearch)}&page=${currentPage}&sort=${currentSort}&direction=${currentDirection}`;

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#payment-repositories tbody').html(response.html);
                $('#pagination').html(response.pagination);
            }
        });
    }
    $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        var newPage = $(this).attr('href').split('page=')[1];
        if(newPage !== undefined) {
            currentPage = newPage;
            fetchAndUpdate();
        }
    });

    $('#search-input').on('input', function() {
        currentSearch = $(this).val();
        currentPage = 1;
        fetchAndUpdate();
    });
});
    </script>
  @endsection