<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDocument extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'application_id',
    'document_type',
    'file_path',
    'status'
  ];

  public function application()
  {
    return $this->belongsTo(Application::class);
  }
}
