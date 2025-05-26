<!DOCTYPE html>
<html dir="ltr" lang="en" class="no-outlines">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- ==== Document Title ==== -->
    <title>Dashboard - Hotel Help</title>

    <!-- ==== Document Meta ==== -->
    <meta name="author" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- ==== Favicon ==== -->
    <link rel="icon" href="favicon.png" type="image/png">

    <!-- ==== Google Font ==== -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700%7CMontserrat:400,500">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/jquery-ui.min.css">
    <link rel="stylesheet" href="assets/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" href="assets/css/morris.min.css">
    <link rel="stylesheet" href="assets/css/select2.min.css">
    <link rel="stylesheet" href="assets/css/jquery-jvectormap.min.css">
    <link rel="stylesheet" href="assets/css/horizontal-timeline.min.css">
    <link rel="stylesheet" href="assets/css/weather-icons.min.css">
    <link rel="stylesheet" href="assets/css/dropzone.min.css">
    <link rel="stylesheet" href="assets/css/ion.rangeSlider.min.css">
    <link rel="stylesheet" href="assets/css/ion.rangeSlider.skinFlat.min.css">
    <link rel="stylesheet" href="assets/css/datatables.min.css">
    <link rel="stylesheet" href="assets/css/fullcalendar.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Page Level Stylesheets -->

</head>

<body>

    <!-- Wrapper Start -->
    <div class="wrapper">
        <!-- Navbar Start -->
        <header class="navbar navbar-fixed">
            <!-- Navbar Header Start -->
            <div class="navbar--header">
                <!-- Logo Start -->
                <a href="index.php" class="logo">
                    <img src="assets/img/logo.png" alt="">
                </a>
                <!-- Logo End -->

                <!-- Sidebar Toggle Button Start -->
                <a href="#" class="navbar--btn" data-toggle="sidebar" title="Toggle Sidebar">
                    <i class="fa fa-bars"></i>
                </a>
                <!-- Sidebar Toggle Button End -->
            </div>
            <!-- Navbar Header End -->

            <!-- Sidebar Toggle Button Start -->
            <a href="#" class="navbar--btn" data-toggle="sidebar" title="Toggle Sidebar">
                <i class="fa fa-bars"></i>
            </a>
            <!-- Sidebar Toggle Button End -->

            <!-- Navbar Search Start -->
            <div class="navbar--search">
                <form action="search-results.php">
                    <input type="search" name="search" class="form-control" placeholder="Search Something..." required>
                    <button class="btn-link"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <!-- Navbar Search End -->

            <div class="navbar--nav ml-auto">
                <ul class="nav">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa fa-bell"></i>
                            <span class="badge text-white bg-blue">7</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="mailbox_inbox.php" class="nav-link">
                            <i class="fa fa-envelope"></i>
                            <span class="badge text-white bg-blue">4</span>
                        </a>
                    </li>
 
                    <!-- Nav Language End -->

                    <!-- Nav User Start -->
                    <li class="nav-item dropdown nav--user online">
                        <a href="#" class="nav-link" data-toggle="dropdown">
                            <img src="assets/img/avatars/01_80x80.png" alt="" class="rounded-circle">
                            <span>Jeff Byars</span>
                            <i class="fa fa-angle-down"></i>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a href="profile.php"><i class="far fa-user"></i>Profile</a></li>
                            <!--<li><a href="mailbox_inbox.php"><i class="far fa-envelope"></i>Inbox</a></li> -->
                            <li><a href="#"><i class="fa fa-cog"></i>Settings</a></li>
                            <li class="dropdown-divider"></li>
                            <li><a href="lock-screen.php"><i class="fa fa-lock"></i>Lock Screen</a></li>
                            <li><a href="#"><i class="fa fa-power-off"></i>Logout</a></li>
                        </ul>
                    </li>
                    <!-- Nav User End -->
                </ul>
            </div>
        </header>
        <!-- Navbar End -->

        <!-- Sidebar Start -->
        <aside class="sidebar" data-trigger="scrollbar">
            <!-- Sidebar Profile Start -->
            <div class="sidebar--profile">
                <div class="profile--img">
                    <a href="profile.php">
                        <img src="assets/img/avatars/01_80x80.png" alt="" class="rounded-circle">
                    </a>
                </div>

                <div class="profile--name">
                    <a href="profile.php" class="btn-link">Jeff Byars</a>
                </div>

                <div class="profile--nav">
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="profile.php" class="nav-link" title="User Profile">
                                <i class="fa fa-user"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="lock-screen.php" class="nav-link" title="Lock Screen">
                                <i class="fa fa-lock"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="mailbox_inbox.php" class="nav-link" title="Messages">
                                <i class="fa fa-envelope"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" title="Logout">
                                <i class="fa fa-sign-out-alt"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Sidebar Profile End -->

            <!-- Sidebar Navigation Start -->
            <div class="sidebar--nav">
                <!--     
<li>
<ul>
<li class="active">
<a href="index.php">
<i class="fa fa-home"></i>
<span>Dashboard</span>
</a>
</li>
<li>
<a href="#">
<i class="fa fa-shopping-cart"></i>
<span>Ecommerce</span>
</a>

<ul>
<li><a href="ecommerce.php">Dashboard</a></li>
<li><a href="products.php">Products</a></li>
<li><a href="products-edit.php">Edit Products</a></li>
<li><a href="orders.php">Orders</a></li>
<li><a href="order-view.php">Order View</a></li>
</ul>
</li> 
</ul> 
</li>  -->

                <!--my-work-->
                <ul>
                    <li class="active">
                        <a href="index.php">
                            <i class="fa fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                </ul>
                <ul>
                    <li>
                        <a href="#">
                            <i class="fa fa-file"></i>
                            <span>Employee Maintenance</span>
                        </a>

                        <ul>
                            <li><a href="hire-employe.php">Hire Employee</a></li>
                            <li><a href="edit-employe.php">Edit Employee</a></li>
                            <li><a href="employe-timecards.php">Employee Timecards</a></li>
                            <li><a href="employe-data-report.php">Employee Data Report</a></li>
                        </ul>
                    </li>
                </ul>
                <!--         <ul>
<li>
<a href="#">Layouts</a>

<ul>
<li>
<a href="#">
<i class="fa fa-th"></i>
<span>Page Layouts</span>
</a>

<ul>
<li><a href="blank.html">Blank Page</a></li>
<li><a href="page-light.html">Page Light</a></li>
<li><a href="sidebar-light.html">Sidebar Light</a></li>
</ul>
</li>
<li>
<a href="#">
<i class="fa fa-th-list"></i>
<span>Footers</span>
</a>

<ul>
<li><a href="footer-light.html">Footer Light</a></li>
<li><a href="footer-dark.html">Footer Dark</a></li>
<li><a href="footer-transparent.html">Footer Transparent</a></li>
</ul>
</li>
</ul>
</li>
</ul> -->

                <ul>
                    <li>
                        <a href="#">
                            <i class="fa fa-file"></i>
                            <span>My Reports</span>
                        </a>

                        <ul>
                            <li><a href="report-archive.php">Report Archive</a></li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-th"></i>
                                    <span>Report Writer</span>
                                </a>

                                <ul>
                                    <li><a href="employe-report.php">Employee Report</a></li>
                                    <li><a href="hotel-report.php">Hotel Reportt</a></li>
                                    <li><a href="invoices.php">Invoices</a></li>
                                    <li><a href="payable.php">Payable</a></li>
                                    <li><a href="previous-records.php">Previous Records </a></li>
                                </ul>
                            </li>
                            <li><a href="quarterly-reports-demand.php">Quarterly Reports on Demand</a></li>
                            <li><a href="client-reports.php">Client Reports</a></li>
                            <li><a href="roi-dashboard.php">ROI Dashboard</a></li>
                            <!--  <li><a href="#">My Reports Queue</a></li> -->
                            <!--    <li><a href="#">Check Print Back</a></li> -->
                            <!--    <li><a href="#">Continuous Reports Archive</a></li> -->
                            <li><a href="year-end-reports-archive.php">Year End Report Archive</a></li>
                            <li><a href="year-end-reports-on-demand.php">Year End Reports On Demand</a></li>
                            <!--    <li><a href="#">Reports to CD</a></li> -->
                            <!--   <li><a href="#">Return Archive</a></li> -->
                            <li><a href="organizational-chart.php">Organizational Chart</a></li>
                            <li><a href="revenue-report.php">Revenue Report</a></li>
                            <li><a href="aged-receivables.php"> Aged Receivables</a></li>
                            <li><a href="invoicing-report.php">Invoicing Report</a></li>
                            <!--   <li><a href="#">KPI Dashboard</a></li> -->
                        </ul>
                    </li>
                </ul>

                <ul>
                    <li>
                        <a href="#">
                            <i class="fa fa-file"></i>
                            <span>Executive Dashboard</span>
                        </a>

                        <ul>
                            <li><a href="employee-demographics.php">Employee Demographics</a></li>
                            <li><a href="head-count.php">Head Count</a></li>
                            <li><a href="gross-payroll.php">Gross Payroll </a></li>
                            <li><a href="employee-terminations.php">Employee Terminations</a></li>
                        </ul>
                    </li>
                </ul>


                <ul>
                    <li>
                        <a href="mass-email-utility.php">
                            <i class="fa fa-file"></i>
                            <span>Mass Email Utility</span>
                        </a>
                    </li>
                </ul>

                <ul>
                    <li>
                        <a href="#">
                            <i class="fa fa-file"></i>
                            <span>Regulatory</span>
                        </a>

                        <ul>
                            <!-- <li><a href="federal-reporting-data.php">Federal Reporting Data</a></li> -->
                            <li><a href="#">Privacy Policy/Disclaimers</a></li>
                        </ul>
                    </li>
                </ul>

                <ul>
                    <li>
                        <a href="#">
                            <i class="fa fa-file"></i>
                            <span>Tables</span>
                        </a>

                        <ul>
                            <li><a href="organization-table.php">Organization Table</a></li>
                            <li><a href="employment-categories.php">Employment Catagories</a></li>
                            <li><a href="termination-reasons.php">Termination Reasons</a></li>
                            <li><a href="organization-workers-comp.php">Organization Workers Comp</a></li>
                            <li><a href="compensation-plans.php">Compensation Plans</a></li>
                            <li><a href="report-group-access.php">Report Group Access</a></li>
                            <li><a href="change-reason.php">Change Reason</a></li>
                            <li><a href="employment-statuses.php">Employment Statuses</a></li>
                            <li><a href="work-comp-policies.php">Work Comp Policies</a></li>
                            <li><a href="misc-field-categories.php">Misc. Field Catagories</a></li>
                            <li><a href="misc-employee-fields.php">Misc. Employee Fields</a></li>
                        </ul>
                    </li>
                </ul>

                <ul>
                    <li>
                        <a href="#">
                            <i class="fa fa-file"></i>
                            <span>Client Maintenance</span>
                        </a>

                        <ul>
                            <li><a href="hotel-add-edit.php">Hotels (Add/Edit)</a></li>
                            <!-- <li><a href="checks-at-organization-level.php">Checks at Organization Level </a></li> -->
                            <li><a href="contacts.php">Contacts </a></li>
                            <li><a href="pay-group.php">Pay Group </a></li>
                            <li><a href="pay-groups-report.php">Pay Groups Report </a></li>
                            <li><a href="scheduled-report-options.php">Scheduled Report Options</a></li>
                            <li><a href="addresses.php">Addresses</a></li>
                            <!-- <li><a href="#">Delivery Package</a></li>  -->
                        </ul>
                    </li>
                </ul>

                <ul>
                    <li>
                        <a href="all-invoices.php">
                            <i class="fa fa-file"></i>
                            <span>Invoices</span>
                        </a>
                    </li>
                </ul>
                <ul>
                    <li>
                        <a href="financial-reports.php">
                            <i class="fa fa-file"></i>
                            <span>Financial Reports</span>
                        </a>
                    </li>
                </ul>

                <ul>
                    <li>
                        <a href="#">
                            <i class="fa fa-file"></i>
                            <span>Payroll</span>
                        </a>

                        <ul>
                            <li><a href="earnings.php">Earnings</a></li>
                            <!-- <li><a href="memo-calculations.php">Memo Calculations</a></li> -->
                            <li><a href="additional-checks.php">Additional Checks</a></li>
                            <li><a href="deductions.php">Deductions</a></li>
                            <li><a href="pay-items-default-values.php">Pay Items Default Values</a></li>
                            <li><a href="alternate-pay-rates.php">Alternate Pay Rates</a></li>
                            <!--  <li><a href="accumulators.php">Accumulators</a></li> -->
                            <li><a href="work-locations-and-location-maintenance.php">Work Locations and Location Maintenance</a></li>
                            <li><a href="payroll-report.php">Payroll Report</a></li>
                        </ul>
                    </li>
                </ul>


                <ul>
                    <li>
                        <a href="#">
                            <i class="fa fa-file"></i>
                            <span>Time Management</span>
                        </a>

                        <ul>
                            <!-- <li><a href="eligibility-rules.php">Eligibility Rules</a></li> -->
                            <li><a href="time-keeping.php">Time keeping Report</a></li>
                            <li><a href="holidays.php">Holidays</a></li>
                            <li><a href="holiday-rules.php">Holiday Rules</a></li>
                            <!--  <li><a href="hours-allocation-rules.php">Hours Allocation Rules</a></li> -->
                            <li><a href="meal-and-break-rules.php">Meal and Break Rules</a></li>
                            <li><a href="rounding-rules.php">Rounding Rules</a></li>
                            <li><a href="timecard-adjustment-rules.php">Timecard Adjustment Rules</a></li>
                            <li><a href="timecard-permission-rules.php">Time Card Permission Rules</a></li>
                            <li><a href="custom-alerts.php">Custom Alerts</a></li>
                            <li><a href="alert-rules.php">Alert Rules</a></li>
                            <li><a href="punch-log.php">Punch Log</a></li>
                            <li><a href="verification-rules.php">Verification Rules</a></li>
                            <li><a href="calendar-rules.php">Calendar Rules</a></li>
                            <li><a href="manage-teams.php">Manage Teams</a></li>
                            <li><a href="policy-groups.php">Policy Groups</a></li>
                            <li><a href="labor-groups.php">Labor Groups</a></li>
                            <li><a href="time-card-notes.php">Time Card Notes</a></li>
                            <li><a href="note-rules.php">Note Rules</a></li>
                            <li><a href="occurrence-rules.php">Occurrence Rules</a></li>
                            <li><a href="manage-clocks.php">Manage Clocks</a></li>
                        </ul>
                    </li>
                </ul>

            </div>

            <!--my-work-end-->

            <!-- Sidebar Navigation End -->

            <!-- Sidebar Widgets Start -->
            <!---->
            <!-- Sidebar Widgets End -->
        </aside>
        <!-- Sidebar End -->