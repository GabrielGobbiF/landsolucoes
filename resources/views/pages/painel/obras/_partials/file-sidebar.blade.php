<div class="filemgr-sidebar" class="h-100">
    <div class="filemgr-sidebar-header">
        <div class="dropdown dropdown-icon flex-fill">
            <button class="btn btn-xs btn-block btn-outline-info" data-toggle="modal" data-target="#modal-add-pasta">Novo <i class="chevron-down"></i></button>
            <div class="dropdown-menu tx-13">
                <button type="button" data-toggle="modal" data-target="#modal-add-pasta" class="dropdown-item"><i class="fas fa-folder"></i><span> Pasta</span></button>
            </div>
        </div>
        @if(isset($pasta))
        <div class="dropdown dropdown-icon flex-fill mg-l-10">
            <button type="button" data-toggle="modal" data-target="#modal-add-documento" class="btn btn-xs btn-block btn-primary" data-toggle="dropdown">Upload <i
                    class="chevron-down"></i>
            </button>
        </div>
        @endif
    </div>
    <div class="filemgr-sidebar-body ps">
        <div class="pd-b-10 pd-x-10">
            <label class="tx-sans tx-uppercase tx-medium tx-10 tx-spacing-1 tx-color-03 pd-l-10">Arquivos</label>
            <nav class="nav nav-sidebar tx-13">
                <a href="{{ route('arquivos.index') }}" class="nav-link active"><i data-feather="folder"></i> <span>Todos os Arquivos</span></a>
                <a href="{{ route('arquivos.my.favorites') }}" class="nav-link"><i data-feather="info"></i> <span>Favoritos</span></a>
            </nav>
        </div>
    </div>
</div>


