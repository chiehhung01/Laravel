<?php

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CommentPosted extends Mailable
{
    use Queueable, SerializesModels;
    public $comment;

    /**
     * Create a new message instance.
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function build(){
        $subject = "Commented was posted on your {$this->comment->commentable->title} blog post";
        return $this
        //First example with full path
        // ->attach(storage_path('app/public'). '/' . $this->comment->user->image->path,
        // [
        //     'as' =>'profile_picture.jpeg',
        //     'mime' => 'jpg/jpeg'
        // ])
        // ->attachFromStorage($this->comment->user->image->path,'profile_picture.jpeg')
        // //預設即無'app/public'
        //->attachFromStorageDisk('public',$this->comment->user->image->path)
        ->attachData(Storage::get($this->comment->user->image->path),'profile_picture_from_data.jpeg',[
            'mime' => 'image/jpeg'
        ])
        ->subject($subject)
        ->view('emails.posts.commented');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = "Commented was posted on your {$this->comment->commentable->title} blog post";
        return new Envelope(           
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.posts.commented',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {     
        return [
        //    
        ];
    }
}
