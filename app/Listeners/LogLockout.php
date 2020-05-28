<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogLockout
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
     * @param  Lockout  $event
     * @return void
     */
    public function handle(Lockout $event)
    {
        $userId = (!empty($event->user)) ? $event->user->user_id : 'N/A';
        Log::notice('Auth lockout detected! {"user_id": "'.$userId.'", "email_address": "'.$event->credentials['email'].'", "ip_address": "'.request()->ip().'"}');
    }
}
