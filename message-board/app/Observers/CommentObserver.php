<?php

namespace App\Observers;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Support\Facades\Cache;

class CommentObserver
{
        public function creating(Comment $comment): void
    {   // dd("I'm created");
        if($comment->commentable_type === BlogPost::class){
            Cache::tags(['blog-post'])->forget("blog-post-{$comment->commentable_id}");
            Cache::tags(['blog-post'])->forget("blog-post-Commented");
        }
    }
}
