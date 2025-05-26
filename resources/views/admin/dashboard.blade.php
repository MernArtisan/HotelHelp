@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div class="page-wrapper">
        <main class="main--container">
            <!-- Page Header Start -->
            <section class="page--header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Page Title Start -->
                            <h2 class="page--title h5">Dashboard</h2>
                            <!-- Page Title End -->

                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active"><span>Dashboard</span></li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <!-- Summary Widget Start -->
                            <div class="summary--widget">
                                <div class="summary--item">
                                    <p class="summary--chart" data-trigger="sparkline" data-type="bar" data-width="5"
                                        data-height="38" data-color="#009378">2,9,7,9,11,9,7,5,7,7,9,11</p>
                        
                                    <p class="summary--title">This Month</p>
                                    <p class="summary--stats text-green">${{ number_format($thisMonthAmount, 2) }}</p>
                                </div>
                        
                                <div class="summary--item">
                                    <p class="summary--chart" data-trigger="sparkline" data-type="bar" data-width="5"
                                        data-height="38" data-color="#e16123">2,3,7,7,9,11,9,7,9,11,9,7</p>
                        
                                    <p class="summary--title">Last Month</p>
                                    <p class="summary--stats text-orange">${{ number_format($lastMonthAmount, 2) }}</p>
                                </div>
                            </div>
                            <!-- Summary Widget End -->
                        </div>
                        
                    </div>
                </div>
            </section>
            <!-- Page Header End -->

            <!-- Main Content Start -->
            <section class="main--content">
                <div class="row gutter-20">
                    <div class="col-md-4">
                        <div class="panel">
                            <!-- Mini Stats Panel Start -->
                            <div class="miniStats--panel">
                                <div class="miniStats--header bg-darker">
                                    <p class="miniStats--chart" data-trigger="sparkline" data-type="bar" data-width="4"
                                        data-height="30" data-color="#2bb3c0">5,6,9,4,9,5,3,5,9,15,3,2,2,3,9,11,9,7,20,9,7,6
                                    </p>

                                    <p class="miniStats--label text-white bg-blue">
                                        <i class="fa fa-level-up-alt"></i>
                                        <span>10%</span>
                                    </p>
                                </div>

                                <div class="miniStats--body">
                                    <i class="miniStats--icon fa fa-user text-blue"></i>

                                    <p class="miniStats--caption text-blue">New</p>
                                    <h3 class="miniStats--title h4">Help</h3>
                                    <p class="miniStats--num text-blue">{{ $employeesActive->count() }}</p>
                                </div>
                            </div>
                            <!-- Mini Stats Panel End -->
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="panel">
                            <!-- Mini Stats Panel Start -->
                            <div class="miniStats--panel">
                                <div class="miniStats--header bg-darker">
                                    <p class="miniStats--chart" data-trigger="sparkline" data-type="bar" data-width="4"
                                        data-height="30" data-color="#e16123">2,2,3,9,11,9,7,20,9,7,6,5,6,9,4,9,5,3,5,9,15,3
                                    </p>

                                    <p class="miniStats--label text-white bg-orange">
                                        <i class="fa fa-level-down-alt"></i>
                                        <span>10%</span>
                                    </p>
                                </div>

                                <div class="miniStats--body">
                                    <i class="miniStats--icon fa fa-ticket-alt text-orange"></i>

                                    <p class="miniStats--caption text-orange">Ongoing</p>
                                    <h3 class="miniStats--title h4">Hotels</h3>
                                    <p class="miniStats--num text-orange">{{ $hotelsActive->count() }}</p>
                                </div>
                            </div>
                            <!-- Mini Stats Panel End -->
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="panel">
                            <!-- Mini Stats Panel Start -->
                            <div class="miniStats--panel">
                                <div class="miniStats--header bg-darker">
                                    <p class="miniStats--chart" data-trigger="sparkline" data-type="bar" data-width="4"
                                        data-height="30" data-color="#009378">2,2,3,9,11,9,7,20,9,7,6,5,6,9,4,9,5,3,5,9,15,3
                                    </p>

                                    <p class="miniStats--label text-white bg-green">
                                        <i class="fa fa-level-up-alt"></i>
                                        <span>10%</span>
                                    </p>
                                </div>

                                <div class="miniStats--body">
                                    <i class="miniStats--icon fa fa-rocket text-green"></i>

                                    <p class="miniStats--caption text-green">Total</p>
                                    <h3 class="miniStats--title h4">Hotels</h3>
                                    <p class="miniStats--num text-green">{{ $totalHotels->count() }}</p>
                                </div>
                            </div>
                            <!-- Mini Stats Panel End -->
                        </div>
                    </div>

                  

                    <div class="col-xl-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    Hotels Map
                                </h3>
                            </div>
                    
                            <div class="panel-body">
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                    
                    <script>
                        function initMap() {
                            // Initialize the map centered at the default world view
                            var map = new google.maps.Map(document.getElementById('map'), {
                                zoom: 2, // Zoom out to show the whole world
                                center: {
                                    lat: 0, // Center at latitude 0
                                    lng: 0  // Center at longitude 0 (default to the center of the world map)
                                },
                                mapTypeId: 'roadmap'
                            });
                    
                            // Markers Data from PHP
                            var hotels = @json($hotels);
                    
                            // Add markers for each hotel
                            hotels.forEach(function(hotel) {
                                if (hotel.latitude && hotel.longitude) {
                                    // Add a marker for each hotel
                                    var marker = new google.maps.Marker({
                                        position: {
                                            lat: parseFloat(hotel.latitude),
                                            lng: parseFloat(hotel.longitude)
                                        },
                                        map: map,
                                        title: hotel.name
                                    });
                                }
                            });
                        }
                    </script>
                    
                    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2zcZWYTrnjovVYwCR9zwHJwVEtUEufJk&callback=initMap" async defer></script>
                    
                    <style>
                        #map {
                            height: 500px;
                            width: 100%;
                        }
                    </style>
                    

                    <div class="col-xl-12 col-md-6">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">Total Overdue</h3>
                    
                                <div class="dropdown">
                                    <button type="button" class="btn-link dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>
                    
                                    <ul class="dropdown-menu">
                                        <li><a href="#"><i class="fa fa-sync"></i>Update Data</a></li>
                                        <li><a href="#"><i class="fa fa-cogs"></i>Settings</a></li>
                                        <li><a href="#"><i class="fa fa-times"></i>Remove Panel</a></li>
                                    </ul>
                                </div>
                            </div>
                    
                            <div class="panel-chart">
                                <div class="chart--title text-blue">
                                    <h2 class="h2">${{ number_format($totalAmount, 2) }}</h2>
                                </div>
                    
                                <!-- Morris Line Chart 03 Start -->
                                <div id="morrisLineChart03" class="chart--body line--chart style--3"></div>
                                <!-- Morris Line Chart 03 End -->
                    
                                <div class="chart--action">
                                    <a href="#" class="btn-link">Export PDF <i class="fa fa-long-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                </div>
            </section>

            <footer class="main--footer main--footer-light">
                <p>Copyright &copy; <a href="#">Hotel Help</a>. All Rights Reserved.</p>
            </footer>
        </main>
    </div>
@endsection
