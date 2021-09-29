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

    .tree>li>a {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 72%;
    }

    .tree>li>a.nav-link {
        padding: 0.5rem 0px
    }

</style>



<ul class="nav nav-pills flex-column tree">
    @foreach ($pasta as $root_folder)
        @php
            $childrens = $root_folder->childrens();
            $docs = $root_folder->documentos()->get();
        @endphp
        <li class="nav-item">
            <a class="nav-link" href="#" data-type="0" data-toggle="collapse" data-target="#collapse{{ $root_folder->slug }}" aria-expanded="true"
                aria-controls="collapse{{ $root_folder->slug }}" data-path="{{ $root_folder->url }}">
                @if (count($childrens) > 0 || count($docs) > 0)
                    <i class="fas fa-angle-down"></i>
                @endif
                <i class="fa fa-folder fa-fw"></i> {{ $root_folder->name }}
            </a>
            <div id="collapse{{ $root_folder->slug }}" class="collapse" aria-labelledby="heading{{ $root_folder->slug }}" data-parent="#accordion">
                <div class="tree" style="margin-left: 30px;">
                    @if ($childrens)
                        @include('pages.painel.obras.obras.documentos.childrens')
                    @endif
                    @if ($docs)
                        @include('pages.painel.obras.obras.documentos.documents', ['docs'=>$docs])
                    @endif
                </div>
            </div>
        </li>
    @endforeach
    @if ($docsPasta)
        @include('pages.painel.obras.obras.documentos.documents', ['docs'=>$docsPasta])
    @endif
</ul>

<div class="mt-3">
    @php
        $cliente = $obra->client_id;
        $obraId = $obra->id;
        $url = file_get_contents("http://landsolucoes.com.br/autorizationsAjax/getPreview/$obraId/$cliente") ?? null;
        if ($url) {
            $docAntigo = json_decode($url, true);
        }
    @endphp

    @if (isset($docAntigo))
    <hr class="my-2">
    <h6 class="mt-4">Sistema Antigo</h6>
        <ul class="nav nav-pills flex-column tree">
            @foreach ($docAntigo as $pasta => $documentos)
                @php
                    $slug = limpar($pasta);
                @endphp
                <li class="nav-item">
                    <a class="nav-link" href="#" data-type="0" data-toggle="collapse" data-target="#collapse_docs_antigos_{{ $slug }}" aria-expanded="true"
                        aria-controls="collapse_docs_antigos_{{ $slug }}">
                        <i class="fa fa-folder fa-fw"></i> {{ $pasta }}
                    </a>
                    <div id="collapse_docs_antigos_{{ $slug }}" class="collapse" aria-labelledby="heading{{ $pasta }}" data-parent="#accordion">
                        <div class="tree" style="margin-left: 30px;">
                            @if (isset($documentos['documentos']))
                                @foreach ($documentos['documentos'] as $docs)
                                    <ul class="nav nav-pills flex-column tree">
                                        <li class="nav-item sub-item">
                                            <div class="dropdown">
                                                <a href="http://www.landsolucoes.com.br/{{ $docs['docs_link'] }}/{{ $docs['docs_nome'] }}" target="_blank" class="nav-link" >
                                                    {{ $docs['docs_nome'] }}
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

</div>
