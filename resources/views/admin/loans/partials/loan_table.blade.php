<tbody>
@foreach ($loanApplications as $loanApplication)
<tr>
    <td class="align-middle no-wrap"> {{ $loop->iteration }} </td>
    <td class="align-middle no-wrap"><a href="{{ route('admin.loan.application', $loanApplication->loan_reference) }}" class="text-decoration-none text-primary">{{ $loanApplication->loan_reference }}</a></td>
    <td class="align-middle no-wrap"> {{  $loanApplication->user->account_number}} </td>
    <td class="align-middle no-wrap"> {{ $loanApplication->customer_name }} </td>
    <td class="align-middle no-wrap"> {{ $loanApplication->college }} </td>
    <td class="align-middle no-wrap"> {{ $loanApplication->loan_type }} </td>
    <td class="align-middle no-wrap"> {{ \Carbon\Carbon::parse($loanApplication->application_date)->format('m/d/Y') }} </td>
    <td class="align-middle no-wrap"> Php {{ number_format($loanApplication->financed_amount, 2) }} </td>
    <td class="align-middle no-wrap"> Php {{ number_format($loanApplication->finance_charge, 2) }}</td>
    <td class="align-middle fs-6">
      <span class="@if($loanApplication->application_status == 'pending') text-primary-emphasis bg-primary-subtle fw-medium @elseif($loanApplication->application_status == 'approved') text-success bg-success-subtle fw-medium @elseif($loanApplication->application_status == 'rejected') text-danger-emphasis bg-danger-subtle fw-medium @endif px-2 py-1 rounded">{{ ucfirst($loanApplication->application_status) }}</span>
    </td>
  </tr>
@endforeach
</tbody>
