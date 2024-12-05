<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Pivot
{
    protected $table = 'bookings';

    protected $fillable = [
        'user_id',
        'event_id',
        'status',
        'review',
        'stars',
        'payment_url',
        'is_payment_validated'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function event(){
        return $this->belongsTo(Event::class);
    }
}
