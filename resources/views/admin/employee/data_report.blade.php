@extends('admin.layouts.master')

@section('title','Employees Report')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: left;
    }

    th {
        cursor: pointer;
        background-color: #f2f2f2;
    }

    .filter-section,
    .search-section {
        margin-bottom: 20px;
    }

    .filter-section select,
    .search-section input {
        margin-right: 20px;
        padding: 5px;
    }

    .all-label {
        margin-right: 10px;
        margin-left: 20px;
    }
</style>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <main class="main--container" id="main--container">
                        <section class="main--content table-report">
                            <div class="panel">
                                <div class="container alert alert-light p-4">
                                    <h1 class="text-center mb-4">Employee Report</h1>

                                    <div class="d-flex justify-content-between mb-3">
                                        <div class="row w-100">
                                            <div class="col-md-6 mb-3">
                                                <label for="searchBar" class="mr-2">Search:</label>
                                                <input type="text" id="searchBar" class="form-control"
                                                    placeholder="Search for anything..." onkeyup="searchTable()">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="hotelFilter" class="mr-2">Hotel:</label>
                                                <select id="hotelFilter" class="form-control" onchange="filterTable()">
                                                    <option value="">All</option>
                                                    @foreach ($hotels as $hotel)
                                                        <option value="{{ $hotel->name }}">{{ $hotel->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mb-3">
                                        <div class="row w-100">
                                            <div class="col-md-4 mb-3">
                                                <label for="stateFilter" class="mr-2">Location:</label>
                                                <select id="stateFilter" class="form-control" onchange="filterTable()">
                                                    <option value="">All</option>
                                                    @foreach ($locations as $location)
                                                        <option value="{{ $location->location }}">{{ $location->location }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="positionFilter" class="mr-2">Designation:</label>
                                                <select id="positionFilter" name="position" class="form-control"
                                                    onchange="filterTable()">
                                                    <option value="">All</option>
                                                    @foreach ($designations as $designation)
                                                        <option value="{{ $designation->name }}">{{ $designation->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="employeeTypeFilter" class="mr-2">Employee Type:</label>
                                                <select id="employeeTypeFilter" class="form-control"
                                                    onchange="filterTable()">
                                                    <option value="">All</option>
                                                    <option value="w2">W2</option>
                                                    <option value="1099">1099</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-container" id="table-container">
                                        <table id="employeeTable" class="table" id="">
                                            <thead style="background-color: #f2f2f2">
                                                <tr>
                                                    {{-- <th onclick="sortTable(0)">ID</th> --}}
                                                    <th width="15%" onclick="sortTable(1)">Full Name</th>
                                                    <th width="10%"  onclick="sortTable(2)">DOB</th>
                                                    {{-- <th onclick="sortTable(3)">Hire Date</th> --}}
                                                    <th width="10%" onclick="sortTable(4)">Pay Group</th>
                                                    <th width="20%" onclick="sortTable(5)">Hotel</th>
                                                    <th width="40%" onclick="sortTable(6)">Location</th>
                                                    <th onclick="sortTable(7)">Designation</th>
                                                    <th width="5%"  onclick="sortTable(8)">Type</th>
                                                </tr>
                                            </thead>
                                            <tbody id="employeeTableBody">
                                                @foreach ($employees as $employee)
                                                    <tr>
                                                        {{-- <td>{{ $employee->employee_id }}</td> --}}
                                                        <td>{{ $employee->user->first_name }} {{ $employee->user->middle_name }} {{ $employee->user->last_name }}</td>
                                                        <td>{{ $employee->user->birth_date }}</td>
                                                        {{-- <td>{{ $employee->hire_date }}</td> --}}
                                                        <td>{{ $employee->payGroup->name }}</td>
                                                        <td>{{ $employee->hotel->name }}</td>
                                                        <td>{{ $employee->location }}</td>
                                                        <td>{{ $employee->designation }}</td>
                                                        <td>{{ $employee->employee_type }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </section>
                    </main>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function searchTable() {
            const input = document.getElementById("searchBar").value.toLowerCase();
            const table = document.getElementById("employeeTable");
            const rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName("td");
                let match = false;

                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].innerText.toLowerCase().indexOf(input) > -1) {
                        match = true;
                        break;
                    }
                }

                rows[i].style.display = match ? "" : "none";
            }
        }

        function filterTable() {
            const hotelFilter = document.getElementById("hotelFilter").value;
            const stateFilter = document.getElementById("stateFilter").value;
            const positionFilter = document.getElementById("positionFilter").value;
            const employeeTypeFilter = document.getElementById("employeeTypeFilter").value;

            $.ajax({
                url: "{{ route('admin.employees-data-report') }}",
                method: 'GET',
                data: {
                    hotel: hotelFilter,
                    state: stateFilter,
                    position: positionFilter,
                    employee_type: employeeTypeFilter,
                },
                success: function(response) {
                    $('#employeeTableBody').html(response);
                }
            });
        }
 
    </script>
@endsection
