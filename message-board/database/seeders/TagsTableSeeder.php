<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = collect(['Science', 'Sport', 'Politics', 'Entertainment', 'Economy']);
        $tags->each(function ($tagname) {  
            $tag = new Tag();
            $tag->name = $tagname;
            $tag->save();
        });
    }
}
