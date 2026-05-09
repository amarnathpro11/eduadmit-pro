<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Application;
use App\Models\Payment;

class DashboardController extends Controller
{
    /**
     * Display the parent dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Fetch real student linked to parent if user is logged in
        $studentUser = $user ? $user->students()->first() : null;
        
        if (!$studentUser) {
            // Fallback to demo data if no student is linked
            $student = [
                'name' => 'Demo Student (No Link Found)',
                'id' => 'STU12345',
                'course' => 'Computer Science & Engineering',
                'status' => 'Provisionally Admitted',
                'progress' => 75,
            ];

            $applications = [
                [
                    'id' => 'APP001',
                    'course' => 'B.Tech CSE',
                    'status' => 'Verified',
                    'date' => '2026-05-01',
                ]
            ];

            $payments = [
                [
                    'id' => 'PAY001',
                    'amount' => 1000,
                    'status' => 'Paid',
                    'date' => '2026-05-05',
                    'type' => 'Application Fee'
                ],
                [
                    'id' => 'PAY002',
                    'amount' => 50000,
                    'status' => 'Pending',
                    'date' => '2026-05-15',
                    'type' => 'Admission Fee'
                ]
            ];
            
            $lmsRecords = [
                (object)['subject' => 'Introduction to Programming', 'grade' => 'A', 'attendance' => 95, 'status' => 'active'],
                (object)['subject' => 'Data Structures', 'grade' => 'B+', 'attendance' => 88, 'status' => 'active'],
                (object)['subject' => 'Discrete Mathematics', 'grade' => 'A-', 'attendance' => 90, 'status' => 'active'],
            ];
            
            return view('parent.dashboard', compact('student', 'applications', 'payments', 'lmsRecords'))->with('warning', 'No real student mapped to this parent yet. Showing demo data.');
        }
        
        $application = $studentUser->applications()->first();
        
        $student = [
            'name' => $studentUser->name,
            'id' => 'STU' . str_pad($studentUser->id, 5, '0', STR_PAD_LEFT),
            'course' => $application && $application->course ? $application->course->name : 'N/A',
            'status' => $application ? ucfirst($application->status) : 'Registered',
            'progress' => $application ? ($application->status === 'enrolled' ? 100 : 50) : 10,
        ];
        
        $applications = $studentUser->applications->map(function($app) {
            return [
                'id' => 'APP' . str_pad($app->id, 5, '0', STR_PAD_LEFT),
                'course' => $app->course ? $app->course->name : 'N/A',
                'status' => ucfirst($app->status),
                'date' => $app->created_at->format('Y-m-d'),
            ];
        })->toArray();
        
        $payments = \App\Models\Payment::where('user_id', $studentUser->id)->get()->map(function($pay) {
            return [
                'id' => 'PAY' . str_pad($pay->id, 5, '0', STR_PAD_LEFT),
                'amount' => $pay->amount,
                'status' => ucfirst($pay->status),
                'date' => $pay->created_at->format('Y-m-d'),
                'type' => ucfirst($pay->payment_type ?? 'Fee')
            ];
        })->toArray();

        $lmsRecords = \Illuminate\Support\Facades\DB::table('lms_student_records')->where('user_id', $studentUser->id)->get();

        return view('parent.dashboard', compact('student', 'applications', 'payments', 'lmsRecords'));
    }

    public function lms()
    {
        $user = Auth::user();
        $studentUser = $user ? $user->students()->first() : null;
        
        if (!$studentUser) {
            $lmsRecords = [
                (object)['subject' => 'Introduction to Programming', 'grade' => 'A', 'attendance' => 95, 'status' => 'active'],
                (object)['subject' => 'Data Structures', 'grade' => 'B+', 'attendance' => 88, 'status' => 'active'],
                (object)['subject' => 'Discrete Mathematics', 'grade' => 'A-', 'attendance' => 90, 'status' => 'active'],
            ];
            return view('parent.lms', compact('lmsRecords'))->with('warning', 'Showing demo data.');
        }
        
        $lmsRecords = \Illuminate\Support\Facades\DB::table('lms_student_records')->where('user_id', $studentUser->id)->get();
        
        return view('parent.lms', compact('lmsRecords', 'studentUser'));
    }
}
