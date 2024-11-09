<?php

namespace App\Models;

use App\Models\Booking;
use App\Models\Organizer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    protected $fillable = [
        'title',
        'venue',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'description',
        'price',
        'organizer_id',
        'is_shown',
    ];

    public function bookings():HasMany{
        return $this->hasMany(Booking::class);
    }

    public function bookmarks():HasMany{
        return $this->hasMany(Bookmark::class);
    }

    public function organizer():BelongsTo{
        return $this->belongsTo(Organizer::class);
    }

    public function eventCategories():BelongsToMany{
        return $this->belongsToMany(EventCategory::class, 'event_event_category_mappings', 'event_id', 'event_category_id');
    }

    public function eventEventCategoryMappings():HasMany{
        return $this->hasMany(EventEventCategoryMapping::class);
    }

    public function tags():BelongsToMany{
        return $this->belongsToMany(Tag::class, 'event_tag_mappings', 'event_id', 'tag_id')->withPivot('notes');
    }

    public function eventTagMappings():HasMany{
        return $this->hasMany(Tag::class);
    }
}
