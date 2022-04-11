@extends('app')

@section('title', "RDSE'S")

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-3">
                    <label>Status</label>
                    <select name="status" id="select--status" class="form-control select2 search-input">
                        @foreach (__trans('rdses.status_label') as $status => $text)
                            <option value='{{ $status }}'
                                {{ (!request()->filled('status') && $text == 'Em Medição'
                                        ? ' selected="selected"'
                                        : request()->filled('status') && request()->input('status') == $status)
                                    ? ' selected="selected"'
                                    : '' }}>
                                {{ $text }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="table table-api">
                <div class="table-responsive d-none">
                    <div id="toolbar">
                        <div class="form-inline" role="form">
                            <div class="btn-group mr-2">
                                <button type="button" data-toggle="modal" data-target="#modal-add-rdse" class="btn btn-dark waves-effect waves-light">
                                    <i class="ri-add-circle-line align-middle mr-2"></i> Novo
                                </button>
                                @php
                                    $state = 'pending';
                                @endphp
                                @if (request()->input('status') == 'pending')
                                    @php
                                        $state = 'approved';
                                    @endphp
                                    <button type="button" data-toggle="modal" data-target="#modal-finalize" class="btn btn-warning waves-effect waves-light">
                                        <i class="fas fa-archive"></i> Finalizar Medições
                                    </button>
                                @elseif(request()->input('status') == 'approved')
                                    @php
                                        $state = 'pending';
                                    @endphp
                                    <button type="button" data-toggle="modal" data-target="#modal-finalize" class="btn btn-info waves-effect waves-light">
                                        <i class="fas fa-archive"></i> Retirar Aprovações
                                    </button>
                                    <button type="button" data-toggle="modal" data-target="#modal-faturar" class="btn btn-warning waves-effect waves-light">
                                        <i class="fas fa-hand-holding-usd"></i> Faturar
                                    </button>
                                @endif
                            </div>
                        </div>

                    </div>
                    <table data-toggle="table" id="table-api" data-table="rdses" data-on-click="true">
                        <thead class="thead-light">
                            <tr>
                                <th data-field="id" data-sortable="true" data-visible="false">#</th>
                                <th data-field="n_order" data-sortable="true">Nº Ordem</th>
                                <th data-field="description">Descrição</th>
                                <th data-field="equipe" data-sortable="true">Equipe</th>
                                <th data-field="solicitante" data-sortable="true">Solicitante</th>
                                <th data-field="at" data-sortable="true">Data</th>
                                <th data-field="type" data-sortable="true">Tipo</th>
                                <th data-field="status_label">Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class='modal modal-rdse-status' id='modal-finalize' tabindex='-1' role='dialog'>
        <div class='modal-dialog  modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <form id='form-update-status' role='form' class='needs-validation' action='{{ route('rdse.update.status', [$state]) }}' method='POST'>
                    @csrf
                    @method('put')
                    <div class='modal-header'>
                        <h5 class='modal-title'>Escolha as medições</h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    <div class='modal-body'>
                        <select name='medicoes[]' class='form-control select2 medicoes'></select>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-primary btn-submit'>Enviar</button>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class='modal modal-rdse-status' id='modal-faturar' tabindex='-1' role='dialog'>
        <div class='modal-dialog  modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <form id='form-update-status' role='form' class='needs-validation' action='{{ route('rdse.update.status', ['invoice']) }}' method='POST'>
                    @csrf
                    @method('put')
                    <div class='modal-header'>
                        <h5 class='modal-title'>Escolha as medições para faturar</h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    <div class='modal-body'>
                        <select name='medicoes[]' class='form-control select2 medicoes'></select>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-primary btn-submit'>Faturar</button>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('pages.painel._partials.modals.modal-add', ['redirect' => 'rdse.index', 'type' => 'rdse'])

@endsection

@section('scripts')
    <script>
        $('#select--status').on('change', function() {
            let state = $(this).val();
            window.location.href = `${base_url}/rdse/rdse?status=${state}`;
        })

        $('.modal-rdse-status').on("show.bs.modal", function() {
            let modal = $(this);
            modal.find('.select2').each(function() {
                $(this).select2({
                    multiple: true,
                    minimumInputLength: 3,
                    language: "pt-br",
                    closeOnSelect: false,
                    dropdownParent: $(`#${modal.attr('id')} .modal-content`),
                    formatNoMatches: function() {
                        return "Pesquisa não encontrada";
                    },
                    inputTooShort: function() {
                        return "Digite para Pesquisar";
                    },
                    ajax: {
                        url: `${base_url}/v1/api/rdses`,
                        dataType: 'json',
                        data: function(term, page) {
                            return {
                                search: term, //search term
                                filter: {
                                    status: `{{ request()->input('status') ?? 'pending' }}`,
                                }
                            };
                        },
                        processResults: function(data, page) {
                            var myResults = [];
                            $.each(data.data, function(index, item) {
                                myResults.push({
                                    'id': item.id,
                                    'text': `${item.n_order} - ${item.description}`,
                                });
                            });
                            return {
                                results: myResults
                            };
                        }
                    },
                    escapeMarkup: function(m) {
                        return m;
                    }
                })
            })
        })
    </script>
@append
