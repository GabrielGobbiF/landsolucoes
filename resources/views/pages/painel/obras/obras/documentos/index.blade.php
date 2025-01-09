<style>
    /*Level 1*/
    .tree>li>ul {
        margin: 0;
        padding: 0;
    }

    /*All other levels*/
    .tree>li>ul .sub-item {
        margin: 0 0 0 30px;
        padding: 0;
    }

    .tree>li>div.d-flex>a {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 72%;
        text-decoration: none;
        cursor: pointer;
        color: #505d69
    }

    .tree>li>a.nav-link {
        padding: 0.5rem 0px
    }

    .tree .nav-link {
        padding: .5rem 0.1rem !important;
    }
</style>

<ul class="nav nav-pills flex-column tree">
    @foreach ($pasta as $root_folder)
        @php
            $childrens = $root_folder->childrens();
            $docs = $root_folder->documentos()->get();
        @endphp
        <li class="nav-item">
            <div class="d-flex align-items-center">
                <a class="nav-link" href="#" data-type="0" data-toggle="collapse" data-target="#collapse{{ $root_folder->slug }}" aria-expanded="true"
                   aria-controls="collapse{{ $root_folder->slug }}" data-path="{{ $root_folder->url }}">
                    @if (count($childrens) > 0 || count($docs) > 0)
                        <i class="fas fa-angle-down"></i>
                    @endif
                    <i class="fa fa-folder fa-fw"></i> {{ $root_folder->name }}
                </a>

                <div class="dropdown">
                    <a class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="javascript:void(0)" data-text="Excluir Pasta" data-href="{{ route('pastas.destroy', $root_folder->id) }}" rel="tooltip"
                               title="Excluir Pasta" class="dropdown-item js-btn-delete delete-folder">
                               <i class="fas fa-trash mr-2 text-danger"></i>
                               Excluir Pasta
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
            <div id="collapse{{ $root_folder->slug }}" class="collapse" aria-labelledby="heading{{ $root_folder->slug }}" data-parent="#accordion">
                <div class="tree" style="margin-left: 30px;">
                    @if ($childrens)
                        @include('pages.painel.obras.obras.documentos.childrens')
                    @endif
                    @if ($docs)
                        @include('pages.painel.obras.obras.documentos.documents', ['docs' => $docs])
                    @endif
                </div>
            </div>
        </li>
    @endforeach
    @if ($docsPasta)
        @include('pages.painel.obras.obras.documentos.documents', ['docs' => $docsPasta])
    @endif
</ul>


