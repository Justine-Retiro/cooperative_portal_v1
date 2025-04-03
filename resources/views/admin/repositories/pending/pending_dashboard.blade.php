@extends('layouts.app')
@section('title', 'Pending Users')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/repositories.css') }}">
@endsection
@section('content')

<div id="page-content-wrapper">
    <div class="container-fluid xyz">
      <div class="row">
        <div class="col-lg-12">
          <h1>New member's request</h1> 
          <div class="">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('admin.repositories') }}" class="text-decoration-none">Members Repositories</a></li>
                  <li class="breadcrumb-item active" aria-current="page">New member's request</li>
              </ol>
          </nav>
          </div>
          <div class="row pt-3 card" >
            <!-- Table -->
            <div class="row m-0">
              <div class="col-lg-12">
                <div class="row">
                  <div class="row mb-3">
                    <div class="col-lg-11">
                      
                      <div class="row d-flex align-items-center justify-content-between flex-lg-row">
                        <div class="col-lg-auto col-sm-auto border d-flex justify-content-center px-1 me-2 " style="border-radius: 10px;">
                          <div class="py-1 w-100 d-flex justify-content-between flex-column flex-sm-row">
                            <div class="col-auto pt-0 mx-sm-1 mx-0 w-auto">
                              <button class="btn text-primary w-100 text-start filter-btn fw-medium" data-status="all" onclick="$('.filter-btn').removeClass('active'); $(this).addClass('active');">All <small>{{ $allMember }}</small></button>
                            </div>
                            <div class="col-auto pt-0 me-sm-1 me-0 w-auto">
                              <button class="btn text-primary-emphasis w-100 text-start filter-btn fw-medium" data-status="pending" onclick="$('.filter-btn').removeClass('active'); $(this).addClass('active');">Pending <small>{{ $pendingMember }}</small></button>
                            </div>
                            <div class="col-auto pt-0 me-sm-1 me-0 w-auto">
                              <button class="btn text-success w-100 text-start filter-btn fw-medium" data-status="approved" onclick="$('.filter-btn').removeClass('active'); $(this).addClass('active');">Approved <small>{{ $approvedMember }}</small></button>
                            </div>
                            <div class="col-auto pt-0 me-sm-1 me-0 w-auto">
                              <button class="btn text-danger w-100 text-start filter-btn fw-medium" data-status="rejected" onclick="$('.filter-btn').removeClass('active'); $(this).addClass('active');">Rejected <small>{{  $rejectedMember }}</small></button>
                            </div>
                          </div>
                        </div>
                        <!-- Search bar -->
                        <div class="col-lg-4 mt-3 mt-lg-0 w-100-lg px-0" id="search-top-bar">
                          <form action="{{ route('admin.search-repo') }}" method="GET">
                            <div class="">
                                <input class="form-control" type="search" placeholder="Search" id="search-input" aria-describedby="button-addon1">
                            </div>
                        </form>
                        </div>
                        <!-- /Search bar -->
                      </div>
                  </div>
                  
                </div>
                <hr>
                  <div class="table table-responsive" id="client-repositories">
                    <table id="pending_table" class="table table-bordered table-hover" style="font-size: large;">
                      <thead>
                        <tr>
                        <th class='fw-medium'>#</th>
                        <th class='fw-medium'>Name of Applicant</th>
                        <th class='fw-medium'>Birth Date</th>
                        <th class='fw-medium'>Position</th>
                        <th class='fw-medium'>Nature of Work</th>
                        <th class='fw-medium'>Date employed</th>
                        <th class='fw-medium'>Requested Share Amount</th>
                        <th class='fw-medium'>Date Applied</th>
                        <th class='fw-medium'>Status</th>
                        <th class='fw-medium'>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>  
                  </div>
                  <div id="pagination" class="pagination flex-column">
                    
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
    var currentStatus = 'all';
    var currentSort = 'desc';
    var currentSearch = '';
    var currentPage = 1;

    function fetchData() {
        var url = `{{ route('admin.repositories.pending.filter', '') }}/${currentStatus}?sort=${currentSort}&search=${encodeURIComponent(currentSearch)}&page=${currentPage}`;

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#pending_table tbody').html(response.html);
                $('#pagination').html(response.pagination);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    $('.filter-btn').on('click', function() {
        currentStatus = $(this).data('status');
        currentPage = 1;
        fetchData();
    });

    $('#search-input').on('input', function() {
        currentSearch = $(this).val();
        currentPage = 1;
        fetchData();
    });

    $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        var newPage = $(this).attr('href').split('page=')[1];
        if(newPage !== undefined) {
            currentPage = newPage;
            fetchData();
        }
    });

    // Trigger the initial fetch
    fetchData();
});
</script>
@endsection
@endsection
