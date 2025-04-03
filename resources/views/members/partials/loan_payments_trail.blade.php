
@forelse ($payments as $payment)
    @foreach ($payment->payment_pivot as $pivot)
        <tr>
            <td>{{ $loop->parent->iteration }}</td>
            <td>{{ $payment->reference_no }}</td>
            <td>{{ $pivot->loanApplication->loan_reference }}</td>
            <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('D, M d, Y') }}</td>
            <td>{{ $payment->amount_paid }}</td>
            <td>{{ $pivot->remarks }}</td>
            @if($payment->note)
                <td><button class='btn btn-primary btn-sm w-100' data-bs-toggle='modal' data-bs-target='#noteModal' data-note="{{ $payment->note }}">Note</button></td>
            @else
                <td>N/A</td>
            @endif
        </tr>
    @endforeach
@empty
    <tr><td colspan="7" class="text-center">No records found.</td></tr>
@endforelse