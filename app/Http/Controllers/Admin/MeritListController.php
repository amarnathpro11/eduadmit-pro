<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Course;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\OfferLetterMail;

class MeritListController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');

        $query = Application::with('course', 'user', 'quotaCategory')->whereIn('status', ['verified', 'merit', 'offer_made', 'confirmed', 'enrolled', 'shortlisted']);

        if ($status == 'shortlisted') {
            $query->where('status', 'merit'); // map 'merit' to shortlisted
        } elseif ($status == 'selected') {
            $query->whereIn('status', ['offer_made', 'confirmed', 'enrolled']);
        }

        $applications = $query->paginate(10);

        $totalCandidates = Application::whereIn('status', ['verified', 'merit', 'offer_made', 'confirmed', 'enrolled', 'shortlisted'])->count();

        $stats = [
            'total' => $totalCandidates,
            'shortlisted' => Application::whereIn('status', ['merit', 'shortlisted'])->count(),
            'selected' => Application::whereIn('status', ['offer_made', 'confirmed', 'enrolled'])->count(),
            'verified' => Application::where('status', 'verified')->count() // acting as waitlisted/pending
        ];

        $courses = Course::withCount(['applications' => function ($q) {
            $q->whereIn('status', ['offer_made', 'confirmed', 'enrolled']);
        }])->get();

        return view('admin.merit_list.index', compact('applications', 'stats', 'courses', 'status'));
    }

    public function generate()
    {
        // Calculate merit score based on 10th and 12th percentage since there is no entrance exam.
        // We calculate an average of both percentages as the merit score.
        $applications = Application::with('quotaCategory')->whereIn('status', ['verified', 'confirmed'])->get();
        if ($applications->isEmpty()) {
            return redirect()->back()->with('error', 'No verified or paid candidates available to shortlist.');
        }

        $shortlistedCount = 0;

        foreach ($applications as $app) {
            $threshold = $app->quotaCategory->merit_threshold ?? 60;
            $tenth = floatval($app->tenth_percentage);
            $twelfth = floatval($app->twelfth_percentage);

            // Calculate a score out of 100
            $score = ($tenth + $twelfth) / 2;
            $app->merit_score = $score;

            // Shortlist only if average score >= threshold
            if ($score >= $threshold) {
                $app->status = 'merit'; // map merit to Shortlisted
                $shortlistedCount++;
            }

            $app->save();
        }

        return redirect()->back()->with('success', "Auto-Merit generated. $shortlistedCount candidates shortlisted based on their respective category thresholds.");
    }

    public function publish()
    {
        // Move 'merit' to 'offer_made'
        $applications = Application::where('status', 'merit')->get();
        if ($applications->isEmpty()) {
            return redirect()->back()->with('error', 'No shortlisted candidates available to publish.');
        }
        foreach ($applications as $app) {
            $app->status = 'offer_made';
            $app->save();

            // Send the Offer Letter Email
            $email = $app->user->email ?? $app->email;
            if ($email) {
                try {
                    Mail::to($email)->send(new OfferLetterMail($app));
                } catch (\Exception $e) {
                    Log::error("Failed to send offer letter to {$email}: " . $e->getMessage());
                }
            }
        }

        return redirect()->back()->with('success', 'Merit List published successfully. Candidates have been notified and offers are active.');
    }

    public function previewMail()
    {
        // Find the first shortlisted or verified application to use as dummy data for the preview
        $application = Application::whereIn('status', ['merit', 'verified', 'offer_made'])->first();

        if (!$application) {
            return redirect()->back()->with('error', 'No applications available to generate a preview.');
        }

        // Return the Mail object directly - Laravel automatically renders the Mailable in the browser!
        return new OfferLetterMail($application);
    }

    public function resetList()
    {
        // Reset all 'merit' and 'offer_made' status applications back to 'verified'
        $count = Application::whereIn('status', ['merit', 'offer_made'])
            ->update(['status' => 'verified']);

        return redirect()->back()->with('success', "Merit list reset successfully. $count candidates have been returned to the Waitlisted/Verified pool.");
    }

    public function markShortlisted($id)
    {
        $app = Application::findOrFail($id);
        if ($app->status == 'verified') {
            $app->status = 'merit';
            $app->save();
            return redirect()->back()->with('success', 'Candidate shortlisted.');
        }
        return redirect()->back()->with('error', 'Candidate cannot be shortlisted from current status.');
    }

    public function markSelected($id)
    {
        $app = Application::findOrFail($id);
        if (in_array($app->status, ['verified', 'merit'])) {
            $app->status = 'offer_made';
            $app->save();
            return redirect()->back()->with('success', 'Candidate selected & offer made.');
        }
        return redirect()->back()->with('error', 'Candidate cannot be selected from current status.');
    }
}
