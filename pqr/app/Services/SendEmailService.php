<?php
namespace App\Services;

use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;

class SendEmailService
{
    public function execute(array $data): void
    {
        Mail::to($data['email'])->send(new NotificationMail($data));
    }
}