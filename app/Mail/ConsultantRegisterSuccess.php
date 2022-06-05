<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConsultantRegisterSuccess extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct() { }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->view('email.consultant-register-success')
      ->from("no-reply@gotoconsult.com", "GotoConsult")
      ->subject('Thank you! Your application is being reviewed.');
    }
}
