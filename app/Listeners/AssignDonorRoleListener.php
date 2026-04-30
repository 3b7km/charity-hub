<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Spatie\Permission\Models\Role;

class AssignDonorRoleListener
{
    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $user = $event->user;
        
        // Automatically assign 'donor' role upon registration
        if (!$user->hasAnyRole(['admin', 'charity_manager', 'donor', 'volunteer'])) {
            $user->assignRole('donor');
        }
    }
}
