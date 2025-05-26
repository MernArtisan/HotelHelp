@extends('admin.layouts.master')

@section('title', 'Announcements')
@section('content')
    <style>
        body {
            color: black;
        }

        th {
            color: rgb(255, 255, 255);
        }

        td {
            color: black;
            font-weight: bold;
        }

        .abc {
            color: black;
            font-weight: bold;
        }
    </style>
    <main class="main--container">
        <section class="main--content table-report">
            <div class="panel">
                <div class="container alert alert-light mt-4 p-4">


                    <!-- Filter Section -->
                    <div class="filter-section mb-4 abc">
                        <h1 class="mb-4">Payroll Report</h1>
                        <div class="row g-3">
                            <!-- Date Filter -->
                            <div class="col-md-3">
                                <label for="dateFilter" class="form-label">Date:</label>
                                <input type="date" class="form-control" id="dateFilter" onchange="filterTable()">
                            </div>

                            <!-- Employee Filter -->
                            <div class="col-md-3">
                                <label for="employeeFilter" class="form-label">Employee:</label>
                                <input type="text" class="form-control" id="employeeFilter"
                                    placeholder="Enter Employee Name" onkeyup="filterTable()">
                            </div>

                            <!-- Pay Group Filter -->
                            <div class="col-md-3">
                                <label for="payGroupFilter" class="form-label">Pay Group:</label>
                                <select id="payGroupFilter" class="form-control" onchange="filterTable()">
                                    <option value="">Select Pay Group</option>
                                    @foreach ($payGroups as $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <!-- Hotel Filter -->
                            <div class="col-md-3">
                                <label for="hotelFilter" class="form-label">Hotel:</label>
                                <select id="hotelFilter" class="form-control" onchange="filterTable()">
                                    <option value="">All</option>
                                    @foreach ($hotels as $hotel)
                                        <option value="{{ $hotel->name }}">{{ $hotel->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <!-- Employee Type Filter -->
                            <div class="col-md-3">
                                <label for="employeeTypeFilter" class="form-label">Employee Type:</label>
                                <select id="employeeTypeFilter" class="form-control" onchange="filterTable()">
                                    <option value="">All</option>
                                    <option value="W2">W2</option>
                                    <option value="1099">1099</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Table Section -->
                    <table class="table table-striped table-bordered" id="example">
                        <thead class="table-dark">
                            <tr>
                                <th>Date</th>
                                <th>Employee</th>
                                <th>Employee ID</th>
                                <th>Hotel</th>
                                <th>Pay Group</th>
                                <th>Hours</th>
                                <th>Pay Rate</th>
                                <th>Payroll Cost</th>
                                <th>Employee Type</th>
                                <th>Invoice</th> <!-- Add Invoice column -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td>{{ $employee->timecards[0]->date }}</td>
                                    <td>{{ $employee->user->first_name }} {{ $employee->user->middle_name }} {{ $employee->user->last_name }}</td>
                                    <td>{{ $employee->employee_id }}</td>
                                    <td>{{ $employee->hotel->name }}</td>
                                    <td>{{ $employee->payGroup->name }}</td>
                                    <td>{{ $employee->timecards->sum('total_hours') }}</td>
                                    <td>${{ $employee->pay_rate }}</td>
                                    <td>${{ $employee->timecards->sum('total_amount') }}</td>
                                    <td>{{ $employee->employee_type }}</td>
                                    
                                    <!-- Link to download PDF invoice -->
                                    <td>
                                        <a href="{{ route('admin.employee.invoice', $employee->id) }}" class="btn btn-dark btn-sm">
                                            <i class="bi bi-printer"></i> 
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    

                </div>
            </div>
        </section>
    </main>

@endsection
@section('scripts')
    <script>
        function filterTable() {

            const dateFilter = document.getElementById("dateFilter").value;
            const employeeFilter = document.getElementById("employeeFilter").value.toLowerCase();
            const payGroupFilter = document.getElementById("payGroupFilter").value.toLowerCase();
            const hotelFilter = document.getElementById("hotelFilter").value.toLowerCase();
            const employeeTypeFilter = document.getElementById("employeeTypeFilter").value.toLowerCase();


            const rows = document.querySelectorAll("#example tbody tr");
            rows.forEach(row => {
                const cells = row.querySelectorAll("td");
                const date = cells[0].innerText;
                const employee = cells[1].innerText.toLowerCase();
                const hotel = cells[3].innerText.toLowerCase();
                const payGroup = cells[4].innerText.toLowerCase();
                const employeeType = cells[8].innerText.toLowerCase();


                if (
                    (dateFilter === "" || date.includes(dateFilter)) &&
                    (employeeFilter === "" || employee.includes(employeeFilter)) &&
                    (payGroupFilter === "" || payGroup.includes(payGroupFilter)) &&
                    (hotelFilter === "" || hotel.includes(hotelFilter)) &&
                    (employeeTypeFilter === "" || employeeType.includes(employeeTypeFilter))
                ) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
    </script>
@endsection
