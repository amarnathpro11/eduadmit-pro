<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FollowUp;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowUpController extends Controller
{
    public function index()
    {
        $followUps = FollowUp::with('lead')
            ->where('user_id', Auth::id())
            ->orderBy('scheduled_at', 'asc')
            ->get();

        $leads = Lead::where('assigned_to', Auth::id())->get();
        
        $todayTasks = FollowUp::with('lead')
            ->where('user_id', Auth::id())
            ->whereDate('scheduled_at', now()->toDateString())
            ->orderBy('scheduled_at', 'asc')
            ->get();

        $overdueTasks = FollowUp::with('lead')
            ->where('user_id', Auth::id())
            ->where('scheduled_at', '<', now())
            ->where('status', 'scheduled')
            ->orderBy('scheduled_at', 'desc')
            ->get();

        return view('admin.follow_ups.index', compact('followUps', 'leads', 'todayTasks', 'overdueTasks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'date' => 'required|date',
            'time' => 'required',
            'priority' => 'required|in:low,medium,high',
            'system_notification' => 'boolean',
            'email_notification' => 'boolean',
            'note' => 'nullable|string'
        ]);

        $scheduledAt = $validated['date'] . ' ' . $validated['time'];

        FollowUp::create([
            'lead_id' => $validated['lead_id'],
            'user_id' => Auth::id(),
            'scheduled_at' => $scheduledAt,
            'priority' => $validated['priority'],
            'system_notification' => $request->has('system_notification'),
            'email_notification' => $request->has('email_notification'),
            'note' => $validated['note'] ?? null,
            'status' => 'scheduled'
        ]);

        return back()->with('success', 'Follow-up scheduled successfully.');
    }

    public function updateStatus(Request $request, FollowUp $followUp)
    {
        $validated = $request->validate([
            'status' => 'required|in:scheduled,completed,cancelled,missed'
        ]);

        $followUp->update(['status' => $validated['status']]);

        return back()->with('success', 'Follow-up status updated.');
    }

    public function destroy(FollowUp $followUp)
    {
        $followUp->delete();
        return back()->with('success', 'Follow-up deleted.');
    }
}
