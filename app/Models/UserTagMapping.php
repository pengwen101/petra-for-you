<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTagMapping extends Pivot
{

    protected $table = 'user_tag_mappings';

    protected $fillable = [
        'user_id',
        'tag_id',
        'score',
    ];

    public function user():BelongsTo{
        return $this->belongsTo(Event::class);
    }
    public function tag():BelongsTo{
        return $this->belongsTo(Tag::class);
    }
}
