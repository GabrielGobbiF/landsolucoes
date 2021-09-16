@foreach ($docs as $doc)
    @php
        $desc = $doc->desc;
    @endphp
    <ul class="nav nav-pills flex-column tree">
        <li class="nav-item sub-item">
            <a class="nav-link" target="_blank" href="{{ asset($doc->url) }}" data-type="0" data-path="{{ $doc->url }}">
                <i style="color:{{ $desc['color'] }}" class="{{ $desc['icon'] }}"></i> {{ $doc->name }}
            </a>
        </li>
    </ul>
@endforeach
