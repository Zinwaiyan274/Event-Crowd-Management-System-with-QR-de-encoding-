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
                <input type="text" name="text" id="text" readonly="" placeholder="Value" class="form-control">
                <button class="btn btn-outline-success mt-2" type="submit">Save</button>
            </form>
        </div>

    </div>
    <div class="row fs-4 mt-3">
        <div class="col">
            <div class="mb-3">
                <a href="{{ route('firstDay') }}">
                    <button class="btn btn-outline-danger">Day 1</button>
                </a>
                <a href="{{ route('secondDay') }}">
                    <button class="btn btn-outline-danger">Day 2</button>
                </a>
            </div>
            @yield('dayTable')
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
