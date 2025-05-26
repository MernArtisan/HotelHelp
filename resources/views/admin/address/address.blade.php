@extends('admin.layouts.master')
@section('title', 'Employee List')

@section('content')
    <div class="page-wrapper">
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }

            h2 {
                text-align: center;
            }

            input[type="text"] {
                width: 100%;
                padding: 8px;
                margin: 10px 0;
                font-size: 16px;
                border: 1px solid #ddd;
                border-radius: 5px;
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
                padding: 12px;
                text-align: left;
            }

            th {
                background-color: #f4f4f4;
            }
        </style>
        <main class="main--container">
            <section class="main--content table-report">
                <div class="panel">
                    <div class="container alert alert-light">
                        <br>
                        <h2>Client Addresses</h2>

                        <!-- Search Bar -->
                        <input type="text" id="searchBar" placeholder="Search by hotel name..." onkeyup="filterHotels()">

                        <!-- Table to display hotel details -->
                        <table id="hotelTable">
                            <thead>
                                <tr>
                                    <th>Hotel Name</th>
                                    <th>Address</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($hotels as $hotel)
                                    <tr class="hotel-row">
                                        <td>{{ $hotel->name }}</td>
                                        <td>{{ $hotel->address }}, {{ $hotel->location }}</td>
                                        <td>{{ $hotel->contact }}</td>
                                        <td>{{ $hotel->email }}</td>
                                    </tr>
                                @empty
                                    <p>No hotels found.</p>
                                @endforelse
                            </tbody>
                        </table>

                        <br>
                        <br>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>
        // Function to filter hotels based on the search input
        function filterHotels() {
            let input = document.getElementById('searchBar');
            let filter = input.value.toLowerCase();
            let table = document.getElementById('hotelTable');
            let tr = table.getElementsByTagName('tr');

            // Loop through all rows, except the first (header)
            for (let i = 1; i < tr.length; i++) {
                let td = tr[i].getElementsByTagName('td')[0]; // Target the first column (Hotel Name)
                if (td) {
                    let txtValue = td.textContent || td.innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = ''; // Show row
                    } else {
                        tr[i].style.display = 'none'; // Hide row
                    }
                }
            }
        }
    </script>

@endsection
