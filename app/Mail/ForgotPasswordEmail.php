<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Change Password',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.verify_email_password',
        );
    }

    public function build()
    {
        // $hexCode = bin2hex($this->user->code); // Corrected from codecode to code
        return $this->from('cooperative.partners.2324@gmail.com', 'Credit Cooperative')
                    ->to($this->user->email, $this->user->name)
                    ->bcc('cooperative.partners.2324@gmail.com')
                    ->subject('Change Password')
                    ->markdown('emails.verify_email_password', [
                        'name' => $this->user->name,
                        'email' => $this->user->email,
                        'verificationCode' => $this->user->code,
                        'verificationUrl' => route('forgot.email.verify.url', ['code' => $this->user->code]),
                    ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
