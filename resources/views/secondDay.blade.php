@extends('qr_scan')

@section('dayTable')
<table class="table table-success table-striped">
    <thead>
      <tr>
        <th scope="col">Id</th>
        <th scope="col">Name</th>
        <th scope="col">Role</th>
        <th scope="col">Company Name</th>
        <th scope="col">Attended Time</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($secondDay as $item)
      <tr>
        <th scope="row">{{ $item->id }}</th>
        <td>{{ $item->name }}</td>
        <td>{{ $item->role }}</td>
        <td>{{ $item->company_name }}</td>
        <td>{{ $item->created_at->format('Y-m-d h:i:s A') }}</td>
      </tr>
      @endforeach
    </tbody>
</table>
@endsection
