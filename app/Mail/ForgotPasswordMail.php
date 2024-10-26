<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    protected string $url;
    /**
     * Create a new message instance.
     */
    public function __construct(protected User $user)
    {
        $this->url = env('APP_URL');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Forgot Password Mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        $view = 'emails.forgot-password';

        return $this->view($view,
            [
                'url' => $this->url,
                'user' => $this->user,
                'jwt' => $this->user->generateJWT('passwordreset', time() + 3600)
            ]);
    }
}
