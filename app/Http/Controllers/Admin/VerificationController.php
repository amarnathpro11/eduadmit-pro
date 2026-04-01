<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\StudentDocument;

class VerificationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');

        $applications = Application::with('course', 'user', 'payments');

        if ($status == 'all') {
            // No filter, show all
        } elseif ($status == 'pending' || $status == 'submitted_documents') {
            $applications->whereIn('status', ['pending', 'submitted_documents']);
        } elseif ($status == 'verified') {
            $applications->whereIn('status', ['verified', 'merit', 'offer_made', 'confirmed', 'enrolled']);
        } else {
            $applications->where('status', $status);
        }

        $applications = $applications->latest()->get();

        $counts = [
            'all' => Application::count(),
            'pending' => Application::whereIn('status', ['pending', 'submitted_documents'])->count(),
            'verified' => Application::whereIn('status', ['verified', 'merit', 'offer_made', 'confirmed', 'enrolled'])->count(),
            'rejected' => Application::where('status', 'rejected')->count(),
        ];

        return view('admin.verification.index', compact('applications', 'counts', 'status'));
    }

    public function show($id)
    {
        $application = Application::with('course', 'user', 'documents')->findOrFail($id);
        return response()->json([
            'application' => $application,
            'documents' => $application->documents
        ]);
    }

    public function approveDocument($id)
    {
        $document = StudentDocument::findOrFail($id);
        $document->status = 'verified';
        $document->save();

        $this->updateApplicationStatus($document->application_id);

        return redirect()->route('admin.verification.index', [
            'status' => 'pending',
            'app_id' => $document->application_id
        ])->with('success', 'Document verified successfully.');
    }

    public function rejectDocument($id)
    {
        $document = StudentDocument::findOrFail($id);
        $document->status = 'rejected';
        $document->save();

        $this->updateApplicationStatus($document->application_id);

        return redirect()->route('admin.verification.index', [
            'status' => 'pending',
            'app_id' => $document->application_id
        ])->with('error', 'Document rejected.');
    }

    private function updateApplicationStatus($appId)
    {
        $app = Application::with('documents')->findOrFail($appId);
        
        // Define terminal/higher statuses that should NEVER be downgraded by document verification
        $protectedStatuses = ['merit', 'offer_made', 'confirmed', 'enrolled', 'shortlisted'];
        
        if (in_array($app->status, $protectedStatuses)) {
            return; // Don't revert status if they are already advanced in the journey
        }

        $totalDocs = $app->documents->count();
        $verifiedDocs = $app->documents->where('status', 'verified')->count();
        $rejectedDocs = $app->documents->where('status', 'rejected')->count();

        // Check if all 6 required types are present and verified
        $requiredTypes = ['10th', '12th', 'tc', 'id', 'photo', 'income'];
        $verifiedTypes = $app->documents->where('status', 'verified')->pluck('document_type')->toArray();
        $allRequiredVerified = count(array_intersect($requiredTypes, $verifiedTypes)) === 6;

        if ($rejectedDocs > 0) {
            $app->status = 'rejected';
        } elseif ($allRequiredVerified) {
            $app->status = 'verified';
        } else {
            // Keep as 'submitted_documents' if they've at least started
            $app->status = 'submitted_documents';
        }
        
        $app->save();
    }
}
