<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Support\Facades\Notification;

class SendOrderCreatedNotification
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
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;
        $user = User::find(3);
        $user->notify(new OrderCreatedNotification($order));

        // if you want sent to all user you can work this
        //first way :
        // foreach ($event->order->user() as $user) {
        //     $user->notify(new OrderCreatedNotification($event->order));
        // }

        //second way :
        // Notification::send($event->order->user(), new OrderCreatedNotification($event->order));

        // broadcast(new OrderCreatedNotification($event->order), ['App.Models.User.${userID}']);

    }
}
