@foreach ($clients as $client)
    <tr>
        <td class="align-middle no-wrap">{{ $loop->iteration }}</td>
        <td class="align-middle no-wrap"> <a class="text-decoration-none fw-medium" href="{{ route('admin.view-repo', ['id' => $client->user_id, 'account_number' => $client->user->account_number]) }}">{{ $client->user->account_number }}</a></td>
        <td class="align-middle no-wrap" class="name-cell" title="{{ $client->first_name . ' ' . $client->last_name }}">{{ Str::limit($client->first_name . ' ' . $client->last_name, 70) }}</td>
        <td class="align-middle no-wrap">{{ $client->birth_date->format('F j, Y') }}</td>
        <td class="align-middle no-wrap">{{ $client->nature_of_work }}</td>
        <td class="fw-medium align-middle fs-6 w-auto">
            <span class="{{ $client->account_status == 'Active' ? 'text-success-emphasis bg-success-subtle' : 'text-danger-emphasis bg-danger-subtle' }} px-2 py-1 rounded fw-medium no-wrap">{{ $client->account_status }}</span>
        </td>
        <td class="align-middle no-wrap">Php {{ number_format($client->balance, 2) }}</td>
        <td class="align-middle no-wrap">Php {{ $client->amount_of_share }}</td>
        <td class="align-middle">
            <a href="{{ route('admin.view-repo', ['id' => $client->user_id, 'account_number' => $client->user->account_number]) }}">
                <button class="btn btn-primary">View</button>
            </a>
        </td>
    </tr>
@endforeach
