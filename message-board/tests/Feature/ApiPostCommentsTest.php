<?php

namespace Tests\Feature;


use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiPostCommentsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function testNewBlogPostDoesNotHaveComments()
    {
    $this->blogPost();

    $response = $this->json('GET', 'api/v1/posts/1/comments');

    $response->assertStatus(200)
            ->assertJsonStructure(['data','links','meta'])
            ->assertJsonCount(0,'data');
    }

    public function testBlogPostHas10Comments()
    {
    $this->blogPost()->each(function(BlogPost $post){
        $post->comments()->saveMany(
            Comment::factory(10)->make([
                'user_id' => $this->user()->id
            ])
        );
    });
    $response = $this->json('GET', 'api/v1/posts/2/comments');

    $response->assertStatus(200)
            ->assertJsonStructure([
                'data' =>[
                    '*'=>[
                        'id','content','created_at','updated_at',
                        'user'=>[
                            'id','name'
                        ]
                    ]
                ]
            ,'links','meta'])
           
            ->assertJsonCount(10,'data');
    }

    Public function testAddingCommentsWhenNotAuthenticated(){
        $this->blogPost();
        $response = $this->json('POST','api/v1/posts/3/comments',[
            'content' => 'Hello'
        ]);
        $response->assertStatus(401);
    }

    public function testAddingCommentsWithInvalidData(){
        $this->blogPost();
        $response = $this->actingAs($this->user(),'api')->json('POST','api/v1/posts/4/comments',[
            'content' => 'Hello'
        ]);
        $response->assertStatus(201);
    }

    public function testAddingCommentsWhenAuthenicated(){
        $this->blogPost();
        $response = $this->actingAs($this->user(),'api')->json('POST','api/v1/posts/5/comments',[]);
        $response->assertStatus(422)
        ->assertJson([
            "message" => "The content field is required.",
            "errors" => [
                "content" =>[
                    "The content field is required."
                ]
                
            ]
        ]);
    }   
}
