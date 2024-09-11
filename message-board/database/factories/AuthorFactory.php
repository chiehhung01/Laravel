<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Author;
use App\Models\Profile;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    

    public function configure()
    {
        return $this->afterCreating(function (Author $author) {
            $author->profile()->save(Profile::factory()->make());
        })-> $this->afterMatking(function (Author $author) {
            $author->profile()->save(Profile::factory()->make());
        });
    }
    //在 Laravel 的工厂中，configure 方法是用来配置工厂的回调和状态的地方。在这个方法中，
    //你可以定义一些全局的配置，例如使用 afterCreating 或 afterMaking 等方法来定义在模型创建或构造之后执行的操作


}
