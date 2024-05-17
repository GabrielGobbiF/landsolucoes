@extends('app')

@section('title', 'Motoristas')

@section('content')

    <div class="card">

        {{--
        <div class="card-body">
            <div class="row">

                <div class="col-auto align-self-center">
                    <span class="pos-relative t-10">Agrupar por: </span>
                </div>

                <div class="col-md-3">
                    <label for="fl_art_nome">Data</label>
                    <input id="input--at" type="date" name="drive_at" class="form-control search-input">
                </div>

                <div class="col-md-3 justify-content-end align-self-center mg-t-25">
                    <a href="{{ route('drivers.index') }}" class="btn btn-dark btn-empty-search">Limpar </a>
                </div>

            </div>
        </div>
--}}

        <div class="card-body">
            <div class="table table-api">
                <div id="toolbar">
                    <div class="form-inline" role="form">
                        <div class="btn-group mr-2">
                            <button data-toggle="modal" data-target="#modal-add-drivers" class="btn btn-dark"><i class="fas fa-truck"></i>
                                Novo Motorista
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive d-none">
                    <table id="table-api" data-toggle="table" data-table="drivers">
                        <thead class="thead-light">
                            <tr>
                                <th data-field="id" data-sortable="true" data-visible="false">#</th>
                                <th data-field="name">Nome</th>
                                <th data-field="cnh_number">CNH</th>
                                <th data-field="cnh_validity">CNH Validade</th>
                                <th data-field="cnh_category">CNH Categoria</th>
                                <th data-field="cpf" data-visible="false">CPF</th>
                                <th data-field="re">RE</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('pages.painel._partials.modals.modal-add', ['redirect' => 'drivers.index', 'type' => 'drivers'])

@endsection

@section('scripts')
    <script>
        $(function() {
            $('.search-input').on('change keyup', function() {
                time = setTimeout(function() {
                    initTable();
                }, 1200);
            });
        })
    </script>
@append
