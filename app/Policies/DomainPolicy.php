<?php

namespace App\Policies;

use App\Models\Domain;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DomainPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Allow all authenticated users to view the list of domains
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Domain $domain): bool
    {
        // Allow users to view their own domains
        return $user->id === $domain->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Allow all authenticated users to create domains
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Domain $domain): bool
    {
        // Allow users to update their own domains
        return $user->id === $domain->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Domain $domain): bool
    {
        // Allow users to delete their own domains
        return $user->id === $domain->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Domain $domain): bool
    {
        // Allow users to restore their own domains (if using soft deletes)
        return $user->id === $domain->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Domain $domain): bool
    {
        // Allow users to force delete their own domains (if using soft deletes)
        return $user->id === $domain->user_id;
    }
}
