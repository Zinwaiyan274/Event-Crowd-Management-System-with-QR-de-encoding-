@extends('layout.app')

@section('content')
<section class="" style="background-color: #d2c9ff; height: 92.5vh;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-8">
                <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            {{-- data input --}}
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="d-flex justify-content-between align-items-center mb-5">
                                        <h1 class="fw-bold mb-0 text-black">QR Code Generator</h1>
                                    </div>
                                    <hr class="my-4">
                                        <div class="row mb-4 d-flex justify-content-between align-items-center">
                                            <form action="{{ route('generateQr') }}" method="post">
                                                @csrf
                                                <div class="form-outline mb-4">
                                                    <label for="form-label">Attendee Name</label>
                                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                                </div>
                                                <div class="form-outline mb-4">
                                                    <label for="form-label">Role</label>
                                                    <input type="text" class="form-control" name="role">
                                                </div>
                                                <div class="form-outline mb-4">
                                                    <label for="form-label">Company Name</label>
                                                    <input type="text" class="form-control" name="companyName">
                                                </div>
                                                <div class="mb-4 text-end">
                                                    <button type="submit" class="btn btn-outline-success fs-5">
                                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    <hr class="my-4">
                                </div>
                            </div>
                            {{-- data input --}}

                            {{-- QR Code Show --}}
                            <div class="col-lg-6" style="background-color: #d3d3d3">
                                <div class="p-5">
                                    <div class="d-flex justify-content-center align-items-center mb-5">
                                        <h1 class="fw-bold mb-0 text-black">QR Code </h1>
                                    </div>
                                    <hr class="my-2">
                                    @foreach ($data as $item)
                                        <div class="text-center">
                                            <h1>{{ $item->name }}</h1>
                                            <img src="{{ asset("storage/$item->qr") }}" width="200" alt="qr" class="mb-2"> <br>
                                            <a href="{{ Storage::url($item->qr) }}" target="_blank" download class="text-decoration-none">Download</a>
                                        </div>
                                    @endforeach
                                    <div class="d-flex justify-content-center mt-3">
                                        {{ $data->links() }}
                                    </div>
                                    <hr class="my-2">
                                    <p class="text-end">Total Attendee - {{ $count }}</p>

                                </div>
                            </div>
                            {{-- QR Code Show --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
