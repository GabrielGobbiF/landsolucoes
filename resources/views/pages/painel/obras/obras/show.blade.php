@extends("app")

@section('title', ucfirst($obra->razao_social) . ' - ' . $obra->last_note)

@section('content-max-fluid')

    <div class="page--obra">

        <div class="obr-menu filemgr-wrapper">
            <div class="filemgr-sidebar" data-simplebar="">
                <div class="col-12">
                    <div class="box-body">
                        <dl class="row mb-0 mg-t-15">

                            <input type="hidden" id="input--obra_id" value="{{ $obra->id }}">

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input--razao_social">Obra</label>
                                    <input type="text" name="razao_social" class="form-control @error('razao_social') is-invalid @enderror" id="input--razao_social"
                                        value="{{ $obra->razao_social ?? old('razao_social') }}" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input--concessionaria">Concessionaria</label>
                                    <input type="text" name="concessionaria" class="form-control" readonly disabled id="input--concessionaria" value="{{ $obra->concessionaria->name }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input--service">Tipo de Obra / Serviço</label>
                                    <input type="text" name="service" class="form-control" readonly disabled id="input--service" value="{{ $obra->service->name }}">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="input--build_at">Data</label>
                                    <input type="text" name="build_at" class="form-control" id="input--build_at" value="{{ old('build_at') ?? $obra->build_at }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input--description">Descrição</label>
                                    <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" id="input--description"
                                        value="{{ $obra->description ?? old('description') }}" autocomplete="off">
                                </div>
                            </div>
                        </dl>
                    </div>
                </div>


                <div class="col-12">
                    <div class="box-body">

                        <div class='card'>
                            <div class='card-header'>
                                <h4 class='card-title'></h4>
                                <h4 class='card-title'></h4>
                                <h4 class='card-title'></h4>
                                <h4 class='card-title'></h4>
                                <h4 class='card-title'></h4>
                            </div>
                            <div class='card-body'>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid" style="max-width: 49% !important;">
            <div class="obr-etapa">
                <div class="box box-default box-solid">
                    <div class="col-md-12">
                        <div class="box-header with-border">
                            <h3 class="box-title text-center">Etapas</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12 mg-0 pd-0">
                                    <ul class="message-list" style="    padding: 5px 0px 0px 1px;">
                                        @foreach ($etapas as $etapa)
                                            <li>
                                                <div class="col-mail col-mail-1">
                                                    <div class="checkbox-wrapper-mail">
                                                        <input type="checkbox" id="chk20">
                                                        <label for="chk20" class="toggle"></label>
                                                    </div>
                                                    <a href="javascript:void(0)" data-id="{{ $etapa->id }}" class="title right-bar-etp-toggle">{{ $etapa->nome }}</a>
                                                </div>
                                                <div class="col-mail col-mail-2" style="    ">
                                                    <span class="badge-warning badge mr-2"></span>
                                                    <span class="teaser"></span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="obr-documento">
            <div class='card'>
                <div class='card-header'>
                    <h4 class='card-title'></h4>
                </div>
                <div class='card-body'>
                </div>
            </div>
        </div>

    </div>

    @include('pages.painel.obras.obras.etapas.show_right')


@section('scripts')
    <script>
        var obra_id = $('#input--obra_id').val();
        const BASE_URL_API_OBRA = BASE_URL_API + 'obra/' + obra_id + '/'

        $(document).ready(function() {

            showEtapa(89)

            $('.right-bar-etp-toggle').on('click', function(e) {
                showEtapa($(this).attr('data-id'))
            });

            $(document).on('click', 'body', function(e) {
                if ($(e.target).closest('.right-bar-etp-toggle, .right-bar-etp, .col-mail-1').length > 0) {
                    return;
                }

                $('body').removeClass('right-bar-etp-enabled');
                return;
            });
        })

        function getEtapas() {

        }

        function showEtapa(etp_id) {
            const BASE_URL_API_OBRA_ETAPA = BASE_URL_API + 'obra/' + obra_id + '/etapa/' + etp_id

            $('body').addClass('right-bar-etp-enabled');
            $('#preloader-content-etp').removeClass('d-none');
            $('.etp').addClass('d-none');

            $.ajax({
                url: BASE_URL_API_OBRA + "etapa/" + etp_id,
                type: 'GET',
                ajax: true,
                dataType: "JSON",
                success: function(j) {
                    var data = j.data;
                    var $modal = $('.right-bar-etp');

                    $modal.find('#js-etapa-id').val(etp_id)
                    $modal.find('.box-title').html(data.name);
                    $modal.find('#preloader-content-etp').addClass('d-none');
                    $modal.find('.etp').removeClass('d-none');

                    $modal.find('.js-textarea-description').html(data.observacao)
                    $modal.find('.js-input-etapa-n-nota').html(data.n_nota)

                },
            });

            /* Configurações Mudar  */
            $.fn.editable.defaults.mode = 'inline';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.js-input-etapa-n-nota').editable({
                pk: 'nota_numero',
                url: BASE_URL_API_OBRA_ETAPA,
            })

            $('.js-edit-description').click(function(e) {
                e.stopPropagation();

                var btnEdit = $(this);
                btnEdit.addClass('d-none')

                $('.js-textarea-description', this.$e).editable({
                    pk: 'observacao',
                    url: BASE_URL_API_OBRA_ETAPA,
                    success: function(response, newValue) {
                        $(this).html(newValue); //update backbone model
                    }
                }).editable('toggle');

                $('.js-textarea-description').editable().on('hidden', function(e, params) {
                    $('.js-textarea-description').editable('destroy');
                    if (params == "cancel") {
                        btnEdit.removeClass('d-none')
                    }
                    btnEdit.removeClass('d-none')
                });

            })

        }
    </script>
@endsection

@stop
