<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Employer;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
       

       
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Piotr Jura',
            'email' => 'piotr@jura.com',
        ]);
         User::factory(300)->create();
         $users = User::all()->shuffle();
        //產生20個Employer
         for($i = 0; $i < 20; $i++)
         {
            Employer::factory()->create([
                'user_id' => $users->pop()->id

                //pop()它會刪除並返回集合中的最後一個元素，避免id重複
            ]);
         }

         $employers = Employer::all();
         //產生100個job
         for($i = 0; $i < 100 ;$i++)
         {
            Job::factory()->create([
                'employer_id' => $employers->random()->id
            ]);
         }
        
       foreach ($users as $user){
        $jobs = Job::inRandomOrder()->take(rand(0,4))->get();

        foreach ($jobs as $job) {
            JobApplication::factory()->create([
                'job_id' => $job->id,
                'user_id' => $user->id
            ]);
        }
       }
      
    
    }
}
