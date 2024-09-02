<?php

namespace App\Listeners;

use App\Events\UserSignedUp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Notifications\VerificationCodeCreated;
class SendUserSignedUpNotification
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
    public function handle(UserSignedUp $event): void
    {
        $this->sendVerificationCode($event->user);
    }

    private function sendVerificationCode($user){
        $verificationCode = $user->code;
        
        //$user->notify(new VerificationCodeCreated($verificationCode));
    }
}
