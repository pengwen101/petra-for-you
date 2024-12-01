<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bookmark extends Pivot
{
    protected $table = 'bookmarks';
    protected $fillable = [
        'user_id',
        'event_id',
        'notes',
    ];

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function event():BelongsTo{
        return $this->belongsTo(Event::class);
    }
}
