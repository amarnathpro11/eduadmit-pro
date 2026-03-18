<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotaCategory extends Model
{
    protected $fillable = [
        'name',
        'code',
        'percentage',
        'is_active'
    ];

    public function courseQuotas()
    {
        return $this->hasMany(CourseQuota::class);
    }
}
