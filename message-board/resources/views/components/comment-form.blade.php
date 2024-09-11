<div class="mb-2 mt-2">
    @auth
        <form action="{{ $route }}" method="POST">
            @csrf
            <div class="form-group">
                <textarea class="form-control" name="content" id="content"></textarea>
            </div>
            <div><input class="btn btn-primary btn-block mt-3" type="submit" value="Add comment"></div>
        </form>
        @errors @enderrors
    @else
        <a href="{{ route('login') }}">Sign-in </a> to post comments!
    @endauth
</div>
