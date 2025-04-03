@extends('layouts.app')
@section('title', 'View Applicant')
@section('content')
<div id="page-content-wrapper">
    <div class="container-fluid xyz">
      <div class="row">
        <div class="col-lg-12">
          <h1>Applicant Details</h1>
          <div class="">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('admin.repositories.pending') }}" class="text-decoration-none">New member's request</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Applicant Details</li>
              </ol>
          </nav>
          </div>
          <div class="row d-flex align-items-center pt-3 card" >
            <div class="row mb-3">
                <div class="col-lg-4">
                    <label for="last_name" class="fw-medium">Last Name</label>
                    <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $applyingMember->last_name }}" placeholder="Enter your last name" disabled>

                </div>
                <div class="col-lg-4">
                    <label for="middle_name" class="fw-medium">Middle Name</label>
                    <input type="text" class="form-control" name="middle_name" id="middle_name" value="{{ $applyingMember->middle_name }}" placeholder="Enter your middle name" disabled>

                </div>
                <div class="col-lg-4">
                    <label for="first_name" class="fw-medium">First Name</label>
                    <input type="text" class="form-control" name="first_name" id="first_name" value="{{ $applyingMember->first_name }}" placeholder="Enter your first name" disabled>

                </div>
            </div>
            
            <!-- Row 2 -->
            <div class="row mb-3">
                <div class="col-lg-4">
                    <label for="birth_date" class="fw-medium">Date of Birth</label>
                    <input type="text" class="form-control" name="birth_date" id="birth_date" value="{{ date('M-d-Y', strtotime($applyingMember->birth_date)) }}" placeholder="Enter your date of birth" disabled>

                </div>
                <div class="col-lg-4">
                    <label for="birth_place" class="fw-medium">Place of Birth</label>
                    <input type="text" class="form-control" name="birth_place" id="birth_place" value="{{ $applyingMember->birth_place }}" placeholder="Enter your place of birth" disabled>

                </div>
                
                <div class="col-lg-4">
                    <label for="phone_number" class="fw-medium">Phone Number</label>
                    <div class="input-group w-100">
                        <span class="input-group-text">+63</span>
                        <input type="number" class="form-control" name="phone_number" id="phone_number" value="{{ $applyingMember->phone_number }}" placeholder="Enter your phone number" oninput="if(this.value.length > 11) { alert('Phone number cannot exceed 11 digits.'); this.value = this.value.slice(0,11); }" disabled>
                    </div>
                </div>
            </div>
            
            <!-- Row 3 -->
            <div class="row mb-3">
                <div class="col-lg-4">
                    <label for="civil_status" class="fw-medium">Civil Status</label>
                    <select class="form-control" name="civil_status" id="civil_status" value="{{ $applyingMember->civil_status }}" disabled>
                        <option select>Select one</option>  
                        <option value="Single" {{ $applyingMember->civil_status == 'Single' ? 'selected' : '' }}>Single</option>
                        <option value="Married" {{ $applyingMember->civil_status == 'Married' ? 'selected' : '' }}>Married</option>
                        <option value="Divorced" {{ $applyingMember->civil_status == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                        <option value="Widowed" {{ $applyingMember->civil_status == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                    </select>
                </div>
                <div class="col-lg-4">
                    <label for="spouse_name" class="fw-medium">Name of Spouse</label>
                    <input type="text" class="form-control" name="spouse_name" id="spouse_name" value="{{ $applyingMember->spouse_name }}" placeholder="Enter your spouse name" disabled>
                   
                </div>
                <div class="col-lg-4">
                    <label for="citizenship" class="fw-medium">Citizenship</label>
                    <input type="text" class="form-control" name="citizenship" id="citizenship" value="{{ $applyingMember->citizenship }}" placeholder="Enter your citizenship" disabled>
                </div>
                
            </div>
            
            <div class="row mb-3">
                
                <div class="col-lg-4">
                    <label for="city_address" class="fw-medium">City Address</label>
                    <input type="text" class="form-control" name="city_address" id="city_address" value="{{ $applyingMember->city_address }}" placeholder="Enter your city address" disabled>
               
                </div>
                <div class="col-lg-4">
                    <label for="provincial_address" class="fw-medium">Provincial Address</label>
                    <input type="text" class="form-control" name="provincial_address" id="provincial_address" value="{{ $applyingMember->provincial_address }}" placeholder="Enter your provincial address" disabled>
                   
                </div>
                <div class="col-lg-4">
                    <label for="mailing_address" class="fw-medium">Home Address</label>
                    <input type="text" class="form-control" name="mailing_address" id="mailing_address" value="{{ $applyingMember->mailing_address }}" placeholder="Enter your mailing address" disabled>
                   
                </div>
            </div>
            
            <div class="row mb-3">
                
                <div class="col-lg-4">
                    <label for="email" class="fw-medium">Email</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ $applyingMember->email }}" placeholder="Enter your email" disabled>
                </div>
                <div class="col-lg-4">
                    <label for="taxID_num" class="fw-medium">Tax Identification Number</label>
                    <input type="text" class="form-control" name="tax_id_number" id="tax_id_number" value="{{ $applyingMember->tax_id_number }}" placeholder="Enter your tax identification number" disabled>
                </div>
                <div class="col-lg-4">
                    <label for="position" class="fw-medium">Work Position</label>
                    <input type="text" class="form-control" name="position" id="position" value="{{ $applyingMember->position }}" placeholder="Enter your position" disabled>
                </div>
            </div>
            <div class="row mb-3">
                
                <div class="col-lg-4">
                    <label for="date_employed" class="fw-medium">Date of Employment</label>
                    <input type="text" class="form-control" name="date_employed" id="date_employed" value="{{ date('M-d-Y', strtotime($applyingMember->date_employed)) }}" placeholder="Enter your date of employment" disabled>
                    
                </div>
                <div class="col-lg-4">
                    <label for="nature_of_work" class="fw-medium">Nature of Work</label>
                    <select class="form-control" name="nature_of_work" id="nature_of_work" value="{{ $applyingMember->nature_of_work }}" disabled>
                        <option value="Teaching" {{ $applyingMember->nature_of_work == 'Teaching' ? 'selected' : '' }}>Teaching</option>
                        <option value="Non-Teaching" {{ $applyingMember->nature_of_work == 'Non-Teaching' ? 'selected' : '' }}>Non-Teaching</option>
                        <option value="Others" {{ $applyingMember->nature_of_work == 'Others' ? 'selected' : '' }}>Others</option>
                    </select>
                </div>
                <div class="col-lg-4">
                    <label for="amount_of_share" class="fw-medium">Amount of shares</label>
                    <span data-bs-toggle="tooltip" data-bs-placement="right" title="Shares will be added to balance upon account approval.">
                        <i class="bi bi-info-circle"></i>
                    </span>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">₱</span>
                        <input type="number" class="form-control" name="amount_of_share" id="amount_of_share" min="2000" max="20000" value="{{ $applyingMember->amount_of_share }}" placeholder="Enter your amount of shares" title="Minimum ₱2,000.00 shares, Maximum ₱20,000.00 shares" disabled>
                    </div>

                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-4">
                    <label for="valid_id_type" class="fw-medium">Type of ID</label>
                    <select class="form-control" name="valid_id_type" id="valid_id_type" disabled>
                        <option value="">Select ID Type</option>
                        <option value="passport" {{ $applyingMember->valid_id_type == 'passport' ? 'selected' : '' }}>Passport</option>
                        <option value="driver_license" {{ $applyingMember->valid_id_type == 'driver_license' ? 'selected' : '' }}>Driver's License</option>
                        <option value="national_id" {{ $applyingMember->valid_id_type == 'national_id' ? 'selected' : '' }}>National ID</option>
                        <option value="voter_id" {{ $applyingMember->valid_id_type == 'voter_id' ? 'selected' : '' }}>Voter ID</option>
                        <option value="umid" {{ $applyingMember->valid_id_type == 'umid' ? 'selected' : '' }}>UMID</option>
                    </select>
                   
                </div>
            </div>

            <div class="row my-3">
                <div class="d-flex justify-content-between col-lg-12">
                    <div class="d-flex gap-3">
                        <div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#validIdPhotoModal">
                                View Valid ID Photo
                            </button>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#schoolIdPhotoModal">
                                View School ID Photo
                            </button>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        @if($applyingMember->status == 'Pending')
                            <form action="{{ route('admin.approve', $applyingMember->id) }}" method="post">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-success">Approve</button>
                            </form>
                            <form action="{{ route('admin.reject', $applyingMember->id) }}" method="post">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-danger">Reject</button>
                            </form>
                            @else
                        @endif
                    </div>
                </div>
                
                

            </div>
            @php
                use App\Http\Controllers\Admin\PendingController;
                $pendingController = new PendingController();
            @endphp
            <div class="row mb-3">
                <div class="w-50">
                    
                    <!-- Modal -->
                    <div class="modal fade" id="schoolIdPhotoModal" tabindex="-1" aria-labelledby="schoolIdPhotoModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="schoolIdPhotoModalLabel">School ID Photo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    
                                    @if($applyingMember->school_id_photo)
                                        @php
                                        $decryptedContent = $pendingController->getDecryptedImageContent($applyingMember->school_id_photo);
                                        @endphp
                                        
                                        <img class="img-fluid" src="data:image/jpeg;base64,{{ base64_encode($decryptedContent) }}" alt="School ID Photo">
                                        @if (session()->has('error'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-50">
                    <!-- Modal -->
                    <div class="modal fade" id="validIdPhotoModal" tabindex="-1" aria-labelledby="validIdPhotoModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="validIdPhotoModalLabel">Valid ID Photo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @if($applyingMember->valid_id_photo)
                                        @php
                                        $decryptedContent = $pendingController->getDecryptedImageContent($applyingMember->valid_id_photo);
                                        @endphp
                                        
                                        <img class="img-fluid" src="data:image/jpeg;base64,{{ base64_encode($decryptedContent) }}" alt="Valid ID Photo">
                                        @if (session()->has('error'))
                                            <div class="alert alert-danger" role="alert">
                                                {{ session('error') }}
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        @if(session()->has('success'))
            toastr.success('{{ session('success') }}');
        @endif
        @if(session()->has('message'))
            toastr.error('{{ session('message') }}');
        @endif
        $('[data-bs-toggle="tooltip"]').tooltip();
    });

</script>
    
@endsection