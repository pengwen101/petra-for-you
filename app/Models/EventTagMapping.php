<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventTagMapping extends Pivot
{
    protected $fillable = [
        'name',
        'notes',
    ];

    public function event():BelongsTo{
        return $this->belongsTo(Event::class);
    }
    public function tag():BelongsTo{
        return $this->belongsTo(Tag::class);
    }
}
