@if ($rating)
    @for ($i = 1; $i <= 5; $i++)
    {{ $i<= round($rating) ? '★':'☆' }}
    @endfor
@else
    Not rating yet
@endif



