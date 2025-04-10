<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'restaurant_id',
    ];

    /**
     * Get the restaurant that owns the tag.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * The customers that belong to the tag.
     */
    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_tag');
    }
}
