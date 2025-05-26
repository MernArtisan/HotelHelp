<style>
    .btn-logout {
        background-color: transparent;
        border: none;
        color: #fff;
        font-size: 16px;
        padding: 10px;
        cursor: pointer;
    }

    .btn-logout:hover {
        color: #ff6f61;
        /* Change color on hover */
        background-color: rgba(255, 255, 255, 0.1);
        /* Light hover effect */
    }

    .nav-link {
        display: inline-flex;
        align-items: center;
        /* color: white; Ensures the icon and text are white */
        text-decoration: none;
    }
</style>
<aside class="sidebar" data-trigger="scrollbar">
    <div class="sidebar--profile">
        <div class="profile--img">
            <a href="profile.php">
                <img src="{{ asset(Auth::user()->image ? Auth::user()->image : 'admin/assets/img/avatars/01_150x150.png') }}"
                    alt="Profile Picture of {{ Auth::user()->name }}" class="rounded-circle">
            </a>
        </div>

        <div class="profile--name">
            <a href="profile.php" class="btn-link">{{ Auth::user()->name }}</a>
        </div>

        <div class="profile--nav">
            <ul class="nav">
                <li class="nav-item">
                    <a href="{{ route('admin.profile') }}" class="nav-link" title="User Profile">
                        <i class="fa fa-user"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.lock-screen') }}" class="nav-link" title="Lock Screen">
                        <i class="fa fa-lock"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn-logout">
                            <i class="fa fa-sign-out-alt"></i>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <div class="sidebar--nav">
        <ul>
            <li class="active">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>

        <ul>
            <li>
                <a href="#">
                    <i class="fa fa-file"></i>
                    <span>User Roles & Permission</span>
                </a>

                <ul>
                    <li><a href="{{ route('admin.roles.index') }}">Roles</a></li>
                    <li><a href="{{ route('admin.permissions.index') }}">Permission</a></li>
                </ul>
            </li>
        </ul>

        <ul>
            <li>
                <a href="#">
                    <i class="fa fa-file"></i>
                    <span>Employee Maintenance</span>
                </a>

                <ul>
                    <li><a href="{{ route('admin.employees.create') }}">Hire Employee</a></li>
                    <li><a href="{{ route('admin.employees.index') }}">List Employee</a></li>
                    <li><a href="{{ route('admin.timecardCreate') }}">Employee Timecards</a></li>
                    <li><a href="{{ route('admin.employees-data-report') }}">Employee Data Report</a></li>
                </ul>
            </li>
        </ul>


        <ul>
            <li>
                <a href="#">
                    <i class="fa fa-file"></i>
                    <span>My Reports</span>
                </a>

                <ul>
                    <li>
                        <a href="#">
                            <i class="fa fa-th"></i>
                            <span>Report Writer</span>
                        </a>

                        <ul>
                            <li><a href="{{ route('admin.EmployeesReports') }}">Employee Report</a></li>
                            <li><a href="{{ route('admin.HotelReport') }}">Hotel Reportt</a></li>
                            <li><a href="{{ route('admin.payables') }}">Payable</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('admin.QuarterlyReports') }}">Quarterly Reports on Demand</a></li>
                    {{-- <li><a href="client-reports.php">Client Reports</a></li> --}}
                    <li><a href="{{ route('admin.RoiDashboard') }}">ROI Dashboard</a></li>
                    {{-- <li><a href="year-end-reports-archive.php">Year End Report Archive</a></li>
                    <li><a href="year-end-reports-on-demand.php">Year End Reports On Demand</a></li> --}}
                    <li><a href="{{ route('admin.organizationalChart') }}">Organizational Chart</a></li>
                    {{-- <li><a href="revenue-report.php">Revenue Report</a></li> --}}
                    <li><a href="{{ route('admin.agedReceivables') }}">Receivables / Revenue Report</a></li>
                    {{-- <li><a href="invoicing-report.php">Invoicing Report</a></li> --}}
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
                    <li><a href="{{ route('admin.EmployeeDemographics') }}">Employee Demographics</a></li>
                    <li><a href="{{ route('admin.HeadCount') }}">Head Count</a></li>
                    {{-- <li><a href="gross-payroll.php">Gross Payroll </a></li> --}}
                    <li><a href="{{ route('admin.Termination') }}">Employee Terminations</a></li>
                </ul>
            </li>
        </ul>


        <ul>
            <li>
                <a href="{{ route('admin.announcements') }}">
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
                    <li><a href="{{ route('admin.privacyPolicy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('admin.termCondition') }}">Terms & Condition</a></li>
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
                    {{-- <li><a href="{{route('admin.organizationTable')}}">Organization Table</a></li> --}}
                    <li><a href="{{ route('admin.employmentCategories') }}">Employment Catagories</a></li>
                    <li><a href="{{ route('admin.terminationReasons') }}">Termination Reasons</a></li>
                    {{-- <li><a href="organization-workers-comp.php">Organization Workers Comp</a></li> --}}
                    {{-- <li><a href="compensation-plans.php">Compensation Plans</a></li> --}}
                    {{-- <li><a href="report-group-access.php">Report Group Access</a></li> --}}
                    {{-- <li><a href="change-reason.php">Change Reason</a></li> --}}
                    <li><a href="{{ route('admin.employmentStatuses') }}">Employment Statuses</a></li>
                    {{-- <li><a href="work-comp-policies.php">Work Comp Policies</a></li> --}}
                    <li><a href="{{ route('admin.miscFieldCategories') }}">Misc. Field Catagories</a></li>
                    <li><a href="{{ route('admin.miscFieldEmployees') }}">Misc. Employee Fields</a></li>
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
                    <li><a href="{{ route('admin.hotels.create') }}">Add Hotels</a></li>
                    <li><a href="{{ route('admin.hotels.index') }}">List Hotels</a></li>
                    {{-- <li><a href="contacts.php">Contacts </a></li> --}}
                    <li><a href="{{ route('admin.pay-group.index') }}">Pay Group </a></li>
                    {{-- <li><a href="pay-groups-report.php">Pay Groups Report </a></li> --}}
                    {{-- <li><a href="scheduled-report-options.php">Scheduled Report Options</a></li> --}}
                    <li><a href="{{ route('admin.ClientAddress') }}">Client Addresses</a></li>
                </ul>
            </li>
        </ul>

        {{-- <ul>
            <li>
                <a href="{{ route('admin.invoices') }}">
                    <i class="fa fa-file"></i>
                    <span>Invoices</span>
                </a>
            </li>
        </ul> --}}

        <ul>
            <li>
                <a href="{{ url('task-list') }}">
                    <i class="fa fa-file"></i>
                    <span>Task</span>
                </a>
            </li>
        </ul>

        <ul>
            <li>
                <a href="{{ route('admin.invoicesList') }}">
                    <i class="fa fa-file"></i>
                    <span>Invoices</span>
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
                    <li><a href="{{ route('admin.Earning') }}">Earnings</a></li>
                    <li><a href="{{ route('admin.AdditionalChecks') }}">Additional Checks</a></li>
                    <li><a href="{{route('admin.deductions')}}">Deductions</a></li>
                    {{-- <li><a href="pay-items-default-values.php">Pay Items Default Values</a></li> --}}
                    {{-- <li><a href="alternate-pay-rates.php">Alternate Pay Rates</a></li> --}}
                    <!--  <li><a href="accumulators.php">Accumulators</a></li> -->
                    {{-- <li><a href="work-locations-and-location-maintenance.php">Work Locations and Location
                            Maintenance</a></li> --}}
                    <li><a href="{{route('admin.payrollReport')}}">Payroll Report</a></li>
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
                    <li><a href="{{route('admin.holidays')}}">Holidays</a></li>
                    {{-- <li><a href="holiday-rules.php">Holiday Rules</a></li> --}}
                    <li><a href="{{route('admin.mealAndBreakRules')}}">Meal and Break Rules</a></li>
                    <li><a href="{{route('admin.roundingRules')}}">Rounding Rules</a></li>
                    {{-- <li><a href="timecard-adjustment-rules.php">Timecard Adjustment Rules</a></li>
                    <li><a href="timecard-permission-rules.php">Time Card Permission Rules</a></li> --}}
                    {{-- <li><a href="custom-alerts.php">Custom Alerts</a></li>
                    <li><a href="alert-rules.php">Alert Rules</a></li>
                    <li><a href="punch-log.php">Punch Log</a></li> --}}
                    {{-- <li><a href="verification-rules.php">Verification Rules</a></li>
                    <li><a href="calendar-rules.php">Calendar Rules</a></li>
                    <li><a href="manage-teams.php">Manage Teams</a></li>
                    <li><a href="policy-groups.php">Policy Groups</a></li> --}}
                    {{-- <li><a href="labor-groups.php">Labor Groups</a></li>
                    <li><a href="time-card-notes.php">Time Card Notes</a></li> --}}
                    <li><a href="{{route('admin.noteRules')}}">Note Rules</a></li>
                    <li><a href="{{route('admin.occurrenceRules')}}">Occurrence Rules</a></li>
                    {{-- <li><a href="manage-clocks.php">Manage Clocks</a></li> --}}
                </ul>
            </li>
        </ul>

    </div>

</aside>