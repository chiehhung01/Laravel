<nav {{ $attributes }}>
    <ul class="flex space-x-4 text-slate-500">
        <li><a href="/">Home</a></li>
        @foreach ($links as $label => $link)
            <li>→</li>
            <li><a href="{{ $link }}">{{ $label }}</a></li>
        @endforeach
    </ul>
</nav>

{{-- 在 Laravel Blade 模板中，$attributes 是一個特殊的變數，它包含了所有未明確定義的 HTML 屬性。
當你在使用 Blade 組件時，使用 $attributes 可以將父元素傳遞給子元素，使子元素能夠保留父元素的所有 HTML 屬性。 --}}