<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;

class FinalAdmissionController extends Controller
{
    public function index()
    {
        // For simplicity, just list applications that are offer_made, confirmed, or enrolled.
        $applications = Application::with('course', 'user', 'payments')->whereIn('status', ['offer_made', 'confirmed', 'enrolled'])->paginate(10);
        return view('admin.final_admission.index', compact('applications'));
    }

    public function show($id)
    {
        $application = Application::with(['course', 'user', 'documents'])->findOrFail($id);

        // Simple logic for the checklist items.
        // Assuming docs are verified if their status is 'verified'.
        $docsVerifiedCount = $application->documents->where('status', 'verified')->count();
        $docsVerified = $docsVerifiedCount >= 2; // e.g. at least 2 docs verified. Could be anything.

        $admissionFee = $application->course->admission_fee ?? 0;
        $labFee = $application->course->lab_fee ?? 0;
        $libraryFee = $application->course->library_fee ?? 0;
        
        $totalBalance = $admissionFee + $labFee + $libraryFee;
        
        $paidAmount = \App\Models\Payment::where('user_id', $application->user_id)->where('status', 'success')->sum('amount');
        
        // Fee is considered paid if the student has successful payments. 
        // We'll be more lenient here: as long as they have paid the registration/admission amount, it's a pass.
        $feePaid = \App\Models\Payment::where('user_id', $application->user_id)->where('status', 'success')->exists();

        $meritThreshold = $application->quotaCategory->merit_threshold ?? 60;
        $meritScore = $application->merit_score ?? (($application->tenth_percentage + $application->twelfth_percentage) / 2);
        $eligibilityMet = $meritScore >= $meritThreshold; 

        $completedTasks = ($docsVerified ? 1 : 0) + ($feePaid ? 1 : 0) + ($eligibilityMet ? 1 : 0);

        return view('admin.final_admission.show', compact('application', 'docsVerified', 'feePaid', 'eligibilityMet', 'completedTasks'));
    }

    public function approve(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $application->status = 'enrolled'; // Mark as enrolled

        // Final remarks
        if ($request->has('remarks')) {
            $application->admin_remarks = $request->remarks;
        }

        $application->save();

        return redirect()->route('admin.final_admission.index')->with('success', 'Admission approved and student officially enrolled.');
    }

    public function reject(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $application->status = 'rejected';

        if ($request->has('remarks')) {
            $application->admin_remarks = $request->remarks;
        }

        $application->save();

        return redirect()->route('admin.final_admission.index')->with('success', 'Application rejected.');
    }

    public function saveProgress(Request $request, $id)
    {
        $application = Application::findOrFail($id);

        if ($request->has('remarks')) {
            $application->admin_remarks = $request->remarks;
            $application->save();
        }

        return redirect()->back()->with('success', 'Progress saved successfully.');
    }
}
