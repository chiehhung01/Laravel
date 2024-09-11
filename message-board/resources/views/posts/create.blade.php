@extends('layouts.app')

@section('title', 'Create the post')

@section('content')
<form action=" {{ route('posts.store') }} " method="POST" enctype="multipart/form-data">
    @csrf
    @include('posts.partials.form')
    <div><input class="btn btn-primary btn-block mt-3" type="submit" value="Create"></div>
</form>
@endsection