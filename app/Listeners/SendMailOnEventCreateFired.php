<?php

namespace App\Listeners;

use App\Events\SendMailOnEventCreate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use Mail;

class SendMailOnEventCreateFired implements ShouldQueue
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
     * @param  \App\Events\SendMailOnEventCreate  $event
     * @return void
     */
    public function handle(SendMailOnEventCreate $event)
    {
        $email = $event->email;
        
        Mail::send('emails.event-created', ['email' => $email], function($message) use ($email) {
            $message->to($email);
            $message->subject('Event Testing');
        });
    }
}
