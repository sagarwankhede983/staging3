<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailOnUserRegistration extends Mailable
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
        $name=$data_ar['name'];
        $email=$data_ar['email'];
        $password1=$data_ar['password'];
        $role=$data_ar['role'];
        $link='http://rsdashboard.king-ranch.com/login';
        //dd($datacode);
        return $this->from('rssupport@king-ranch.com')->subject('King-Ranch Resort Suite Dashboard')->view('dynamic_email_template_for_first_time_user_registration',compact('link','name','email','password1','role'));
    }
}
