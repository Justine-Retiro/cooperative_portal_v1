@if($recentLoanApplication->isEmpty())
    <tr>
    <td colspan="8" class="text-center">No recent loan records available.</td>
    </tr>
@else
    @foreach($recentLoanApplication as $loanApplication)
    @php
    $dueDate = \Carbon\Carbon::now()->addMonths($loanApplication->time_pay)->format('Y-m-d');
    @endphp  
    <tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $loanApplication->loan_reference }}</td>
    <td>{{ $loanApplication->loan_type }}</td>
    <td>{{ \Carbon\Carbon::parse($loanApplication->created_at)->format('D, M d, Y') }}</td>
    <td>{{ $loanApplication->due_date ? \Carbon\Carbon::parse($loanApplication->due_date)->format('D, M d, Y') : 'N/A' }}</td>
    <td>{{ $loanApplication->financed_amount }}</td>
    <td>{{ $loanApplication->finance_charge }}</td>
    <td>{{ $loanApplication->monthly_pay }}/mo</td>
    </tr>
    @endforeach
@endif