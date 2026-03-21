<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\RuleController;
use App\Http\Controllers\Admin\AdmissionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\Admin\MeritListController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\FollowUpController;
use App\Http\Controllers\Student\AuthController as StudentAuthController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\PaymentController;
use App\Http\Middleware\StudentMiddleware;

Route::get('/', function () {
    return view('admin.welcome');
});

Route::prefix('admin')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/signup', [AuthController::class, 'signup'])->name('admin.signup.submit');

    // Password Reset Routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('admin.password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('admin.password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('admin.password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('admin.password.update');


    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/dashboard/download', [DashboardController::class, 'downloadSummary'])->name('admin.dashboard.download');
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

        // Lead Management
        Route::get('/leads', [\App\Http\Controllers\Admin\LeadController::class, 'index'])->name('admin.leads.index');
        Route::post('/leads', [\App\Http\Controllers\Admin\LeadController::class, 'store'])->name('admin.leads.store');
        // Lead Assignment & Allocation
        Route::get('/leads/assignment', [\App\Http\Controllers\Admin\LeadAssignmentController::class, 'index'])->name('admin.leads.assignment');
        Route::post('/leads/assign', [\App\Http\Controllers\Admin\LeadAssignmentController::class, 'assign'])->name('admin.leads.assign');
        Route::post('/leads/auto-assign', [\App\Http\Controllers\Admin\LeadAssignmentController::class, 'autoAssign'])->name('admin.leads.auto_assign');

        Route::get('/leads/{lead}', [\App\Http\Controllers\Admin\LeadController::class, 'show'])->name('admin.leads.show');
        Route::post('/leads/{lead}/communications', [\App\Http\Controllers\Admin\LeadController::class, 'storeCommunication'])->name('admin.leads.communications.store');

        // Profile & Settings
        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
        Route::post('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::get('/settings', [ProfileController::class, 'settings'])->name('admin.settings');
        Route::post('/settings', [ProfileController::class, 'updateSettings'])->name('admin.settings.update');

        // Follow-ups
        Route::get('/follow-ups', [FollowUpController::class, 'index'])->name('admin.follow_ups.index');
        Route::post('/follow-ups', [FollowUpController::class, 'store'])->name('admin.follow_ups.store');
        Route::patch('/follow-ups/{followUp}/status', [FollowUpController::class, 'updateStatus'])->name('admin.follow_ups.status');
        Route::delete('/follow-ups/{followUp}', [FollowUpController::class, 'destroy'])->name('admin.follow_ups.destroy');
    });
    Route::get('/users', [UserController::class, 'index'])
        ->name('admin.users.index');

    Route::get('/users/export', [UserController::class, 'exportExcel'])
        ->name('admin.users.export');

    Route::get('/users/create', [UserController::class, 'create'])
        ->name('admin.users.create');

    Route::post('/users', [UserController::class, 'store'])
        ->name('admin.users.store');

    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->name('admin.users.edit');

    Route::put('/users/{user}', [UserController::class, 'update'])
        ->name('admin.users.update');


    Route::get('/departments', [DepartmentController::class, 'index'])
        ->name('admin.departments.index');

    Route::post('/departments', [DepartmentController::class, 'store'])
        ->name('admin.departments.store');

    Route::get('/departments/{department}', [DepartmentController::class, 'show'])
        ->name('admin.departments.show');

    Route::put('/departments/{department}', [DepartmentController::class, 'update'])
        ->name('admin.departments.update');

    Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])
        ->name('admin.departments.destroy');

    Route::post('/courses', [CourseController::class, 'store'])
        ->name('admin.courses.store');

    Route::put('/courses/{course}', [CourseController::class, 'update'])
        ->name('admin.courses.update');

    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])
        ->name('admin.courses.destroy');

    Route::post('/courses/{course}/toggle', [CourseController::class, 'toggleActive'])
        ->name('admin.courses.toggle');

    Route::get('/rules', [RuleController::class, 'index'])
        ->name('admin.rules.index');

    Route::post('/rules/threshold', [RuleController::class, 'updateThreshold'])
        ->name('admin.rules.threshold.update');

    Route::get('/admissions', [AdmissionController::class, 'index'])
        ->name('admin.admissions.index');

    Route::get('/verification', [VerificationController::class, 'index'])
        ->name('admin.verification.index');

    Route::get('/verification/{id}', [VerificationController::class, 'show'])
        ->name('admin.verification.show');

    Route::post('/verification/document/{id}/approve', [VerificationController::class, 'approveDocument'])
        ->name('admin.verification.document.approve');

    Route::post('/verification/document/{id}/reject', [VerificationController::class, 'rejectDocument'])
        ->name('admin.verification.document.reject');

    Route::get('/merit-list', [MeritListController::class, 'index'])
        ->name('admin.merit_list.index');

    Route::post('/merit-list/generate', [MeritListController::class, 'generate'])
        ->name('admin.merit_list.generate');

    Route::post('/merit-list/publish', [MeritListController::class, 'publish'])
        ->name('admin.merit_list.publish');

    Route::get('/merit-list/mail-preview', [MeritListController::class, 'previewMail'])
        ->name('admin.merit_list.mail_preview');

    Route::post('/merit-list/reset', [MeritListController::class, 'resetList'])
        ->name('admin.merit_list.reset');

    Route::post('/merit-list/{id}/shortlist', [MeritListController::class, 'markShortlisted'])
        ->name('admin.merit_list.shortlist');

    Route::post('/merit-list/{id}/select', [MeritListController::class, 'markSelected'])
        ->name('admin.merit_list.select');

    Route::get('/final-admission', [\App\Http\Controllers\Admin\FinalAdmissionController::class, 'index'])
        ->name('admin.final_admission.index');

    Route::get('/final-admission/{id}', [\App\Http\Controllers\Admin\FinalAdmissionController::class, 'show'])
        ->name('admin.final_admission.show');

    Route::post('/final-admission/{id}/approve', [\App\Http\Controllers\Admin\FinalAdmissionController::class, 'approve'])
        ->name('admin.final_admission.approve');

    Route::post('/final-admission/{id}/reject', [\App\Http\Controllers\Admin\FinalAdmissionController::class, 'reject'])
        ->name('admin.final_admission.reject');

    Route::post('/final-admission/{id}/save', [\App\Http\Controllers\Admin\FinalAdmissionController::class, 'saveProgress'])
        ->name('admin.final_admission.save');
});

Route::prefix('admin/reports')->group(function () {

    Route::get('/', [ReportController::class, 'index'])
        ->name('admin.reports.index');

    Route::get('/export-excel', [ReportController::class, 'exportExcel'])
        ->name('admin.reports.export.excel');

    Route::get('/export-pdf', [ReportController::class, 'exportPDF'])
        ->name('admin.reports.export.pdf');

    Route::get('/generate', [ReportController::class, 'generate'])
        ->name('admin.reports.generate');

    Route::get('/live-logs', [ReportController::class, 'liveLogs']);
});

Route::prefix('student')->group(function () {

    Route::get('/login', [StudentAuthController::class, 'loginForm'])->name('student.login');
    Route::post('/login', [StudentAuthController::class, 'login']);

    Route::get('/register', [StudentAuthController::class, 'registerForm'])->name('student.register');
    Route::post('/register', [StudentAuthController::class, 'register']);

    // Password Reset Routes
    Route::get('/forgot-password', [StudentAuthController::class, 'showForgotPasswordForm'])->name('student.password.request');
    Route::post('/forgot-password', [StudentAuthController::class, 'sendResetLinkEmail'])->name('student.password.email');
    Route::get('/reset-password/{token}', [StudentAuthController::class, 'showResetPasswordForm'])->name('student.password.reset');
    Route::post('/reset-password', [StudentAuthController::class, 'resetPassword'])->name('student.password.update');


    Route::middleware([StudentMiddleware::class])->group(function () {

        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
        Route::post('/register-details', [StudentController::class, 'storeRegistration'])->name('student.register.details');
        Route::get('/status', [StudentController::class, 'status'])->name('student.status');
        Route::get('/documents', [StudentController::class, 'documents'])->name('student.documents');
        Route::post('/documents/upload', [StudentController::class, 'uploadDocument']);
        Route::post('/documents/submit', [StudentController::class, 'submitForVerification'])->name('student.submit_verification');
        Route::get('/payment', [PaymentController::class, 'payment'])->name('student.payment');
        Route::post('/payment/pay', [PaymentController::class, 'processPayment'])->name('student.payment.process');
        Route::post('/payment/verify', [PaymentController::class, 'verifyPayment'])->name('student.payment.verify');
        Route::get('/receipts', [PaymentController::class, 'receipts'])->name('student.receipts');
        Route::get('/receipts/{id}/download', [PaymentController::class, 'downloadReceipt'])->name('student.receipt.download');
        Route::get('/application/download', [StudentController::class, 'downloadSummary'])->name('student.application.download');
        Route::post('/logout', [StudentAuthController::class, 'logout'])->name('student.logout');
    });
});
