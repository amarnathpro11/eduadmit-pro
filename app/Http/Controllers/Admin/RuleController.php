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
    $request->validate([
      'quota_id' => 'required|exists:quota_categories,id',
      'merit_threshold' => 'required|numeric|min:0|max:100'
    ]);

    $quota = QuotaCategory::findOrFail($request->quota_id);
    $quota->update(['merit_threshold' => $request->merit_threshold]);

    return redirect()->back()->with('success', "Merit score threshold for {$quota->name} updated successfully.");
  }

  public function storeQuota(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'code' => 'required|string|max:10|unique:quota_categories',
      'percentage' => 'required|numeric|min:0|max:100',
      'merit_threshold' => 'required|numeric|min:0|max:100',
      'is_active' => 'required|boolean'
    ]);

    QuotaCategory::create($request->all());

    return redirect()->back()->with('success', 'Quota category created successfully.');
  }

  public function updateQuota(Request $request, QuotaCategory $quota)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'code' => 'required|string|max:10|unique:quota_categories,code,' . $quota->id,
      'percentage' => 'required|numeric|min:0|max:100',
      'merit_threshold' => 'required|numeric|min:0|max:100',
      'is_active' => 'required|boolean'
    ]);

    $quota->update($request->all());

    return redirect()->back()->with('success', 'Quota category updated successfully.');
  }

  public function destroyQuota(QuotaCategory $quota)
  {
    $quota->delete();
    return redirect()->back()->with('success', 'Quota category deleted successfully.');
  }
}
