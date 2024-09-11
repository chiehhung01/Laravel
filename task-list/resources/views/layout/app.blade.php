<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel 10 Task List App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- https://tailwindcss.com/docs/installation/play-cdn --}}
    <script src="//unpkg.com/alpinejs" defer></script>

    <style type='text/tailwindcss'>
        {{-- blade-formatter-disable --}} .btn {
            @apply rounded-md px-2 py-1 text-center font-medium shadow-sm ring-1 ring-slate-700/10 hover:bg-slate-50 text-slate-700
        }

        .link {
            @apply font-medium text-gray-700 underline decoration-pink-500
        }

        label {
            @apply block uppercase text-slate-700 mb-2
        }

        input, textarea {
            @apply shadow-sm appearance-none border w-full py-3 px-3 text-slate-700 leading-tight focus:outline-none
        }

        .error {
            @apply text-red-500 text-sm
        }

        /*  shadow-sm: 添加輕微的陰影效果。
appearance-none: 移除默認的外觀樣式，這樣你就可以自定義元素的外觀。
border: 添加元素的邊框。
w-full: 將元素的寬度設置為 100%，即填滿其容器的寬度。
py-3: 添加垂直方向上的 padding，相當於 padding-top: 0.75rem; padding-bottom: 0.75rem;。
px-3: 添加水平方向上的 padding，相當於 padding-left: 0.75rem; padding-right: 0.75rem;。
text-slate-700: 設置文本顏色為 Slate（深灰色）的第 700 級別。
leading-tight: 設置行高為較緊密的值。
focus:outline-none: 在焦點狀態下移除默認的外框，這通常用於去除默認的藍色外框。  */
    </style>




    @yield('styles')
</head>

<body class="container mx-auto mt-10 max-w-lg">
    <h1 class="text-2xl mb-4"> @yield('title') </h1>
    @if (session()->has('success'))
        <div x-data=" { flash: true }">


            <div x-show="flash" role="alert"
                class=" relative mb-10 rounded border border-green-400 bg-green-100 px-4 py-3 text-lg text-green-700">
                <strong class="text-bold">Success!</strong>
                <div> {{ session('success') }}</div>

                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        @click="flash = false" stroke="currentColor" class="h-6 w-6 cursor-pointer">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </span>
            </div>
    @endif

    @yield('content')
    </div>
</body>

</html>
