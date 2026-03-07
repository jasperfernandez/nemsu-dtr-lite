<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Department::class);

        return Inertia::render('departments/Index', [
            'departments' => DepartmentResource::collection(Department::all()),
        ]);
    }

    public function store(DepartmentRequest $request)
    {
        $this->authorize('create', Department::class);

        Department::create($request->validated());

        return back()->with('success', 'Department added successfully.');
    }

    public function show(Department $department)
    {
        $this->authorize('view', $department);

        return new DepartmentResource($department);
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        $this->authorize('update', $department);

        $department->update($request->validated());

        return back()->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $this->authorize('delete', $department);

        $department->delete();

        return back()->with('success', 'Department deleted successfully.');
    }
}
