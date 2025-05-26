<!DOCTYPE html>
<html dir="ltr" lang="en" class="no-outlines">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hotel Help - Dashboard</title>
    <meta name="author" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="icon" href="{{ asset('admin/assets/favicon.png') }}" type="image/png">
    @yield('title')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700%7CMontserrat:400,500">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/perfect-scrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/morris.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/jquery-jvectormap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/horizontal-timeline.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/weather-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/ion.rangeSlider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/ion.rangeSlider.skinFlat.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('admin/assets/css/datatables.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/css/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.2/css/buttons.dataTables.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.min.css" rel="stylesheet">
    @yield('styles')
</head>

<body>
    <div class="wrapper">
        <header class="navbar navbar-fixed">
            <div class="navbar--header">
                <a href="{{ route('admin.dashboard') }}" class="logo">
                    <img src="{{ asset('admin/assets/img/logo.png') }}" alt="">
                </a>

                <a href="#" class="navbar--btn" data-toggle="sidebar" title="Toggle Sidebar">
                    <i class="fa fa-bars"></i>
                </a>

            </div>

            <a href="#" class="navbar--btn" data-toggle="sidebar" title="Toggle Sidebar">
                <i class="fa fa-bars"></i>
            </a>

            <div class="navbar--search">
                <form action="#">
                    <input type="search" name="search" class="form-control" placeholder="Search Something..."
                        required>
                    <button class="btn-link"><i class="fa fa-search"></i></button>
                </form>
            </div>


            <div class="navbar--nav ml-auto">
                <ul class="nav">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa fa-bell"></i>
                            <span class="badge text-white bg-blue">7</span>
                        </a>
                    </li>



                    <li class="nav-item dropdown nav--user online">
                        <a href="#" class="nav-link" data-toggle="dropdown">
                            <img src="{{ asset(Auth::user()->image ? Auth::user()->image : 'default.png') }}"
                                alt="#" class="rounded-circle">
                            <i class="fa fa-angle-down"></i>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a href="{{ route('admin.profile') }}"><i class="far fa-user"></i>Profile</a></li>
                            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-cog"></i>Dashboard</a></li>
                            <li class="dropdown-divider"></li>
                            <li><a href="{{ route('admin.lock-screen') }}"><i class="fa fa-lock"></i> Lock Screen</a>
                            </li>
                            <li>
                                <form action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-link">
                                        <i class="fa fa-power-off"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </header>
        @include('admin.layouts.sidebar')
        @yield('content')

    </div>
    <script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/raphael.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/morris.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-jvectormap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-jvectormap-world-mill.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/horizontal-timeline.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dropzone.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/ion.rangeSlider.min.js') }}"></script>
    {{-- <script src="{{ asset('admin/assets/js/datatables.min.js') }}"></script> --}}
    <script src="{{ asset('admin/assets/js/main.js?=av') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> --}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2zcZWYTrnjovVYwCR9zwHJwVEtUEufJk&libraries=places">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> --}}

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.print.min.js"></script>


    @yield('scripts')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
        $(document).ready(function() {
            $('.select2').select2({
                allowClear: true
            });
        });






        new DataTable('#example', {
            layout: {
                topStart: {
                    buttons: [{
                            extend: 'copy',
                            text: 'Copy',
                            className: 'btn btn-primary'
                        },
                        {
                            extend: 'csv',
                            text: 'Export to CSV',
                            className: 'btn btn-success'
                        },
                        {
                            extend: 'excel',
                            text: 'Export to Excel',
                            className: 'btn btn-info'
                        },
                        {
                            extend: 'pdf',
                            text: 'Export to PDF',
                            className: 'btn btn-danger'
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            className: 'btn btn-secondary'
                        }
                    ]
                }
            }
        });


        function showLoader() {
            document.getElementById('loader').style.display = 'block';
            document.getElementById('myForm').submit();
        }

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}', 'Validation Error', {
                    timeOut: 5000
                });
            @endforeach
        @endif

        @if (session('success'))
            var successSound = new Audio('{{ asset('admin/sounds/success.mp3') }}'); // success sound
            successSound.play();
            toastr.success('{{ session('success') }}', 'Success');
        @endif

        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
        };

        function confirmDelete(userId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to delete?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + userId).submit();
                }
            })
        }



        function initialize() {
            var input = document.getElementById('location');
            var autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    return;
                }

                var lat = place.geometry.location.lat();
                var lng = place.geometry.location.lng();

                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                document.getElementById('map-container').style.display = 'block';

                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 15,
                    center: place.geometry.location
                });

                var marker = new google.maps.Marker({
                    position: place.geometry.location,
                    map: map
                });
            });
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>


    <div class="loader" id="loader"></div>


    <style>
        .loader {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 8px solid #ffffff;
            border-top: 8px solid #003cff;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            display: none;
            /* Initially hidden */
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <style>
        .dt-button.btn {
            margin-right: 5px !important;
            padding: 5px 10px !important;
            font-size: 14px !important;
            border-radius: 4px !important;
        }

        .dt-button.btn-primary {
            background-color: #007bff !important;
            border-color: #007bff !important;
            color: white !important;
        }

        .dt-button.btn-success {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
            color: white !important;
        }

        .dt-button.btn-info {
            background-color: #17a2b8 !important;
            border-color: #17a2b8 !important;
            color: white !important;
        }

        .dt-button.btn-danger {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
            color: white !important;
        }

        .dt-button.btn-secondary {
            background-color: #6c757d !important;
            border-color: #6c757d !important;
            color: white !important;
        }

        /* .buttons-copy{
            color: red !important;
        } */
    </style>

</body>
</body>

</html>
