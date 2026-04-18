<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadCommunication extends Model
{
    const CREATED_AT = 'communicated_at';
    const UPDATED_AT = null;

    protected $fillable = ['lead_id', 'created_by', 'type', 'message'];

    protected $casts = [
        'communicated_at' => 'datetime'
    ];


    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
