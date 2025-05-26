<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Paygroup extends Seeder
{
    public function run()
    {
        DB::table('pay_groups')->insert([
            [
                'name' => 'Weekly Payroll',
                'pay_frequency' => 'weekly',
                'payroll_input_method' => 'manual',
                'payroll_type' => 'hourly',
                'normal_hours' => 40,
                'pay_day_of_week' => 'Tuesday',
                'run_date' => 2, // Run payroll 2 days before pay date
                'inpound_date' => 1, // Impound funds 1 day before pay date
                'period_date' => 5, // Pay period ends 5 days before pay date
                'status' => 'active',
            ],
            [
                'name' => 'Biweekly Payroll',
                'pay_frequency' => 'Biweekly',
                'payroll_input_method' => 'automatic',
                'payroll_type' => 'salary',
                'normal_hours' => 80,
                'pay_day_of_week' => 'Friday',
                'run_date' => 3, // Run payroll 3 days before pay date
                'inpound_date' => 2, // Impound funds 2 days before pay date
                'period_date' => 7, // Pay period ends 7 days before pay date
                'status' => 'active',
            ],
            [
                'name' => 'biweekly Payroll',
                'pay_frequency' => 'biweekly',
                'payroll_input_method' => 'manual',
                'payroll_type' => 'salary',
                'normal_hours' => 160,
                'pay_day_of_week' => 'Monday',
                'run_date' => 5, // Run payroll 5 days before pay date
                'inpound_date' => 3, // Impound funds 3 days before pay date
                'period_date' => 10, // Pay period ends 10 days before pay date
                'status' => 'active',
            ]
        ]);
    }
}
