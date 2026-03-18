<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
  use HasFactory;

  protected $fillable = [
    'application_id',
    'enrolled_at',
    'fee',
  ];

  public function application()
  {
    return $this->belongsTo(Application::class);
  }

  public function payments()
  {
    return $this->hasMany(Payment::class);
  }
}
