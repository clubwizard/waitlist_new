<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiCredential extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'service',
        'credentials',
        'active',
    ];

    protected $casts = [
        'credentials' => 'array',
        'active' => 'boolean',
    ];

    /**
     * Get the restaurant that owns the API credential.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
