<table class="table table-hover table-fixed table-bordered table-lock-height" style="font-size: large;" >
    <thead>
    <tr>
        <th class='fw-medium'>#</th>
        <th class='fw-medium'>Account Number</th>
        <th class='fw-medium'>Name</th>
        <th class='fw-medium'>Balance</th>
        <th class='fw-medium'>Remarks</th>
        <th class='fw-medium'>Status</th>
        <th class='fw-medium'>Actions</th>
    </tr>
    </thead>
    <tbody>
    {{-- For loop --}}
      @foreach ($payments as $payment)
      <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $payment->user->account_number }}</td>
          <td>{{ ucfirst($payment->first_name . ' ' . $payment->last_name) }}</td>
          <td>Php {{ number_format($payment->balance, 2) }}</td>
          <td>{{ ucfirst($payment->remarks) }}</td>
          <td>{{ ucfirst($payment->account_status) }}</td>
          <td>
              <a href="{{ route('admin.payment.edit', $payment->user_id) }}" class="btn btn-primary">Edit</a>
          </td>
      </tr>
      @endforeach
    </tbody>
</table>
<!-- Pagination Links -->
{{ $payments->links() }} 
