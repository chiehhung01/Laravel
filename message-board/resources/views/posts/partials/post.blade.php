<h3>
    @if ($post->trashed())
        <del>
    @endif

    <a class="{{ $post->trashed() ? 'text-muted' : '' }}"
        href=" {{ route('posts.show', ['post' => $post->id]) }} ">{{ $post->title }} </a>

    @if ($post->trashed())
        </del>
    @endif
</h3>


{{-- <p class="text-muted">
    Added {{ $post->created_at->diffForHumans() }} by {{ $post->user->name }}
</p> --}}

@updated(['date' => $post->created_at, 'name' => $post->user->name,'userId' =>$post->user->id])
@endupdated

@tags(['tags' => $post->tags])
    @endtags



{{-- @if ($post->comments_count)
    <p>{{ $post->comments_count }} comments</p>
@else
    <p>Not Comment yet!</p>
@endif --}}

{{ trans_choice('messages.comments',$post->comments_count) }}

<div class="mb-3">
    @auth
        @can('update', $post)
            <a class="btn btn-primary" href=" {{ route('posts.edit', ['post' => $post->id]) }} ">Edit</a>
        @endcan
    @endauth


    {{-- @cannot('delete', $post)
        <p>you can't delete this post!</p> 
    @endcannot --}}
    @auth
        @if (!$post->trashed())
            @can('delete', $post)
                <form class="d-inline" action=" {{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input class="btn btn-primary" type="submit" value="Delete!">
                </form>
            @endcan
        @endif
    @endauth




</div>
