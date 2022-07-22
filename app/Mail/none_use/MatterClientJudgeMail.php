<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class MatterClientJudgeMail extends Mailable
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
        return $this->view('mails.matter_client_judge')
                // ->from('XXX@XXXX','Reffect')
                ->subject("【".Config::get('const.title.title45')."】".$this->mail_param['matter_name']."：".Config::get('const.title.title2')."採用のご連絡。")
                ->with(['mail_param' => $this->mail_param]);
    }
}
