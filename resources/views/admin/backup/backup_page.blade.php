@extends('layouts.app')
@section('title', 'Backup')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection
@section('content')
<div id="page-content-wrapper">
    <div class="container-fluid xyz">
      <div class="row">
        <div class="col-lg-12">
        <h2>Backup Download</h2>

          <div class="col-lg-12 d-flex align-items-center mt-3" >
            <div class="form-wrap ">
              <form action="{{ route('admin.backup.download') }}" method="get">
                <button style="submit" class="btn btn-success">Download Backup</button>
              </form>
            </div>
          </div>         
        </div>
      </div>
    </div>
  </div>
@endsection