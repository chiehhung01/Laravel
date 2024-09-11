<div>
    @if ($allOption)
        {{-- <div class="mb-1 font-semibold">{{ $name }}</div> --}}
        <label for="{{ $name }}" class="mb-1 flex items-center">
            <input type="radio" name="{{ $name }}" value="" @checked(!request($name)) />
            {{-- 如果 experience 參數不存在或為空，則 checkbox 將被勾選 --}}
            <span class="ml-2">All</span>
        </label>
    @endif

    @foreach ($optionsWithLabels as $label => $option)
        <label for="{{ $name }}" class="mb-1 flex items-center">
            <input type="radio" name="{{ $name }}" value="{{ $option }}" @checked($option === ($value ?? request($name))) />
            <span class="ml-2">{{ $label }}</span>
        </label>
    @endforeach

    @error($name)
        <div class="mt-1 text-xs text-red-500 ">
            {{ $message }}
        </div>
    @enderror
</div>
