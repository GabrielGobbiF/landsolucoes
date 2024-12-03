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
                            <select id="obra-select_concessionaria_id" name="concessionaria_id" class="form-control select2 search-input">
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
                                        <input id="form-check-metodo_porcent" class="form-check-input wd-15 ht-15" name="fav" type="checkbox" value="favorites">
                                        <label class="form-check-label" for="form-check-metodo_porcent">Meus Favoritos</label>
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
                                        <label class="form-check-label" for="obras_etapas_vencidas">Etapas Vencidadas</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input id="updated_at" class="form-check-input wd-15 ht-15" name="updated_at" type="checkbox"
                                               value="true">
                                        <label class="form-check-label" for="updated_at">Não Atualizadas</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input id="last_note" class="form-check-input wd-15 ht-15" name="last_note" type="checkbox"
                                               value="true">
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
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('components.myToDo')
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
    </script>
@endsection

@yield('scripts_task')

@endsection
