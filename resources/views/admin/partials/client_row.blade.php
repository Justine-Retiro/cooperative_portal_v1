<table id="repository_table" class="table table-bordered" style="font-size: large;">

    <tbody>
      @foreach ($clients as $client)
        <tr>
          <td> {{ $loop->iteration }}</td>
          <td> {{ $client->user->account_number }}</td>
          <td> {{ $client->user->name }}</td>
          <td> {{ $client->birth_date->format('F j, Y') }}</td>
          <td> {{ $client->nature_of_work }}</td>
          @if ($client->account_status == 'Active')
            <td class="text-success fw-semibold"> {{ $client->account_status }}</td>
          @else
            <td class="text-danger fw-semibold"> {{ $client->account_status }}</td>
          @endif
          <td> {{ $client->amount_of_share }}</td>
          <td>
            <a href="{{ route('admin.edit-repo', $client->id) }}"><button class="btn btn-primary">Edit</button></a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table> 
