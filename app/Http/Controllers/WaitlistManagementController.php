<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\WaitlistEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class WaitlistManagementController extends Controller
{
    /**
     * Display the waitlist management interface for a specific restaurant.
     */
    public function index(Restaurant $restaurant)
    {
        $this->authorize('viewAny', [WaitlistEntry::class, $restaurant]); // Check if user can view any entries for this restaurant


        $waitlistEntries = $restaurant->waitlistEntries()
                                      ->whereIn('status', ['pending', 'notified']) // Show active entries
                                      ->orderBy('created_at', 'asc') // Oldest first
                                      ->paginate(20); // Paginate for large lists

        return view('waitlist.management.index', compact('restaurant', 'waitlistEntries'));
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
