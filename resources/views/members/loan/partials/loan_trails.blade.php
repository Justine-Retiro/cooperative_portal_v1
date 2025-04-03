@if($loanApplications->isEmpty())
    <tr>
        <td colspan="10" class="text-center">No loan records available</td>
    </tr>
@else
    @foreach($loanApplications as $loanApplication)
    @php
        $createdDate = \Carbon\Carbon::parse($loanApplication->created_at);
    @endphp  
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $loanApplication->loan_reference }}</td>
        <td>{{ $loanApplication->loan_type }}</td>
        <td>{{ \Carbon\Carbon::parse($loanApplication->created_at)->format('D, M d, Y') }}</td>
        <td>{{ \Carbon\Carbon::parse($loanApplication->due_date)->format('D, M d, Y') }}</td>
        <td>Php {{ number_format($loanApplication->financed_amount, 2) }}</td>
        <td>Php {{ number_format($loanApplication->finance_charge, 2) }}</td>
        <td>{{ $loanApplication->monthly_pay }}/mo</td>
        <td class="align-middle fs-6">
        <span class="@if($loanApplication->application_status == 'pending') text-primary-emphasis bg-primary-subtle fw-medium @elseif($loanApplication->application_status == 'approved') text-success bg-success-subtle fw-medium @elseif($loanApplication->application_status == 'rejected') text-danger-emphasis bg-danger-subtle fw-medium @endif px-2 py-1 rounded">{{ ucfirst($loanApplication->application_status) }}</span>
        </td>
        <td class="align-middle fs-6">
        <span class="@if($loanApplication->remarks == 'Unpaid' || $loanApplication->remarks == 'unpaid') text-danger-emphasis bg-danger-subtle fw-medium @elseif($loanApplication->remarks == 'paid' || $loanApplication->remarks == 'Paid') text-success bg-success-subtle fw-medium @endif px-2 py-1 rounded">{{ ucfirst($loanApplication->remarks) }}</span>
        </td>
        @if($loanApplication->note)
        <td><button class='btn btn-primary btn-sm w-100' data-bs-toggle='modal' data-bs-target='#noteModal' data-note="{{ $loanApplication->note }}">Note</button></td>
        @else
            <td>N/A</td>
        @endif
        </tr>
    @endforeach
@endif