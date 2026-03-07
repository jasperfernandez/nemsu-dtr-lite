<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceDayRequest;
use App\Http\Resources\AttendanceDayResource;
use App\Models\AttendanceDay;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AttendanceDayController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', AttendanceDay::class);

        return AttendanceDayResource::collection(AttendanceDay::all());
    }

    public function store(AttendanceDayRequest $request)
    {
        $this->authorize('create', AttendanceDay::class);

        return new AttendanceDayResource(AttendanceDay::create($request->validated()));
    }

    public function show(AttendanceDay $attendanceDay)
    {
        $this->authorize('view', $attendanceDay);

        return new AttendanceDayResource($attendanceDay);
    }

    public function update(AttendanceDayRequest $request, AttendanceDay $attendanceDay)
    {
        $this->authorize('update', $attendanceDay);

        $attendanceDay->update($request->validated());

        return new AttendanceDayResource($attendanceDay);
    }

    public function destroy(AttendanceDay $attendanceDay)
    {
        $this->authorize('delete', $attendanceDay);

        $attendanceDay->delete();

        return response()->json();
    }
}
