<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuotaCategory;
use Illuminate\Http\Request;

class RuleController extends Controller
{
  public function index()
  {
    $quotas = QuotaCategory::all();
    $meritThreshold = cache()->get('merit_threshold', 60);
    return view('admin.rules.index', compact('quotas', 'meritThreshold'));
  }

  public function updateThreshold(Request $request)
  {
    $request->validate(['merit_threshold' => 'required|numeric|min:0|max:100']);
    cache()->put('merit_threshold', $request->merit_threshold);
    return redirect()->back()->with('success', 'Merit score threshold updated successfully.');
  }
}
