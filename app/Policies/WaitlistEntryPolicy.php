<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WaitlistEntry;
use Illuminate\Auth\Access\Response;

class WaitlistEntryPolicy
{
    /**
     * Determine whether the user can view the waitlist for a specific restaurant.
     * Note: Actual filtering happens in the controller, this is a general check.
     * For now, any authenticated user might manage *some* waitlist.
     * Refine later with roles/permissions if needed.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists; // Basic check: is the user logged in?
    }

    /**
     * Determine whether the user can view the specific waitlist entry.
     * User must be associated with the restaurant this entry belongs to.
     */
    public function view(User $user, WaitlistEntry $waitlistEntry): bool
    {
        return $user->id === $waitlistEntry->restaurant->user_id;
    }

    /**
     * Determine whether the user can create waitlist entries (for staff).
     * User must be associated with the restaurant they are adding to.
     * The controller should pass the restaurant context.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Determine whether the user can update the waitlist entry (e.g., status).
     * User must be associated with the restaurant this entry belongs to.
     */
    public function update(User $user, WaitlistEntry $waitlistEntry): bool
    {
        return $user->id === $waitlistEntry->restaurant->user_id;
    }

    /**
     * Determine whether the user can delete the waitlist entry.
     * User must be associated with the restaurant this entry belongs to.
     */
    public function delete(User $user, WaitlistEntry $waitlistEntry): bool
    {
        return $user->id === $waitlistEntry->restaurant->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     * Not used currently.
     */
    public function restore(User $user, WaitlistEntry $waitlistEntry): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     * Not used with soft deletes.
     */
    public function forceDelete(User $user, WaitlistEntry $waitlistEntry): bool
    {
        return $user->id === $waitlistEntry->restaurant->user_id;
    }
}
