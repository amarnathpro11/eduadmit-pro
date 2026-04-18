<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\FollowUp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        $myLeadsQuery = Lead::where('assigned_to', $userId);
        
        $stats = [
            'total' => (clone $myLeadsQuery)->count(),
            'new' => (clone $myLeadsQuery)->where('status', 'New')->count(),
            'interested' => (clone $myLeadsQuery)->where('status', 'Interested')->count(),
            'converted' => (clone $myLeadsQuery)->where('status', 'Converted')->count(),
        ];

        $todayFollowUps = FollowUp::with('lead')
            ->where('user_id', $userId)
            ->whereDate('scheduled_at', Carbon::today())
            ->orderBy('scheduled_at', 'asc')
            ->get();

        $recentLeads = (clone $myLeadsQuery)->latest()->take(5)->get();

        return view('counselor.dashboard', compact('stats', 'todayFollowUps', 'recentLeads'));
    }
}
