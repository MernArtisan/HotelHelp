@extends('admin.layouts.master')

@section('title', 'Miscellaneous Employee Fields')

@section('content')
<main class="main--container">
    <section class="main--content table-report">
        <div class="panel">
            <div class="container alert alert-light">
                <br>
                <h1>Miscellaneous Field Employee</h1>

                <div class="filters">
                    <input type="text" id="searchBar" class="form-control" placeholder="Search by Hotel"
                        onkeyup="filterTable()">
                </div>

                <table id="categoriesTable" class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>Hotel Name</th>
                            <th>Employee Name</th>
                            <th>Field</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <br><br>
                <button class="btn btn-primary" onclick="addCategory()">Add New Category</button>
                <button class="btn btn-success" onclick="saveChanges()">Save Changes</button>
                <br><br>
            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const categoriesData = @json($miscellaneousItems); // From backend
    const hotels = @json($hotels);
    const employees = @json($employees);

    function filterTable() {
        const searchTerm = document.getElementById("searchBar").value.toLowerCase();
        const filteredData = categoriesData.filter(item =>
            item.hotel.name.toLowerCase().includes(searchTerm) ||
            (
                item.employee.user.first_name + ' ' +
                (item.employee.user.middle_name ?? '') + ' ' +
                item.employee.user.last_name
            ).toLowerCase().includes(searchTerm)
        );
        renderTable(filteredData);
    }

    function renderTable(data) {
        const tableBody = document.querySelector("#categoriesTable tbody");
        tableBody.innerHTML = "";

        data.forEach((item) => {
            const row = document.createElement("tr");
            row.dataset.id = item.id;

            const employeeOptions = employees
                .filter(emp => emp.hotel_id === item.hotel_id)
                .map(emp => {
                    const fullName = `${emp.user.first_name ?? ''} ${emp.user.middle_name ?? ''} ${emp.user.last_name ?? ''}`;
                    return `<option value="${emp.id}" ${item.employee_id === emp.id ? 'selected' : ''}>
                        ${fullName.trim()}
                    </option>`;
                }).join('');

            const hotelOptions = hotels.map(hotel =>
                `<option value="${hotel.id}" ${item.hotel_id === hotel.id ? 'selected' : ''}>
                    ${hotel.name}
                </option>`
            ).join('');

            row.innerHTML = `
                <td>
                    <select id="hotel${item.id}" class="form-control" style="width: 95%;" onchange="filterEmployees(${item.id})">
                        ${hotelOptions}
                    </select>
                </td>
                <td>
                    <select id="employee${item.id}" class="form-control" style="width: 95%;">
                        ${employeeOptions}
                    </select>
                </td>
                <td><input type="text" value="${item.field_name}" id="field_name${item.id}" class="form-control" style="width: 95%;"></td>
                <td><input type="text" value="${item.field_value}" id="field_value${item.id}" class="form-control" style="width: 95%;"></td>
                <td>
                    <button class="btn btn-danger" onclick="deleteCategory(${item.id})">Delete</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    function filterEmployees(rowId) {
        const hotelId = document.querySelector(`#hotel${rowId}`).value;
        const employeeSelect = document.querySelector(`#employee${rowId}`);

        const filteredEmployees = employees.filter(emp => emp.hotel_id == hotelId);
        employeeSelect.innerHTML = filteredEmployees.map(emp => {
            const fullName = `${emp.user.first_name ?? ''} ${emp.user.middle_name ?? ''} ${emp.user.last_name ?? ''}`;
            return `<option value="${emp.id}">${fullName.trim()}</option>`;
        }).join('');
    }

    function addCategory() {
        const newId = categoriesData.length ? Math.max(...categoriesData.map(item => item.id)) + 1 : 1;
        const newCategory = {
            id: newId,
            hotel_id: hotels[0].id,
            employee_id: employees.find(e => e.hotel_id === hotels[0].id)?.id || employees[0].id,
            field_name: "",
            field_value: ""
        };
        categoriesData.push(newCategory);
        renderTable(categoriesData);
    }

    function deleteCategory(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                const index = categoriesData.findIndex(item => item.id === id);
                if (index > -1) {
                    categoriesData.splice(index, 1);
                    renderTable(categoriesData);
                }

                $.ajax({
                    url: `/delete-misc-employee-fields/${id}`,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire('Deleted!', 'The Employee Field has been deleted.', 'success');
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
        const rows = document.querySelectorAll("#categoriesTable tbody tr");

        rows.forEach((row) => {
            const id = row.dataset.id;
            const hotel = row.querySelector(`#hotel${id}`).value;
            const employee = row.querySelector(`#employee${id}`).value;
            const fieldName = row.querySelector(`#field_name${id}`).value;
            const fieldValue = row.querySelector(`#field_value${id}`).value;

            updatedCategories.push({
                id,
                hotel_id: hotel,
                employee_id: employee,
                field_name: fieldName,
                field_value: fieldValue
            });
        });

        $.ajax({
            url: '/add-misc-employee-fields',
            method: 'POST',
            data: {
                employeesFields: updatedCategories,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                Swal.fire('Success!', 'Employees Fields saved successfully!', 'success');
            },
            error: function(error) {
                Swal.fire('Error!', 'There was an error saving the categories.', 'error');
                console.error(error);
            }
        });
    }

    // Initial render
    renderTable(categoriesData);
</script>
@endsection
