<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data=$data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
        $data_ar = json_decode(json_encode($this->data),true);
        $datacode=$data_ar['code'];
        //dd($datacode);
        return $this->from('rssupport@king-ranch.com')->subject('King-Ranch(Resort-Suite)-OTP')->view('dynamic_email_Template',compact('datacode'));
    }
}
