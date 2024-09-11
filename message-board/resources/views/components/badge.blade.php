@if (!isset($show) || $show)
    <span class="badge text-bg-{{ $type ?? 'success' }}">
        {{ $slot }}
    </span>
@endif
