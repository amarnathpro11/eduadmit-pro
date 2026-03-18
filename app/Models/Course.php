<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CourseQuota;

class Course extends Model
{
    protected $fillable = [
        'name',
        'code',
        'duration_years',
        'total_seats',
        'application_fee',
        'admission_fee',
        'is_active',
        'department_id',
        'description',
        'level'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function quotas()
    {
        return $this->hasMany(CourseQuota::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
