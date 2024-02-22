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
                    <a href="javascript:void(0);" onclick="fileUpdate(this)" data-id="{{ $doc->uuid }}" data-name="{{ $doc->name }}" class="dropdown-item file__change-name">Mudar Nome</a>
                    <a href="javascript:void(0);" onclick="fileMove(this)" data-id="{{ $doc->uuid }}" data-name="{{ $doc->name }}" class="dropdown-item">Mover</a>

                    <a href="javascript:void(0);"
                    data-btn-class="btn btn-warning"
                    data-action="delete"
                    data-text="Deletar"
                    data-route="{{ route('arquivos.destroy', $doc->uuid) }}"
                    onclick="btn_delete(this)" class="dropdown-item"><i class="tx-danger fas fa-trash"></i>
                        Excluir
                    </a>
                </div>
            </div>
        </li>
    </ul>
@endforeach
