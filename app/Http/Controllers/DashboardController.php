<?php

namespace App\Http\Controllers;

use App\Enums\AttendanceLogType;
use App\Models\AttendanceDay;
use App\Models\AttendanceLog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $employee = $request->user()->employee;

        $today = now()->toDateString();

        $stats = [
            'today_status' => null,
            'time_in' => null,
            'time_out' => null,
            'log_count' => 0,
            'next_action' => 'in',
        ];

        if ($employee) {
            $attendanceDay = AttendanceDay::with(['attendanceLogs' => fn ($q) => $q->orderBy('log_time')])
                ->where('employee_id', $employee->id)
                ->where('work_date', $today)
                ->first();

            if ($attendanceDay) {
                $logs = $attendanceDay->attendanceLogs;

                $firstIn = $logs->firstWhere('type', AttendanceLogType::IN);
                $lastOut = $logs->filter(fn ($l) => $l->type === AttendanceLogType::OUT)->last();
                $lastLog = $logs->last();

                $stats['time_in'] = $firstIn?->log_time?->format('h:i A');
                $stats['time_out'] = $lastOut?->log_time?->format('h:i A');
                $stats['log_count'] = $logs->count();
                $stats['next_action'] = ($lastLog?->type === AttendanceLogType::IN) ? 'out' : 'in';

                $stats['today_status'] = match (true) {
                    $stats['log_count'] === 0 => null,
                    $firstIn !== null && $firstIn->log_time->hour >= 8 && $firstIn->log_time->minute > 0 => 'Late',
                    default => 'Present',
                };
            }
        }

        return Inertia::render('Dashboard', [
            'stats' => $stats,
        ]);
    }
}

