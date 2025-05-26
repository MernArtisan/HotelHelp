@extends('admin.layouts.master')

@section('title', 'Employees Report')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    h1 {
        text-align: center;
    }

    .search-bar {
        margin-bottom: 20px;
        text-align: center;
    }

    .search-bar input {
        width: 50%;
        padding: 10px;
        font-size: 16px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;
    }

    th {
        background-color: #f4f4f4;
    }

    .chart-container {
        width: 45%;
        margin: 20px auto;
        display: inline-block;
    }
</style>

<div class="page-wrapper">
    <main class="main--container">
        <section class="main--content table-report">
            <div class="panel">
                <div class="container alert alert-light">

                    <h1>Employee Head Count</h1>

                    <div class="search-bar">
                        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for employees...">
                    </div>
                    <br>

                    <table id="employeeTable">
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employees as $key => $employee)
                            <tr>
                                <td>{{ $employee->employee_id }}</td>
                                <td>{{ $employee->user->first_name }} {{ $employee->user->middle_name }} {{ $employee->user->last_name }}</td>
                                <td>
                                    <button class="btn btn-sm 
                                        {{ $employee->status == 'active' ? 'btn-success' : 
                                            ($employee->status == 'terminated' ? 'btn-danger' : 
                                            ($employee->status == 'hold' ? 'btn-warning' : 
                                            ($employee->status == 'left' ? 'btn-secondary' : 'btn-dark'))) }}">
                                        {{ ucfirst($employee->status) }}
                                    </button>
                                </td>                                
                            </tr>
                            @empty
                                <tr><td colspan="3">No employees found.</td></tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="total">
                                <td colspan="2">Active Employees</td>
                                <td id="activeCount">{{ $activeCount }}</td>
                            </tr>
                            <tr class="total">
                                <td colspan="2">Terminated Employees</td>
                                <td id="terminatedCount">{{ $terminatedCount }}</td>
                            </tr>
                            <tr class="total">
                                <td colspan="2">Total Employees</td>
                                <td id="totalCount">{{ $totalCount }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </section>
    </main>
</div>
@endsection

@section('scripts')
<script>
    // Function to count employees and update totals
    function updateCounts() {
        const rows = document.querySelectorAll('#employeeTable tbody tr');
        let activeCount = 0;
        let terminatedCount = 0;

        rows.forEach(row => {
            const status = row.cells[2].textContent.trim().toLowerCase();
            if (status === 'active') {
                activeCount++;
            } else if (status === 'terminated') {
                terminatedCount++;
            }
        });

        // Update totals in the footer
        document.getElementById('activeCount').textContent = activeCount;
        document.getElementById('terminatedCount').textContent = terminatedCount;
        document.getElementById('totalCount').textContent = activeCount + terminatedCount;
    }

    // Function to filter table based on search input
    function searchTable() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#employeeTable tbody tr');

        rows.forEach(row => {
            const name = row.cells[1].textContent.toLowerCase();
            const status = row.cells[2].textContent.toLowerCase();
            if (name.includes(input) || status.includes(input)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        // Update counts after filtering
        updateCounts();
    }

    // Initialize counts on page load
    updateCounts();
</script>
@endsection
