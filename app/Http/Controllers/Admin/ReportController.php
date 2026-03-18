<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AuditLog;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AuditLogExport;
use Barryvdh\DomPDF\Facade\Pdf;


class ReportController extends Controller
{
    private function getRealLogs()
    {
        $allLogs = collect();

        $applications = \App\Models\Application::with('user.role')->get();
        foreach ($applications as $app) {
            $allLogs->push((object)[
                'created_at' => $app->created_at,
                'user' => $app->user,
                'action' => 'Application Submitted (' . ucfirst(str_replace('_', ' ', $app->status)) . ')',
                'resource' => 'Application #' . $app->application_no,
                'status' => 'success',
            ]);
            if ($app->updated_at && $app->updated_at->gt($app->created_at)) {
                $allLogs->push((object)[
                    'created_at' => $app->updated_at,
                    'user' => $app->user,
                    'action' => 'Application status changed to ' . ucfirst(str_replace('_', ' ', $app->status)),
                    'resource' => 'Application #' . $app->application_no,
                    'status' => 'success',
                ]);
            }
        }

        $payments = \App\Models\Payment::with('user.role')->get();
        foreach ($payments as $payment) {
            $allLogs->push((object)[
                'created_at' => $payment->created_at,
                'user' => $payment->user,
                'action' => 'Payment initiated (Rs. ' . $payment->amount . ')',
                'resource' => 'Transaction: ' . ($payment->transaction_id ?? 'N/A'),
                'status' => $payment->status == 'success' ? 'success' : ($payment->status == 'failed' ? 'failed' : 'warning'),
            ]);
        }

        $users = \App\Models\User::with('role')->get();
        foreach ($users as $user) {
            $allLogs->push((object)[
                'created_at' => $user->created_at,
                'user' => $user,
                'action' => 'User Account Created',
                'resource' => 'User Profile',
                'status' => 'success',
            ]);
        }

        return $allLogs->sortByDesc('created_at')->values();
    }

    public function index(Request $request)
    {
        $allLogs = $this->getRealLogs();

        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $perPage = 10;
        $logs = new \Illuminate\Pagination\LengthAwarePaginator(
            $allLogs->forPage($page, $perPage),
            $allLogs->count(),
            $perPage,
            $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );

        // Stats for the view
        $reportsCount = count($allLogs);
        $failedAttempts = collect($allLogs)->where('status', 'failed')->count();
        $activeAdmins = \App\Models\User::whereHas('role', function ($q) {
            $q->where('name', 'admin');
        })->count();
        try {
            $dbName = config('database.connections.' . config('database.default') . '.database');
            $size = \Illuminate\Support\Facades\DB::select('SELECT SUM(data_length + index_length) / 1024 / 1024 AS size_in_mb FROM information_schema.TABLES WHERE table_schema = ?', [$dbName]);
            $storageUsage = isset($size[0]->size_in_mb) ? round($size[0]->size_in_mb, 2) . ' MB' : '0 MB';
        } catch (\Exception $e) {
            $storageUsage = 'Unknown';
        }

        return view('admin.reports.index', compact(
            'logs',
            'reportsCount',
            'failedAttempts',
            'activeAdmins',
            'storageUsage'
        ));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new AuditLogExport($this->getRealLogs()), 'audit_logs.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $logs = $this->getRealLogs();

        $pdf = Pdf::loadView('admin.reports.pdf', compact('logs'));

        return $pdf->download('audit_logs.pdf');
    }

    public function liveLogs()
    {
        return $this->getRealLogs()->take(10);
    }

    public function generate(Request $request)
    {
        $type = $request->input('report_type', 'System Report');
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        $titles = [
            'Conversion Report' => 'Conversion Report',
            'Admissions Report' => 'Admissions Report',
            'Revenue Report' => 'Revenue Report',
        ];

        $reportTitle = $titles[$type] ?? $type;
        $date = \Carbon\Carbon::now()->timezone('Asia/Kolkata')->format('d M Y h:i A');

        $appQuery = \App\Models\Application::query();
        $leadQuery = \App\Models\Lead::query();
        $payQuery = \App\Models\Payment::query();

        if ($start && $end) {
            $startDate = \Carbon\Carbon::parse($start)->startOfDay();
            $endDate = \Carbon\Carbon::parse($end)->endOfDay();
            $appQuery->whereBetween('created_at', [$startDate, $endDate]);
            $leadQuery->whereBetween('created_at', [$startDate, $endDate]);
            $payQuery->whereBetween('created_at', [$startDate, $endDate]);
            $date = $startDate->format('d M Y') . " to " . $endDate->format('d M Y');
        }

        $totalLeads = $leadQuery->count();
        $totalApplications = $appQuery->count();
        $totalEnrollments = (clone $appQuery)->where('status', 'enrolled')->count();
        $totalPayments = $payQuery->where('status', 'success')->sum('amount');

        $recentApplications = $appQuery->with('course')->latest()->take(15)->get();
        $recentLeads = $leadQuery->latest()->take(15)->get();
        $recentPayments = $payQuery->with('user')->latest()->take(15)->get();

        $pdf = Pdf::loadView('admin.reports.dashboard_summary_pdf', compact(
            'type',
            'reportTitle',
            'date',
            'totalLeads',
            'totalApplications',
            'totalEnrollments',
            'totalPayments',
            'recentApplications',
            'recentLeads',
            'recentPayments'
        ));

        return $pdf->download(str_replace(' ', '_', strtolower($reportTitle)) . '_' . date('Y-m-d') . '.pdf');
    }
}
