<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Payment;
use App\Models\Application;
use Carbon\Carbon;

class AccountantController extends Controller
{
    public function index(Request $request)
    {
        $feeType = $request->get('type', 'admission'); // 'admission' or 'application'
        // 1. Total Revenue Today
        $totalRevenueToday = Payment::whereDate('created_at', Carbon::today())
            ->where('status', 'success')
            ->sum('amount');

        // 2. Successful Transactions
        $successfulTransactions = Payment::where('status', 'success')->count();
        
        // Let's calculate expected vs received for all applications to get pending logic
        $applications = Application::with(['course', 'payments', 'user'])->get();

        $totalExpectedRevenueTotal = 0;
        $totalCollectedRevenueTotal = 0;
        
        $pendingPaymentsCount = 0;
        $awaitingPaymentStudents = collect();

        foreach ($applications as $app) {
            $expected = 0;
            if ($feeType == 'admission') {
                $expected = $app->course ? ($app->course->admission_fee + ($app->course->lab_fee ?? 0) + ($app->course->library_fee ?? 0)) : 0;
            } else {
                $expected = $app->course ? ($app->course->application_fee ?? 700) : 700;
            }
            
            $totalExpectedRevenueTotal += $expected;

            $paid = $app->payments->where('status', 'success')->where('payment_type', $feeType)->sum('amount');
            
            // Legacy support: if no tagged payment found, check untagged ones
            if ($paid < $expected) {
                $untagged = $app->payments->where('status', 'success')->where('payment_type', null);
                $appFee = $app->course->application_fee ?? 700;
                $admFee = $app->course->admission_fee ?? 0;
                $totalAdm = $admFee + ($app->course->lab_fee ?? 0) + ($app->course->library_fee ?? 0);

                foreach($untagged as $p) {
                    if ($feeType == 'application' && ($p->amount == $appFee || $p->amount < $appFee + 100)) {
                        $paid += $p->amount;
                    } elseif ($feeType == 'admission' && ($p->amount == $admFee || $p->amount == $totalAdm || $p->amount > $admFee - 100)) {
                        $paid += $p->amount;
                    }
                }
            }

            $totalCollectedRevenueTotal += $paid;
            $pending = $expected - $paid;

            // Only show students who still have pending dues for the selected fee type
            $shouldShow = ($pending > 0);
            if ($feeType == 'admission' && !in_array($app->status, ['selected', 'confirmed'])) {
                $shouldShow = false;
            }

            if ($shouldShow) {
                $pendingPaymentsCount++;
                
                // Add to our list for the left panel
                $awaitingPaymentStudents->push((object)[
                    'id' => $app->application_no ?? 'APP-'.$app->id,
                    'user_id' => $app->user_id ?? 1,
                    'name' => trim($app->first_name . ' ' . $app->last_name),
                    'course_name' => $app->course ? $app->course->name : 'N/A',
                    'pending_amount' => $pending,
                    'expected_fee' => $expected,
                    // Real breakdown from the model
                    'is_application' => ($feeType == 'application'),
                    'tuition' => ($feeType == 'admission') ? ($expected - ($app->course->library_fee ?? 0) - ($app->course->lab_fee ?? 0)) : $expected,
                    'library' => ($feeType == 'admission') ? ($app->course->library_fee ?? 0) : 0,
                    'lab' => ($feeType == 'admission') ? ($app->course->lab_fee ?? 0) : 0,
                    'application' => ($feeType == 'admission') ? ($app->course->application_fee ?? 0) : 0,
                    'health' => ($feeType == 'admission') ? 500 : 0, 
                ]);
            }
        }

        // Recent Successful Payments for the Interactive Modal
        $recentSuccessfulPayments = Payment::with(['user', 'application.course'])
            ->where('status', 'success')
            ->latest()
            ->limit(15)
            ->get();

        $outstandingDues = $totalExpectedRevenueTotal - $totalCollectedRevenueTotal;

        return view('accountant.dashboard', compact(
            'totalRevenueToday',
            'successfulTransactions',
            'pendingPaymentsCount',
            'outstandingDues',
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
            'type' => 'required|in:application,admission',
        ]);

        $application = Application::where('user_id', $request->user_id)->first();

        // Save the manual payment into the database
        Payment::create([
            'user_id' => $request->user_id,
            'application_id' => $application ? $application->id : null,
            'transaction_id' => $request->transaction_id,
            'amount' => $request->amount,
            'status' => 'success',
            'payment_type' => $request->type,
            'payment_mode' => $request->payment_mode,
            'payment_date' => Carbon::now(),
        ]);

        return redirect()->route('accountant.dashboard')->with('success', 'Payment recorded successfully! (Accountant Action)');
    }

    public function exportReport()
    {
        $payments = Payment::with(['user', 'application.course'])
            ->where('status', 'success')
            ->latest()
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('accountant.reports.collection_pdf', compact('payments'));
        return $pdf->download('Collection_Report_' . date('Y-m-d') . '.pdf');
    }

    public function paymentHistory(Request $request)
    {
        $query = Payment::with(['user', 'application.course']);

        if ($request->filled('search')) {
            $query->where('transaction_id', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
        }

        if ($request->filled('type')) {
            $query->where('payment_type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Default to desc
        $payments = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('accountant.payment_history', compact('payments'));
    }
}
