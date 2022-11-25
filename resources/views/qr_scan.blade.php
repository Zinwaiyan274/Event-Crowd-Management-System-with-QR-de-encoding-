@extends('layout.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-6">
            <video src="" id="preview" width="100%"></video>
        </div>
        <div class="col-4">
            <form action="{{ route('scan') }}" method="post">
                @csrf
                <input type="text" name="text" id="text" readonly="" placeholder="Value" class="form-control"> <br>
                <button class="btn btn-outline-success" type="submit">Save</button>
            </form>
        </div>

    </div>
    <div class="row fs-4 mt-5">
        <div class="col">
            <table class="table table-success table-striped">
                <thead>
                  <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Role</th>
                    <th scope="col">Company Name</th>
                    {{-- <th scope="col">Attend</th> --}}
                    <th scope="col">Attended Time</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $item)
                  <tr>
                    <th scope="row">{{ $item->id }}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->role }}</td>
                    <td>{{ $item->company_name }}</td>
                    {{-- <td></td> --}}
                    <td>{{ $item->created_at->format('Y-m-d h:i:s A') }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
      scanner.addListener('scan', function (content) {
        document.getElementById('text').value = content;
      });
      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
          scanner.start(cameras[0]);
        } else {
          console.error('No cameras found.');
        }
      }).catch(function (e) {
        console.error(e);
      });
</script>
@endsection
