<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class InfluKariMail extends Mailable
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
        return $this->view('mails.influ_kari')
                // ->from('XXX@XXXX','Reffect')
                ->subject('【'.Config::get('const.title.title45').'】仮登録を受け付けました。')
                ->with(['mail_param' => $this->mail_param]);
    }
}
