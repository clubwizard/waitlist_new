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
            'status' => ['required', Rule::in(['pending', 'notified', 'seated', 'cancelled', 'no_show'])],
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
     * Notify a customer that their table is ready.
     */
    public function notify(WaitlistEntry $entry)
    {
        $this->authorize('update', $entry);
        
        $entry->status = 'notified';
        $entry->notified_at = now();
        $entry->save();
        
        return back()->with('success', 'Customer has been notified.');
    }
    
    /**
     * Show the form for editing a waitlist entry.
     */
    public function edit(WaitlistEntry $entry)
    {
        $this->authorize('update', $entry);
        
        $restaurant = $entry->restaurant;
        
        return view('waitlist.management.edit', compact('entry', 'restaurant'));
    }
    
    /**
     * Update the specified waitlist entry in storage.
     */
    public function update(Request $request, WaitlistEntry $entry)
    {
        $this->authorize('update', $entry);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'country_code' => 'required|string|max:10',
            'email' => 'nullable|email|max:255',
            'party_size' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:1000',
            'estimated_wait_time' => 'nullable|integer|min:1',
        ]);
        
        $entry->name = $validated['name'];
        $entry->phone_number = $validated['country_code'] . $validated['phone'];
        $entry->email = $validated['email'];
        $entry->party_size = $validated['party_size'];
        $entry->notes = $validated['notes'];
        $entry->estimated_wait_time = $validated['estimated_wait_time'];
        
        $entry->save();
        
        return redirect()->route('restaurants.waitlist.index', $entry->restaurant)
                         ->with('success', 'Waitlist entry updated successfully.');
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
