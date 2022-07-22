<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class InfluOuboMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($param)
    {
        //
        $this->param = $param;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.influ_oubo')
                // ->from('XXX@XXXX','Reffect')
                ->subject('【'.Config::get('const.title.title45').'】審査通過のお知らせ')
                ->with(['param' => $this->param]);
    }
}
