@extends('admin.layouts.master')

@section('title', 'Announcements')
@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-row,
        .dropdown-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .search-row input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .dropdown-row select {
            width: 48%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea,
        .form-group button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-group button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="offset-1 col-10 offset-1">
                    <main class="main--container">
                        <section class="main--content table-report">
                            <div class="panel">
                                <div class="container alert alert-light">

                                    <h2>Hotel Announcement</h2>

                                    {{-- <!-- Search Row -->
                                    <div class="search-row">
                                        <input type="text" id="searchInput" placeholder="Search announcements...">
                                    </div>

                                    <!-- Dropdown Row -->
                                    --}}

                                    <!-- Announcement Form -->
                                    <!-- Add this in your Blade layout HEAD -->
                                    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
                                        rel="stylesheet" />

                                    <!-- Your Form -->
                                    <form id="emailForm" action="{{ route('admin.announcementsStore') }}" method="POST">
                                        @csrf

                                        <div class="form-group">
                                            <label>Jobs</label>
                                            <select name="jobs[]" id="jobs" class="form-control select2" multiple>
                                                <option value="All">All Jobs</option>
                                                @foreach ($jobs as $item)
                                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Roles</label>
                                            <select name="roles[]" id="roles" class="form-control select2" multiple>
                                                <option value="All">All Roles</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Hotels</label>
                                            <select name="hotels[]" id="hotels" class="form-control select2" multiple>
                                                <option value="All">All Hotels</option>
                                                @foreach ($hotels as $hotel)
                                                    <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Subject</label>
                                            <input type="text" name="notifyBy" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Message</label>
                                            <textarea name="message" rows="5" class="form-control" required></textarea>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Send Announcement</button>
                                        </div>
                                    </form>

                                    <!-- Include Select2 JS -->
                                    <script
                                        src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                                    <script>
                                        $(document).ready(function () {
                                            $('.select2').select2({
                                                placeholder: 'Select options',
                                                allowClear: true
                                            });
                                        });
                                    </script>


                                    <!-- Sent Emails Table -->
                                    <h3>All Announcements</h3>
                                    <table id="example">
                                        <thead>
                                            <tr>
                                                <th>Subject</th>
                                                <th>Message</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($announcements as $announcement)
                                                <tr>
                                                    <td>{{ $announcement->notifyBy }}</td>
                                                    <td>{{ $announcement->message }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <br>
                                    <br>
                                </div>
                        </section>
                    </main>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        const emailForm = document.getElementById('emailForm');
        const emailTable = document.getElementById('emailTable').querySelector('tbody');
        const searchInput = document.getElementById('searchInput');
        const filterCategory = document.getElementById('filterCategory');
        const broadcastTier = document.getElementById('broadcastTier');

        // Handle form submission
        emailForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const subject = document.getElementById('emailSubject').value.trim();
            const message = document.getElementById('emailContent').value.trim();
            const category = filterCategory.value;
            const tier = broadcastTier.value;
            const currentTime = new Date().toLocaleString();

            if (!subject || !message) {
                alert("Please fill in all fields.");
                return;
            }

            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                    <td>${subject}</td>
                    <td>${message}</td>
                    <td>${category}</td>
                    <td>${tier}</td>
                    <td>${currentTime}</td>
                    <td><button class="delete-btn">Delete</button></td>
                `;

            emailTable.appendChild(newRow);
            emailForm.reset();
        });

        // Handle search functionality
        searchInput.addEventListener('input', function () {
            const searchText = searchInput.value.toLowerCase();
            const rows = emailTable.querySelectorAll('tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const matches = Array.from(cells).some(cell =>
                    cell.textContent.toLowerCase().includes(searchText)
                );
                row.style.display = matches ? '' : 'none';
            });
        });

        // Handle delete button
        emailTable.addEventListener('click', function (event) {
            if (event.target.classList.contains('delete-btn')) {
                const row = event.target.closest('tr');
                row.remove();
            }
        });
    </script>
@endsection