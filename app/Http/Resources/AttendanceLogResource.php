<?php

namespace App\Http\Resources;

use App\Models\AttendanceLog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin AttendanceLog */
class AttendanceLogResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'log_time' => $this->log_time,
            'type' => $this->type,
            'ip_address' => $this->ip_address,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'attendance_day_id' => $this->attendance_day_id,
            'employee_id' => $this->employee_id,

            'attendanceDay' => new AttendanceDayResource($this->whenLoaded('attendanceDay')),
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
        ];
    }
}
