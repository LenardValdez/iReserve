<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogFailedLogin
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
     * @param  Failed  $event
     * @return void
     */
    public function handle(Failed $event)
    {
        $userId = (!empty($event->user)) ? $event->user->user_id : 'N/A';
        Log::notice('Failed login attempt detected! {"user_id": "'.$userId.'", "email_address": "'.$event->credentials['email'].'", "ip_address": "'.request()->ip().'"}');
    }
}
