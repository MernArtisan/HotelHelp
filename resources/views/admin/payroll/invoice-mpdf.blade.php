<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Invoice</title>
    <style>
        body {
            font-family: 'Arial, sans-serif';
            color: #333;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .heading {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #000000;
        }

        .invoice-details {
            margin-bottom: 30px;
        }

        .invoice-details p {
            margin: 5px 0;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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
            font-size: 14px;
        }

        th {
            background-color: #000000;
            color: #fff;
        }

        .total-section {
            margin-top: 30px;
            font-size: 18px;
            text-align: right;
        }

        .total-section h3 {
            margin: 5px 0;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
            font-size: 14px;
        }

        .signature p {
            margin-bottom: 40px;
        }

        .signature-line {
            border-top: 1px solid #333;
            display: inline-block;
            width: 200px;
            margin-top: 20px;
        }

        .logo {
            width: 150px;
            height: auto;
            margin-bottom: 10px;
            text-align: center;
        }

        .header {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="https://demo.hotelhelp.appniacs.com/public/logo.png" alt="Company Logo" class="logo"
                width="">
        </div>
        <h1 class="heading">Employee Invoice</h1>

        <div class="invoice-details">
            <p><strong>Employee Name:</strong> {{ $employee->user->name }}</p>
            <p><strong>Employee ID:</strong> {{ $employee->employee_id }}</p>
            <p><strong>Hotel:</strong> {{ $employee->hotel->name }}</p>
            <p><strong>Pay Group:</strong> {{ $employee->payGroup->name }}</p>
        </div>

        <h3>Timecards</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Total Hours</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employee->timecards as $timecard)
                    <tr>
                        <td>{{ $timecard->date }}</td>
                        <td>{{ \Carbon\Carbon::parse($timecard->start_time)->format('h:i A') }}</td>
                        <td>{{ \Carbon\Carbon::parse($timecard->end_time)->format('h:i A') }}</td>
                        <td>{{ $timecard->total_hours }} Hours</td>
                        <td>${{ $timecard->total_amount }} Wages</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <h3><strong>Total Work Hours:</strong> {{ $total_hours }} hours</h3>
            <h3><strong>Total Pay:</strong> ${{ number_format($total_pay, 2) }}</h3>
        </div>

        <div class="signature">
            <p>Authorized Signature</p>
            <div class="signature-line"></div>
        </div>
    </div>
</body>

</html>
