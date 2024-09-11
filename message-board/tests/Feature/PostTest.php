<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;



class PostTest extends TestCase
{
   use RefreshDatabase;
    // public function testNoBlogPostsWhenNothingInDatabase(){
    //    $response = $this->get('/posts');
    //    $response->assertSeeText('No posts found');
    // }
    // public function testSee1BlogPostWhenThereIs1(){
    //     //Arrange
    //     $post = new BlogPost();
    //     $post->title = 'New title';
    //     $post->content = 'Content of the blog post';
    //     $post->save();

    //     //Act
    //     $response = $this->get('/posts');
    //     //Assert
    //     $response->assertSeeText('New title');
    //     $response->assertSeeText('Not Comment yet!');
    //     $this->assertDatabaseHas('blog_posts',[
    //         'title'=> 'New title',
    //     ]);
    // }

    

    public function testSee1BlogPostWithComments(){
       
        //Arrange
         $user = $this->user();
         $post = $this->createDummyBlogPost();  
        
        //Act
        Comment::factory(4)->create([
            'commentable_id' =>$post->id,            
            'commentable_type' => BlogPost::class,
            'user_id' => $user->id,
        ]);       
        
        //Assert
        $response = $this->get('/posts');
        $response->assertSeeText('4 comments');

    }



    public function testStoreValid(){       

        $params=[
            'title'=> 'Valid title',
            'content'=> 'At least 10 characteres',
        ];      

        $this->actingAs($this->user())
        ->post('/posts', $params)
        ->assertStatus(302)
        ->assertSessionHas('status');
        $this->assertEquals(session('status'), 'The blog post was created');
    
    } 

    public function testStoreFail(){
        $params=[
            'title'=> 'x',
            'content'=> 'x',
        ];
        $this->actingAs($this->user())->post('/posts', $params)->assertStatus(302)->assertSessionHas('errors');
       $messages = session('errors')->getMessages();

    //    dd($messages->getMessages());

       $this->assertEquals($messages['title'][0],'The title field must be at least 5 characters.');
       $this->assertEquals($messages['content'][0],'The content field must be at least 10 characters.');
    } 

    public function testUpdateValid(){
        //create
        $user =$this->user();
        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts', [ 'title'=> 'New title',]);

        $params=[
            'title'=> 'A new named title',
            'content'=> 'Content was changed',
        ];
        //update
        $this->actingAs($user)->put("/posts/{$post->id}", $params)->assertStatus(302)->assertSessionHas('status');
        $this->assertEquals(session('status'), 'Blog post was updated');

        $this->assertDatabaseMissing('blog_posts', $post->toArray());//[ 'title'=> 'New title',]
        $this->assertDatabaseHas('blog_posts', [ 'title' => 'A new named title'] );

    }




    public function testDelete(){
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);
        $this->assertDatabaseHas('blog_posts', [ 'title'=> 'New title']);

        $this->actingAs($user)->delete("/posts/{$post->id}")->assertStatus(302)->assertSessionHas('status');
        $this->assertEquals(session('status'), 'blog post was deleted!');

        $this->assertDatabaseMissing('blog_posts', $post->toArray());
        //[ 'title'=> 'New title',]      
        // $this->assertSoftDeleted('blog_posts', $post->toArray());
    }




    private function createDummyBlogPost($userId = null) 
    {
        // $post = new BlogPost();
        // $post->title = 'New title';
        // $post->content = 'Content of the blog post';
        // $post->save();

        // return $post;

        return BlogPost::factory()->newTitle()->create(
            [
                 'user_id' =>$userId ?? $this->user()->id,
                 
            ]
        );

    }


}
