<?php

namespace App\Http\Controllers;


use App\Events\BlogPostPosted;
use App\Facades\CounterFacade;
use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\Image;
// use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{ 
     public function __construct(){
        $this->middleware("auth")->only(['create','store','edit','update','destroy']);
        //  $this->middleware("locale");
        
    }
    
    
     public function index()
    {
        // DB::connection()->enableQueryLog();

        // $posts = BlogPost::with('comments')->get();
        
        // foreach ($posts as $post) {
        //     foreach($post->comments as $comment) {
        //         echo $comment->content;}
        // }

        // dd(DB::getQueryLog());

      

        return view('posts.index',
        [
            'posts' => BlogPost::LatestWithRelations()->get(),           
        ]);        
    }

  
    public function create()
    {
        // $this->authorize('posts.create');
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePost $request)
    {
        $validated=$request->validated();
        $validated['user_id'] = $request->user()->id;
        //已通過認證的user_id
        $post = BlogPost::create($validated);   
        //create()不用加save()、make()之後要加save()
       
       
        if($request->hasFile('thumbnail')){
             $path = $request->file('thumbnail')->store('thumbnails');
            // $file = $request->file('thumbnail');
            // $name1 = $file->storeAs('thumbnails',$post->id . '.' . $file->guessExtension());
        
            // dd(Storage::url($name1));



            $post->image()->save(
              Image::make(['path'=> $path])
            );
        }        
        event(new BlogPostPosted($post));
        $request->session()->flash('status','The blog post was created');

        return redirect()->route('posts.show',['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     */
    
      
    public function show($id)
    {
        // abort_if(!isset($this -> posts[$id]), 404);

        // return view('posts.show',['post' => BlogPost::with(['comments' => function($query){
        //     return $query->latest();
        // }])->findOrFail($id)]);

        $blogPost = Cache::tags(['blog-post'])->remember("blog-post-{$id}",60, function ()use($id) {
            return BlogPost::with('comments', 'tags', 'user', 'comments.user')
            ->findOrFail($id); 
        });
        // dd($this->counter);
      
        

        return view('posts.show', [
            'post'=> $blogPost,
            'counter' => CounterFacade::increment("blog-post-{$id}",['blog-post']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = BlogPost::findOrFail($id);
        // if(Gate::denies('update-post', $post)){
        //     abort(403,"You can't edit this blog post!");
        // }        
        $this->authorize('update', $post);
        return view('posts.edit',['post'=> BlogPost::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePost $request, string $id)
    {
        $post = BlogPost::findOrFail($id);
        // if(Gate::denies('update-post', $post)){
        //     abort(403,"You can't edit this blog post!");
        // }
        
        
        $validated = $request->validated();
        $post->fill($validated);
        $post->save();

        if($request->hasFile('thumbnail')){
            $path = $request->file('thumbnail')->store('thumbnails');           

            if($post->image){
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            }else{
                $post->image()->save(
                Image::make(['path'=> $path])
             );
            }       
        }
        $request->session()->flash('status','Blog post was updated');
        return redirect()->route('posts.show',['post'=> $post->id]);      
        
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = BlogPost::findOrFail($id);

        // if(Gate::denies('delete-post', $post)){
        //     abort(403,"You can't delete this blog post!");
        // }     
        $this->authorize('delete', $post);
        $post->delete();
        
        session()->flash('status','blog post was deleted!');
        
        return redirect()->route('posts.index');

    }
}
