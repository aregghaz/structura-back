<?php

namespace App\Http\Controllers;

use App\Mail\SampleMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
    public function index(Request $request)
    {
        $content = [
            'subject' => 'This is the mail subject',
            'body' => 'This is the email body of how to send email from laravel 10 with mailtrap.'
        ];

        $status = Mail::to($request->email)->send(new SampleMail($content));

        return response()->json($status, 200);
    }
}
