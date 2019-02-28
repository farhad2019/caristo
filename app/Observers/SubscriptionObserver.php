<?php

namespace App\Observers;

use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

/**
 * Class SubscriptionObserver
 * @package App\Observers
 */
class SubscriptionObserver
{
    /**
     * @param Subscriber $subscriber
     */
    public function Created(Subscriber $subscriber)
    {
        $email = $subscriber->email;
        $subject = getenv('APP_NAME').' Subscription.';

        Mail::send('email.subscription', [],
            function ($mail) use ($email, $subject) {
                $mail->from(getenv('MAIL_FROM_ADDRESS'), "CaristoCrat App");
                $mail->to($email);
                $mail->subject($subject);
            });
    }
}