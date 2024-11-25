@extends('app')

@section('title', 'Editar - ' . ucfirst($rdse->n_order) . ' - ' . ucfirst($rdse->description))

@section('content-max-fluid')

    <style class="">
        #handsontable-container {
            width: 100%;
            height: 100vh;
            overflow: auto;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable@latest/dist/handsontable.full.min.css">

    <div class="card text-start">
        <div class="card-body">

            <div style="margin-bottom: 20px;">
                <button onclick="redirectToType('enel')" class="btn btn-{{ request('type') === 'enel' || request('type') == -null ? '' : 'outline-' }}danger btn-sm">
                    RESB Enel
                </button>

                @if (!empty($rdse->resb_enel))
                    <button onclick="redirectToType('viabilidade')" class="btn btn-{{ request('type') === 'viabilidade' ? '' : 'outline-' }}danger btn-sm">
                        RESB Viabilidade
                    </button>
                @endif

                {{--
                @if (!empty($rdse->resb_enel))
                    <button onclick="redirectToType('requisicao')" class="btn btn-{{ request('type') === 'requisicao' ? '' : 'outline-' }}danger btn-sm">
                        Requisição de Material
                    </button>
                @endif


                @if (!empty($rdse->resb_viabilidade))
                    <button onclick="redirectToType('executada')" class="btn btn-{{ request('type') === 'executada' ? '' : 'outline-' }}danger btn-sm">
                        RESB Executada
                    </button>
                @endif

--}}
            </div>

            <h4 class="card-title"></h4>

            <div class="my-3">

                @if ($rdse->canResetResb())
                    <button data-text="Resetar RESB" data-action="DELETE" data-href="{{ route('rdse.rsbe.reset', $rdse->id) }}" type="button"
                            class="btn btn-sm btn-outline-danger js-btn-delete">
                        Resetar RESB
                    </button>
                @endif

                @if (empty($rdse->resb_enel))
                    <button id="add-row-button" class="btn btn-sm btn-primary">Adicionar 10 Linhas</button>

                    <button data-text="Salvar RESB" data-action="put" data-href="{{ route('rdse.rsbe.save', ['col' => 'resb_enel', $rdse->id]) }}" type="button"
                            class="btn btn-sm btn-outline-primary js-btn-delete">
                        Salvar RESB Enel
                    </button>
                @endif

                @if (empty($rdse->resb_viabilidade) && request('type') === 'viabilidade')
                    <button data-text="Salvar RESB Viabilidade" data-action="put"
                            data-href="{{ route('rdse.rsbe.save', ['col' => 'resb_viabilidade', $rdse->id]) }}" type="button"
                            class="btn btn-sm btn-outline-primary js-btn-delete">
                        Salvar RESB Viabilidade
                    </button>
                @endif

                @if (request('type') === 'viabilidade')
                    <button data-text="Criar Nova Requisição" data-action="put" data-href="{{ route('rdse.rsbe.store.requisicao', $rdse->id) }}" type="button"
                            class="btn btn-sm btn-outline-info js-btn-delete">
                        Nova Requisição de Compra
                    </button>
                @endif

                @if (empty($rdse->resb_execucao) && request('type') === 'executada')
                    <button data-text="Salvar RESB Execução" data-action="put" data-href="{{ route('rdse.rsbe.save', ['col' => 'resb_execucao', $rdse->id]) }}"
                            type="button" class="btn btn-sm btn-outline-primary js-btn-delete">
                        Salvar RESB Execução
                    </button>
                @endif


                @if (request('type') === 'requisicao')
                    <button data-text="Criar Nova Requisição" data-action="put" data-href="{{ route('rdse.rsbe.store.requisicao', $rdse->id) }}" type="button"
                            class="btn btn-sm btn-outline-info js-btn-delete">
                        Nova Requisição de Compra
                    </button>
                @endif
            </div>

            <div>
                <div class="card text-start">
                    <div class="card-body">
                        <div class="float-right">
                            <span id="saving-message" class="d-none"> Salvando...</span>
                        </div>

                        <div id="handsontable-container"></div>
                    </div>
                </div>

            </div>


        </div>
    </div>

    {{--
     @if (!empty($rdse->resb_enel))
                var contextMenu = {
                    items: {
                        'insert_row': false,
                        'remove_row': false,
                        'insert_col': false,
                        'remove_col': false
                    }
                };
            @endif --}}
@endsection

@section('scripts')


    <script src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('handsontable-container');

            const columns = @json($columns);

            const initialData = @json($rows);

            var contextMenu = true;

            const hot = new Handsontable(container, {


                @if (!empty($rdse->resb_enel) )
                    cells: function(row, col) {
                        const cellProperties = {};

                        if (col === 4 ) {
                            cellProperties.readOnly = true;
                        }

                        return cellProperties;
                    },
                @endif

                @if ($rdse->resb_status == 'viabilidade')
                    cells: function(row, col) {
                        const cellProperties = {};

                        if (col === 4 || col === 5) {
                            cellProperties.readOnly = true;
                        }

                        return cellProperties;
                    },
                @endif


                @if (request('type') === 'executada')
                    cells: function(row, col) {
                        const cellProperties = {};

                        if (col === 1 || col === 2 || col === 3 || col === 4 || col === 5) {
                            cellProperties.readOnly = true;
                        }

                        return cellProperties;
                    },
                @endif

                contextMenu: contextMenu,
                data: initialData,
                colHeaders: columns,
                rowHeaders: true,
                allowInsertRow: true,
                filters: true,
                dropdownMenu: true,
                allowInsertColumn: false,
                licenseKey: 'non-commercial-and-evaluation',
                hiddenColumns: {
                    columns: [0],
                    indicators: true
                },
            });

            document.getElementById('add-row-button')?.addEventListener('click', () => {
                hot.alter('insert_row_below', null, 10);
            });

            let saveTimeout;

            function debounceSave() {
                clearTimeout(saveTimeout);
                saveTimeout = setTimeout(saveData, 2000);
            }

            const savingMessage = document.getElementById('saving-message');

            function saveData() {
                const data = hot.getData();

                axios.put(`${base_url}/api/v1/rdses/{{ $rdse->id }}/resb?type={{ $type }}`, {
                        data: data
                    })
                    .then(response => {
                        savingMessage.innerHTML = 'Salvo com sucesso';

                        saveTimeout = setTimeout(() => {
                            savingMessage.classList.add('d-none');
                        }, 2000);

                    })
                    .catch(error => {
                        console.error('Erro ao salvar os dados:', error);
                        savingMessage.innerHTML = 'Erro ao salvar os dados';
                    }).finally(() => {});;
            }

            // Adiciona um evento que é chamado toda vez que a tabela é modificada
            hot.addHook('afterChange', (changes, source) => {
                if (source === 'loadData') {
                    return;
                }

                savingMessage.classList.remove('d-none');

                debounceSave(); // Chama a função debounce para salvar com atraso
            });

        });

        function redirectToType(type) {
            window.location.href = `resb?type=${type}`;
        }
    </script>

@append
