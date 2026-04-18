<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lead;
use App\Models\User;
use App\Models\Role;
use App\Models\Course;
use App\Models\LeadCommunication;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::with('course', 'assignedTo');

        // Stats
        $stats = [
            'total' => Lead::count(),
            'highIntent' => Lead::where('lead_score', '>=', 80)->count(),
            'converted' => Lead::where('status', 'Converted')->count(),
            'lost' => Lead::where('status', 'Lost')->count(),
        ];
        
        // Filters
        if ($request->filled('status') && $request->status != 'All') {
            $query->where('status', $request->status);
        }
        if ($request->filled('source') && $request->source != 'All') {
            $query->where('source', $request->source);
        }
        if ($request->filled('assigned_to') && $request->assigned_to != 'Any') {
            $query->where('assigned_to', $request->assigned_to);
        }

        $leads = $query->latest()->paginate(10);

        // Check login status for leads that are also registered users
        $leads->getCollection()->transform(function($lead) {
            $user = User::where('email', $lead->email)->first();
            $lead->is_registered = !is_null($user);
            $lead->last_login = $user->last_login_at ?? null;
            return $lead;
        });
        
        $counselors = User::whereHas('role', function($q) {
            $q->whereIn('name', ['admin', 'counselor']);
        })->get();

        $courses = Course::where('is_active', true)->get();

        return view('admin.leads.index', compact('leads', 'stats', 'counselors', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'required|string',
            'source' => 'required|string',
            'course_interested' => 'required|exists:courses,id',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'required|string',
            'lead_score' => 'required|integer|min:0|max:100',
            'notes' => 'nullable|string'
        ]);

        Lead::create($validated);

        return redirect()->route('admin.leads.index')->with('success', 'Lead created successfully.');
    }

    public function show(Lead $lead)
    {
        $lead->load(['course', 'assignedTo']);
        $communications = LeadCommunication::with('user')->where('lead_id', $lead->id)->latest()->get();
        return view('admin.leads.show', compact('lead', 'communications'));
    }

    public function storeCommunication(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'message' => 'nullable|string'
        ]);

        $validated['created_by'] = \Illuminate\Support\Facades\Auth::id();
        $validated['lead_id'] = $lead->id;

        LeadCommunication::create($validated);

        return back()->with('success', 'Communication added successfully.');
    }

    public function publicCapture(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:leads,email',
            'phone' => 'required|string',
            'course_interested' => 'required|exists:courses,id',
            'source' => 'nullable|string'
        ]);

        $validated['source'] = $validated['source'] ?? 'Website';
        $validated['status'] = 'New';
        $validated['lead_score'] = 10; // Default score

        $lead = Lead::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Lead captured successfully!',
            'data' => $lead
        ], 201);
    }
}
