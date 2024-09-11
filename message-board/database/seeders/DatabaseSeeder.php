<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    protected static ?string $password;
    /**
     * Seed the application's database.
     * 
     */


    public function run(): void
    {
        Cache::tags(['blog-post'])->flush();
        if($this->command->confirm("Do you want to refresh the database")) 
        {
            $this->command->call('migrate:refresh');
            $this->command->info('Database was refreshed');
        }

        $this->call([
            UsersTableSeeder::class,
            BlogPostsTableSeeder::class,
            CommentsTableSeeder::class,
            TagsTableSeeder::class,
            BlogPostTagTableSeeder::class,
        ]);           
    }
}
