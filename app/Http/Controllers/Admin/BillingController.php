<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Application;
use Carbon\Carbon;

class BillingController extends Controller
{
    public function index()
    {
        // 1. Total Revenue Today
        $totalRevenueToday = Payment::whereDate('created_at', Carbon::today())
            ->where('status', 'success')
            ->sum('amount');

        // 2. Successful Transactions
        $successfulTransactions = Payment::where('status', 'success')->count();
        
        // Let's calculate expected vs received for all applications to get pending logic
        $applications = Application::with(['course', 'payments', 'user'])->get();

        $totalExpectedRevenue = 0;
        $totalCollectedRevenue = Payment::where('status', 'success')->sum('amount');
        
        $pendingPaymentsCount = 0;
        $awaitingPaymentStudents = collect();

        foreach ($applications as $app) {
            $expected = $app->course ? $app->course->admission_fee : 0;
            $totalExpectedRevenue += $expected;

            $paid = $app->payments->where('status', 'success')->sum('amount');
            $pending = $expected - $paid;

            if ($pending > 0) {
                $pendingPaymentsCount++;
                
                // Add to our list for the left panel
                $awaitingPaymentStudents->push((object)[
                    'id' => $app->application_no ?? 'APP-'.$app->id,
                    'user_id' => $app->user_id ?? 1,
                    'name' => trim($app->first_name . ' ' . $app->last_name),
                    'course_name' => $app->course ? $app->course->name : 'N/A',
                    'pending_amount' => $pending,
                    'expected_fee' => $expected,
                    // We can simulate breakdown based on expected
                    'tuition' => $expected * 0.70,
                    'library' => $expected * 0.10,
                    'lab' => $expected * 0.10,
                    'sports' => $expected * 0.05,
                    'health' => $expected * 0.05,
                ]);
            }
        }

        // Recent Successful Payments for the Interactive Modal
        $recentSuccessfulPayments = Payment::with(['user', 'application.course'])
            ->where('status', 'success')
            ->latest()
            ->limit(15)
            ->get();

        // 4. Fee Collection Rate
        $feeCollectionRate = $totalExpectedRevenue > 0 
            ? round(($totalCollectedRevenue / $totalExpectedRevenue) * 100, 1) 
            : 0;

        return view('admin.billing.index', compact(
            'totalRevenueToday',
            'successfulTransactions',
            'pendingPaymentsCount',
            'feeCollectionRate',
            'awaitingPaymentStudents',
            'recentSuccessfulPayments'
        ));
    }

    public function storePayment(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'amount' => 'required|numeric',
            'payment_mode' => 'required',
            'transaction_id' => 'required|string',
        ]);

        $application = Application::where('user_id', $request->user_id)->first();

        // Save the manual payment into the database
        Payment::create([
            'user_id' => $request->user_id,
            'application_id' => $application ? $application->id : null,
            'transaction_id' => $request->transaction_id,
            'amount' => $request->amount,
            'status' => 'success',
            'payment_mode' => $request->payment_mode,
            'payment_date' => \Carbon\Carbon::now(),
        ]);

        return redirect()->route('admin.billing.index')->with('success', 'Payment recorded successfully! (Database Updated)');
    }
}
