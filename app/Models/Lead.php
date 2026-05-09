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

  public function calculateScore()
  {
    $score = 10; // Base score
    
    if ($this->phone) $score += 30;
    if ($this->email) $score += 20;
    if ($this->source == 'Website') $score += 20;
    if ($this->source == 'Campaign') $score += 30;
    
    if ($this->status == 'Interested') $score += 20;
    if ($this->status == 'Converted') $score = 100;
    
    return min(100, $score);
  }
}
