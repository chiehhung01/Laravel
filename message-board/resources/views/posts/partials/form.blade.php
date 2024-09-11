<div class="form-group">
    <label for="title">Title</label>
    <input class="form-control" type="text" name="title" id="title" value="{{ old('title', optional($post ?? null)->title) }}">
    {{-- @error('title')
        <div class="alert alert-danger"> {{ $message }} </div>
    @enderror --}}
</div>
<div class="form-group">
    <label for="content">Content</label>
    <textarea class="form-control" name="content" id="content" >{{ old('content', optional($post ?? null)->content) }}</textarea>
</div>

<div>
    <div class="form-group">
        <label>Thumbnail</label>
        <input class="form-control-file" type="file" name="thumbnail">       
    </div>
</div>

@errors @enderrors
