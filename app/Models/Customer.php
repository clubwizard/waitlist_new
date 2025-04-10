<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'notes',
        'marketing_opt_in',
        'preferences',
    ];

    protected $casts = [
        'preferences' => 'array',
        'marketing_opt_in' => 'boolean',
    ];

    /**
     * Get the waitlist entries for the customer.
     */
    public function waitlistEntries()
    {
        return $this->hasMany(WaitlistEntry::class);
    }

    /**
     * The tags that belong to the customer.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'customer_tag');
    }

    /**
     * Get the messages for the customer.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
