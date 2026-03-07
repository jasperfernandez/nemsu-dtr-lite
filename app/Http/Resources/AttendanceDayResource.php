<?php

namespace App\Http\Resources;

use App\Models\AttendanceDay;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin AttendanceDay */
class AttendanceDayResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'work_date' => $this->work_date,
            'status' => $this->status,
            'remarks' => $this->remarks,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'employee_id' => $this->employee_id,

            'employee' => new EmployeeResource($this->whenLoaded('employee')),
        ];
    }
}
