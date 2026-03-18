<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Department;

class CourseController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'duration_years' => 'required|numeric',
            'total_seats' => 'required|integer',
            'application_fee' => 'required|numeric',
            'admission_fee' => 'required|numeric',
            'level' => 'nullable|string',
        ]);

        Course::create($request->all());

        return redirect()->back()->with('success', 'Course added successfully');
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'duration_years' => 'required|numeric',
            'total_seats' => 'required|integer',
            'application_fee' => 'required|numeric',
            'admission_fee' => 'required|numeric',
            'level' => 'nullable|string',
        ]);

        $course->update($request->all());

        return redirect()->back()->with('success', 'Course updated successfully');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json(['success' => true, 'message' => 'Course deleted successfully.']);
    }

    public function toggleActive(Request $request, Course $course)
    {
        $course->is_active = !$course->is_active;
        $course->save();

        return response()->json([
            'success' => true,
            'is_active' => $course->is_active,
            'message' => 'Course status updated successfully'
        ]);
    }
}
