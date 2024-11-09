<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organizer extends Model
{

    protected $fillable = [
        'name',
        'description',
        'type',
        'instagram_link',
        'website_link',
        'phone_number',
        'line_id',
        'active',
    ];

    public function events():HasMany{
        return $this->hasMany(Event::class);
    }
}
