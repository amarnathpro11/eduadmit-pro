<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseQuota extends Model
{
  protected $fillable = [
    'course_id',
    'quota_category_id',
    'reserved_seats'
  ];

  public function course()
  {
    return $this->belongsTo(Course::class);
  }

  public function category()
  {
    return $this->belongsTo(QuotaCategory::class, 'quota_category_id');
  }
}
