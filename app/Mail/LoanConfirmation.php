<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoanConfirmation extends Mailable
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
            subject: 'Loan Application Received',
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
            view: 'emails.verifynew',
        );
    }

    public function build()
    {
        // $hexCode = bin2hex($this->user->code); // Corrected from codecode to code
        return $this->from('cooperative.partners.2324@gmail.com', 'Credit Cooperative')
                    ->to($this->user->email, $this->user->name)
                    ->bcc('cooperative.partners.2324@gmail.com')
                    ->subject('Loan Application Received')
                    ->markdown('emails.application_confirmation', [
                        'name' => $this->user->name,
                        'email' => $this->user->email,
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
