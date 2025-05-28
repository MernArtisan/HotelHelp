<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Help | Login</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #d6d6d6d2;
            background-size: cover;
            background-position: center;
            box-sizing: border-box;
        }

        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 2px 1000px rgba(0, 0, 0, 0.1);
            width: 360px;
            text-align: center;
        }

        .login-container h2 {
            font-size: 26px;
            color: #333;
            margin-bottom: 30px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .input-field {
            width: 100%;
            padding: 14px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .input-field:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
        }

        .btn {
            width: 100%;
            padding: 15px;
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .forgot-password {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }

        .forgot-password a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .login-container img {
            width: 150px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <div class="login-container">
        <img src="{{ asset('logo.png') }}" alt="Logo">
        <h2>Login to Your Account</h2>


        <form action="{{ route('admin.authenticate') }}" method="POST">
            @csrf
            <input type="email" name="email" class="input-field" placeholder="Enter your email"
                value="{{ old('email') }}" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <input type="password" name="password" class="input-field" placeholder="Enter your password" required>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if (session('success'))
            var successSound = new Audio('{{ asset('admin/sounds/success.mp3') }}');
            successSound.play();
            toastr.success('{{ session('success') }}', 'Success');
        @endif

        @if (session('error'))
            var errorSound = new Audio('{{ asset('admin/sounds/error.mp3') }}');
            errorSound.play();
            toastr.error('{{ session('error') }}', 'Error');
        @endif
    </script>



    <script>
        toastr.options = {
            "closeButton": true, // Show close button
            "progressBar": true, // Show progress bar
            "positionClass": "toast-top-right", // Position the toast in the top right
            "timeOut": "5000", // Toast will disappear after 5 seconds
            "extendedTimeOut": "1000" // Extended time for closing the toast after hover
        };
    </script>

</body>

</html>
