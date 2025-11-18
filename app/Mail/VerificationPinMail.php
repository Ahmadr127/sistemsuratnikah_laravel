<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationPinMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $pin;
    public string $purpose;

    public function __construct(string $pin, string $purpose)
    {
        $this->pin = $pin;
        $this->purpose = $purpose; // 'register' or 'password_reset'
    }

    public function build(): self
    {
        $subject = $this->purpose === 'register'
            ? 'Kode Verifikasi Pendaftaran'
            : 'Kode Verifikasi Reset Password';

        return $this->subject($subject)
            ->view('emails.verification-pin')
            ->with([
                'pin' => $this->pin,
                'purpose' => $this->purpose,
            ]);
    }
}
