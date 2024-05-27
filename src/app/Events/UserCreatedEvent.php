<?php

namespace App\Events;

use App\Events\Event;
use App\Models\User;

/**
 * User Created Event.
 */
class UserCreatedEvent extends Event
{
    /**
     * The user instance.
     */
    public User $user;

    /**
     * Create a new event instance.
     *
     * @param  User  $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}