<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function sendEmail(Request $request)
{
    // 1. Validamos los campos que llegan del formulario
    $request->validate([
        'name'         => 'required|string|max:255',
        'destinatario' => 'required|email',
        'subject'      => 'required|string|max:255',
        'mensaje'      => 'required|string',
    ]);

    // 2. Empaquetamos los datos con los nombres exactos que espera la vista
    $data = [
        'name'    => $request->name,          // Corresponde a {{ $name }}
        'email'   => $request->destinatario,  // Corresponde a {{ $email }}
        'subject' => $request->subject,       // Corresponde a {{ $subject }}
        'mensaje' => $request->mensaje,       // Corresponde a {{ $mensaje }}
    ];

    // 3. Enviamos el correo a la empresa
    Mail::send('mails.correo', $data, function($message) use ($data) {
        $message->to('devixsystems8@gmail.com') 
                ->subject('Consulta Web: ' . $data['subject'])
                ->from('devixsystems8@gmail.com', 'Devix Systems')
                ->replyTo($data['email'], $data['name']);
    });

    return back()->with('success', 'Correo enviado con éxito.');
}
}