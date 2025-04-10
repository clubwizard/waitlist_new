<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaitlistEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'customer_id',
        'name',
        'email',
        'phone_number',
        'party_size',
        'status',
        'position',
        'estimated_wait_time',
        'quoted_wait_time',
        'notes',
        'table_number',
        'metadata',
        'notified_at',
        'seated_at',
        'user_id', // Staff user who added/seated
    ];

    protected $casts = [
        'metadata' => 'array',
        'notified_at' => 'datetime',
        'seated_at' => 'datetime',
    ];

    /**
     * Get the restaurant that owns the waitlist entry.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Get the customer associated with the waitlist entry.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the user (staff) associated with the waitlist entry.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the messages for the waitlist entry.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
