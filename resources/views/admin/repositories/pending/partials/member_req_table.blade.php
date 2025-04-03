@foreach ($applyingMembers as $applyingMember)
    <tr>
        <td class="align-middle no-wrap">{{ $loop->iteration }}</td>
        <td class="align-middle no-wrap"><a class="text-decoration-none fw-medium" href="{{ route('admin.view-applicant', $applyingMember->id) }}">{{ $applyingMember->first_name }} {{ $applyingMember->last_name }}</a></td>
        <td class="align-middle no-wrap">{{ \Carbon\Carbon::parse($applyingMember->birth_date)->format('F j, Y') }}</td>
        <td class="align-middle no-wrap">{{ $applyingMember->position }}</td>
        <td class="align-middle no-wrap">{{ $applyingMember->nature_of_work }}</td>
        <td class="align-middle no-wrap">{{ \Carbon\Carbon::parse($applyingMember->date_employed)->format('F j, Y') }}</td>
        <td class="align-middle no-wrap">Php {{ number_format($applyingMember->amount_of_share, 2) }}</td>
        <td class="align-middle no-wrap">{{ $applyingMember->created_at->toFormattedDateString() }}</td>
        <td class="align-middle fs-6">
            <span class="{{ $applyingMember->status == 'Approved' ? 'text-success-emphasis bg-success-subtle' : ($applyingMember->status == 'Pending' ? 'text-primary-emphasis bg-primary-subtle' : 'text-danger-emphasis bg-danger-subtle ') }} px-2 py-1 rounded  fw-medium">{{ $applyingMember->status }}</span>
        </td>
        <td class="align-middle">
            <a href="{{ route('admin.view-applicant', $applyingMember->id) }}">
                <button class="btn btn-primary">View</button>
            </a>
        </td>
    </tr>
@endforeach

