<?php

use App\Http\Controllers\Admin\AnnoicmentController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DeductionController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\HolidayController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\PaygroupController;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\TimeCardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;



Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('optimize:clear');
    return "Cache is cleared";
});

Route::get('/test-email', function () {
    \Mail::raw('This is a test email from hotelhelp server.', function ($message) {
        $message->to('faizankhan888980@gmail.com')
                ->subject('Test Email from hotelhelp');
    });

    return 'Email sent!';
});


Route::name('admin.')->group(function () {
    Route::group(['middleware' => ['admin.guest']], function () {
        Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
    });
    Route::get('lock-screen', [DashboardController::class, 'LockScreen'])->name('lock-screen');
    Route::post('unlock', [DashboardController::class, 'unlockScreen'])->name('unlockScreen');
    Route::group(['middleware' => ['admin.auth', 'locked']], function () {
        // Resource route
        Route::group(['middleware' => ['permission:pay-group-management']], function () {
            Route::resource('pay-group', PaygroupController::class);
        });
        Route::group(['middleware' => ['permission:hotels-management']], function () {
            Route::resource('hotels', HotelController::class);
        });
        Route::group(['middleware' => ['permission:employees-management']], function () {
            Route::resource('employees', EmployeeController::class);
        });
        Route::group(['middleware' => ['permission:permissions-management']], function () {
            Route::resource('permissions', PermissionController::class);
        });

        Route::post('/jobs/store', [EmployeeController::class, 'jobstore'])->name('jobs.store');

        Route::group(['middleware' => ['permission:roles-management']], function () {
            Route::resource('roles', RoleController::class);
        });
        // Custom routes here
        Route::get('permission-denied', [DashboardController::class, 'PermissionDenied'])->name('permission-denied');
        Route::post('logout', [DashboardController::class, 'destroy'])->name('logout');

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('my-profile', [ProfileController::class, 'profile'])->name('profile');
        Route::post('update-password', [ProfileController::class, 'updatePassword'])->name('updatePassword');
        Route::post('update-profile', [ProfileController::class, 'updateProfile'])->name('updateProfile');
        Route::get('employees-data-report', [EmployeeController::class, 'EmployeeDataReport'])->name('employees-data-report')->middleware('permission:employee-data-report');
        Route::get('client-addresses', [HotelController::class, 'ClientAddress'])->name('ClientAddress')->middleware('permission:view-client-addresses');
        Route::get('employee-demographics', [EmployeeController::class, 'EmployeeDemographics'])->name('EmployeeDemographics')->middleware('permission:view-EmployeeDemographics');
        Route::get('termination', [EmployeeController::class, 'Termination'])->name('Termination')->middleware('permission:view-termination');
        Route::post('termination-post', [EmployeeController::class, 'TerminationPost'])->name('TerminationPost')->middleware('permission:Termination-post');
        Route::get('head-count', [EmployeeController::class, 'HeadCount'])->name('HeadCount')->middleware('permission:view-headCount');
        Route::get('timecard', [TimeCardController::class, 'timecardCreate'])->name('timecardCreate')->middleware('permission:view-timecard');
        Route::post('timecardPost', [TimeCardController::class, 'timecardPost'])->name('timecardPost')->middleware('permission:add-timecard');
        Route::get('privacy-policy', [ContentController::class, 'privacyPolicy'])->name('privacyPolicy')->middleware('permission:view-privacyPolicy');
        Route::post('privacy-policy/update', [ContentController::class, 'updatePrivacyPolicy'])->name('updatePrivacyPolicy')->middleware('permission:update-privacyPolicy');
        Route::get('term-condition', [ContentController::class, 'termCondition'])->name('termCondition')->middleware('permission:view-term-condition');
        Route::post('term-condition/update', [ContentController::class, 'updateTermCondition'])->name('updateTermCondition')->middleware('permission:update-term-condition');
        Route::get('organization-table', [TableController::class, 'organizationTable'])->name('organizationTable')->middleware('permission:view-organization-table');
        Route::get('employment-categories', [TableController::class, 'employmentCategories'])->name('employmentCategories')->middleware('permission:view-employment-categories');
        Route::get('termination-reasons', [TableController::class, 'terminationReasons'])->name('terminationReasons')->middleware('permission:view-termination-reasons');
        Route::get('employment-statuses', [TableController::class, 'employmentStatuses'])->name('employmentStatuses')->middleware('permission:view-employment-statuses');
        Route::get('misc-field-categories', [TableController::class, 'miscFieldCategories'])->name('miscFieldCategories')->middleware('permission:view-misc-field-categories');
        Route::post('add-misc-field-categories', [TableController::class, 'AddmiscFieldCategories'])->name('AddmiscFieldCategories')->middleware('permission:add-misc-field-categories');
        Route::delete('delete-misc-field-category/{id}', [TableController::class, 'deleteCategory']);
        Route::get('misc-employee-fields', [TableController::class, 'miscFieldEmployees'])->name('miscFieldEmployees')->middleware('permission:view-misc-field-employee');
        Route::post('add-misc-employee-fields', [TableController::class, 'AddmiscFieldEmployees'])->name('AddmiscFieldEmployees')->middleware('permission:add-misc-field-employee');
        Route::delete('delete-misc-employee-fields/{id}', [TableController::class, 'deleteEmployeeField']);
        Route::get('aged-receivables', [ReportController::class, 'agedReceivables'])->name('agedReceivables')->middleware('permission:aged-receivables');
        Route::post('aged-receivables-paid/{id}', [ReportController::class, 'PaidAgedReceivables'])->name('PaidAgedReceivables')->middleware('permission:paid-aged-receivables');
        Route::get('organizational-chart', [ReportController::class, 'organizationalChart'])->name('organizationalChart')->middleware('permission:organizational-chart');
        Route::get('hotel-report', [ReportController::class, 'HotelReport'])->name('HotelReport')->middleware('permission:hotel-report');
        Route::get('roi-dashboard', [ReportController::class, 'RoiDashboard'])->name('RoiDashboard')->middleware('permission:roi-dashboard');
        Route::get('quarterly-reports', [ReportController::class, 'QuarterlyReports'])->name('QuarterlyReports')->middleware('permission:quarterly-reports');
        Route::get('employees-reports', [ReportController::class, 'EmployeesReports'])->name('EmployeesReports')->middleware('permission:employees-reports');
        Route::post('timecard/calculate-amount', [ReportController::class, 'calculateAmount'])->name('calculateAmount');
        Route::post('timecard/mark-as-paid', [ReportController::class, 'markAsPaid'])->name('markAsPaid');
        Route::get('payables', [ReportController::class, 'payables'])->name('payables')->middleware('permission:view-payables');
        Route::get('invoices/download/{id}', [InvoiceController::class, 'download'])->name('invoices.download');
        Route::get('announcements', [AnnoicmentController::class, 'announcements'])->name('announcements')->middleware('permission:view-announcements');
        Route::post('announcements/store', [AnnoicmentController::class, 'announcementsStore'])->name('announcementsStore')->middleware('permission:add-announcements');

        Route::get('task-list', [InvoiceController::class, 'taskList'])->name('taskList');
        Route::get('task', [InvoiceController::class, 'task'])->name('task');
        Route::post('task-store', [InvoiceController::class, 'TaskStore'])->name('TaskStore');
        Route::get('/get-employees/{hotel_id}', [InvoiceController::class, 'getEmployees'])->name('admin.getEmployees');



        Route::get('invoices', [InvoiceController::class, 'invoicesList'])->name('invoicesList');
        Route::get('invoices-add', [InvoiceController::class, 'invoicesAdd'])->name('invoicesAdd');
        Route::get('get-hotel-employees', [InvoiceController::class, 'getHotelEmployees'])->name('getHotelEmployees');
        Route::post('invoices/single', [InvoiceController::class, 'singleInvoiceStore'])->name('singleInvoiceStore');
        Route::post('invoices-store', [InvoiceController::class, 'InvoiceStore'])->name('InvoiceStore');


        Route::get('earnings', [PayrollController::class, 'Earning'])->name('Earning')->middleware('permission:view-earnings');
        Route::get('additional-checks', [PayrollController::class, 'AdditionalChecks'])->name('AdditionalChecks')->middleware('permission:view-additional-checks');
        Route::post('additional-checks/store', [PayrollController::class, 'AdditionalChecksStore'])->name('AdditionalChecksStore')->middleware('permission:add-additional-checks');
        Route::get('deductions', [DeductionController::class, 'deductions'])->name('deductions')->middleware('permission:view-deductions');

        Route::post('deductions/store', [DeductionController::class, 'deductionsStore'])->name('deductionsStore')->middleware('permission:add-deductions');
        Route::get('decution-delete/{id}', [DeductionController::class, 'decutionDelete'])->name('decutionDelete')->middleware('permission:delete-deductions');
        Route::get('payroll-report', [PayrollController::class, 'payrollReport'])->name('payrollReport')->middleware('permission:payroll-report');
        Route::get('/employee/invoice/{id}', [PayrollController::class, 'generateInvoiceWithMpdf'])->name('employee.invoice');

        Route::get('holidays', [HolidayController::class, 'holidays'])->name('holidays')->middleware('permission:view-holidays');
        Route::get('holidays/create', [HolidayController::class, 'holidaysCreate'])->name('holidaysCreate')->middleware('permission:create-holidays');
        Route::post('holidays/store', [HolidayController::class, 'holidaysStore'])->name('holidaysStore')->middleware('permission:create-holidays');
        Route::get('holidays/edit/{id}', [HolidayController::class, 'holidaysEdit'])->name('holidaysEdit')->middleware('permission:edit-holidays');
        Route::put('holidays/update/{id}', [HolidayController::class, 'holidaysUpdate'])->name('holidaysUpdate')->middleware('permission:edit-holidays');


        Route::get('occurrence-rules', [HolidayController::class, 'occurrenceRules'])->name('occurrenceRules')->middleware('permission:occurrence-rules');
        Route::post('occurrence-rules/store', [HolidayController::class, 'occurrenceRulesStore'])->name('occurrenceRulesStore')->middleware('permission:create-occurrence-rules');
        Route::get('occurrence-rules/{id}', [HolidayController::class, 'deleteOccurrenceRules'])->name('deleteOccurrenceRules');

        Route::get('note-rules', [HolidayController::class, 'noteRules'])->name('noteRules')->middleware('permission:view-note-rules');
        Route::post('note-rules/add', [HolidayController::class, 'noteRulesAdd'])->name('noteRulesAdd')->middleware('permission:add-note-rules');
        Route::get('note-rules/{id}', [HolidayController::class, 'noteRulesDelete'])->name('noteRulesDelete');



        Route::get('meal-and-break-rules', [HolidayController::class, 'mealAndBreakRules'])->name('mealAndBreakRules')->middleware('permission:view-meal-and-break-rules');
        Route::post('meal-break-rules/store', [HolidayController::class, 'mealAndBreakRulesStore'])->name('mealAndBreakRulesStore');
        Route::get('MealBreakRulesDelete/{id}', [HolidayController::class, 'MealBreakRulesDelete'])->name('MealBreakRulesDelete');


        Route::get('rounding-rules', [HolidayController::class, 'roundingRules'])->name('roundingRules')->middleware('permission:view-rounding-rules');
        Route::post('rounding-rules/store', [HolidayController::class, 'roundingRulesStore'])->name('roundingRulesStore');
        Route::get('roundingRulesDelete/{id}', [HolidayController::class, 'roundingRulesDelete'])->name('roundingRulesDelete');
    });
});
