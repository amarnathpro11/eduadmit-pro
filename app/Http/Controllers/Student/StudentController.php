<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentDocument;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentController extends Controller
{
  public function dashboard()
  {
    $user = Auth::guard('student')->user();
    $application = Application::where('user_id', $user->id)->first();
    $courses = \App\Models\Course::where('is_active', true)->get();
    return view('student.dashboard', compact('application', 'courses'));
  }

  public function storeRegistration(Request $request)
  {
    $request->validate([
      'first_name' => 'required|string|max:255',
      'last_name' => 'required|string|max:255',
      'dob' => 'required|date',
      'mobile' => 'required|string|max:20',
      'course_id' => 'required|exists:courses,id',
      'tenth_percentage' => 'required|numeric|min:0|max:100',
      'twelfth_percentage' => 'required|numeric|min:0|max:100',
    ]);

    $user = Auth::guard('student')->user();

    Application::updateOrCreate(
      ['user_id' => $user->id],
      [
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'dob' => $request->dob,
        'mobile' => $request->mobile,
        'course_id' => $request->course_id,
        'tenth_percentage' => $request->tenth_percentage,
        'twelfth_percentage' => $request->twelfth_percentage,
        'status' => 'applied',
        'application_no' => 'APP-' . strtoupper(\Illuminate\Support\Str::random(8)),
        'applied_date' => now()
      ]
    );

    return redirect()->route('student.dashboard')->with('success', 'Registration details saved successfully.');
  }

  public function status()
  {
    $user = Auth::guard('student')->user();
    $application = Application::where('user_id', $user->id)->first();
    $documents = StudentDocument::where('user_id', $user->id)->get()->keyBy('document_type');
    $payments = \App\Models\Payment::where('user_id', $user->id)->where('status', 'success')->get();
    return view('student.status', compact('application', 'documents', 'payments'));
  }

  public function documents()
  {
    $user = Auth::guard('student')->user();
    $application = Application::where('user_id', $user->id)->first();

    if (!$application) {
      // Create a dummy application if none exists to avoid errors, or handle as needed
      $application = Application::create([
        'user_id' => $user->id,
        'application_no' => 'APP-' . strtoupper(\Illuminate\Support\Str::random(8)),
        'status' => 'draft'
      ]);
    }

    $documents = StudentDocument::where('user_id', $user->id)->get()->keyBy('document_type');

    $documentTypes = [
      ['id' => '10th', 'name' => '10th Marksheet'],
      ['id' => '12th', 'name' => '12th Certificate'],
      ['id' => 'tc', 'name' => 'Transfer Certificate'],
      ['id' => 'id', 'name' => 'ID Proof (Aadhaar)'],
      ['id' => 'photo', 'name' => 'Passport Photo'],
      ['id' => 'income', 'name' => 'Income Certificate'],
    ];

    return view('student.documents', compact('documents', 'documentTypes', 'application'));
  }

  public function uploadDocument(Request $request)
  {
    $request->validate([
      'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
      'type' => 'required|string'
    ]);

    $user = Auth::guard('student')->user();
    $application = Application::where('user_id', $user->id)->first();

    if (!$application) {
      return back()->with('error', 'Please complete your application profile first.');
    }

    $file = $request->file('document');
    $extension = $file->getClientOriginalExtension() ?: 'bin';
    $fileName = time() . '_' . \Illuminate\Support\Str::random(10) . '.' . $extension;
    $path = $file->storeAs('documents/' . $user->id, $fileName, 'public');

    StudentDocument::updateOrCreate(
      [
        'user_id' => $user->id,
        'application_id' => $application->id,
        'document_type' => $request->type
      ],
      [
        'file_path' => $path,
        'status' => 'pending'
      ]
    );

    return back()->with('success', $request->type . ' uploaded successfully.');
  }

  public function submitForVerification()
  {
    $user = Auth::guard('student')->user();
    $application = Application::where('user_id', $user->id)->first();

    if (!$application) {
      return back()->with('error', 'No application found to submit.');
    }

    $requiredTypes = ['10th', '12th', 'tc', 'id', 'photo', 'income'];
    $uploadedTypes = StudentDocument::where('user_id', $user->id)->pluck('document_type')->toArray();

    $missingCount = count($requiredTypes) - count(array_intersect($requiredTypes, $uploadedTypes));

    if ($missingCount > 0) {
      return back()->with('error', 'Please upload all 6 required documents before submitting for verification. (' . $missingCount . ' documents still pending)');
    }

    $application->update(['status' => 'submitted_documents']);

    return redirect()->route('student.status')->with('success', 'Documents submitted successfully. Verification is now in progress!');
  }

  public function payment()
  {
    return view('student.payment');
  }

  public function processPayment(Request $request)
  {
    // payment logic
    return back()->with('success', 'Payment successful.');
  }

  public function receipts()
  {
    return view('student.receipts');
  }

  public function downloadSummary()
  {
    $user = Auth::guard('student')->user();
    $application = Application::with('course')->where('user_id', $user->id)->first();

    if (!$application) {
      return back()->with('error', 'No application found to download.');
    }

    $documents = StudentDocument::where('user_id', $user->id)->get();
    $payments = \App\Models\Payment::where('user_id', $user->id)->where('status', 'success')->get();

    $pdf = Pdf::loadView('student.application_pdf', compact('application', 'user', 'documents', 'payments'));

    return $pdf->download('Application_Summary_' . $application->application_no . '.pdf');
  }
}
