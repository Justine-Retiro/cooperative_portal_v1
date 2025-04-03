<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
class AccountDetailsMail extends Mailable
{
    use Queueable, SerializesModels;

    
    public $user;
    public $password;

    

    /**
     * Create a new message instance.
     *
     * @return void
     */
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
            subject: 'Membership Status',
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
            'emails.membership_acceptance'
        );
    }

    public function build()
    {
        return $this->from('cooperative.partners.2324@gmail.com', 'Credit Cooperative')
                     -> view('emails.membership_acceptance')
                    ->with([
                        'name' => $this->user->name,
                        'email' => $this->user->email,
                        'account_number' => $this->user->account_number,
                        'defaultPassword' => $this->password, 
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
