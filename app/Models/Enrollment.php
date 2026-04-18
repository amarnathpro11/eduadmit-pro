<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
  use HasFactory;

  protected $fillable = [
    'student_id',
    'user_id',
    'course_id',
    'enrolled_at',
  ];

  public function application()
  {
    return $this->belongsTo(Application::class, 'user_id', 'user_id');
  }

  public function payments()
  {
    return $this->hasMany(Payment::class);
  }
}
