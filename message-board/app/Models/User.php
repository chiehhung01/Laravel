<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

   public const LOCALES =[
    'en' =>'English',
    'es' =>'Espanol',
    'de' =>'Deutsch'
   ];
    
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password','remember_token','email','email_verified_at','created_at','updated_at','is_admin','locale'

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function image(){
        return $this->morphOne(Image::class,'imageable');
    }
    
    public function BlogPosts(){
        return $this->hasMany(BlogPost::class);
    }
    //所有評論
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    //用戶自己寫的評論
    public function commentsOn(){
        return $this->morphMany(Comment::class,'commentable')->latest();      
    }

    public function scopeWithMostBlogPosts(Builder $query){
        return $query->withCount('blogPosts')->orderBy('blog_posts_count','desc');
    }

    public function scopeWithMostBlogPostsLastMonth(Builder $query){
        return $query->withCount(['blogPosts' => function($query) {
            $query->whereBetween(static::CREATED_AT, [now()->subMonths(1), now()]);
        }])->has('blogPosts','>=',2)
        ->orderBy('blog_posts_count','desc');
    }

    public function scopeThatHasCommentedOnPost(Builder $query, BlogPost $post ){
        return $query->whereHas('comments', function($query)use($post){
            return $query->where('commentable_id','=', $post->id)
                ->where('commentable_Type','=', BlogPost::class);
        });
    }

    public function scopeThatIsAdmin(Builder $query){
        return $query->where('is_admin', true);
    }
}
