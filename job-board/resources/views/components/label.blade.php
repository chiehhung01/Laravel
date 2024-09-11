<label class="mb-2 block text-sm font-semibold text-slate-900" for="{{ $for }}">
    {{ $slot }}
    @if ($required)
        <span>*</span>
    @endif
</label>
