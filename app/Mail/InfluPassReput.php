<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class InfluPassReput extends Mailable
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
        $this->param=$param;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.influ_pass_reput')
                // ->from('XXX@XXXX','Reffect')
                ->subject('【'.Config::get('const.title.title45').'】パスワード再発行のお知らせ')
                ->with(['param' => $this->param]);
    }
}
