@extends('admin.layouts.master')

@section('title', 'Miscellaneous Field Categories')
@section('content')

    <main class="main--container">
        <section class="main--content table-report">
            <div class="panel">
                <div class="container alert alert-light">
                    <br>
                    <h1>Miscellaneous Field Categories</h1>

                    <div class="filters">
                        <input type="text" id="searchBar" class="form-control" placeholder="Search by Hotel Name or Category"
                            onkeyup="filterTable()">
                    </div>

                    <table id="categoriesTable" class="table table-bordered mt-4">
                        <thead>
                            <tr>
                                <th>Hotel Name</th>
                                <th>Item Name</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Existing Categories Rendered Here -->
                        </tbody>
                    </table>
                    <br>
                    <br>

                    <button class="btn btn-primary" onclick="addCategory()">Add New Category</button>
                    <button class="btn btn-success" onclick="saveChanges()">Save Changes</button>

                    <br>
                    <br>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const categoriesData = @json($miscellaneousItems); // Pre-loaded categories from server
        const hotels = @json($hotels); // Pre-loaded hotel data from server

        function filterTable() {
            const searchTerm = document.getElementById("searchBar").value.toLowerCase();
            const filteredData = categoriesData.filter(item =>
                item.hotel.name.toLowerCase().includes(searchTerm) ||
                item.category.toLowerCase().includes(searchTerm)
            );
            renderTable(filteredData);
        }

        function renderTable(data) {
            const tableBody = document.querySelector("#categoriesTable tbody");
            tableBody.innerHTML = ""; // Clear existing rows

            data.forEach((item) => {
                const row = document.createElement("tr");
                row.dataset.id = item.id; // Ensure each row has a unique identifier
                row.innerHTML = `
                <td>
                    <select id="hotel${item.id}" class="form-control" style="width: 95%;">
                        ${hotels.map(hotel => `
                                            <option value="${hotel.id}" ${item.hotel_id === hotel.id ? 'selected' : ''}>
                                                ${hotel.name}
                                            </option>
                                        `).join('')}
                    </select>
                </td>
                <td><input type="text" value="${item.item_name}" id="item_name${item.id}" class="form-control" style="width: 95%;"></td>
                <td><input type="text" value="${item.description}" id="description${item.id}" class="form-control" style="width: 95%;"></td>
                <td><input type="text" value="${item.category}" id="category${item.id}" class="form-control" style="width: 95%;"></td>
                <td>
                    <button class="btn btn-danger" onclick="deleteCategory(${item.id})">Delete</button>
                </td>
            `;
                tableBody.appendChild(row);
            });
        }

        function addCategory() {
            const newCategory = {
                id: categoriesData.length ? Math.max(...categoriesData.map(item => item.id)) + 1 :
                1, // Ensure unique ID
                hotel_id: hotels[0].id, // Default to the first hotel for new category
                item_name: "",
                description: "",
                category: ""
            };

            categoriesData.push(newCategory); // Add the new category to the data
            renderTable(categoriesData); // Re-render the table with the updated data
        }

        function deleteCategory(id) {
            // Confirm before deleting
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Remove category by id from the data array
                    const index = categoriesData.findIndex(item => item.id === id);
                    if (index > -1) {
                        categoriesData.splice(index, 1); // Remove category
                        renderTable(categoriesData); // Re-render the table with the updated data
                    }

                    // Send a request to the server to delete the category from the database
                    $.ajax({
                        url: `/delete-misc-field-category/${id}`, // Backend route
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}' // CSRF token for security
                        },
                        success: function(response) {
                            Swal.fire('Deleted!', 'The category has been deleted.', 'success');
                        },
                        error: function(error) {
                            Swal.fire('Error!', 'There was an error deleting the category.', 'error');
                            console.error(error);
                        }
                    });
                }
            });
        }

        function saveChanges() {
            const updatedCategories = [];
            const tableBody = document.querySelector("#categoriesTable tbody");
            const rows = tableBody.querySelectorAll("tr");

            rows.forEach((row) => {
                const id = row.dataset.id;
                const hotel = row.querySelector(`#hotel${id}`).value;
                const itemName = row.querySelector(`#item_name${id}`).value;
                const description = row.querySelector(`#description${id}`).value;
                const category = row.querySelector(`#category${id}`).value;

                updatedCategories.push({
                    id, // Include the id to update the category
                    hotel_id: hotel,
                    item_name: itemName,
                    description,
                    category
                });
            });

            // Perform save operation, like sending a request to Laravel backend (e.g., using AJAX)
            $.ajax({
                url: '/add-misc-field-categories',
                method: 'POST',
                data: {
                    categories: updatedCategories,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire('Success!', 'Categories saved successfully!', 'success');
                },
                error: function(error) {
                    Swal.fire('Error!', 'There was an error saving the categories.', 'error');
                    console.error(error);
                }
            });
        }

        renderTable(categoriesData); // Initial table render when the page loads
    </script>
@endsection
