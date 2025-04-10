<?php

namespace App\Policies;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RestaurantPolicy
{
    /**
     * Determine whether the user can view any models.
     * For now, any authenticated user can view their own list.
     */
    public function viewAny(User $user): bool
    {
        return true; // Assuming users can always see the index page (controller filters by user)
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Restaurant $restaurant): bool
    {
        return $user->id === $restaurant->user_id; // || $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can create models.
     * Any authenticated user can create a restaurant for now.
     */
    public function create(User $user): bool
    {
        return true; // Adjust based on subscription/plan limits later if needed
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Restaurant $restaurant): bool
    {
        return $user->id === $restaurant->user_id; // || $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Restaurant $restaurant): bool
    {
        return $user->id === $restaurant->user_id; // || $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can restore the model.
     * Not implementing soft deletes for now.
     */
    public function restore(User $user, Restaurant $restaurant): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     * Not implementing soft deletes for now.
     */
    public function forceDelete(User $user, Restaurant $restaurant): bool
    {
        return $user->id === $restaurant->user_id; // || $user->hasRole('super_admin');
    }
}
