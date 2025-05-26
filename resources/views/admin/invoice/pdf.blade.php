<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #eeeeee;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            color: #333;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            padding: 10px;
            border: 1px solid #eeeeee;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .total {
            text-align: right;
            font-size: 18px;
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #666;
        }

        .logo {
            width: 150px;
            height: auto;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="https://demo.hotelhelp.appniacs.com/public/logo.png" alt="Company Logo" class="logo">
            <h1>Invoice #{{ $invoice->invoice_number }}</h1>
            <p>Invoice Date: {{ $invoice->invoice_date }} | Due Date: {{ $invoice->due_date }}</p>
        </div>

        <h3>Hotel Details:</h3>
        <p><strong>Hotel Name:</strong> {{ $invoice->hotel->name }}</p>
        <p><strong>Email:</strong> {{ $invoice->hotel->email }}</p>
        <p><strong>Location:</strong> {{ $invoice->hotel->location }}</p>
        <p><strong>Invoice Date:</strong> {{ $invoice->created_at->format('y-m-d') }}</p>

        <h3>Invoice Items:</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Persons</th>
                    <th>Time (hrs)</th>
                    <th>Unit Price</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $item)
                    <tr>
                        <td>{{ $item->service }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->time }}</td>
                        <td>{{ number_format($item->price_per_unit, 2) }}</td>
                        <td>{{ $item->start_date }}</td>
                        <td>{{ $item->end_date }}</td>
                        <td>{{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            <strong>Total Amount: </strong>{{ number_format($invoice->total_amount, 2) }}
        </div>

        <div class="footer">
            <p>Thank you for doing business with us.</p>
            <p>If you have any questions, feel free to contact us.</p>
        </div>
    </div>
</body>

</html>
