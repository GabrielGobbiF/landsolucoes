@foreach ($docs as $doc)
    @php
        $desc = $doc->desc;
    @endphp
    <ul class="nav nav-pills flex-column tree">
        <li class="nav-item sub-item">
            <div class="dropdown">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false">
                    <i style="color:{{ $desc['color'] }}" class="{{ $desc['icon'] }}"></i> {{ $doc->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-end" style="">
                    <a target="_blank" href="{{ asset($doc->url) }}" class="dropdown-item">Visualizar</a>
                    <a href="javascript:void(0);" data-id="{{ $doc->id }}" data-name="{{ $doc->name }}" class="dropdown-item">Mudar Nome</a>
                    <a href="javascript:void(0);" data-id="{{ $doc->id }}" data-name="{{ $doc->name }}" class="dropdown-item">Mover</a>
                    <a href="javascript:void(0);" data-id="{{ $doc->id }}" data-name="{{ $doc->name }}" class="dropdown-item"><i class="tx-danger fas fa-trash"></i> Excluir</a>
                </div>
            </div>
        </li>
    </ul>
@endforeach
