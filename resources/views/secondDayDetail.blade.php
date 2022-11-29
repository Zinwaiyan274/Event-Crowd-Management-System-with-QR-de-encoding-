@extends('layout.app')

@section('content')
    <section class="" style="background-color: white; height: 92.5vh;">
        <div class="container py-5 h-100">
            <h3 class="text-center">Second Day Attendance Information</h3>
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
                    <div class="frac" id='total_count'>
                        <span>{{ $first_people }}</span>
                        <span class="symbol">/</span>
                        <span class="bottom">{{ $total_people }}</span>
                    </div>
                </div>
            </div>

            {{-- filter by company name and role --}}
            <div class="row justify-content-center my-4">
                <div class="col-3 ">
                    <select name="filter" id="filter" class="form-control" onchange="filterByCompany()">
                        <option value="">Select Company.....</option>
                        @foreach ($secondDayData as $first)
                        <option value="{{ $first->company_name }}">{{ $first->company_name }}</option>
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
                    <form action="{{ route('secondDayDetail') }}" method="GET">
                        @csrf
                        <div class="d-flex">
                            <input type="text" name="search" id="" class="form-control" placeholder="Search Data...">
                            <button type="submit" class="btn btn-sm bg-dark text-white">Search</button>
                        </div>
                    </form>

                </div>
            </div>

            {{-- data table --}}
            <table class="table table-striped mt-3 text-center">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Company Name</th>
                    <th scope="col">Role</th>
                    <th scope="col">Attend Time</th>
                  </tr>
                </thead>
                <tbody id='filteredData'>
                    @foreach ($secondDayData as $data)
                    <tr>
                        <th scope="row">{{ $data->name }}</th>
                        <td>{{ $data->company_name }}</td>
                        <td>{{ $data->role }}</td>
                        <td>{{ $data->created_at->format('F-j-Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
              <div>
                {{ $secondDayData->appends(request()->query())->links() }}
              </div>
            {{-- end data table --}}
        </div>
    </section>
@endsection

@section('js')
    <script>
        // filter by company name
        function filterByCompany(){
            let filter = document.getElementById('filter').value;
            $.ajax({
                url: '/filter/company',
                type: 'get',
                data: {'filter': filter},
                dataType: 'json',
                success: function(response){
                    let detail = response.second_filter_data.data;
                        let list = '';
                        let count = '';
                        for($i=0; $i<detail.length; $i++){

                            //  Change Date Format
                        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                        $db_date = detail[$i].created_at
                        $date = new Date($db_date);
                        $new_date = $months[$date.getMonth()] +"-"+ $date.getDate() +"-"+ $date.getFullYear();

                            list += `
                            <tr>
                            <th scope="row">${detail[$i].name}</th>
                            <td>${detail[$i].company_name}</td>
                            <td>${detail[$i].role}</td>
                            <td>${$new_date}</td>
                            </tr>
                            `;

                            count = `
                            <span>${response.second_people}</span>
                            <span class="symbol">/</span>
                            <span class="bottom">${response.filter_people}</span>
                            `
                }
                document.getElementById('filteredData').innerHTML = list ;
                document.getElementById('total_count').innerHTML = count ;
            }

            })
        }

        // filter by role
        function filterByRole(){
            let filter_role = document.getElementById('filter_role').value;
            $.ajax({
                url: '/filter/role',
                type: 'get',
                data: {'filter_role': filter_role},
                dataType: 'json',
                success: function(response){
                    let detail = response.second_filter_data.data;
                        let list = '';
                        let count = '';

                        for($i=0; $i<detail.length; $i++){

                            //  Change Date Format
                        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                        $db_date = detail[$i].created_at
                        $date = new Date($db_date);
                        $new_date = $months[$date.getMonth()] +"-"+ $date.getDate() +"-"+ $date.getFullYear();

                            list += `
                            <tr>
                            <th scope="row">${detail[$i].name}</th>
                            <td>${detail[$i].company_name}</td>
                            <td>${detail[$i].role}</td>
                            <td>${$new_date}</td>
                            </tr>
                            `;

                            count = `
                            <span>${response.second_people}</span>
                            <span class="symbol">/</span>
                            <span class="bottom">${response.total_people}</span>`;

                }
                document.getElementById('filteredData').innerHTML = list ;
                document.getElementById('total_count').innerHTML = count ;
            }

            })
        }
    </script>
@endsection
