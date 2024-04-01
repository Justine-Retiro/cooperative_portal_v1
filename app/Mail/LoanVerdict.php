<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoanVerdict extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    protected $loanApplication;
    protected $status;
    public function __construct($loanApplication, $status)
    {
        $this->loanApplication = $loanApplication;
        $this->status = $status;
    }


    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Loan Application Status',
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
                    ->to($this->loanApplication->user->email, $this->loanApplication->user->name)
                    ->bcc('cooperative.partners.2324@gmail.com')
                    ->subject('Loan Application Status')
                    ->markdown('emails.application_verdict', [
                        'name' => $this->loanApplication->user->name,
                        'email' => $this->loanApplication->user->email,
                        'applicationStatus' => $this->loanApplication->status,
                        'bookKeeperApproved' => $this->status === 'approvedByLevel3',
                        'generalManagerApproved' => $this->status === 'approvedByLevel1',
                        'rejectedByLevel3' => $this->status === 'rejectedByLevel3',
                        'rejectedByLevel1' => $this->status === 'rejectedByLevel1',
                
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
