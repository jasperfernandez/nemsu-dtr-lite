<?php

namespace App\Http\Resources;

use App\Models\AttendanceSummary;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin AttendanceSummary */
class AttendanceSummaryResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'first_in' => $this->first_in,
            'last_out' => $this->last_out,
            'late_minutes' => $this->late_minutes,
            'undertime_minutes' => $this->undertime_minutes,
            'work_minutes' => $this->work_minutes,
            'overtime_minutes' => $this->overtime_minutes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'attendance_day_id' => $this->attendance_day_id,

            'attendanceDay' => new AttendanceDayResource($this->whenLoaded('attendanceDay')),
        ];
    }
}
