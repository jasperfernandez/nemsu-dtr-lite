<?php

namespace Database\Factories;

use App\Models\AttendanceDay;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/** @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AttendanceDay> */
class AttendanceDayFactory extends Factory
{
    protected $model = AttendanceDay::class;

    public function definition()
    {
        return [
            'work_date' => Carbon::now(),
            'status' => $this->faker->word(),
            'remarks' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'employee_id' => Employee::factory(),
        ];
    }
}
