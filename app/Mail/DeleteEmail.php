<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DeleteEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data=[];
    /**
     * Create a new message instance.
     */
    public function __construct( $data )
    {
         $this->data = $data;
      //  $this->switchMailSettings();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
    
        return new Envelope(
            subject: 'طلب حذف حساب' ,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if($this->data['dest']=='admin'){
         return new Content(
            view: 'admin.mail.admin-del-template',
            with:['data'=>$this->data]
        );
        }else{
            return new Content(
                view: 'admin.mail.client-del-template',
                with:['data'=>$this->data]
            );
        }
       
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

}
