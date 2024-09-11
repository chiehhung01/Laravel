<?php

namespace App\Providers;

use App\Http\ViewComposer\ActivityComposer;
use App\Models\BlogPost;
use App\Models\Comment;
use App\Observers\BlogPostObserver;
use App\Observers\CommentObserver;
use App\Services\Counter;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {      
        Blade::aliasComponent('components.badge', 'badge'); 
        Blade::aliasComponent('components.updated','updated');
        Blade::aliasComponent('components.card','card');   
        Blade::aliasComponent('components.tags','tags');  
        Blade::aliasComponent('components.errors','errors');  
        Blade::aliasComponent('components.comment-form','commentForm');  
        Blade::aliasComponent('components.comment-list','commentList');  
        view()->composer(['posts.index','posts.show'], ActivityComposer::class);
        //當 Laravel 渲染 posts.index 視圖時，將使用 ActivityComposer 這個合成器進行合成
        BlogPost::observe(BlogPostObserver::class);
        Comment::observe(CommentObserver::class);
        Schema::defaultStringLength(191);   
        
        $this->app->singleton(Counter::class,function($app){
            return new Counter(
                $app->make('Illuminate\Contracts\Cache\Factory'),
                $app->make('Illuminate\Contracts\Session\Session'),
                //這兩行程式碼用於取得應用程式中的緩存和會話服務的實例，
                //這些服務實現了相應的 Laravel 契約（Contracts），提供了統一的接口以方便在應用程式中使用緩存和會話功能。
                env('COUNTER_TIMEOUT')
            );
            //傳遞給Counter $timeout
        });

        // $this->app->when(Counter::class)
        // ->needs('$timeout')
        // ->give(env('COUNTER_TIMEOUT'));
// 選擇 bind 或 singleton 的考慮：
// 如果你希望每次解析時都獲得一個新的實例，使用 bind。
// 如果你希望在整個應用程式生命週期中只有一個實例，使用 singleton。
// 使用 bind 可以更靈活，因為它創建的實例是新的，不受先前解析實例的影響。使用 singleton 可以節省資源，因為它只創建一個實例，但要小心它可能導致全局狀態和依賴性。
        
        $this->app->bind(
            'App\Contracts\CounterContract',
             Counter::class,
             //DummyCounter::class
        );

       // CommentResource::withoutWrapping();
        JsonResource::withoutWrapping();

}
}
