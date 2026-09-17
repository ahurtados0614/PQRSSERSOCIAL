<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendEmailRequest;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    public function send(SendEmailRequest $request)
    {
        $data = $request->validated();

        // Facade en acción
        Mail::to($data['email'])->queue(new NotificationMail($data));

        return response()->json([
            'status'  => 'success',
            'message' => 'Notificación encolada correctamente.'
        ], 200);
    }
}