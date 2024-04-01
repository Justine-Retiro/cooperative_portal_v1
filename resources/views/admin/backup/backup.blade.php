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
        <h2>Backup authorization verification</h2>
          @if(session('message'))
            <div class="alert alert-success" role="alert">
              {{ session('message') }}
            </div>
          @elseif($errors->any())
            <div class="alert alert-danger" role="alert">
              @foreach($errors->all() as $error)
                {{ $error }}<br>
              @endforeach
            </div>
          @endif
          <div class="col-lg-12 d-flex  align-items-center mt-3" >
            <div class="form-wrap">
              <form action="{{ route('admin.backup.store') }}" method="POST" id="">
                @csrf
                @method('POST')
                <div class="form-group">
                  <label class="control-label mb-10" >Host</label>
                  <input type="text" class="form-control" placeholder="Enter Server Name EX: Localhost" name="server" id="server" required="" autocomplete="on">
                </div>
                <div class="form-group">
                  <label class="control-label mb-10" >Database Username</label>
                  <input type="text" class="form-control" placeholder="Enter Database Username EX: root" name="username" id="username" required="" autocomplete="on">
                </div>
                <div class="form-group">
                  <label class="pull-left control-label mb-10" >Database Password</label>
                  <input type="password" class="form-control" placeholder="Enter Database Password" name="password" id="password" >
                </div>
                <div class="form-group">
                  <label class="pull-left control-label mb-10">Database Name</label>
                  <input type="text" class="form-control" placeholder="Enter Database Name" name="dbname" id="dbname" required="" autocomplete="on">
                </div>
                <div class="form-group text-center mt-3">
                  <button type="submit" name="backupnow" class="btn btn-primary float-end">Initiate Backup</button>
                </div>
              </form>
            </div>
          </div>         
        </div>
      </div>
    </div>
  </div>
@endsection