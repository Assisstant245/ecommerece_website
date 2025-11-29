<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactResponse extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectLine;
    public $userMessage;
    public $adminResponse;



    public function __construct($subjectLine,$userMessage, $adminResponse, )
    {
        $this->subjectLine = $subjectLine;

        $this->userMessage   = $userMessage;
        $this->adminResponse = $adminResponse;
    }

    public function build()
    {
   
    return $this->view('admin.contact.userEmailSend')
        ->subject('your response have been listen')
        ->with([
                'userMessage'   => $this->userMessage,
                'adminResponse' => $this->adminResponse
            ]);
}
}
