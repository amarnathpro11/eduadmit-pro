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

        $applications = Application::with('course', 'user');

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
        $application = Application::with('course', 'user')->findOrFail($id);
        $documents = StudentDocument::where('user_id', $application->user_id)->get();
        return response()->json([
            'application' => $application,
            'documents' => $documents
        ]);
    }

    public function approveDocument($id)
    {
        $document = StudentDocument::findOrFail($id);
        $document->status = 'verified';
        $document->save();

        $this->updateApplicationStatus($document->application_id);

        return redirect()->back()->with('success', 'Document verified successfully.');
    }

    public function rejectDocument($id)
    {
        $document = StudentDocument::findOrFail($id);
        $document->status = 'rejected';
        $document->save();

        $this->updateApplicationStatus($document->application_id);

        return redirect()->back()->with('error', 'Document rejected.');
    }

    private function updateApplicationStatus($appId)
    {
        $app = Application::findOrFail($appId);
        $docs = StudentDocument::where('user_id', $app->user_id)->get();
        // Assume 6 docs are required
        if ($docs->where('status', 'verified')->count() >= 6) {
            $app->status = 'verified';
        } elseif ($docs->where('status', 'rejected')->count() > 0) {
            $app->status = 'rejected';
        } else {
            $app->status = 'pending';
        }
        $app->save();
    }
}
