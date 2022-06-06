<?php

namespace App\Http\Controllers;

use App\Mail\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail()
    {
        $subject = "Testing email";
        $body = "<h1>Testing mail</h1><p>This mail is sent for testing purpose</p>";
        Mail::to("acharyaumesh742@gmail.com")->send(new Mailer($subject, $body));

        return "Mail sent successfully";
    }
}
