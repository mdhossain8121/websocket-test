<?php

namespace App\Listeners;

use App\Events\NoticeEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NoticeListener
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
     * @param  \App\Events\NoticeEvent  $event
     * @return void
     */
    public function handle(NoticeEvent $event)
    {
        // broadcast($event->total)->toOthers();
    }
}
