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
                          <input class="form-control border rounded " type="text" placeholder="Search" id="search-input">
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
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $payment->user->account_number }}</td>
                                <td>{{ ucfirst($payment->first_name . ' ' . $payment->last_name) }}</td>
                                <td>Php {{ number_format($payment->balance, 2) }}</td>
                                <td>{{ ucfirst($payment->remarks) }}</td>
                                <td>{{ ucfirst($payment->account_status) }}</td>
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
            <!-- /Table -->
        </div>
      </div>
    </div>
  </div>
  @section('script')
    <script>
  $(document).ready(function() {
    var currentSort = 'id';
    var currentDirection = 'asc';
    var query = '';
    fetchAndUpdate();

    function fetchAndUpdate(url) {
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#payment-repositories').html(response.html);
                $('#pagination').html(response.pagination);
            }
        });
    }

    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        var url = `/admin/payment?page=${page}&sort=${currentSort}&direction=${currentDirection}&search=${encodeURIComponent(query)}`;
        fetchAndUpdate(url);
    });

    $('#search-input').on('keyup', function() {
        query = $(this).val();
        var url = `/admin/payment?sort=${currentSort}&direction=${currentDirection}&search=${encodeURIComponent(query)}`;
        fetchAndUpdate(url);
    });
});
    </script>
  @endsection
  @endsection