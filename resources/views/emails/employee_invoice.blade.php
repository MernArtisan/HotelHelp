<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Invoice Email</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 40px;">
    <div
        style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 6px; padding: 30px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

        <h2 style="color: #333333;">Hello {{ $empData['name'] }},</h2>

        <p style="font-size: 15px; color: #555;">
            Your task invoice has been generated successfully. Please find the details below:
        </p>

        <table style="width: 100%; margin-top: 20px; font-size: 14px; color: #333; border-collapse: collapse;">
            <tr>
                <td style="padding: 8px 0;"><strong>Invoice #:</strong></td>
                <td style="padding: 8px 0;">{{ $empData['invoice_number'] }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Pay Rate:</strong></td>
                <td style="padding: 8px 0;">${{ number_format($empData['pay_rate'], 2) }} per hour</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Per Day Hour:</strong></td>
                <td style="padding: 8px 0;">
                    {{ fmod($empData['time'], 1) == 0 ? intval($empData['time']) : number_format($empData['time'], 2) }}
                    Hours per Day
                </td>

            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Start Date:</strong></td>
                <td style="padding: 8px 0;">{{ $empData['start_date'] }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>End Date:</strong></td>
                <td style="padding: 8px 0;">{{ $empData['end_date'] }}</td>
            </tr>
        </table>

        <div style="margin-top: 30px;">
            <p style="font-size: 15px; color: #444;">Thanks & regards,</p>
            <p style="font-weight: bold; color: #222;">{{ config('app.name') }} Team</p>
        </div>
    </div>
</body>

</html>
