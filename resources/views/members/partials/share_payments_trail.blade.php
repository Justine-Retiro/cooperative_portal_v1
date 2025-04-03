@foreach ($sharePayments as $sharePayment)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $sharePayment->payment->reference_no }}</td> 
    <td>{{ \Carbon\Carbon::parse($sharePayment->payment->created_at)->format('D, M d, Y') }}</td>
    <td>{{ $sharePayment->payment->amount_paid }}</td>
    <td>{{ $sharePayment->remarks }}</td>
</tr>
@endforeach
