<?php

namespace App\Models;


use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Comment extends Model
{
    use HasFactory;
    use SoftDeletes, Taggable;
    protected $fillable = ['user_id','content'] ;

    protected $hidden = ['deleted_at', 'commentable_type', 'commentable_id','user_id'];


    // public function blogPost(){
    //     return $this->belongsTo(BlogPost::class);
    // }
    public function commentable(){
        return $this->morphTo();
    }

    public function user(){
        return $this->belongsTo(User::class); 
    }

    

    //local query
    public function scopeLatest(Builder $query){
        return $query->orderBy(static::CREATED_AT,'desc');
    }

    
    //global query
    // public  static function boot(){
    //     parent::boot();
    //     // static::addGlobalScope(new LatestScope);
        
    // }
        
}
