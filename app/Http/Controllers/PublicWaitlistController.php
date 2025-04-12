<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\WaitlistEntry;
use Illuminate\Http\Request;
use App\Http\Requests\StoreWaitlistEntryRequest; // Will create this later

class PublicWaitlistController extends Controller
{
    /**
     * Display the public waitlist form for a specific restaurant.
     */
    public function show(Restaurant $restaurant)
    {
        if (!$restaurant->active) {
            abort(404, 'Restaurant not found or inactive.');
        }

        return view('public.waitlist.show', compact('restaurant'));
    }

    /**
     * Store a new waitlist entry from the public form.
     */
    public function store(StoreWaitlistEntryRequest $request, Restaurant $restaurant)
    {
         if (!$restaurant->active) {
            abort(403, 'This restaurant is currently not accepting waitlist entries.');
        }

        $validatedData = $request->validated();

        \Log::info('Attempting to create waitlist entry', [
            'restaurant_id' => $restaurant->id,
            'name' => $validatedData['name'],
            'phone' => $request->input('country_code') . $validatedData['phone'],
            'email' => $validatedData['email'] ?? null,
            'party_size' => $validatedData['party_size']
        ]);

        try {
            $entry = WaitlistEntry::create([
                'restaurant_id' => $restaurant->id,
                'customer_id' => null, // Placeholder - needs customer logic
                'name' => $validatedData['name'],
                'phone_number' => $request->input('country_code') . $validatedData['phone'], // Include country code
                'email' => $validatedData['email'] ?? null,
                'party_size' => $validatedData['party_size'],
                'estimated_wait_time' => $restaurant->average_wait_time ?? 15, // Default or calculated
                'status' => 'pending', // Corrected default status to match migration ENUM
                'notes' => $validatedData['notes'] ?? null,
            ]);
            
            \Log::info('Waitlist entry created successfully', ['entry_id' => $entry->id]);
        } catch (\Exception $e) {
            \Log::error('Failed to create waitlist entry', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        return redirect()->back()
                         ->with('success', 'You have been added to the waitlist!');
    }
}
