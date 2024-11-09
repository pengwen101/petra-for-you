<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'notes',
    ];

    public function events():BelongsToMany{
        return $this->belongsToMany(Event::class, 'event_tag_mappings', 'tag_id', 'event_id');
    }
    public function eventTagMappings():HasMany{
        return $this->hasMany(EventTagMapping::class);
    }
}
