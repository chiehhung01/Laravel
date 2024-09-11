<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="
        https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js
        "></script>
    <link href="
    https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css
    " rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="{{asset('js/app.js')}}" defer></script>

    <title>Laravel App - @yield('title')</title>
</head>

<body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 bg-white border-bottem shadow-sm mb-3">
        <h5 class="my-0 me-md-auto font-weight-normal">Laravel App</h5>
        <nav>
            <a class="p-2 text-dark" href="{{ route('home.index') }}">{{__('Home')}}</a>
            <a class="p-2 text-dark" href="{{ route('contact') }}">{{__('Contact')}}</a>
            <a class="p-2 text-dark" href="{{ route('posts.index') }}">{{__('Blog Posts')}}</a>
            <a class="p-2 text-dark" href="{{ route('posts.create') }}">{{__('Add')}}</a>

            @guest
                @if (Route::has('register'))
                    <a class="p-2 text-dark" href="{{ route('register') }}">{{__('Register')}}</a>
                @endif
                <a class="p-2 text-dark" href="{{ route('login') }}">{{__('Login')}}</a>
            @else
            <a class="p-2 text-dark" href="{{ route('users.show',['user' => Auth::user()->id]) }}">{{__('Profile')}}</a>
            <a class="p-2 text-dark" href="{{ route('users.edit',['user' => Auth::user()->id]) }}">{{__('Edit Profile')}}</a>
                <a class="p-2 text-dark" href="{{ route('logout') }}"
                    onclick="event.preventDefault();$('#logout-form').submit();">{{__('Logout')}}({{ Auth::user()->name }})</a>
                <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display:none;">
                    @csrf
                </form>
            @endguest

        </nav>
    </div>
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success"> {{ session('status') }}</div>
        @endif

        @yield('content')
    </div>

</body>

</html>
