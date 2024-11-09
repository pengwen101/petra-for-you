<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EventEventCategoryMapping;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EventCategory extends Model
{
    protected $fillable = [
        'name',
        'notes',
    ];


    public function events():BelongsToMany{
        return $this->belongsToMany(Event::class, 'event_event_category_mappings', 'event_category_id', 'event_id');
    }
    public function eventEventCategoryMappings():HasMany{
        return $this->hasMany(EventEventCategoryMapping::class);
    }

}
