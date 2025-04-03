@foreach ($payments as $payment)
<tr>
    <td class="align-middle">{{ $loop->iteration }}</td>
    <td class="align-middle"> <a class="text-decoration-none fw-medium" href="{{ route('admin.payment.edit', $payment->user_id) }}">{{ $payment->user->account_number }}</a></td>
    <td class="align-middle">{{ ucfirst($payment->first_name . ' ' . $payment->last_name) }}</td>
    <td class="align-middle">Php {{ number_format($payment->balance, 2) }}</td>
    <td class="align-middle">{{ ucfirst($payment->remarks) }}</td>
    <td class="fw-medium align-middle fs-6 w-auto">
        <span class="{{ $payment->account_status == 'Active' ? 'text-success-emphasis bg-success-subtle' : 'text-danger-emphasis bg-danger-subtle' }} px-2 py-1 rounded fw-medium no-wrap">{{ $payment->account_status }}</span>
    </td>
    <td>
        <a href="{{ route('admin.payment.edit', $payment->user_id) }}" class="btn btn-primary">Edit</a>
    </td>
</tr>
@endforeach