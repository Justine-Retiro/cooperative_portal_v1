<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMailAdmin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $password;

    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Reset Password Mail Admin',
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
            view: 'emails.reset-password',
        );
    }
    public function build()
    {
        // $hexCode = bin2hex($this->user->code); // Corrected from codecode to code
        return $this->from('cooperative.partners.2324@gmail.com', 'Credit Cooperative')
                    ->to($this->user->email, $this->user->name)
                    ->bcc('cooperative.partners.2324@gmail.com')
                    ->subject('Reset Password')
                    ->markdown('emails.reset-password', [
                        'name' => $this->user->name,
                        'email' => $this->user->email,
                        'account_number' => $this->user->account_number,
                        'password' => $this->password,
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
