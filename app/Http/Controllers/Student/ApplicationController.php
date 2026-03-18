<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
  public function index()
  {
    $applications = Application::where('user_id', Auth::id())->get();
    return view('student.applications.index', compact('applications'));
  }

  public function create()
  {
    return view('student.applications.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      // Add validation rules
    ]);

    $application = new Application($request->all());
    $application->user_id = Auth::id();
    $application->status = 'pending';
    $application->save();

    return redirect()->route('student.applications.index')->with('success', 'Application submitted successfully.');
  }

  public function show(Application $application)
  {
    if ($application->user_id !== Auth::id()) {
      abort(403);
    }
    return view('student.applications.show', compact('application'));
  }
}
