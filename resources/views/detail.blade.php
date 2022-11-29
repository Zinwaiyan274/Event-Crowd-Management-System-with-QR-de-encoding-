@extends('layout.app')

@section('content')
    <section class="" style="background-color: white; height: 92.5vh;">
        <div class="container py-5 h-100">
            <h3 class="text-center">All Day Attendance Information</h3>
            <div class="row text-center mt-3">
                <div class="col-md-4 mb-3">
                    <a href="{{ route('detail') }}">
                        <div class="">
                            <button class="btn bg-dark text-white">All Days</button>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="{{ route('firstDayDetail') }}">
                        <div class="">
                            <button class="btn bg-dark text-white">First Day</button>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="{{ route('secondDayDetail') }}">
                        <div class="">
                            <button class="btn bg-dark text-white">Second Day</button>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Total count --}}
            <div class="row">
                <div class="text-center my-4">
                    <span class="fs-3"> Total Invitation :</span>
                    {{-- <span>{{ $total_people }}</span> --}}
                    <div class="frac" id='total_count'>
                        <span class="fs-4">{{ $total_people }}</span>
                        {{-- <span class="symbol">/</span>
                        <span class="bottom">{{ $total_people }}</span> --}}
                    </div>
                </div>
            </div>

            {{-- filter by company name and role --}}
            <div class="row justify-content-center my-4">
                <div class="col-3 ">
                    <select name="filter" id="filter" class="form-control" onchange="filterByCompany()">
                        <option value="">Select Company.....</option>
                        @foreach ($detail as $d)
                            <option value="{{ $d->company_name }}">{{ $d->company_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-3 ">
                    <select name="filter_role" id="filter_role" class="form-control" onchange="filterByRole()">
                        <option value="">Select Role.....</option>
                        <option value="judge">Judge</option>
                        <option value="guest">Guest</option>
                    </select>
                </div>

                <div class="col-3 ">
                    <select name="filter_attend" id="filter_attend" class="form-control" onchange="filterByAttend()">
                        <option value="">Select Attend or Not Attend.....</option>
                        <option value="attend">Attend</option>
                        <option value="not_attend">Not Attend</option>
                    </select>
                </div>

                <div class="col-3 ">
                    <form action="{{ route('detail') }}" method="GET">
                        @csrf
                        <div class="d-flex">
                            <input type="text" name="search" id="" class="form-control"
                                placeholder="Search Data...">
                            <button type="submit" class="btn btn-sm bg-dark text-white">Search</button>
                        </div>
                    </form>

                </div>
            </div>

            {{-- data table --}}
            <table class="table table-striped mt-3 text-center mb-5">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Company Name</th>
                        <th scope="col">Role</th>
                    </tr>
                </thead>
                <tbody id='filteredData'>
                    @foreach ($detail as $data)
                        <tr>
                            <th scope="row">{{ $data->name }}</th>
                            <td>{{ $data->company_name }}</td>
                            <td>{{ $data->role }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{ $detail->appends(request()->query())->links() }}
            </div>
            {{-- end data table --}}
        </div>
    </section>
@endsection

@section('js')
    <script>
        // filter by company name
        function filterByCompany() {
            let filter = document.getElementById('filter').value;
            $.ajax({
                url: '/filter/company',
                type: 'get',
                data: {
                    'filter': filter
                },
                dataType: 'json',
                success: function(response) {
                    let detail = response.filter_data.data;
                    let list = '';
                    let count = '';
                    for ($i = 0; $i < detail.length; $i++) {

                        list += `
                            <tr>
                            <th scope="row">${detail[$i].name}</th>
                            <td>${detail[$i].company_name}</td>
                            <td>${detail[$i].role}</td>
                            </tr>
                            `;

                        count = `
                            <span>${response.filter_people}</span>
                            <span class="symbol">/</span>
                            <span class="bottom">${response.total_people}</span>
                            `
                    }
                    document.getElementById('filteredData').innerHTML = list;
                    document.getElementById('total_count').innerHTML = count;
                }

            })
        }

        // filter by role
        function filterByRole() {
            let filter_role = document.getElementById('filter_role').value;
            $.ajax({
                url: '/filter/role',
                type: 'get',
                data: {
                    'filter_role': filter_role
                },
                dataType: 'json',
                success: function(response) {
                    let detail = response.filter_data.data;
                    let list = '';
                    let count = '';

                    for ($i = 0; $i < detail.length; $i++) {

                        list += `
                            <tr>
                            <th scope="row">${detail[$i].name}</th>
                            <td>${detail[$i].company_name}</td>
                            <td>${detail[$i].role}</td>
                            </tr>
                            `;

                        count = `
                            <span>${response.people}</span>
                            <span class="symbol">/</span>
                            <span class="bottom">${response.total_people}</span>`;

                    }
                    document.getElementById('filteredData').innerHTML = list;
                    document.getElementById('total_count').innerHTML = count;
                }

            })
        }

        // filter by all day attend or not
        function filterByAttend() {
            let filter_attend = document.getElementById('filter_attend').value;
            $.ajax({
                url: '/filter/attend',
                type: 'get',
                data: {
                    'filter_attend': filter_attend
                },
                dataType: 'json',
                success: function(response) {
                    {
                        let list = '';
                        let count = '';
                        let detail = response.filter_attend.data;

                        //append data for  attend
                        if (filter_attend == 'attend') {
                            for ($i = 0; $i < detail.length; $i++) {

                                list += `
                                    <tr>
                                        <th scope="row">${detail[$i].name}</th>
                                        <td>${detail[$i].company_name}</td>
                                        <td>${detail[$i].role}</td>
                                    </tr>`;

                                count = `
                                    <span>${response.attend_people}</span>
                                    <span class="symbol">/</span>
                                    <span class="bottom">${response.total_people}</span>`;

                            }
                            document.getElementById('filteredData').innerHTML = list;
                            document.getElementById('total_count').innerHTML = count;
                        }
                        //apend data for not attend
                        else{

                            for ($i = 0; $i < detail.length; $i++) {

                                list += `
                                        <tr>
                                            <th scope="row">${detail[$i].name}</th>
                                            <td>${detail[$i].company_name}</td>
                                            <td>${detail[$i].role}</td>
                                        </tr>`;

                                count = `
                                        <span>${response.not_attend_people}</span>
                                        <span class="symbol">/</span>
                                        <span class="bottom">${response.total_people}</span>`;

                            }
                            document.getElementById('filteredData').innerHTML = list;
                            document.getElementById('total_count').innerHTML = count;
                        }

                    }
                }
            })
        }
    </script>
@endsection
