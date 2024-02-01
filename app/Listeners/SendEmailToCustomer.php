<?php

namespace App\Listeners;

use App\Events\order_create;
use App\Mail\mymail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailToCustomer
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
    public function handle(order_create $event)
    {
        $id = $event->orders->user_id;
        $email = User::find($id)->first('email');
        Mail::to($email)->send(new mymail($event->orders));
    }
}
