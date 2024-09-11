<?php

namespace Database\Factories;
use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = BlogPost::class;
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(10),
            'content'=> $this->faker->paragraphs(5,true),
            'created_at' => $this->faker->dateTimeBetween('-3 months'),
        ];

  
    }

    

    public function newTitle()
    {
        return $this->state(function (array $attributes) {
            return ['title' => 'New title','content' => 'content of the blog post'];
        });
    }
}
