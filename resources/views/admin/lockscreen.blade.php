<!DOCTYPE html>
<html dir="ltr" lang="en" class="no-outlines">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hotel Help - Lock Screen</title>
    <meta name="author" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="icon" href="{{ asset('admin/assets/favicon.png') }}" type="image/png">
    @yield('title')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700%7CMontserrat:400,500">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/perfect-scrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/morris.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/jquery-jvectormap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/horizontal-timeline.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/weather-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/ion.rangeSlider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/ion.rangeSlider.skinFlat.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    @yield('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>

<body>

    <!-- Wrapper Start -->
    <div class="wrapper">
        <!-- Lock Screen Page Start -->
        <div class="m-account-w" data-bg-img="{{ asset('ad  min/assets/img/account/dwrapper-bg.jpg') }}">
            <div class="m-account m-account-lock">
                <!-- Lock Screen Form Start -->
                <div class="m-account--form-w">
                    <div class="m-account--form m-account--lock">
                        <div class="m-account--user">
                            <img src="{{ asset('admin/assets/img/avatars/01_80x80.png') }}" alt="">
                            <h3 class="h3">{{ Auth::user()->name }} <i class="fa fa-unlock"></i></h3>
                        </div>

                        <!-- resources/views/admin/lockscreen.blade.php -->
                        <form action="{{ route('admin.unlockScreen') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <i class="fas fa-key"></i>
                                    </div>
                                    <input type="password" name="password" placeholder="Enter Password"
                                        class="form-control" autocomplete="off" required>
                                </div>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-rounded btn-info">Unlock</button>
                            </div>
                        </form>


                    </div>
                </div>
                <!-- Lock Screen Form End -->
            </div>
        </div>
        <!-- Lock Screen Page End -->
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
    <script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/raphael.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/morris.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-jvectormap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-jvectormap-world-mill.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/horizontal-timeline.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dropzone.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/main.js') }}"></script>

</body>

</html>
