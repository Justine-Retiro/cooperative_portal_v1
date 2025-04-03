@foreach ($auditLogs as $log)
@if($auditLogs->isEmpty())
<tr>
    <td colspan="7" class="text-center">No audit records available.</td>
</tr>
@else
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $log->id }}</td>
    <td>{{ ucfirst($log->action) }}</td>
    <td>{{ $log->user->name }}</td>
    <td>{{ $log->permission_type }}</td>
    <td>{{ ucfirst($log->description) }}</td>
    <td class="text-nowrap ps-4">{{ $log->created_at->format('D, M d, Y h:i A') }}</td>
</tr>
@endif
@endforeach

