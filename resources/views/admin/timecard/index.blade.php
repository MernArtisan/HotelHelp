@extends('admin.layouts.master')
@section('title', 'Permission List')
<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 20px;
        background-color: #f4f7fa;
    }

    .page-wrapper {
        background-color: #ffffff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 30px;
    }

    h1 {
        font-size: 1.8rem;
        margin-bottom: 20px;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        border-radius: 8px;
        overflow: hidden;
    }

    th,
    td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ddd;
        color: #333;
    }

    th {
        background-color: rgb(139, 139, 139) !important;
        color: black !important;
        /* font-weight: bold; */
        font-size: 15px
    }

    td {
        font-size: 13px;
        background-color: #f9f9f9;
    }

    tr:nth-child(even) td {
        background-color: #f1f1f1;
    }

    tr:hover {
        background-color: #f1f9ff;
    }

    .highlight {
        background-color: #ffa500;
        color: white;
    }

    .regular {
        background-color: #007bff;
        color: white;
    }

    .search-bar {
        margin-bottom: 20px;
        display: flex;
        justify-content: flex-start;
        align-items: center;
    }

    .search-bar input {
        padding: 8px 12px;
        border-radius: 4px;
        border: 1px solid #ccc;
        font-size: 1rem;
    }

    .search-bar button {
        padding: 8px 12px;
        margin-left: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .search-bar button:hover {
        background-color: #0056b3;
    }

    .table-container {
        margin-top: 20px;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination a {
        padding: 10px 15px;
        margin: 0 5px;
        background-color: #007bff;
        color: white;
        border-radius: 4px;
        text-decoration: none;
    }

    .pagination a:hover {
        background-color: #0056b3;
    }

    .pagination a.active {
        background-color: #0056b3;
    }
</style>
@section('content')
    <div class="page-wrapper">
        <main class="main--container">
            <section class="main--content table-report">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header text-dark d-flex justify-content-between align-items-center">
                                <h2 class="page-title mb-0">EMPLOYEES TIME CARD</h2>
                                <hr>
                                <button type="button" class="btn btn-dark btn-sm" data-toggle="modal"
                                    data-target="#createTimeCard">
                                    <i class="fas fa-key"></i> + Mark Attendance
                                </button>
                            </div>
                        </div>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif
                </div>
                <div class="panel">
                    <div class="container alert alert-light">
                        <div class="form-inline mb-3">
                            <div class="form-group mx-2">
                                <label for="employee_id" class="sr-only">Employee ID</label>
                                <select class="form-control filter-select" id="filter-employee">
                                    <option value="">Select Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->employee_id }}">
                                            {{ $employee->employee_id }} - {{ $employee->user->first_name }}
                                            {{ $employee->user->middle_name }} {{ $employee->user->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mx-2">
                                <label for="hotel" class="sr-only">Hotel</label>
                                <select class="form-control filter-select" id="filter-hotel">
                                    <option value="">Select Hotel</option>
                                    @foreach ($hotels as $hotel)
                                        <option value="{{ $hotel->name }}">{{ $hotel->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mx-2">
                                <label for="paygroup" class="sr-only">Pay Group</label>
                                <select class="form-control filter-select" id="filter-paygroup">
                                    <option value="">Select Pay Group</option>
                                    @foreach ($payGroups as $payGroup)
                                        <option value="{{ $payGroup->name }}">{{ $payGroup->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button class="btn btn-secondary mx-2" id="reset-filters">Reset</button>
                        </div>
                    </div>

                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="table table-bordered nowrap" id="example" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Last Name</th>
                                        <th>Date</th>
                                        <th>Hotel</th>
                                        <th>Pay Group</th>
                                        <th>Start Time</th>
                                        <th>Break Start</th>
                                        <th>Break End</th>
                                        <th>End Time</th>
                                        <th>Total Work Hours</th>
                                        <th>Break Duration</th>
                                        <th>Wages</th>
                                    </tr>
                                </thead>

                                <tbody id="timecard-table-body">
                                    @forelse ($timeCard as $item)
                                        <tr>
                                            <td>{{ $item->employee->employee_id }}</td>
                                            <td>{{ $item->employee->user->first_name }}</td>
                                            <td>{{ $item->employee->user->middle_name }}</td>
                                            <td>{{ $item->employee->user->last_name }}</td>

                                            {{-- date is fine as-is (no TZ) --}}
                                            <td>{{ $item->date }}</td>

                                            <td>{{ $item->employee->hotel->name ?? 'N/A' }}</td>
                                            <td>{{ $item->employee->payGroup->name ?? 'N/A' }}</td>

                                            {{-- 4 clock columns — store UTC stamp in data-utc.
                                            Text inside <td> is a Karachi fallback for users with JS disabled. --}}
                                            <td class="time" data-utc="{{ $item->start_time->toIso8601String() }}">
                                                {{ $item->start_time->timezone('Asia/Karachi')->format('h:i A') }}
                                            </td>

                                            <td class="time" data-utc="{{ $item->break_start->toIso8601String() }}">
                                                {{ $item->break_start->timezone('Asia/Karachi')->format('h:i A') }}
                                            </td>

                                            <td class="time" data-utc="{{ $item->break_end->toIso8601String() }}">
                                                {{ $item->break_end->timezone('Asia/Karachi')->format('h:i A') }}
                                            </td>

                                            <td class="time" data-utc="{{ $item->end_time->toIso8601String() }}">
                                                {{ $item->end_time->timezone('Asia/Karachi')->format('h:i A') }}
                                            </td>

                                            <td>{{ $item->working_hours }} HR {{ $item->remaining_minutes }} MIN</td>
                                            <td>{{ $item->break_duration_in_minutes }} MIN</td>
                                            <td>${{ $item->total_amount ?? 'N/A' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="14" class="text-center">No timecards found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </section>
        </main>
    </div>


    <div class="modal fade" id="createTimeCard" tabindex="-1" role="dialog" aria-labelledby="createTimeCardLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white" id="createTimeCardLabel">Mark Attendance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.timecardPost') }}" id="createTimecard"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="employee_id" class="form-label">Employee ID</label>
                                    <div class="input-group">
                                        <select name="employee_id" id="employee_id" class="form-control">
                                            <option value="">Select Employee</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">
                                                    {{ $employee->employee_id }} - {{ $employee->user->first_name }}
                                                    {{ $employee->user->middle_name }} {{ $employee->user->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('employee_id')
                                        <small id="employee_id" class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="created_at" class="form-label">Date</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" name="date">
                                    </div>
                                    @error('date')
                                        <small id="date" class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="start_time" class="form-label">Start Time</label>
                                    <div class="input-group">
                                        <input type="time" class="form-control" name="start_time">
                                    </div>
                                    @error('start_time')
                                        <small id="start_time" class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="end_time" class="form-label">End Time</label>
                                    <div class="input-group">
                                        <input type="time" class="form-control" name="end_time">
                                    </div>
                                    @error('end_time')
                                        <small id="end_time" class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="break_start" class="form-label">Break Start</label>
                                    <div class="input-group">
                                        <input type="time" class="form-control" name="break_start">
                                    </div>
                                    @error('break_start')
                                        <small id="break_start" class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="break_end" class="form-label">Break End</label>
                                    <div class="input-group">
                                        <input type="time" class="form-control" name="break_end">
                                    </div>
                                    @error('break_end')
                                        <small id="break_end" class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer with Buttons -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Mark Attendance</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
        /**
         * Convert every <td class="time"> to the viewer’s local clock.
         * Runs once on load *and* each time DataTables redraws.
         */
        function renderLocalTimes(ctx = document) {
            const opts = { hour: '2-digit', minute: '2-digit', hour12: true };
            ctx.querySelectorAll('td.time').forEach(td => {
                const iso = td.dataset.utc;
                if (!iso) return;
                const local = new Date(iso);                         // auto-converts UTC→browser zone
                td.textContent = local.toLocaleTimeString(undefined, opts);
                td.title = local.toLocaleString();             // tooltip with full date+time
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Initial pass
            renderLocalTimes();

            // If you use DataTables, hook its draw event so new/filtered rows stay correct.
            const dt = $('#example').DataTable({
                responsive: true,
                order: [[0, 'asc']],
                drawCallback: function () {
                    // `this.api().table().body()` points to tbody element just redrawn
                    renderLocalTimes(this.api().table().body());
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get the filter dropdowns and table rows
            const employeeFilter = document.getElementById('filter-employee');
            const hotelFilter = document.getElementById('filter-hotel');
            const payGroupFilter = document.getElementById('filter-paygroup');
            const resetButton = document.getElementById('reset-filters');
            const tableBody = document.getElementById('timecard-table-body');
            const rows = tableBody.getElementsByTagName('tr');

            // Filter function
            function filterTable() {
                const employeeVal = employeeFilter.value.toLowerCase();
                const hotelVal = hotelFilter.value.toLowerCase();
                const payGroupVal = payGroupFilter.value.toLowerCase();

                // Loop through all rows and hide or show based on filter
                for (let i = 0; i < rows.length; i++) {
                    const employeeCol = rows[i].getElementsByTagName('td')[0].textContent.toLowerCase();
                    const hotelCol = rows[i].getElementsByTagName('td')[3].textContent.toLowerCase();
                    const payGroupCol = rows[i].getElementsByTagName('td')[4].textContent.toLowerCase();

                    const showRow = (employeeVal === '' || employeeCol.includes(employeeVal)) &&
                        (hotelVal === '' || hotelCol.includes(hotelVal)) &&
                        (payGroupVal === '' || payGroupCol.includes(payGroupVal));

                    rows[i].style.display = showRow ? '' : 'none';
                }
            }

            // Event listeners for dropdown change
            employeeFilter.addEventListener('change', filterTable);
            hotelFilter.addEventListener('change', filterTable);
            payGroupFilter.addEventListener('change', filterTable);

            // Reset filters
            resetButton.addEventListener('click', function () {
                employeeFilter.value = '';
                hotelFilter.value = '';
                payGroupFilter.value = '';
                filterTable();
            });

            // Initial filter on page load (in case filters were previously set)
            filterTable();
        });
    </script>
@endsection