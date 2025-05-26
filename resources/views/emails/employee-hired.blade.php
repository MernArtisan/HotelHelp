<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f7;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            font-size: 16px;
            color: #333;
        }

        .header {
            background-color: #4e73df;
            color: white;
            text-align: center;
            padding: 30px;
            font-size: 26px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .content {
            padding: 30px;
            color: #555;
            line-height: 1.8;
        }

        .content p {
            margin-bottom: 20px;
        }

        .content ul {
            list-style-type: none;
            padding: 0;
            margin: 0 0 20px;
        }

        .content ul li {
            margin-bottom: 12px;
            font-size: 16px;
        }

        .content ul li strong {
            color: #333;
        }

        .button-container {
            text-align: center;
            margin: 30px 0;
        }

        .button {
            background-color: #4e73df;
            color: white;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 18px;
            transition: background-color 0.3s ease;
            display: inline-block;
        }

        .button:hover {
            background-color: #3758b1;
        }

        .footer {
            background-color: #f4f4f7;
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #777;
            border-top: 1px solid #eaeaea;
        }

        .footer a {
            color: #4e73df;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media screen and (max-width: 600px) {
            .email-container {
                width: 100%;
                margin: 20px auto;
                border-radius: 0;
            }

            .header,
            .content,
            .footer {
                padding: 20px;
            }

            .button {
                padding: 12px 24px;
                font-size: 16px;
            }
        }
    </style>
</head>

<body>

    <div class="email-container">
        <!-- Header Section -->
        <div class="header">
            Welcome to {{ config('app.name') }}!
        </div>

        <!-- Content Section -->
        <div class="content">
            <p>Dear {{ $user->name }},</p>
            <p>Congratulations! You have been successfully hired as a new member of our team. Below are your account
                details:</p>

            <ul>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Password:</strong> {{ $password }}</li>
            </ul>

            <p>Please use the credentials above to log in to your account. We strongly recommend changing your password
                upon logging in.</p>

            <!-- Button Section -->
            <div class="button-container">
                <a href="" class="button">Login to Your Account</a>
            </div>

            <p>We are thrilled to have you with us and look forward to working together!</p>
        </div>

        <!-- Footer Section -->
        <div class="footer">
            Best regards,<br>
            The {{ config('app.name') }} Team<br>
            {{-- <a href="">Visit our website</a> --}}
        </div>
    </div>

</body>

</html>
