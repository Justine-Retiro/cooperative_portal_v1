@extends('layouts.app')
@section('title', 'Members Loan')
@section('css')
<link rel="stylesheet" href="{{ asset('css/repositories.css') }}">
@endsection
@section('content')

<div id="page-content-wrapper">
  <div class="spinner-body position-absolute top-50 start-50 translate-middle z-3">
    <div class=" spinner"></div>
  </div>
  <div class="container-fluid xyz pe-0">
    <div class="row">
      <div class="col-lg-12">
        <h1>
          Members Loan Requests
        </h1>
        <div class="row" style="margin-top: 2em;">
          <!-- Table -->
          <div class="row pe-0">
            <div class="col-lg-12">
              <div class="row">
                <div class="col w-100">
                  <div class="col-lg-12">
                    <!-- Whole top bar -->
                    <div class="row d-flex align-items-center justify-content-between flex-lg-row">
                      <div class="col-lg-auto col-sm-auto border d-flex justify-content-center px-1 me-2 " style="border-radius: 10px;">
                        <div class="py-1 w-100 d-flex justify-content-between flex-column flex-sm-row">
                          <div class="col-auto pt-0 mx-sm-1 mx-0 w-auto">
                            <button class="btn text-primary text-start w-100 filter-btn fw-medium" data-status="all" onclick="$('.filter-btn').removeClass('active'); $(this).addClass('active');">All <small>{{ $allCount }}</small></button>
                          </div>
                          <div class="col-auto pt-0 me-sm-1 me-0 w-auto">
                            <button class="btn text-primary-emphasis text-start w-100 filter-btn fw-medium" data-status="pending" onclick="$('.filter-btn').removeClass('active'); $(this).addClass('active');">Pending <small>{{ $pendingCount }}</small></button>
                          </div>
                          <div class="col-auto pt-0 me-sm-1 me-0 w-auto">
                            <button class="btn text-success text-start filter-btn w-100 fw-medium" data-status="approved" onclick="$('.filter-btn').removeClass('active'); $(this).addClass('active');">Approved <small>{{ $approvedCount }}</small></button>
                          </div>
                          <div class="col-auto pt-0 me-sm-1 me-0 w-auto">
                            <button class="btn text-danger text-start filter-btn w-100 fw-medium" data-status="rejected" onclick="$('.filter-btn').removeClass('active'); $(this).addClass('active');">Rejected <small>{{ $rejectedCount }}</small></button>
                          </div>
                        </div>
                      </div>
                      <!-- Search bar -->
                      <div class="col-lg-4 mt-3 mt-lg-0 w-100-lg px-0" id="search-top-bar">
                        <div class="">
                          <input class="form-control border rounded" type="text" placeholder="Search" id="search-input">
                        </div>
                      </div>
                      <!-- /Search bar -->
                    </div>
                  </div>
                  </div>
                </div>
                <!-- /Whole top bar -->
                <div class="row ps-0 my-3">
                  <div class="col-12 d-sm-flex justify-content-between px-0">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                      <label class="form-label ps-0" for="sort">Sort by:</label>
                      <div class="d-flex w-100 justify-content-between">
                        <div class="col-lg-6 w-100">
                          <select id="sort" name="sort" class="form-control">
                            <option value="desc" selected>Date of Applying (DESC)</option>
                            <option value="asc">Date of Applying (ASC)</option>
                        </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-xxl-2col-xl-3 col-lg-2 col-md-4 col-sm-4 d-flex justify-content-sm-end align-items-center align-items-sm-end mt-2 mt-sm-0">
                      <div class="col-xl-5 col-lg-4 col-md-12 w-100 d-flex justify-content-sm-end align-items-center">
                        <a href="{{ route('admin.export') }}" class="btn btn-success w-auto" type="button" >
                          <i class="bi bi-box-arrow-up-left"></i>
                          &nbsp;
                          Export Applications
                        </a>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>

              <div class="card">
                <div class="mt-0 p-1 pt-2 table table-responsive">
                  <table id="loan-applications" class="table table-hover table-bordered" style="font-size: large;">
                    <thead>
                      <tr>
                        <th class='fw-medium'>#</th>
                        <th class='fw-medium'>Reference number</th>
                        <th class='fw-medium'>Account Number</th>
                        <th class='fw-medium'>Name</th>
                        <th class='fw-medium'>College/Dept</th>
                        <th class='fw-medium'>Type</th>
                        <th class='fw-medium'>Date of applying</th>
                        <th class='fw-medium'>Requested Amount</th>
                        <th class='fw-medium'>Finance Disbursed</th>
                        <th class='fw-medium'>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($loanApplications as $loanApplication)
                        <tr>
                          <td> {{ $loop->iteration }}</td>
                          <td><a href="{{ route('admin.loan.application', $loanApplication->loan_reference) }}" class="text-decoration-none text-primary">{{ $loanApplication->loan_reference }}</a></td>
                          <td> {{  $loanApplication->user->account_number}}</td>
                          <td> {{ $loanApplication->customer_name }}</td>
                          <td> {{ $loanApplication->college }}</td>
                          <td> {{ $loanApplication->loan_type }}</td>
                          <td> {{ \Carbon\Carbon::parse($loanApplication->application_date)->format('m/d/Y') }}</td>
                          <td> Php {{ number_format($loanApplication->financed_amount, 2) }}</td>
                          <td> Php {{ number_format($loanApplication->finance_charge, 2) }}</td>
                          <td>
                            <span class="@if($loanApplication->application_status == 'pending') text-primary-emphasis bg-primary-subtle fw-medium @elseif($loanApplication->application_status == 'approved') text-success fw-medium @elseif($loanApplication->application_status == 'rejected') text-danger fw-medium @endif px-2 py-1 rounded">{{ $loanApplication->application_status }}</span>

                          </td>
                          {{-- <td class="@if($loanApplication->application_status == 'pending') text-primary-emphasis fw-medium @elseif($loanApplication->application_status == 'approved') text-success fw-medium @elseif($loanApplication->application_status == 'rejected') text-danger fw-medium @endif"> {{ ucfirst($loanApplication->application_status) }}</td> --}}
                        </tr>
                      @endforeach
                    </tbody>
                  </table>  
                  
              </div>
              </div>
             
                <div id="pagination" class="pagination mt-3 flex-column">
                  <!-- Pagination links will be updated here by AJAX -->
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
document.addEventListener("DOMContentLoaded", function() {
    window.scrollTo(0, 0);
});

$(document).ready(function() {
    // Show preloader at the start
    showPreloader();

    var currentStatus = 'all'; 
    var currentSort = $('#sort').val(); 
    var query = $('#search-input').val(); 
    
    // Initial fetch for loans with preloader management
    fetchLoansByStatusAndSort(currentStatus, currentSort, query, 1, true); 

    // Event handler for filter buttons
    $('.filter-btn').on('click', function() {
        currentStatus = $(this).data('status');
        fetchLoansByStatusAndSort(currentStatus, currentSort, query); 
    });

    // Event handler for the search input
    $('#search-input').on('keyup', function() {
        query = $(this).val(); // Update the global query variable
        fetchLoansByStatusAndSort(currentStatus, currentSort, query);
    });

    // Event handler for the sort select dropdown
    $('#sort').on('change', function() {
        currentSort = $(this).val();
        fetchLoansByStatusAndSort(currentStatus, currentSort, query);
    });

    // Separate event handler for pagination links
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        handlePagination(currentStatus, currentSort, query, page); 
    });
    $('.filter-btn[data-status="all"]').trigger('click');
});

function fetchLoansByStatusAndSort(status, sort, query = '', page = 1, initialLoad = false) {
    setTimeout(function() {
        
        var url = `/admin/loans/filter/${status}?sort=${sort}&search=${encodeURIComponent(query)}&page=${page}`;
        fetchAndUpdate(url, initialLoad);
    }, 100);
}

function handlePagination(status, sort, query  = '', page) {
    showPreloader();
    setTimeout(function() {
        var url = `/admin/loans/filter/${status}?sort=${sort}&search=${encodeURIComponent(query)}&page=${page}`;
        fetchAndUpdate(url);
    }, 100); 
}

function updateShowingResults(counts, currentFilter) {
        const showingResultsElement = document.querySelector("#showing-results");
        if (!showingResultsElement) return;

        let text = `${counts[currentFilter] || 0}`; 
        showingResultsElement.textContent = text;
    }

function fetchAndUpdate(url, initialLoad = false) {
    var all = {{ $allCount }}
    fetch(url)
        .then(response => response.json())
        .then(data => {
            document.querySelector("#loan-applications tbody").innerHTML = data.html;
            
            // Check if pagination data is empty or not as expected
            if (!data.pagination.trim()) {
                // Manually create a minimal pagination structure
                document.querySelector("#pagination").innerHTML = `
                <nav class="d-flex justify-items-center justify-content-between">
                    <div class="d-flex justify-content-between flex-fill d-sm-none">
                        <ul class="pagination">
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link">« Previous</span>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="http://127.0.0.1:8000/admin/loans/filter/all?sort=desc&amp;search=&amp;status=all&amp;page=2" rel="next">Next »</a>
                            </li>
                        </ul>
                    </div>

                    <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
                        <div>
                            <p class="small text-muted">
                                Showing
                                <span class="fw-semibold">1</span>
                                to
                                <span class="fw-semibold">1</span>
                                of
                                <span class="fw-semibold" id="showing-results"></span>
                                results
                            </p>
                        </div>

                        <div>
                            <ul class="pagination">
                                <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                                    <span class="page-link" aria-hidden="true">‹</span>
                                </li>
                                <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                                <li class="page-item disabled">
                                    <a class="page-link" href="http://127.0.0.1:8000/admin/loans/filter/all?sort=desc&amp;search=&amp;status=all&amp;page=2" rel="next" aria-label="Next »">›</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                `;
            } else {
                document.querySelector("#pagination").innerHTML = data.pagination;
            }

            // Update the counts based on the current filter
            updateShowingResults(data.counts, data.currentFilter);

            if (initialLoad) {
                hidePreloader();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (initialLoad) {
                hidePreloader();
            }
        });
}

function showPreloader() {
    $('.spinner').show();
    // $('body').css('overflow', 'hidden'); // Make body unscrollable
}

function hidePreloader() {
    $('.spinner').hide();
    $('.spinner-body').hide();
    $('body').css('overflow', 'auto'); // Revert body to scrollable
}
</script>
@endsection
@endsection