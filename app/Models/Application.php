<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StudentDocument;
use App\Models\Payment;

class Application extends Model
{
  use HasFactory;

  protected $fillable = [
    'first_name',
    'last_name',
    'dob',
    'mobile',
    'course_id',
    'status',
    'applied_date',
    'user_id',
    'application_no',
    'tenth_percentage',
    'twelfth_percentage'
  ];

  public function lead()
  {
    return $this->belongsTo(Lead::class);
  }

  public function course()
  {
    return $this->belongsTo(Course::class);
  }

  public function enrollment()
  {
    return $this->hasOne(Enrollment::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function documents()
  {
    return $this->hasMany(StudentDocument::class);
  }

  public function payments()
  {
    return $this->hasMany(Payment::class, 'user_id', 'user_id');
  }
}
