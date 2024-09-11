<style>
    body{
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

<p> Hi {{$comment->commentable->user->name }} </p>
{{-- 這篇blogpost的作者 --}}

<p>
    Someone has commented on your blog post
    <a href="{{ route('posts.show',['post'=> $comment->commentable->id])}}">
        {{ $comment->commentable->title}}
    </a>
</p>
<hr/>
<p>
    {{-- <img src="{{ $message->embed($comment->user->image->url())}}"/> --}}
    <a href="{{ route('users.show',['user' => $comment->user->id])}} ">
        {{ $comment->user->name }}
        {{-- 回復comment的人 --}}
    </a> said:
</p>

<p>"{{ $comment->content }}" </p>