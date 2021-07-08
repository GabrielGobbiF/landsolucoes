@extends("app")

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
                            <select name="client_id" id="select--client_id" class="form-control select2 search-input">
                                <option value="" selected>Selecione</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"> {{ $client->username }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="fl_art_nome">Concessionarias</label>
                            <select name="concessionaria_id" id="select--concessionaria_id" class="form-control select2 search-input">
                                <option value="" selected>Selecione</option>
                                @foreach ($concessionarias as $concessionaria)
                                    <option value="{{ $concessionaria->id }}"> {{ $concessionaria->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 justify-content-end align-self-center mg-t-25">
                            <button class="btn btn-dark btn-empty-search">Limpar </button>
                        </div>

                    </div>
                </div>

                <div class="card-body">
                    <div class="text-center" id="preloader-content">
                        <div class="spinner-border text-primary m-1 align-self-center" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>

                    <div class="table table-responsive d-none">
                        <div id="toolbar">
                            <div class="form-inline" role="form">
                                <div class="form-group mg-t-5">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input wd-15 ht-15" name="urgence" type="checkbox" value="urgence">
                                        <label class="form-check-label" for="metodo_real">Com Urgência</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input wd-15 ht-15" name="fav" type="checkbox" value="favorites">
                                        <label class="form-check-label" for="metodo_porcent">Meus Favoritos</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table data-toggle="table4" id="table-api4" data-table="obras4" data-search-text="nº nota, razão social">
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true" data-visible="false">#</th>
                                    <th data-field="razao_social" data-sortable="true">Razão Social</th>
                                    <th data-field="clients.username" data-sortable="true">Cliente</th>
                                    <th data-field="concessionaria_name" data-sortable="true">Concessionaria</th>
                                    <th data-field="service.name">Serviço</th>
                                    <th data-field="concessionaria.service" data-visible="false">Concessionaria - Serviço</th>
                                    <th data-field="client.concessionaria.service" data-visible="false">Cliente - Concessionaria - Serviço</th>
                                    <th data-field="last_note" data-visible="false">Nº nota</th>
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
@endsection
