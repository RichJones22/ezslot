<?php declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Welcome constructor.
     */
    public function __construct()
    {
    }

    public function setFromEmailAddress(string $fromEmailAddress, string $fromEmailName)
    {
        $this->from($fromEmailAddress, $fromEmailName);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->markdown('email.welcome');
    }
}
