{{-- slot:$comment --}}
@forelse ($comments as $comment)
    <p>{{ $comment->content }}</p>
     {{-- <img src="127.0.0.1:8000/storage/{{ $post->image->path }}">  --}}
    <p class="text-muted">
        @tags(['tags' => $comment->tags])@endtags
        @updated(['date' => $comment->created_at, 'name' => $comment->user->name, 'userId' => $comment->user->id])
        @endupdated
        
    </p>
@empty
    <p>No Comments yet!</p>
@endforelse


