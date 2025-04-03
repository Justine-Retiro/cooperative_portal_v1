@extends('layouts.app')
@section('title', 'Audit Logs')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/admin/application.css') }}"> --}}
<style>
.text-wrap {
    display: inline-block;
    max-width: 100%;
    word-wrap: break-word;
    white-space: normal;
}
.w-100 {
    overflow-wrap: break-word; /* Ensures breaking at the end of the boundary */
}
</style>
@endsection
@section('content')

<div id="page-content-wrapper">
    <div class="container-fluid xyz">
      <div class="row">
        <div class="col-12">
            <h1>Audit Logs</h1>
            <hr>
            <div class="card">
                <div class="table-responsive">
                    <table id="audit-table" class="table table-striped table-hover mt-0">
                        <thead>
                            <tr class="table-primary">
                                <th class="align-middle">#</th>
                                <th class="align-middle">ID</th>
                                <th class="align-middle">Action</th>
                                <th class="align-middle">User</th>
                                <th class="align-middle">Role</th>
                                <th class="align-middle">Description</th>
                                <th colspan="1">
                                    <button id="sort-date-time" class="text-decoration-underline-none btn d-flex justify-content-between">
                                        <span class="text-nowrap">Date and Time <i class="bi bi-arrow-up"></i></span>
                                        
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody >
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="pagination" class="pagination flex-column">
            </div>
        </div>
    </div>
  </div>
</div>
@section('script')
<script>
$(document).ready(function() {
    var currentPage = 1;
    var sort = 'asc'; // Default sort order

    function fetchLogs(order = 'asc') {
        var url = `{{ route("admin.audit.fetchRecords") }}?page=${currentPage}&order=${order}`;
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#audit-table tbody').html(response.html);
                $('#pagination').html(response.pagination);
            }
        });
    }

    $('#sort-date-time').click(function(e) {
        e.preventDefault();
        var $button = $(this);
        var currentOrder = $button.find('i').hasClass('bi-arrow-up') ? 'asc' : 'desc';
        sort = currentOrder === 'asc' ? 'desc' : 'asc'; // Toggle the order and update the 'sort' variable

        if (sort === 'asc') {
            $button.find('i').removeClass('bi-arrow-down').addClass('bi-arrow-up');
        } else {
            $button.find('i').removeClass('bi-arrow-up').addClass('bi-arrow-down');
        }

        fetchLogs(sort); // Fetch logs with the updated sorting order
    });

    $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var newPage = url.split('page=')[1];
        if (newPage !== undefined) {
            currentPage = newPage;
            // url += '&order=' + sort; // Append the sorting order to the URL
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    $('#audit-table tbody').html(response.html);
                    $('#pagination').html(response.pagination);
                }
            });
        }
    });

    fetchLogs(); // Initial fetch
});
</script>
@endsection
@endsection


