<?php

namespace App\Http\Controllers;

use App\Mail\Mailer;
use App\Models\OrderDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

    public function downloadView(Request $request)
    {
        $order = OrderDetail::with([
            'orderItems.product.ratings',
            'orderItems.product.images.file',
            'orderItems.inventory.discount',
            'address.delivery',
            'discount',
        ])->find($request->input('orderid'));

        $pdf = Pdf::loadView('invoice', ['orderDetail' => $order])->setPaper('a4', 'landscape');
        return $pdf->download('demo.pdf');
    }
}
