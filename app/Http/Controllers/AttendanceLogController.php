<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceLogRequest;
use App\Http\Resources\AttendanceLogResource;
use App\Models\AttendanceLog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AttendanceLogController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', AttendanceLog::class);

        return AttendanceLogResource::collection(AttendanceLog::all());
    }

    public function store(AttendanceLogRequest $request)
    {
        $this->authorize('create', AttendanceLog::class);

        return new AttendanceLogResource(AttendanceLog::create($request->validated()));
    }

    public function show(AttendanceLog $attendanceLog)
    {
        $this->authorize('view', $attendanceLog);

        return new AttendanceLogResource($attendanceLog);
    }

    public function update(AttendanceLogRequest $request, AttendanceLog $attendanceLog)
    {
        $this->authorize('update', $attendanceLog);

        $attendanceLog->update($request->validated());

        return new AttendanceLogResource($attendanceLog);
    }

    public function destroy(AttendanceLog $attendanceLog)
    {
        $this->authorize('delete', $attendanceLog);

        $attendanceLog->delete();

        return response()->json();
    }
}
