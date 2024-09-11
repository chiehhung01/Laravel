<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\BlogPost::class => \App\Policies\BlogPostPolicy::class,
        \App\Models\User::class => \App\Policies\UserPolicy::class,
        \App\Models\Comment::class => \App\Policies\CommentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('home.secret',function ($user) {      
            return $user->is_admin;
         });
        // Gate::define("update-post", function ($user,$post) {
        //     return $user->id == $post->user_id;    
        // });
        // Gate::define("delete-post", function ($user,$post) {
        //     return $user->id == $post->user_id;    
        // });

        // Gate::define('posts.update', 'App\Policies\BlogPostPolicy@update');
        // Gate::define('posts.delete', 'App\Policies\BlogPostPolicy@delete');

        // Gate::resource('posts','App\Policies\BlogPostPolicy');
        //posts.create, posts.view posts.update, posts.delete


        Gate::before(function ($user,$ability) {
        if($user->is_admin && in_array($ability, ['update','delete'])) {
            return true;
            }
        });
        //全局 Before 鉤子：這個 Before 鉤子是在所有其他授權檢查之前執行的。
        //它檢查用戶是否具有 "is_admin" 權限，如果是，就直接通過所有其他授權檢查。

        // Gate::after(function ($user,$result) {
        //     if($user->is_admin) {
        //         return true;
        //         }
        //  });
    }
}
