<?php

namespace App\Listeners;

use App\Events\PostPusherEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class popupbox
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
     * @param  PostPusherEvent  $event
     * @return void
     */
    public function handle(PostPusherEvent $event)
    {
        //
    }
}
