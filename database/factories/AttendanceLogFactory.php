<?php

namespace Database\Factories;

use App\Models\AttendanceDay;
use App\Models\AttendanceLog;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/** @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AttendanceLog> */
class AttendanceLogFactory extends Factory
{
    protected $model = AttendanceLog::class;

    public function definition()
    {
        return [
            'log_time' => Carbon::now(),
            'type' => $this->faker->word(),
            'ip_address' => $this->faker->ipv4(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'attendance_day_id' => AttendanceDay::factory(),
            'employee_id' => Employee::factory(),
        ];
    }
}
