<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $link;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link)
    {   
      $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->view('email.reset-password', [
        'link' => $this->link
      ])
      ->from("no-reply@gotoconsult.com", "GotoConsult")
      ->subject("Password Reset");
    }
}
