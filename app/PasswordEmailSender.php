<?php
/**
 * Created by PhpStorm.
 * User: michaela
 * Date: 23.5.18
 * Time: 17:57
 */

namespace App;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordEmailSender extends Mailable
{
    use Queueable, SerializesModels;
    public $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('ourEmail@blabla.com') //TODO: add email of the sender
            ->view('pages.reset_mail');
    }

}