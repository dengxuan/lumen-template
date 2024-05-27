<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;


class UserEventsListener implements ShouldQueue
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // Logic to handle the user event
    }
}