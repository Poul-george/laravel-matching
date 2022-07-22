<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class IssuePermissionMail extends Mailable
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
        return $this->view('mails.issue_permission')
                // ->from('XXX@XXXX','Reffect')
                ->subject('案件掲載許可、審査通過のご連絡')
                ->with(['mail_param' => $this->mail_param]);
    }
}
