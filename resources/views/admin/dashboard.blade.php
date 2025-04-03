@extends('layouts.app')
@section('title', 'Dashboard')
@section('css')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
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
    <div class="container-fluid xyz pe-3 pe-md-5">
      <div class="row">
        <div class="col-lg-12">
          <div class="col-sm-12">
            <div id="user-greet" class="w-100">
                <h1>Hi, <span class="text-wrap">{{ Str::limit(Auth::user()->name, 25, '') }}</span>
                </h1>
              </div>
          </div>
         
          <h1>
            Dashboard Overview
          </h1>
          <div class="row gap-2" style="margin-top: 2em;">
            <div class="col-sm-12">
              @if (Auth::user()->permission_id == '1' || Auth::user()->permission_id == '3')
              <div class="col-sm-12 col-12 mb-3 d-flex flex-sm-row flex-column gap-3 w-100 ">
                <!-- Requests -->
                <div class="col-sm-6 card-whole mb-sm-0">
                  <div class="h-100 " id="card-container" style="width: auto;">
                    <div id="card-title" class="text-wrap">
                        <div>
                          <div>
                            <div>
                              <small class="text-muted">Total of Members</small>
                            </div>
                          </div>
                        <div>
                          <div>
                              <span style="font-size: 25px;">{{ $totalClients }} {{ $totalClients > 1 ? 'Members' : 'Member' }}</span>
                            </div>
                        </div>                      
                      </div>
                    </div>
                  </div>
                </div>
                {{-- Pending Application for the last 24 hours --}}
                <div class="col-sm-6 card-whole">
                  <div class="h-100" id="card-container" style="width: auto;">
                    <div id="card-title">
                        <div>
                          <div id="">
                              <div>
                                  <small class="text-muted">Total of Membership Applicants</small>
                              </div>
                          </div>
                          <div>
                              <div>
                                  <span style="font-size: 25px;">{{ $newMembershipApplicants }} {{ $newMembershipApplicants > 1 ? 'Applicants' : 'Applicant' }}</span>
                              </div>
                          </div>                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 mb-3 d-flex flex-sm-row flex-column gap-3 w-100">
                <!-- Requests -->
                <div class="col-sm-6 card-whole mb-sm-0">
                  <div class="h-100" id="card-container" style="width: auto;">
                    <div id="card-title">
                        <div>
                          <div id="">
                              <div>
                                  <small class="text-muted">Pending loan request</small>
                              </div>
                          </div>
                          <div>
                              <div>
                                  <small style="font-size: 25px;">{{ $pendingLoanRequests }} {{ $pendingLoanRequests > 1 ? 'Applications' : 'Application' }}</small>
                              </div>
                          </div>                        
                      </div>
                    </div>
                  </div>
                </div>
                {{-- Pending Application for the last 24 hours --}}
                <div class="col-sm-6 card-whole">
                  <div class="h-100" id="card-container" style="width: auto;">
                    <div id="card-title">
                        <div>
                          <div id="">
                              <div>
                                  <small class="text-muted">New loan request for the past 24 hours</small>
                              </div>
                          </div>
                          <div>
                              <div>
                                  <span style="font-size: 25px;">{{ $newLoanRequestsLast24Hours }} {{ $newLoanRequestsLast24Hours > 1 ? 'Applications' : 'Application' }}</span>
                              </div>
                          </div>                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 mt-3 d-flex flex-sm-row flex-column gap-3 w-100">
                <div class="col-sm-12 mb-3 d-flex flex-sm-row flex-column gap-3 w-100">
                {{-- Total of paid --}}
                <div class="col-sm-6 card-whole mb-sm-0">
                  <div class="h-100" id="card-container">
                    <div id="card-title">
                      <div>
                          <div>
                              <div>
                                  <small class="text-muted">Total of Paid Members</small>
                                </div>
                          </div>
                        <div>
                          <div>
                              <span style="font-size: 25px;">{{ $clientsPaid }} {{ $clientsPaid > 1 ? 'Members' : 'Member' }}</span>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                {{-- Total of Unpaid --}}
                <div class="col-sm-6 card-whole">
                  <div class="h-100" id="card-container">
                    <div id="card-title">
                      <div>
                          <div>
                              <div>
                                  <small class="text-muted">Total of Unpaid Members</small>
                                </div>
                          </div>
                        <div>
                          <div>
                              <span style="font-size: 25px;">{{ $clientsNotPaid }} {{ $clientsNotPaid > 1 ? 'Members' : 'Member' }}</span>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
              </div>
              @else
              <div class="col-sm-12 mt-3 d-flex flex-sm-row flex-column gap-3 w-100">
                <div class="col-sm-12 mb-3 d-flex flex-sm-row flex-column gap-3 w-100">
                {{-- Total of paid --}}
                <div class="col-sm-6 card-whole mb-sm-0">
                  <div class="h-100" id="card-container">
                    <div id="card-title">
                      <div>
                          <div>
                              <div>
                                  <small class="text-muted">Total of Paid Members</small>
                                </div>
                          </div>
                        <div>
                          <div>
                              <span style="font-size: 25px;">{{ $clientsPaid }} {{ $clientsPaid > 1 ? 'Members' : 'Member' }}</span>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                {{-- Total of Unpaid --}}
                <div class="col-sm-6 card-whole">
                  <div class="h-100" id="card-container">
                    <div id="card-title">
                      <div>
                          <div>
                              <div>
                                  <small class="text-muted">Total of Unpaid Members</small>
                                </div>
                          </div>
                        <div>
                          <div>
                              <span style="font-size: 25px;">{{ $clientsNotPaid }} {{ $clientsNotPaid > 1 ? 'Members' : 'Member' }}</span>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
              </div>
              @endif
              
              
              
            </div>
              
          </div>
      </div>
    </div>
  </div>
</div>

@endsection