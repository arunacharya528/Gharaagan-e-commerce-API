<?php

namespace App\Http\Controllers;

use App\Mail\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;

class MailController extends Controller
{
    public function sendMail()
    {
        try {
            $subject = "Testing email";
            $body = "<h1>Testing mail</h1><p>This mail is sent for testing purpose</p>";

            $pdf = PDF::loadView('mail', ['body' => $body])
                ->setPaper('a4', 'landscape')
                ->setWarnings(false);

            $mailable = new Mailer($subject, $body);
            $mailable->setAttachment($pdf->output(), 'demo.pdf', [
                'mime' => 'application/pdf',
            ]);

            Mail::to("acharyaumesh742@gmail.com")->send($mailable);
            return "Mail sent successfully";
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            return response()->json($th->getMessage(), 500);
        }
    }

    public function downloadView()
    {

        $data = ['body' => 'This is a body of this pdf'];
        $pdf = PDF::loadView('mail', $data);
        return $pdf->download('demo.pdf');
    }
}
