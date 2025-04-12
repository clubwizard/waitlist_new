<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\WaitlistEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreWaitlistEntryRequest;

class WaitlistManagementController extends Controller
{
    /**
     * Display the waitlist management interface for a specific restaurant.
     */
    public function index(Restaurant $restaurant)
    {
        $this->authorize('viewAny', [WaitlistEntry::class, $restaurant]);


        $waitlistEntries = $restaurant->waitlistEntries()
                                      ->whereIn('status', ['pending', 'notified']) // Show active entries
                                      ->orderBy('created_at', 'asc') // Oldest first
                                      ->paginate(20); // Paginate for large lists

        return view('waitlist.management.index', compact('restaurant', 'waitlistEntries'));
    }

    /**
     * Show the form for creating a new waitlist entry by staff.
     */
    public function create(Restaurant $restaurant)
    {
        $this->authorize('create', [WaitlistEntry::class, $restaurant]);

        return view('waitlist.management.create', compact('restaurant'));
    }

    /**
     * Store a newly created waitlist entry in storage by staff.
     */
    public function store(StoreWaitlistEntryRequest $request, Restaurant $restaurant)
    {
        $this->authorize('create', [WaitlistEntry::class, $restaurant]);

        $validatedData = $request->validated();

        WaitlistEntry::create([
            'restaurant_id' => $restaurant->id,
            'customer_id' => null, // Placeholder - needs customer logic
            'name' => $validatedData['name'],
            'phone_number' => $request->input('country_code') . $validatedData['phone'], // Include country code
            'email' => $validatedData['email'] ?? null,
            'party_size' => $validatedData['party_size'],
            'estimated_wait_time' => $restaurant->average_wait_time ?? 15, // Default or calculated
            'status' => 'pending',
            'notes' => $validatedData['notes'] ?? null,
            'user_id' => Auth::id(), // Record which staff member added the entry
        ]);

        return redirect()->route('restaurants.waitlist.index', $restaurant)
                         ->with('success', 'Waitlist entry added successfully.');
    }

    /**
     * Update the status of a waitlist entry.
     */
    public function updateStatus(Request $request, WaitlistEntry $entry)
    {

        $this->authorize('update', $entry); // Check if user can update this specific entry

        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'seated', 'cancelled', 'no_show'])],
        ]);

        $entry->status = $validated['status'];

        if ($validated['status'] === 'seated') {
            $entry->seated_at = now();
        } else {
            $entry->seated_at = null; // Reset if changed from seated
        }

        $entry->save();

        return back()->with('success', 'Waitlist entry status updated.');
    }

    /**
     * Remove the specified waitlist entry from storage.
     */
    public function destroy(WaitlistEntry $entry)
    {

        $this->authorize('delete', $entry); // Check if user can delete this specific entry

        $entry->delete();

        return back()->with('success', 'Waitlist entry removed.');
    }
}
