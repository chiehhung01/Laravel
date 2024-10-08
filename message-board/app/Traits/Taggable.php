<?php

namespace App\Traits;

use App\Models\Tag;

trait Taggable{

    public static function bootTaggable(){
        static::updating(function($model){
            $model->tags()->sync(static::findTagsInContent($model->content));
        });
        static::created(function($model){
            $model->tags()->sync(static::findTagsInContent($model->content));
        });
    }
    public function tags(){
        return $this->morphToMany(Tag::class,'taggable')->withTimestamps();
    }

   private static function findTagsInContent($content){
    preg_match_all('/@([^@]+)@/m',$content,$tags);
    //query tags table的name
    return Tag::whereIn('name',$tags[1] ?? [])->get();
   }
}