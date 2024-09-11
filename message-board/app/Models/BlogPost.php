<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
use App\Scopes\LatestScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class BlogPost extends Model
{
    use HasFactory;
    use SoftDeletes,Taggable;

    protected $fillable = ['title','content','user_id'];

    public function comments(){
        return $this->morphMany(Comment::class,'commentable')->latest();      
    }

    public function user(){
        return $this->belongsTo(User::class); 
    }

  

    public function image(){
        return $this->morphOne(Image::class,'imageable');
    }

    public function scopeLatestWithRelations(Builder $query){
        return $query->latest()
        ->withCount('comments')->with('tags')->with('user');
    }
    public function scopeLatest(Builder $query){
        return $query->orderBy(static::CREATED_AT,'desc');
    }

    public function scopeMostCommented(Builder $query){
        return $query->withCount('comments')->orderBy('comments_count','desc');
    }
    public  static function boot(){
        static::addGlobalScope(new DeletedAdminScope);
        parent::boot();
        
        
    }
}
