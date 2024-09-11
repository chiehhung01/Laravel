<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use App\Jobs\NotifyUserPostWasCommented;
use App\Jobs\ThrottledMail;
use App\Mail\CommentPostedMarkdown;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyUsersAboutComment
{
   
    /**
     * Handle the event.
     */
    public function handle(CommentPosted $event): void
    {   
        // dd('i was called in response to an event');
        //PostCommentController cut paste
        ThrottledMail::dispatch(new CommentPostedMarkdown($event->comment),$event->comment->user)
        ->onQueue('high');
        NotifyUserPostWasCommented::dispatch($event->comment)
        ->onQueue('low');
    }
}
