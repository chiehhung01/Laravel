<div class="card" style="width: 100%;">
    <div class="card-body">
        <h5 class="card-title">{{ $title }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">
            {{ $subtitle }}
        </h6>
    </div>
    <ul class="list-group list-group-flush">
       @if(is_a($items, 'Illuminate\Support\Collection'))
       {{-- 這個條件語句檢查 $items 是否是 Illuminate\Support\Collection 的實例，如果是，則執行標籤內的代碼。 --}}
        @foreach ($items as $item)
            <li class="list-group-item">
               {{ $item }}
            </li>
        @endforeach
        @else
            {{$items}}
        @endif
    </ul>
</div>