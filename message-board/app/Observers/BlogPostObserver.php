<?php

namespace App\Observers;

use App\Models\BlogPost;
use Illuminate\Support\Facades\Cache;

class BlogPostObserver
{
    public function updating(BlogPost $blogPost): void
    {
        
        Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
    }  
    
    public function deleting(BlogPost $blogPost): void
    {
        // dd("I'm delete");
        $blogPost->comments()->delete();
            Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
    }
    
    public function restoring(BlogPost $blogPost): void
    {
        $blogPost->comments()->restore();
    }   //再還原post時comment也會回來
}
