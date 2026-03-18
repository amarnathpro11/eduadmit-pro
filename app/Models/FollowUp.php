<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    use HasFactory;
    protected $fillable = [
        'lead_id',
        'user_id',
        'scheduled_at',
        'priority',
        'status',
        'system_notification',
        'email_notification',
        'note'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'system_notification' => 'boolean',
        'email_notification' => 'boolean',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
