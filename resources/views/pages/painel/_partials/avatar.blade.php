<!-- xs sm md lg xl -->
@php
$name = Str::title($name);
$name = substr(mb_strtoupper($name, 'UTF-8'), 0, 2);
$size = $size ?? 'sm';
$class = $class ?? 'avatar-' . $size;
$tx = $size == 'lg' ? 'tx-20' : '';
@endphp

@if ($avatar != '')
    <img src="{{ asset('storage/' . $avatar) }}" alt="" class="rounded-circle avatar-{{ $size}}" width={{ $width ?? '' }}>
@else
    <div class="{{ $class }} font-weight-bold d-inline-block">
        <span class="avatar-title rounded-circle bg-soft-purple {{ $tx }}">
            {{ $name }}
        </span>
    </div>
@endif
