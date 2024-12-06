<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;



class Organizer extends Authenticatable
{

    use Notifiable;
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
