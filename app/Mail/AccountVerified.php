<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountVerified extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $user;
    public $password;

    public function __construct($user, $password)
    {
        $this->user = $user;    
        $this->password = $password;
    }

    public function build()
    {
        return $this->from('support@magentickphotoframes.com', 'MagentickPhotoFrames')
                    ->subject('Account Verified')
                    ->view('emails.account_verified')
                    ->with([
                        'name' => $this->user->name,
                        'password' => $this->password,
                    ]);
    }
}
