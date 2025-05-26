@foreach($employees as $employee)
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
