<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'phone',
        'email',
        'website',
        'logo_path',
        'timezone',
        'active',
        'settings',
        'average_wait_time',
        'user_id',
    ];

    protected $casts = [
        'settings' => 'array',
        'active' => 'boolean',
    ];

    /**
     * Get the user that owns the restaurant.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the waitlist entries for the restaurant.
     */
    public function waitlistEntries()
    {
        return $this->hasMany(WaitlistEntry::class);
    }

    /**
     * Get the tags for the restaurant.
     */
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    /**
     * Get the API credentials for the restaurant.
     */
    public function apiCredentials()
    {
        return $this->hasMany(ApiCredential::class);
    }

    /**
     * Get the messages for the restaurant.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    
    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
