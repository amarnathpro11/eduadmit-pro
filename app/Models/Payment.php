<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'application_id',
    'transaction_id',
    'amount',
    'payment_type',
    'status',
    'payment_mode',
    'payment_date',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function application()
  {
    return $this->belongsTo(Application::class);
  }
}
