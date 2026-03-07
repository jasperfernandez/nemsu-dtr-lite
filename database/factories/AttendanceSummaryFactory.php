<?php

namespace Database\Factories;

use App\Models\AttendanceDay;
use App\Models\AttendanceSummary;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/** @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AttendanceSummary> */
class AttendanceSummaryFactory extends Factory
{
    protected $model = AttendanceSummary::class;

    public function definition()
    {
        return [
            'first_in' => Carbon::now(),
            'last_out' => Carbon::now(),
            'late_minutes' => $this->faker->randomNumber(),
            'undertime_minutes' => $this->faker->randomNumber(),
            'work_minutes' => $this->faker->randomNumber(),
            'overtime_minutes' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'attendance_day_id' => AttendanceDay::factory(),
        ];
    }
}
