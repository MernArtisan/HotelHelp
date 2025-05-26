<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timecard>
 */
class TimecardFactory extends Factory
{
    protected $model = \App\Models\Timecard::class;

    public function definition()
    {
        return [
            'employee_id' => Employee::factory(), // Assuming you have an Employee factory
            'start_time' => $this->faker->dateTimeThisMonth(),
            'break_start' => $this->faker->dateTimeThisMonth(),
            'break_end' => $this->faker->dateTimeThisMonth(),
            'end_time' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
