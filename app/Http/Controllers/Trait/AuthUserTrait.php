<?php

namespace App\Http\Controllers\Trait;

use App\Mail\Mailer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

trait AuthUserTrait
{

    public function sendEmailForVerification($user, $pin)
    {
        $subject = "Email verification";
        $body = <<<EOD
        Dear $user->name,<br>
        <p><u>$pin</u> is the pin code to verify your email</p>
        With regards.
        EOD;
        $mailable = new Mailer($subject, $body);
        Mail::to($user->email)->send($mailable);
    }
}
