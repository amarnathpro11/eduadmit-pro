<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
  public function index()
  {
    $documents = StudentDocument::where('user_id', Auth::id())->get();
    return view('student.documents.index', compact('documents'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'document' => 'required|file|mimes:pdf,jpg,png|max:2048',
      'type' => 'required|string'
    ]);

    $path = $request->file('document')->store('student_documents');

    StudentDocument::create([
      'user_id' => Auth::id(),
      'file_path' => $path,
      'document_type' => $request->type,
      'status' => 'pending'
    ]);

    return back()->with('success', 'Document uploaded successfully.');
  }
}
