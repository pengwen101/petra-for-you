<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventEventCategoryMapping extends Pivot
{
    protected $fillable = [
        'name',
        'notes',
        'score'
    ];

    public function event():BelongsTo{
        return $this->belongsTo(Event::class);
    }
    public function eventCategory():BelongsTo{
        return $this->belongsTo(EventCategory::class);
    }
}
