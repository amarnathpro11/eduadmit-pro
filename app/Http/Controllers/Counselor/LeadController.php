<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\LeadCommunication;
use App\Models\FollowUp;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeadCommunicationMail;
use App\Mail\StudentWelcomeMail;

class LeadController extends Controller
{
    public function sendEmail(Lead $lead)

    {
        if ($lead->assigned_to !== Auth::id()) abort(403);

        try {
            Mail::to($lead->email)->send(new LeadCommunicationMail($lead));

            // Log this as a communication
            LeadCommunication::create([
                'lead_id' => $lead->id,
                'created_by' => Auth::id(),
                'type' => 'Email Sent (System)',
                'message' => 'Automated follow-up email sent to ' . $lead->email
            ]);

            return back()->with('success', 'Email sent to ' . $lead->email . ' successfully! Check your Mailtrap inbox.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }

    public function previewEmail(Lead $lead)
    {
        if ($lead->assigned_to !== Auth::id()) abort(403);
        return new LeadCommunicationMail($lead);
    }

    public function destroyCommunication(LeadCommunication $communication)
    {
        // Simple security check: Only the person who created it or whoever it's assigned to can delete?
        // Or just allow the assigned counselor.
        $communication->delete();
        return back()->with('success', 'Communication log deleted.');
    }


    public function index(Request $request)
    {
        $query = Lead::with('course')->where('assigned_to', Auth::id());

        if ($request->filled('status') && $request->status != 'All') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $leads = $query->latest()->paginate(10);

        $stats = [
            'total' => Lead::where('assigned_to', Auth::id())->count(),
            'highIntent' => Lead::where('assigned_to', Auth::id())->where('lead_score', '>=', 80)->count(),
        ];

        return view('counselor.leads.index', compact('leads', 'stats'));
    }


    public function show(Lead $lead)
    {
        if ($lead->assigned_to !== Auth::id()) {
            abort(403);
        }
        $lead->load(['course']);
        $communications = LeadCommunication::with('user')->where('lead_id', $lead->id)->latest()->get();
        $followUps = FollowUp::where('lead_id', $lead->id)->latest()->get();

        $todayFollowUps = FollowUp::with('lead')
            ->where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->whereDate('scheduled_at', \Carbon\Carbon::today())
            ->where('status', 'scheduled')

            ->orderBy('scheduled_at', 'asc')
            ->get();

        $completedFollowUps = FollowUp::with('lead')
            ->where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->whereDate('scheduled_at', \Carbon\Carbon::today())
            ->where('status', 'completed')
            ->orderBy('scheduled_at', 'asc')
            ->get();

        return view('counselor.leads.show', compact('lead', 'communications', 'followUps', 'todayFollowUps', 'completedFollowUps'));
    }

    public function history(Lead $lead)
    {
        if ($lead->assigned_to !== Auth::id()) {
            abort(403);
        }
        $lead->load(['course']);
        $communications = LeadCommunication::with('user')->where('lead_id', $lead->id)->latest()->paginate(15);

        $stats = [
            'total' => LeadCommunication::where('lead_id', $lead->id)->count(),
            'calls' => LeadCommunication::where('lead_id', $lead->id)->where('type', 'like', '%call%')->count(),
            'emails' => LeadCommunication::where('lead_id', $lead->id)->where('type', 'like', '%email%')->count(),
        ];

        return view('counselor.leads.history', compact('lead', 'communications', 'stats'));
    }

    public function storeCommunication(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'message' => 'required|string',
            'status_update' => 'nullable|string'
        ]);

        LeadCommunication::create([
            'lead_id' => $lead->id,
            'created_by' => Auth::id(),
            'type' => $validated['type'],
            'message' => $validated['message']
        ]);

        if (!empty($validated['status_update'])) {
            $oldStatus = $lead->status;
            $lead->status = $validated['status_update'];
            
            // Score adjustments based on status
            if ($lead->status == 'Interested' && $lead->lead_score < 50) $lead->lead_score = 50;
            if ($lead->status == 'Converted') $lead->lead_score = 100;
            if ($lead->status == 'Lost') $lead->lead_score = 0;
            
            $lead->save();
        } else {
            // General interaction increases score slightly if not already very high
            if ($lead->lead_score < 70) {
                $lead->increment('lead_score', 5);
            }
        }

        return back()->with('success', 'Note saved successfully.');
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        if ($lead->assigned_to !== Auth::id()) abort(403);
        $request->validate(['status' => 'required|string']);
        
        $newStatus = $request->status;
        $score = $lead->lead_score;

        if ($newStatus == 'Interested' && $score < 50) $score = 50;
        if ($newStatus == 'Converted') $score = 100;
        if ($newStatus == 'Lost') $score = 0;

        $lead->update([
            'status' => $newStatus,
            'lead_score' => $score
        ]);
        
        return back()->with('success', 'Status updated.');
    }

    public function scheduleFollowup(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'scheduled_at' => 'required|date',
            'priority' => 'required|string',
            'note' => 'nullable|string'
        ]);

        $validated['lead_id'] = $lead->id;
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'scheduled';


        FollowUp::create($validated);
        return back()->with('success', 'Follow-up scheduled.');
    }

    public function completeFollowup(FollowUp $followup)
    {
        if ($followup->user_id !== Auth::id()) abort(403);
        $followup->update(['status' => 'completed']);
        return back()->with('success', 'Task marked as completed.');
    }


    public function convert(Request $request, Lead $lead)
    {
        if ($lead->status === 'Converted') {
            return back()->with('error', 'Lead is already converted.');
        }

        // Logic to convert a lead into a Student User Profile
        $studentRole = Role::where('name', 'student')->first();
        if (!$studentRole) {
            return back()->with('error', 'Student role not found in system.');
        }

        $existingUser = User::where('email', $lead->email)->first();
        if (!$existingUser && $lead->email) {
            $user = User::create([
                'name' => $lead->name,
                'email' => $lead->email,
                'password' => Hash::make(Str::random(12)),
                'role_id' => $studentRole->id,
            ]);
            
            // Send welcome email with password reset link
            $token = Str::random(60);
            try {
                Mail::to($user->email)->send(new StudentWelcomeMail($user, $token));
                
                // Log communication
                LeadCommunication::create([
                    'lead_id' => $lead->id,
                    'created_by' => Auth::id(),
                    'type' => 'Email Sent (System)',
                    'message' => 'Welcome email with login instructions sent to ' . $lead->email
                ]);
            } catch (\Exception $e) {
                // Log error but continue conversion
                logger()->error('Failed to send welcome email: ' . $e->getMessage());
            }
        }

        $lead->update([
            'status' => 'Converted',
            'lead_score' => 100
        ]);

        return back()->with('success', 'Lead successfully converted. Student profile created.');
    }

    public function resendWelcome(Lead $lead)
    {
        if ($lead->assigned_to !== Auth::id()) abort(403);
        
        $user = User::where('email', $lead->email)->first();
        if (!$user) {
            return back()->with('error', 'Student profile does not exist for this lead.');
        }

        $token = Str::random(60);
        try {
            Mail::to($user->email)->send(new StudentWelcomeMail($user, $token));
            
            return back()->with('success', 'Welcome email resent to ' . $lead->email);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to resend email: ' . $e->getMessage());
        }
    }

    public function schedule()
    {
        $upcoming = FollowUp::with('lead.course')
            ->where('user_id', Auth::id())
            ->where('status', 'scheduled')
            ->orderBy('scheduled_at', 'asc')
            ->get();

        $completed = FollowUp::with('lead.course')
            ->where('user_id', Auth::id())
            ->where('status', 'completed')
            ->orderBy('scheduled_at', 'desc')
            ->take(20)
            ->get();

        return view('counselor.leads.schedule', compact('upcoming', 'completed'));
    }

    public function destroyFollowup(FollowUp $followup)
    {
        if ($followup->user_id !== Auth::id()) abort(403);
        $followup->delete();
        return back()->with('success', 'Task removed from schedule.');
    }
}
