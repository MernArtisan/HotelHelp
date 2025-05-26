@extends('admin.layouts.master')

@section('title', 'Privacy Policy')
@section('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        input[type="number"],
        input[type="text"],
        select {
            width: 100%;
            padding: 8px;
            margin: 4px 0;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .button {
            padding: 10px 20px;
            margin: 10px 0;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button-danger {
            background-color: #dc3545;
        }

        .button-container {
            text-align: right;
        }

        .total-row {
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="offset-1 col-10 offset-1">
                    <main class="main--container">
                        <section class="main--content table-report">
                            <div class="panel">
                                <div class="container alert alert-light">
                                    <br>
                                    <h2>Deductions</h2>
                                    <button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#createNewDeductions">
                                        <i class="fas fa-key"></i> + Create New Deduction
                                    </button>

                                    <div class="modal fade" id="createNewDeductions" tabindex="-1" role="dialog" aria-labelledby="createNewDeductionsLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-dark">
                                                    <h5 class="modal-title text-white" id="createNewDeductionsLabel">Create Deductions</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form method="POST" action="{{ route('admin.deductionsStore') }}" id="createNewDeductionsForm" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="container-fluid">
                                                            <div class="row">
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="deduction_type" class="form-label">Deductions Name</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-text"><i class="fas fa-key"></i></div>
                                                                        <input type="text" class="form-control" id="deduction_type" name="deduction_type" value="{{ old('deduction_type') }}" required>
                                                                    </div>
                                                                    @error('deduction_type')
                                                                        <small id="nameError" class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="amount" class="form-label">Amount</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-text"><i class="fas fa-key"></i></div>
                                                                        <input type="number" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" required>
                                                                    </div>
                                                                    @error('amount')
                                                                        <small id="amount" class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>


                                                                <div class="col-md-12 mb-3">
                                                                    <label for="deduction_reason" class="form-label">Deductions Reason</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-text"><i class="fas fa-key"></i></div>
                                                                        <textarea name="deduction_reason" class="form-control" id="deduction_reason">{!! old('deduction_reason') !!}</textarea>
                                                                    </div>
                                                                    @error('deduction_reason')
                                                                        <small id="deduction_reason" class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                    
                                                    <!-- Modal Footer with Buttons -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Create Deductions</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <!-- Search Section -->
                                    <div>
                                        <strong>Search Hotel:</strong>
                                        <input type="text" id="hotelSearch" placeholder="Enter Hotel Name"
                                            onkeyup="filterHotelList()">
                                    </div>

                                    <!-- Deductions Table -->
                                    <table id="deductionsTable">
                                        <thead>
                                            <tr>
                                                <th>Deductions Type</th>
                                                <th>Amount ($)</th>
                                                <th>Deductions Reason</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($deduction as $deductio)
                                                <tr>
                                                    <td>{{ $deductio->deduction_type }}</td>
                                                    <td>{{ $deductio->amount }}</td>
                                                    <td>{{ $deductio->deduction_reason }}</td>
                                                    <td class="text-center">
                                                        <a class="btn btn-danger btn-sm" href="{{route('admin.decutionDelete',$deductio->id)}}">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <p>No data available</p>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                        </section>
                    </main>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- <script>
        // Sample data for deductions
        const deductionTypes = [
            "Taxes",
            "Service Charges",
            "Employee Benefits",
            "Miscellaneous"
        ];

        let deductions = [];

        // Function to filter hotel list
        function filterHotelList() {
            const searchValue = document.getElementById("hotelSearch").value.toLowerCase();
            const rows = document.querySelectorAll("#deductionsTable tbody tr");
            rows.forEach(row => {
                const hotelName = row.cells[0].textContent.toLowerCase();
                if (hotelName.indexOf(searchValue) === -1) {
                    row.style.display = "none";
                } else {
                    row.style.display = "";
                }
            });
        }

        // Function to add a new deduction row
        function addDeductionItem() {
            const tableBody = document.getElementById("deductionsTable").querySelector("tbody");
            const row = document.createElement("tr");

            row.innerHTML = `
                <td>
                    <select>
                        ${deductionTypes.map(type => `<option value="${type}">${type}</option>`).join('')}
                    </select>
                </td>
                <td><input type="number" value="0" min="0" onchange="calculateNetAmount()"></td>
                <td><input type="text" placeholder="Enter deduction reason" onchange="calculateNetAmount()"></td>
                <td><button class="button button-danger" onclick="removeDeductionItem(this)">Remove</button></td>
            `;
            tableBody.appendChild(row);
            calculateNetAmount();
        }

        // Function to remove a deduction row
        function removeDeductionItem(button) {
            button.parentElement.parentElement.remove();
            calculateNetAmount();
        }

        // Function to calculate the total deductions and net earnings
        function calculateNetAmount() {
            const rows = document.querySelectorAll("#deductionsTable tbody tr");
            let totalDeductions = 0;

            rows.forEach(row => {
                const amount = parseFloat(row.cells[1].querySelector("input").value) || 0;
                totalDeductions += amount;
            });

            document.getElementById("totalDeductions").textContent = `$${totalDeductions.toFixed(2)}`;

            const totalEarnings = parseFloat(document.getElementById("totalEarnings").value) || 0;
            const netEarnings = totalEarnings - totalDeductions;
            document.getElementById("netEarnings").textContent = `$${netEarnings.toFixed(2)}`;
        }

        // Confirm Deductions Function
        function confirmDeduction() {
            const rows = document.querySelectorAll("#deductionsTable tbody tr");
            let confirmationMessage = "Confirming the following deductions:\n\n";

            rows.forEach(row => {
                const deductionType = row.cells[0].querySelector("select").value;
                const amount = row.cells[1].querySelector("input").value;
                const reason = row.cells[2].querySelector("input").value;

                confirmationMessage +=
                    `Deduction Type: ${deductionType}\nAmount: $${amount}\nReason: ${reason}\n\n`;
            });

            const totalDeductions = document.getElementById("totalDeductions").textContent;
            const netEarnings = document.getElementById("netEarnings").textContent;

            confirmationMessage += `Total Deductions: ${totalDeductions}\nNet Earnings: ${netEarnings}`;

            if (confirm(confirmationMessage)) {
                alert("Deductions Confirmed!");
            } else {
                alert("Deductions not confirmed.");
            }
        }
    </script> --}}
@endsection
