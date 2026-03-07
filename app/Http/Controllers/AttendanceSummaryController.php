<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceSummaryRequest;
use App\Http\Resources\AttendanceSummaryResource;
use App\Models\AttendanceSummary;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AttendanceSummaryController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', AttendanceSummary::class);

        return AttendanceSummaryResource::collection(AttendanceSummary::all());
    }

    public function store(AttendanceSummaryRequest $request)
    {
        $this->authorize('create', AttendanceSummary::class);

        return new AttendanceSummaryResource(AttendanceSummary::create($request->validated()));
    }

    public function show(AttendanceSummary $attendanceSummary)
    {
        $this->authorize('view', $attendanceSummary);

        return new AttendanceSummaryResource($attendanceSummary);
    }

    public function update(AttendanceSummaryRequest $request, AttendanceSummary $attendanceSummary)
    {
        $this->authorize('update', $attendanceSummary);

        $attendanceSummary->update($request->validated());

        return new AttendanceSummaryResource($attendanceSummary);
    }

    public function destroy(AttendanceSummary $attendanceSummary)
    {
        $this->authorize('delete', $attendanceSummary);

        $attendanceSummary->delete();

        return response()->json();
    }
}
