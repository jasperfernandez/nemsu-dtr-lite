<?php

namespace App\Http\Controllers;

use App\Enums\AttendanceLogSource;
use App\Enums\AttendanceLogType;
use App\Models\AttendanceDay;
use App\Models\AttendanceLog;
use Illuminate\Http\Request;

class TimeLogController extends Controller
{
    public function __invoke(Request $request)
    {
        $employee = $request->user()->employee;

        abort_unless($employee !== null, 403, 'No employee record linked to this account.');

        $today = now()->toDateString();

        // Get or create today's attendance day
        $attendanceDay = AttendanceDay::firstOrCreate(
            [
                'employee_id' => $employee->id,
                'work_date' => $today,
            ],
        );

        // Determine IN or OUT based on the last log
        $lastLog = AttendanceLog::where('attendance_day_id', $attendanceDay->id)
            ->latest('log_time')
            ->first();

        $type = ($lastLog?->type === AttendanceLogType::IN)
            ? AttendanceLogType::OUT
            : AttendanceLogType::IN;

        AttendanceLog::create([
            'attendance_day_id' => $attendanceDay->id,
            'employee_id' => $employee->id,
            'log_time' => now(),
            'type' => $type,
            'source' => AttendanceLogSource::WEB,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Time log recorded successfully.');
    }
}

