<?php

namespace App\Listeners;

use App\Events\ProductCreated;
use App\Events\ProductUpdated;
use App\Events\ProductEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Mail\UserMail;

class NotifyUser
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductEvent $event): void
    {
        \Mail::to('user@gmail.com')->send(new UserMail($event->product));
    }
    // public function handle(ProductCreated|ProductUpdated $event): void
    // {
    //     \Mail::to('user@gmail.com')->send(new UserMail($event->product));
    // }
}
