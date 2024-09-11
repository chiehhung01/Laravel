<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public function BlogPosts(){
       return $this->morphedByMany(BlogPost::class,'taggable')->withTimestamps()->as('tagged');
    }

    public function Comments(){
        return $this->morphedByMany(Comment::class,'taggable')->withTimestamps()->as('tagged');
     }
 }



