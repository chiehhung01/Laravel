<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\UserCommentController;
use App\Http\Controllers\UserController;
use App\Mail\CommentPostedMarkdown;
use App\Models\Comment;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('home.index',[]);
// })->name('home.index');


// Route::get('/contact', function () {
//     return view('home.contact');
// })->name('home.contact');

Route::get('/', [HomeController::class, 'home'])->name('home.index')
// ->middleware('auth')
;
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/secrect', [HomeController::class,'secret'])
->name('secret')
->middleware('can:home.secret');

Route::get('/single', AboutController::class);

Route::get('/recent-posts/{days_ago?}' , function($daysAgo=20){
    return 'Posts from' . $daysAgo . 'days ago' ;
   })->name('post.recent.index')->middleware('auth');
   
Route::resource('posts',PostsController::class);
Route::resource('posts.comments',PostCommentController::class)->only('index','store');
Route::resource('users.comments',UserCommentController::class)->only('store');
Route::resource('users',UserController::class)->only('show', 'edit','update');
Route::get('posts/tag/{tag}',[PostTagController::class,'index'])->name('posts.tags.index');
Route::get('mailable',function(){
    $comment = Comment::class::find(1);
    return new CommentPostedMarkdown($comment);
});

Auth::routes();
// Route::get('/posts/{id}', function ($id) use($posts) {
    

//         abort_if(!isset($posts[$id]), 404);

//         return view('posts.show',['post' => $posts[$id]]);
// })->name('posts.show');

// Route:: get('/posts',function() use($posts){
//     // request()->all();
//     // dd(request()->all());
//     // dd((int)request()->input('page', 1));
//     dd((int)request()->query('page', 1));
//     return view('posts.index',['posts'=>$posts]);
// });

$posts=[
    1 => [
        'title' => 'Tntro to Laravel',
        'content' => 'This is a short intro to Lavarel',
        'is_new' => true,
        'has_comments' => true
    ] ,
    2 => [
        'title' => 'Intro to PHP',
        'content' => 'This is a short intro to PHP',
        'is_new' => false
    ],
    3 => [
        'title' => 'Intro to Golang',
        'content' => 'This is a short intro to Golang',
        'is_new' => false
    ]
    ];

Route::prefix('/fun')->name('fun.')->group(function()use($posts){

    Route::get('responses',function() use($posts){
        return response($posts,201)->header('Content_Type','application/json')->cookie('MY_COOKIE','Piotr Jura',3600);
    })->name('responses');
    
    Route::get('redirect',function() {
        return redirect('/contact');
    })->name('redirect');
    
    Route::get('back',function() {
        return back();
    })->name('back');
    
    Route::get('named-route',function() {
        return redirect()->route('posts.show', ['id'=> 1]);
    })->name('named-route');
    
    Route::get('away',function() {
        return redirect()->away('https://google.com');
    })->name('away');
    
    Route::get('json',function() use( $posts ) {
        return response()->json($posts);
    })->name('json');
    
    Route::get('download',function() use( $posts ) {
        return response()->download(public_path('/daniel.jpg'),'face.jpg');
    })->name('download');

});


