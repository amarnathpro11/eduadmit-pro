<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //
    protected $fillable = [
        'type',
        'department',
        'start_date',
        'end_date',
        'generated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
