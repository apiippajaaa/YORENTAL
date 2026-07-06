<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message_content' => $validated['message'],
        ];

        Mail::send('emails.contact', $data, function ($mail) use ($data) {
            $mail->to('yordankusumaw@gmail.com', 'YORENTAL')
                ->subject('Pesan dari Form Kontak')
                ->replyTo($data['email'], $data['name']);
        });

        return back()->with('success', 'Pesan kamu berhasil dikirim!');
    }
}
