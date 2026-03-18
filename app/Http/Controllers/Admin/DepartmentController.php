<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    //

    public function index()
    {
        $departments = Department::withCount('courses')->get();
        return view('admin.departments.index', compact('departments'));
    }

    public function show(Department $department)
    {
        $department->load('courses');
        return view('admin.departments.show', compact('department'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'hod_name' => 'nullable|string|max:255',
        ]);

        Department::create($request->all());

        return redirect()->back()->with('success', 'Department added successfully');
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'hod_name' => 'nullable|string|max:255',
        ]);

        $department->update($request->all());

        return redirect()->back()->with('success', 'Department details updated successfully');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return response()->json(['success' => true]);
    }
}
