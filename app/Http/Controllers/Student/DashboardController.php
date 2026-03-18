<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\Payment;
use App\Models\StudentDocument;

class DashboardController extends Controller
{
  public function index()
  {
    $user = Auth::user();
    $applications = Application::where('user_id', $user->id)->get();
    $recentPayments = Payment::where('user_id', $user->id)->latest()->take(5)->get();
    $documentCount = StudentDocument::where('user_id', $user->id)->count();

    return view('student.dashboard', compact('applications', 'recentPayments', 'documentCount'));
  }
}
