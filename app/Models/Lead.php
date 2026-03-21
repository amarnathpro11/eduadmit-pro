<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
  use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'source',
        'course_interested',
        'assigned_to',
        'status',
        'lead_score',
        'notes'
    ];

  public function course()
  {
    return $this->belongsTo(Course::class, 'course_interested');
  }

  public function assignedTo()
  {
    return $this->belongsTo(User::class, 'assigned_to');
  }

  public function applications()
  {
    return $this->hasMany(Application::class);
  }
}
