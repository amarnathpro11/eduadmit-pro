<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Application;
use App\Models\Payment;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $selectedYear = $request->input('year', date('Y'));
        
        // total counts
        $totalLeads = Lead::count();
        $totalApplications = Application::count();
        $totalPayments = Payment::sum('amount') ?? 0;
        $totalEnrollments = Enrollment::count();

        // Monthly applications starting from JAN
        $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        $appData = [];
        
        for ($m = 1; $m <= 12; $m++) {
            $count = Application::whereYear('created_at', $selectedYear)
                ->whereMonth('created_at', $m)
                ->count();
            $appData[] = $count;
        }

        // Filter out future months if current year
        if ($selectedYear == date('Y')) {
            $currentMonth = date('n');
            $months = array_slice($months, 0, $currentMonth);
            $appData = array_slice($appData, 0, $currentMonth);
        }

        // Lead source Breakdown (Real Data)
        $leadSourceStats = Lead::select('source', DB::raw('COUNT(*) as total'))
            ->groupBy('source')
            ->get();
        
        $sourceLabels = $leadSourceStats->pluck('source')->toArray();
        $sourceCounts = $leadSourceStats->pluck('total')->toArray();

        $recentApplications = Application::with('course', 'user')->latest()->take(5)->get();
        $availableYears = Application::select(DB::raw('YEAR(created_at) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        if ($availableYears->isEmpty()) {
            $availableYears = [date('Y')];
        }

        // Counselor Performance (Real Data)
        $counselorPerformance = \App\Models\User::whereHas('role', function($q) {
                $q->where('name', 'counselor');
            })
            ->withCount(['leads as total_leads'])
            ->withCount(['leads as converted_leads' => function($q) {
                $q->where('status', 'Converted');
            }])
            ->get()
            ->map(function($counselor) {
                $total = $counselor->total_leads ?: 1; // avoid division by zero
                $counselor->conversion_rate = round(($counselor->converted_leads / $total) * 100);
                return $counselor;
            })
            ->sortByDesc('conversion_rate')
            ->take(5);

        return view("admin.dashboard", compact(
            'totalLeads',
            'totalApplications',
            'totalPayments',
            'totalEnrollments',
            'months',
            'appData',
            'sourceLabels',
            'sourceCounts',
            'recentApplications',
            'selectedYear',
            'availableYears',
            'counselorPerformance'
        ));
    }

    public function downloadSummary()
    {
        $totalLeads = Lead::count();
        $totalApplications = Application::count();
        $totalPayments = Payment::sum('amount');
        $totalEnrollments = Enrollment::count();

        $recentApplications = Application::with('course', 'user')->latest()->take(10)->get();

        $data = [
            'totalLeads' => $totalLeads,
            'totalApplications' => $totalApplications,
            'totalPayments' => $totalPayments,
            'totalEnrollments' => $totalEnrollments,
            'recentApplications' => $recentApplications,
            'date' => date('d M Y')
        ];

        $pdf = Pdf::loadView('admin.reports.dashboard_summary_pdf', $data);
        return $pdf->download('dashboard_summary_' . date('Y-m-d') . '.pdf');
    }
}
