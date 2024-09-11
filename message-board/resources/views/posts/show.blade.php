



@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-8">
        @if($post->image)
        <div style="background-image: url('{{ $post->image->url() }}'); 
            background-size: contain; 
            background-position: center center; 
            background-repeat: no-repeat;
            min-height: 500px; 
            color: white; 
            text-align: center; 
            background-attachment: fixed;
            padding-top: 100px; 
            text-shadow: 1px 2px #000;">
            <h1 style="padding-top: 100px; text-shadow: 1px 2px #000">
        @else
            <h1>
        @endif
            {{ $post->title }}
            @badge(['show' => now()->diffInMinutes($post->created_at) < 30])
                Brand new Post!
            @endbadge
        @if($post->image)    
            </h1>
        </div>
        @else
            </h1>
        @endif

        <p>{{ $post->content }}</p>

        @updated(['date' => $post->created_at, 'name' => $post->user->name])
        @endupdated
        @updated(['date' => $post->updated_at])
            Updated
        @endupdated

        @tags(['tags' => $post->tags])@endtags

        <p>{{ trans_choice('messages.people.reading',$counter)}}</p>

        <h4>Comments</h4>

        @commentForm(['route' => route('posts.comments.store', ['post' => $post->id])])
        @endcommentForm

        @commentList(['comments' => $post->comments])
        @endcommentList
    </div>
    <div class="col-4">
        @include('posts.activity')
    </div>
@endsection
