<?php
 namespace App\Http\ViewComposer;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

 class ActivityComposer{
    public function compose(View $view){
        // 在這裡添加你的合成邏輯
        $mostCommented = Cache::tags(['blog-post'])->remember('blog-post-Commented',60, function () {
            return BlogPost::mostCommented()->take(5)->get();
        });

        $mostActive = Cache::remember('users-most-active',60, function () {
            return User::withMostBlogPosts()->take(5)->get();
        });

        $mostActiveLast = Cache::remember('users-most-active-last-month',60, function () {
            return User::withMostBlogPostsLastMonth()->take(5)->get();
        });
    // 使用 with 方法將數據傳遞給視圖
        $view->with('mostCommented', $mostCommented);
        $view->with('mostActive', $mostActive);
        $view->with('mostActiveLast', $mostActiveLast);      

    }
 }