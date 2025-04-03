@extends('layouts.app')
@section('title', 'Repositories')
@section('css')
<link rel="stylesheet" href="{{ asset('css/repositories.css') }}">
<style>
  .no-wrap {
    white-space: nowrap; /* Prevents text from wrapping */
    overflow: hidden;    /* Keeps the content clipped to the container */
    text-overflow: ellipsis; /* Adds an ellipsis if the text overflows */
}
</style>
@endsection
@section('content')

<div id="page-content-wrapper">
  <div class="container-fluid xyz">
    <div class="row">
      <div class="col-lg-12 ">
        <h1>Members Repositories</h1>
        <div class="row pt-3 mt-3 card">
          <!-- Table -->
          <div class="row m-0">
            <div class="col-lg-12">
              <div class="row">
                <div class="row mb-3 pe-0">
                  <div class="col-lg-12 pe-0">
                    <div class="col-lg-12 col-md-12 col-sm-12 d-flex flex-column flex-xl-row align-items-stretch">
                      <div class="btn-group" role="group">
                        <a href="{{ route('admin.add-repo') }}" class="d-flex align-items-center me-3 ">
                          <button class="btn btn-primary" id="add-mem"><i class="bi bi-plus-lg text-light"></i> &nbsp;Add member</button>
                        </a>
                        <a href="{{ route('admin.repositories.pending') }}" class="d-flex text-decoration-none align-items-center me-md-3 ">
                          <button class="btn btn-outline-primary" id="add-mem"><small> {{ $memberApplicationsCount }} </small> &nbsp;Request New Members</button>
                        </a>
                      </div>
                      
                      <span class="ps-3 border-start border-md-start-0"></span>
                      <div class="mt-3 mt-xl-0 flex-grow-1">
                        <form action="{{ route('admin.search-repo') }}" method="GET">
                            <div class="">
                                <input class="form-control h-100" type="search" placeholder="Search" id="search-input" aria-describedby="button-addon1">
                            </div>
                        </form>
                      </div>
                      
                  </div>
                </div>
                
              </div>
              <hr>
                <div class="table table-responsive" id="client-repositories">
                  <table id="repository_table" class="table table-bordered table-hover" style="font-size: large;">
                    <thead>
                      <tr>
                      <th class='fw-medium'>#</th>
                      <th class='fw-medium'>Account Number</th>
                      <th class='fw-medium'>Name</th>
                      <th class='fw-medium'>Birth Date</th>
                      <th class='fw-medium'>Nature of Work</th>
                      <th class='fw-medium'>Status</th>
                      <th class='fw-medium'>Balance</th>
                      <th class='fw-medium'>Amount of share</th>
                      <th class='fw-medium'>Actions</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>  
                </div>
                <div id="pagination" class="pagination flex-column">
                  {{-- {{ $clients->links() }} --}}
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
  @if(session('success'))
        toastr.success('{{ session('success') }}');
    @elseif(session('error'))
        toastr.error('{{ session('error') }}');
    @endif
  var currentStatus = 'all';
  var currentSearch = '';
  var currentPage = 1;

  function fetchClients(url) {
    var url = `{{ route('admin.repositories.fetchRecords') }}?search=${encodeURIComponent(currentSearch)}&page=${currentPage}`;

    $.ajax({
      url: url,
      type: 'GET',
      success: function(response) {
        $('#repository_table tbody').html(response.html);
        $('#pagination').html(response.pagination);
      },
      error: function(xhr, status, error) {
          console.error(error);
      }
    });
  }
  $('[data-bs-toggle="tooltip"]').tooltip();

 // Event handler for pagination link click
  $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        var newPage = $(this).attr('href').split('page=')[1];
        if(newPage !== undefined) {
            currentPage = newPage;
            fetchClients();
        }
    });

  // Event handler for search input
  $('#search-input').on('input', function() {
    currentSearch = $(this).val();
    currentPage = 1;
    fetchClients();
  });
  fetchClients();
});
</script>
@endsection
@endsection