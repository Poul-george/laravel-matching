<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class UserDecisionMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail_param)
    {
        //
        $this->mail_param=$mail_param;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.user_decision')
                // ->from('XXX@XXXX','Reffect')
                ->subject('案件の人材確定が完了いたしました。')
                ->with(['mail_param' => $this->mail_param]);
    }
}
