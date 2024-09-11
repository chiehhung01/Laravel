<?php

namespace App\Jobs;

use App\Mail\CommentPostedOnPostWatched;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class NotifyUserPostWasCommented implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $comment;
    /**
     * Create a new job instance.
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {        //通知其他留評論除了自己
        User::thatHasCommentedOnPost($this->comment->commentable)
        ->get()
        ->filter(function(User $user){
            return $user->id !== $this->comment->user_id;
        })->map(function(User $user){
            ThrottledMail::dispatch( new CommentPostedOnPostWatched($this->comment,$user),
            $user);           
        });
    }
}
//map 函數是 Laravel 中集合（Collection）對象的一個方法，用來對集合中的每個元素進行操作
//，然後返回一個新的集合。在你提供的程式碼中，map 被用來對使用者陣列中的每個使用者進行操作。