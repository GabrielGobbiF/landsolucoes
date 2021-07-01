@extends("app")

@section('title', ucfirst($obra->razao_social) . ' - ' . $obra->last_note)

@section('content-max-fluid')

    <div class="page--obra">

        <div class="vertical-menu-obr">
            <div data-simplebar class="h-100">
                <div id="sidebar-menu">
                    <div class="col-12">
                        <div class="box-body">

                            <input type="hidden" id="input--obra_id" value="{{ $obra->id }}">

                            <div class="row">
                                <h4 class="col-12 mb-3">Obra <small class="text-muted js-input-obra-name editable">{{ $obra->razao_social ?? '' }}</small></h4>
                                <h6 class="col-12 mb-3 d-flex tx-18"> <i class="ri-community-line mr-2"></i> {{ $obra->concessionaria->name ?? '' }}</h6>
                                <h6 class="col-12 mb-3 d-flex tx-18"> <i class="ri-git-repository-private-fill mr-2"></i> {{ $obra->service->name ?? '' }}</h6>
                                <h6 class="col-12 mb-3 d-flex tx-18"> <i class="ri-calendar-event-line mr-2"></i> {{ return_format_date($obra->build_at, 'pt', '/') ?? '' }}</h6>

                                <div class="col-12 mt-4">
                                    <div class="form-group">
                                        <label for="input--description">Descrição da Obra</label>
                                        <textarea type="text" name="description" class="form-control">{{ $obra->description ?? '' }}</textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="input--description">Informações Importantes</label>
                                        <textarea type="text" name="description" class="form-control">{{ $obra->obr_informacoes ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>


                            <div class="d-none">
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
                            </div>
                        </div>


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
                                    <ul class="message-list" style="padding: 5px 0px 0px 1px;">
                                        @foreach ($etapas as $etapa)
                                            <li>
                                                <div class="col-mail col-mail-1">
                                                    <div class="checkbox-wrapper-mail">
                                                        <input type="checkbox" class="js-btn-status" {{ $etapa->check == 'C' ? 'checked' : '' }} onclick="updateStatus(this)"
                                                            id="chk{{ $etapa->id }}"
                                                            data-id={{ $etapa->id }}>
                                                        <label for="chk{{ $etapa->id }}" class="toggle"></label>
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

            $('.right-bar-etp-toggle').on('click', function(e) {
                showEtapa($(this).attr('data-id'))
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

                    $modal.find('.etapas-comments').html('');

                    if (data.comments.length > 0) {
                        var options = '';
                        $.each(data.comments, function(index, value) {
                            options += '<div class="media mt-4">';
                            options += '<div class="avatar-sm font-weight-bold d-inline-block">'
                            options += '    <span class="avatar-title rounded-circle bg-soft-purple tx-14">'
                            options += value.user
                            options += '    </span>'
                            options += '</div>'
                            options += '    <div class="media-body overflow-hidden ml-2">';
                            options += '        <h5 class="text-truncate mb-1 tx-14 ">' + value.user_name + '</h5>';
                            options += '        <p class="text-truncate mb-0 text-wrap-content">' + value.text + '</p>';
                            options += '    </div>';
                            options += '    <div class="font-size-11">' + value.date + '</div>';
                            options += '</div>';
                        });

                        $modal.find('.etapas-comments').html(options);
                    }

                },
            });

            /* Configurações Mudar  */

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
            /* Configurações Mudar  */

        }

        function newComment() {
            var input = $('#input-new-comment').val();
            var obra_id = $('#input--obra_id').val();
            var etp_id = $('#js-etapa-id').val();
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                url: BASE_URL_API + 'obra/' + obra_id + '/etapa/' + etp_id + '/comment/store ',
                type: 'POST',
                ajax: true,
                dataType: "JSON",
                data: {
                    obs_texto: input
                }
            }).done(function(response) {
                $('#input-new-comment').val('')
                showEtapa(etp_id);
            });
        }

        function updateStatus(v) {
            var obra_id = $('#input--obra_id').val();
            var etp_id = $(v).attr('data-id');
            var value = $(v).is(":checked") ? 'C' : 'EM';
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                url: BASE_URL_API + 'obra/' + obra_id + '/etapa/' + etp_id + '/status',
                type: 'POST',
                ajax: true,
                dataType: "JSON",
                data: {
                    check: value
                }
            })

        }
    </script>
@endsection

@stop
