@extends('app')

@section('title', 'Obras')

@section('content-max-fluid')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-auto align-self-center">
                            <span class="pos-relative t-10">Agrupar por: </span>
                        </div>

                        <div class="col-md-3">
                            <label for="fl_art_nome">Cliente</label>
                            <select id="obra-select_client_id" name="client_id" class="form-control select2 search-input">
                                <option value="" selected>Selecione</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"> {{ $client->username }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="fl_art_nome">Concessionarias</label>
                            <select id="obra-select_concessionaria_id" name="concessionaria_id" multiple class="form-control select2 search-input">
                                <option value="" selected>Selecione</option>
                                @foreach ($concessionarias as $concessionaria)
                                    <option value="{{ $concessionaria->id }}"> {{ $concessionaria->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="fl_art_nome">Serviço</label>
                            <select id="obra-select_service_id" name="service_id" class="form-control select2 search-input">
                                <option value="" selected>Selecione</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}"> {{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-2">
                            <label for="obra-select_gestor">Gestor</label>
                            <select id="obra-select_gestor" name="gestor_id" class="form-control select2 search-input">
                                <option value="" selected>Selecione</option>
                                <option value="not"> Sem Gestor</option>
                                @foreach ($userGestorObras as $userGestor)
                                    <option value="{{ $userGestor->id }}"> {{ $userGestor->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 justify-content-end align-self-center mg-t-25">
                            <button class="btn btn-dark btn-empty-search">Limpar </button>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <div id="preloader-content" class="text-center">
                        <div class="spinner-border text-primary m-1 align-self-center" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>

                    <div class="table table-responsive d-none">
                        <div id="toolbar">
                            <div class="form-inline" role="form">
                                <div class="form-group mg-t-5">
                                    <div class="form-check form-check-inline">
                                        <input id="form-check-metodo_real" class="form-check-input wd-15 ht-15" name="urgence" type="checkbox" value="urgence">
                                        <label class="form-check-label" for="form-check-metodo_real">Com Urgência</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input id="form-check-favorites" class="form-check-input wd-15 ht-15" name="fav" type="checkbox" value="favorites">
                                        <label class="form-check-label" for="form-check-favorites">Meus Favoritos</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input id="form-check-arquivadas" class="form-check-input wd-15 ht-15" name="arq" type="checkbox" value="arquivadas">
                                        <label class="form-check-label" for="form-check-arquivadas">Arquivadas</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input id="obras_etapas_a_vencer" class="form-check-input wd-15 ht-15" name="obras_etapas_a_vencer" type="checkbox"
                                               value="true">
                                        <label class="form-check-label" for="obras_etapas_a_vencer">Etapas a Vencer</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input id="obras_etapas_vencidas" class="form-check-input wd-15 ht-15" name="obras_etapas_vencidas" type="checkbox"
                                               value="true">
                                        <label class="form-check-label" for="obras_etapas_vencidas">Etapas Vencidas</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input id="updated_at" class="form-check-input wd-15 ht-15" name="updated_at" type="checkbox" value="true">
                                        <label class="form-check-label" for="updated_at">Não Atualizadas</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input id="last_note" class="form-check-input wd-15 ht-15" name="last_note" type="checkbox" value="true">
                                        <label class="form-check-label" for="last_note">Sem N' Nota</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id="table-api" data-toggle="table" data-table="obras" data-search-text="" data-target="true">
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true" data-visible="false">#</th>
                                    <th data-field="razao_social" data-sortable="true">Nome Obra</th>
                                    <th data-field="clients.username" data-sortable="true">Cliente</th>
                                    <th data-field="concessionaria_name" data-sortable="true">Concessionaria</th>
                                    <th data-field="service.name">Serviço</th>
                                    <th data-field="concessionaria.service" data-visible="false">Concessionaria - Serviço</th>
                                    <th data-field="client.concessionaria.service" data-visible="false">Cliente - Concessionaria - Serviço</th>
                                    <th data-field="last_note" data-visible="false">Nº nota</th>
                                    <th data-field="created_at">Data de Criação</th>
                                    <th data-field="updated_at">Ultima Att</th>
                                    <th data-field="progressEtapas" data-formatter="progressFormatter">Etapas</th>
                                    <th data-field="observations" data-formatter="observationInput">Obs</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('components.myToDo')

        @include('pages.painel.obras._partials.modal-observations')
    </div>

@section('scripts')
    <script>
        $(function() {

            if (localStorage.getItem('obra-select_concessionaria_id')) {
                $('#obra-select_concessionaria_id').val(JSON.parse(localStorage.getItem('obra-select_concessionaria_id'))).trigger('change');
                initTable();
            }

            let time = null;
            $('.btn-empty-search').on('click', function() {
                $.each($('.search-input'), function() {
                    $(this).val('').trigger('change')
                });
            })

            $('.form-check-input').on('click', function() {
                $(this).is(':checked') ?
                    $(this).addClass('search-input') :
                    $(this).removeClass('search-input');

                initTable();
            })

            //$.each($('.search-input'), function() {
            //    var value = localStorage.getItem($(this).attr('id'))
            //    if (value != null) {
            //        $(this).val(value).trigger('change')
            //    }
            //});

            $('.search-input').on('change keyup', function() {
                const value = $(this).val();
                const id = $(this).attr('id');
                localStorage.setItem(id, JSON.stringify(value));
                clearTimeout(time);
                time = setTimeout(function() {
                    initTable();
                }, 1200);
            });
        })

        function progressFormatter(value, row) {
            return value;
        }

        function observationInput(value, row) {
            let rowValue = value === null ? '' : value;
            let haveClass = row.observations != null ? 'text-success' : 'text-primary';
            return `
                <a name="observations" type="button" class="${haveClass}"
                    onclick="openObservationModal(${row.id}, 'observations')">
                    <i class="fas fa-edit"></i>
                </a>
            `;
        }
    </script>
    @yield('modal-scripts')

@endsection

@yield('scripts_task')

@endsection
