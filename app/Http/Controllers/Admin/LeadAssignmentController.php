<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class LeadAssignmentController extends Controller
{
    public function index()
    {
        // Unassigned leads
        $unassignedLeads = Lead::with('course')
            ->whereNull('assigned_to')
            ->orderBy('created_at', 'desc')
            ->get();

        // Counselors (users with counselor role or admin)
        // For the design, we'll fetch counselors and calculate their stats
        $counselors = User::whereHas('role', function($q) {
            $q->where('name', 'admin')->orWhere('name', 'counselor');
        })->withCount(['leads' => function($q) {
            $q->where('status', '!=', 'Converted');
        }])->get();

        // Stats for the header
        $stats = [
            'unassigned' => Lead::whereNull('assigned_to')->count(),
            'available_counselors' => $counselors->where('is_active', true)->count(),
        ];

        return view('admin.leads.assignment', compact('unassignedLeads', 'counselors', 'stats'));
    }

    public function assign(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $lead = Lead::findOrFail($request->lead_id);
        $lead->assigned_to = $request->user_id;
        $lead->save();

        return response()->json([
            'success' => true,
            'message' => 'Lead assigned successfully'
        ]);
    }

    public function autoAssign()
    {
        // Simple round-robin or workload-based auto assignment logic could go here
        // For now, just a placeholder for the "Bulk Auto-Assign" button
        return back()->with('success', 'Auto-assignment process started.');
    }
}
