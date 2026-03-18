<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuotaCategory;
use App\Models\Course;
use App\Models\Role;

class AdmissionController extends Controller
{
    //
    public function index()
    {
        $quotaCategories = QuotaCategory::where('is_active', 1)->get();
        $courses = Course::with('quotas')->get();
        $roles = Role::with('permissions')->get();

        return view('admin.admissions.index', compact(
            'quotaCategories',
            'courses',
            'roles'
        ));
    }
}
