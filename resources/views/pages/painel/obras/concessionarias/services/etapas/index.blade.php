@extends('app')

@section('title', $concessionaria->name . ' x ' . $service->name)

@section('content-max-fluid')

    <div class="box-body  pd-t-0">
        <div class="box box-default  pd-2">
            <div class="box-header with-border">
                <h3 class="box-title">Etapas</h3>
            </div>
            <div class="box-body">
                <div class="col-md-3">
                    <label for="">Selecione o Tipo</label>
                    <select id="tipo" name="tipo" class="form-control select2">
                        <option value="" selected>Selecione</option>
                        @foreach ($tipos as $tipo)
                            <option {{ Request::input('tipo') == $tipo->id ? ' selected="selected"' : '' }} value="{{ $tipo->id }}">
                                {{ ucfirst(mb_strtolower($tipo->name, 'UTF-8')) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div id="div-etapas" class="box-body d-none">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input id="search-etapa" type="text" class="form-control form-group" name="search-etapa" value="" placeholder="Pesquisar">
                        </div>
                    </div>
                    <div class="col-md-3 mb-2" style="text-align: -webkit-right;">
                        <button class="btn btn-primary btn-new-store"></button>
                    </div>
                </div>

                <div class="box-body no-padding table-responsive d-none" style="max-height: 293px;overflow-x: hidden !important;">
                    <table id="table-etapas" class="table table-hover">
                        <tbody>
                            <tr>
                                <th class="text-center " width="8%">Ação</th>
                                <th>#</th>
                                <th width="50%">Etapa</th>
                                <th>Tipo</th>
                                <th></th>
                            </tr>
                        </tbody>
                        <tbody id="results-table"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="div-etapas-in-con-sev" class="mg-0 d-none" style="display: inline-flex;overflow-x: scroll; width: 100%;"></div>

    @include('pages.painel._partials.modals.modal-new-etapa', [
        'redirect' => route('concessionaria.service', [$concessionaria->slug, $service->slug]),
    ])



@endsection

@section('scripts')
    <script src="{{ asset('panel/js/pages/etapas.js') }}"></script>
    <script>
        const BASE_URL_API = $('meta[name="js-base_url_api"]').attr('content');
        const BASE_URL = $('meta[name="js-base_url"]').attr('content');
        const URL = $('meta[name="url"]').attr('content');

        let selectCategoria = $('#select--categoria');
        let selectSubCategoria = $('#select--sub_categoria');

        $(document).ready(function() {
            initDiv();
            initEtapas();

            $('#tipo').on('change', function() {
                initDiv();
            })

            $('#tipo').select2({
                width: '100%',
                placeholder: 'Selecione',
                language: {
                    noResults: function() {
                        return `<a href="javascript:void(0)" onclick="add_tipo()" style="padding: 6px;height: 20px;display: inline-table;">Sem resultados, Adicionar um novo?</a>`;
                    },
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
            });

            $('.btn-new-store').on('click', function() {
                var $modal = $('#modal-add-update-etapa')
                var $btnStore = $(this);
                var $tipo_id = $btnStore.attr('data-tipo-id');
                var $tipo_name = $btnStore.attr('data-tipo-name');
                $modal.find('.modal-etapa-title').html('Adicionar Etapa "' + $tipo_name + '"');
                $modal.find('#input--tipo_id').val($tipo_id);
                $modal.find('input[name="_method"]').val('post');
                $modal.find('.modal-btn-primary').html('Adicionar');
                $modal.find('#form-add-update-etapa').attr('action', BASE_URL + '/l/etapas')
                $modal.find('#form-add-update-etapa')[0].reset();

                selectCategoria.val('Elétrica').trigger('change')
                selectSubCategoria.empty();

                $('#new_variavel_edit').html('')
                $('#variavel_etapa').html('')
                if ($tipo_name == 'Compra') {
                    $modal.find('.compra').removeClass('d-none');
                } else {
                    $modal.find('.compra').addClass('d-none');
                }
                $modal.modal('show');
            })

            $('.btn-new_variavel_edit').on('click', function() {
                var html = '<div class="row mg-0" >'
                html += '    <input type="hidden" value="" name="variavel[id][]">'
                html += '    <div class="col-md-6">'
                html += '        <div class="form-group" style="margin-right: 26px;margin-left: -10px;">'
                html += '            <label>Nome da Variavel</label>'
                html +=
                    '            <input type="text" class="form-control" value="" name="variavel[nome_variavel][]" id="nome_variavel" autocomplete="off">'
                html += '        </div>'
                html += '    </div>'
                html += '    <div class="col-md-2">'
                html += '        <div class="form-group"  style="margin-right: 26px;margin-left: -10px;">'
                html += '            <label>Preço</label>'
                html +=
                    '            <input type="text" class="form-control money" name="variavel[preco_variavel][]" value="" id="preco_variavel" autocomplete="off">'
                html += '        </div>'
                html += '    </div>'
                $('#new_variavel_edit').append(html);
            });

            $("#form-add-update-etapa").submit(function(event) {
                event.preventDefault();
                $('.btn-primary').attr('disabled', true);
                var post_url = $('#form-add-update-etapa').attr("action");
                var request_method = $('#form-add-update-etapa').attr("method");
                var form_data = new FormData($('#form-add-update-etapa')[0]);
                $.ajax({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: post_url,
                    type: request_method,
                    data: form_data,
                    processData: false,
                    cache: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        console.log('resposne:' + response);
                        if (response.success) {
                            $('.btn-primary').attr('disabled', false);
                            if (response.edit) {
                                edit_etapa(response.id);
                            } else {
                                $('#form-add-update-etapa')[0].reset();
                            }
                            initEtapas();
                            initTableEtapas();
                            toastr.success('Sucesso!')
                        } else {
                            toastr.error('Deu erro meu chama!')
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        toastr.error(thrownError);
                    }
                });
            });

        })

        function initTableEtapas() {
            var data = $('#tipo').select2('data');
            var value = data[0].id;
            var search = $('#search-etapa').val();
            var con_id = `{{ $concessionaria->id }}`
            var serv_id = `{{ $service->id }}`
            $.ajax({
                url: `{{ route('etapas.all') }}`,
                type: 'GET',
                ajax: true,
                data: {
                    tipo: value,
                    search: search,
                    con_id: con_id,
                    serv_id: serv_id,
                },
                dataType: 'JSON',
                success: function(data) {
                    var options = '';
                    if (data.length != 0) {
                        $.each(data.data, function(index, value) {
                            options += '<tr>';
                            options += '    <td class="text-center"><i class="fa fa-edit" onclick="edit_etapa(' + value.id + ')"></i></td>';
                            options += '    <td>' + value.id + '</td>';
                            options += '    <td>' + value.name + '</td>';
                            options += '    <td>' + value.tipo + '</td>';
                            options +=
                                '<td class="buttons"><button onclick="this.disabled = true;add_to_conService(' + value.id +
                                ', this)" class="btn btn-sm btn-dark"><i class="fas fa-arrow-right"></i> <span class="mobile--hidden"> adicionar</span></button></td>';
                            options += '</tr>';
                        });
                    }
                    $('#results-table').html(options);
                    $('#preloader-content-table').addClass('d-none');
                    $('.table-responsive').removeClass('d-none');
                    $('#div-etapas').removeClass('d-none');
                },
            });
        }

        function initEtapas() {
            var con_id = `{{ $concessionaria->id }}`
            var serv_id = `{{ $service->id }}`
            var url = BASE_URL + '/l/api/concessionarias/' + con_id + '/service/' + serv_id + '/etapas/all'
            $.ajax({
                url: url,
                type: 'GET',
                ajax: true,
                dataType: "JSON",
                success: function(data) {
                    var options = '';
                    if (data.length != 0) {
                        $.each(data, function(index, value) {
                            options += '<div class="col-12 col-md-3 pd-0">'
                            options += '    <div class="box-body  pd-t-0">'
                            options += '        <div class="box box-default ">'
                            options += '            <div class="box-header with-border">'
                            options += '                <h3 class="box-title">' + index + '</h3>'
                            options += '            </div>'
                            options += '            <div class="box-body">'
                            options += '                <ul class="todo-list ui-sortable lista" data-tipo-id="1">'
                            $.each(value, function(index, value) {
                                options += '                        <li id="' + value.id + '">'
                                options += '                            <i class="fa fa-ellipsis-v"></i>'
                                options += '                            <span data-toggle="tooltip" data-placement="top" title="' +
                                    value.name + '" class="text">' + value
                                    .name_max + '</span>'
                                options += '                            <div class="tools">'
                                options += '                                <i class="fa fa-edit" onclick="edit_etapa(' + value.id +
                                    ')"></i>'
                                options += '                                <i class="fas fa-trash" onclick="destroy_to_conService(' +
                                    value.id + ')"></i>'
                                options += '                            </div>'
                                options += '                        </li>'
                            });
                            options += '                </ul>'
                            options += '            </div>'
                            options += '        </div>'
                            options += '    </div>'
                            options += '</div>'
                        });
                    }
                    $('#div-etapas-in-con-sev').html(options);
                    $('#div-etapas-in-con-sev').removeClass('d-none');

                    $(".lista").sortable({
                        update: function() {
                            var con_id = `{{ $concessionaria->id }}`
                            var serv_id = `{{ $service->id }}`
                            var ordem_atual = $(this).sortable("toArray");
                            $('.save').removeClass('d-none').html('salvando...');
                            var url = BASE_URL + '/l/concessionarias/' + con_id + '/service/' + serv_id + '/etapas/reorder'
                            $.ajax({
                                headers: {
                                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: url,
                                type: 'POST',
                                ajax: true,
                                dataType: "JSON",
                                data: {
                                    itens: ordem_atual
                                }
                            }).done(function(response) {
                                if (response) {
                                    $('.save').removeClass('d-none').html('salvo')
                                    toastr.success('ordenado com sucesso!')
                                } else {
                                    toastr.error('deu erro, me chama')
                                }
                            });
                        }
                    });
                },
            });
        }

        function initDiv() {
            var data = $('#tipo').select2('data');
            var html = data[0].text;
            var id = data[0].id;
            if (html != '' && id != '') {
                $('.btn-new-store').html('Nova Etapa "' + html + '"')
                $('.btn-new-store').attr('data-tipo-id', id)
                $('.btn-new-store').attr('data-tipo-name', html)
                initTableEtapas()
            } else {
                $('#div-etapas').addClass('d-none');
            }
        }

        function add_tipo(name = '') {
            var name = name == '' ? $("#tipo").data("select2").dropdown.$search.val() : name;
            if (name != '') {
                $.ajax({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `{{ route('etapas.tipo.store') }}`,
                    type: 'POST',
                    data: {
                        name: name,
                    },
                    dataType: 'json',
                    success: function(json) {
                        var option = new Option(name, json.data.id, true, true);
                        $("#tipo").append(option).trigger('change').trigger('close');
                        $('#tipo').select2('close');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        toastr.error(thrownError);
                    }
                });
            }
        }

        function add_to_conService(id, v) {
            $(v).attr("disabled", true);
            var con_id = `{{ $concessionaria->id }}`
            var serv_id = `{{ $service->id }}`
            var url = BASE_URL + '/l/concessionarias/' + con_id + '/service/' + serv_id + '/etapas/store'
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'POST',
                data: {
                    etapa_id: id,
                },
                dataType: 'json',
                success: function(response) {
                    initDiv();
                    initEtapas();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    toastr.error(thrownError);
                }
            });
        }

        function destroy_to_conService(id) {
            var con_id = `{{ $concessionaria->id }}`
            var serv_id = `{{ $service->id }}`
            var url = BASE_URL + '/l/concessionarias/' + con_id + '/service/' + serv_id + '/etapas/destroy'
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'POST',
                data: {
                    etapa_id: id,
                },
                dataType: 'json',
                success: function(response) {
                    initDiv();
                    initEtapas();
                    toastr.success('Retirado');

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    toastr.error(thrownError);
                }
            });
        }

        function edit_etapa(id) {



            $.ajax({
                url: BASE_URL + '/l/etapas/' + id,
                type: 'GET',
                ajax: true,
                dataType: 'JSON',
                success: function(data) {
                    var j = data.data



                    var $modal = $('#modal-add-update-etapa');
                    $modal.find('#form-add-update-etapa').attr('action', BASE_URL + '/l/etapas/' + id)
                    $modal.find('.modal-etapa-title').html('Editar Etapa "' + j.name + '"');
                    $modal.find('input[name="_method"]').val('put');
                    $modal.find('.modal-btn-primary').html('Salvar');
                    $('#new_variavel_edit').html('')
                    $('#variavel_etapa').html('')
                    if (j.tipo == 'Compra') {
                        $modal.find('.compra').removeClass('d-none');
                    } else {
                        $modal.find('.compra').addClass('d-none');
                    }
                    $.each(j, function(index, value) {
                        $modal.find('#input--' + index).val(value)
                    })

                    if (j.categoria != '' && j.categoria != null) {
                        selectCategoria.val(j.categoria);
                        selectCategoria.trigger('change');
                    }

                    categoria(j.sub_categoria);

                    if (j.variables.length > 0) {
                        $.each(j.variables, function(index, value) {
                            var html = '<div class="row mg-0" >'
                            html += '    <input type="hidden" value="' + value.id + '" name="variavel[id][]">'
                            html += '    <div class="col-md-6">'
                            html += '        <div class="form-group" style="margin-right: 26px;margin-left: -10px;">'
                            html += '            <label>Nome da Variavel</label>'
                            html += '            <input type="text" class="form-control" value="' + value.name +
                                '" name="variavel[nome_variavel][]" id="nome_variavel_' + value.id +
                                '" autocomplete="off">'
                            html += '        </div>'
                            html += '    </div>'
                            html += '    <div class="col-md-2">'
                            html += '        <div class="form-group"  style="margin-right: 26px;margin-left: -10px;">'
                            html += '            <label>Preço</label>'
                            html += '            <input type="text" class="form-control money" name="variavel[preco_variavel][]" value="' +
                                value.price + '" id="preco_variavel_' +
                                value.id + '" autocomplete="off">'
                            html += '        </div>'
                            html += '    </div>'
                            html += '   <div class="col-md-2 align-self-center">';
                            html += '       <i style="cursor: pointer" class="fas fa-trash" onclick="destroy_variable(' + value.id + ', ' + j
                                .id + ')"></i>';
                            html += '   </div>';

                            $('#variavel_etapa').append(html);
                        })
                    }

                    const parentModel = 'App\\Models\\Etapa';
                    const parentId = id;
                    document.getElementById('button-add-new-file').setAttribute('data-parentModel', parentModel);
                    document.getElementById('button-add-new-file').setAttribute('data-parentId', parentId);
                    $('#etapa_id').val(id);
                    initResumable(parentModel, parentId);

                    initFetchEtapaDocumentos(id)

                    $modal.modal('show');
                },
            });
        }

        let resumableEtapa = null;

        function initResumable(parentModel, parentId) {
            if (resumableEtapa) {
                resumableEtapa.cancel();
                resumableEtapa.opts.query = function() {
                    return {
                        _token: '{{ csrf_token() }}',
                        parent_model: parentModel,
                        parent_id: parentId,
                    };
                };
                return;
            }

            // Cria uma nova instância se ainda não existir
            resumableEtapa = new Resumable({
                target: '/api/v1/upload',
                query: function() {
                    return {
                        _token: '{{ csrf_token() }}',
                        parent_model: parentModel,
                        parent_id: parentId,
                    };
                },
                chunkSize: 10 * 1024 * 1024, // Tamanho do chunk em bytes
                headers: {
                    'Accept': 'application/json',
                },
                testChunks: false,
                throttleProgressCallbacks: 1,
            });

            resumableEtapa.assignBrowse(document.getElementById('button-add-new-file'));

            resumableEtapa.on('fileAdded', function(file) {
                showProgress();
                resumableEtapa.upload();
            });

            resumableEtapa.on('fileProgress', function(file) {
                updateProgress(Math.floor(file.progress() * 100));
            });

            resumableEtapa.on('fileSuccess', function(file, response) {});

            resumableEtapa.on('fileError', function(file, response) {
                toastr.error('Erro ao enviar o arquivo.');
                hideProgress();
            });

            resumableEtapa.on('complete', function() {
                toastr.success('Arquivo enviado com sucesso!');
                initFetchEtapaDocumentos($('#etapa_id').val());
                hideProgress();
            });

            let progress = $('.progress');

            function showProgress() {
                progress.find('.progress-bar').css('width', '0%');
                progress.find('.progress-bar').html('0%');
                progress.find('.progress-bar').removeClass('bg-success');
                progress.show();
            }

            function updateProgress(value) {
                progress.find('.progress-bar').css('width', `${value}%`);
                progress.find('.progress-bar').html(`${value}%`);
            }

            function hideProgress() {
                progress.hide();
            }
        }


        function destroy_variable(variable_id, etapa_id) {
            var url = BASE_URL + '/l/variables/' + variable_id + '/destroy'
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'DELETE',
                dataType: 'json',
                success: function(response) {
                    edit_etapa(etapa_id);
                    toastr.success('Deletado');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    toastr.error(thrownError);
                }
            });
        }

        function dettach_etapa(id) {
            alert(id)
        }

        selectCategoria.on('change', function() {
            categoria();
        })

        function categoria(sub_categoria) {
            var categoria = selectCategoria.val();

            if (categoria != '' && categoria != null) {
                $.ajax({
                    url: `${base_url}/api/v1/categories/${categoria}?sub-categories=1`,
                    type: "GET",
                    ajax: true,
                    dataType: "JSON",
                    success: function(j) {

                        selectSubCategoria.empty()
                        selectSubCategoria.prepend('<option selected value="">Selecione</option>').select2();

                        $.each(j.data.sub_categories, function(k, field) {
                            var newOption = new Option(field.name, field.name, false, false);
                            selectSubCategoria.append(newOption);
                        });

                        if (sub_categoria != '') {
                            selectSubCategoria.val(sub_categoria);
                            selectSubCategoria.trigger('change');
                        }
                    },
                });
            }
        }

        const preloader = document.getElementById('preloader');
        const documentsTable = document.getElementById('documents-section');
        const documentsTableBody = documentsTable.querySelector('.row');

        const initFetchEtapaDocumentos = async (etapaId) => {
            documentsTableBody.innerHTML = preload('preload-etapas-documents');
            setEtapaDocumentosInDom(etapaId);
        }

        const setEtapaDocumentosInDom = async (etapaId) => {
            const documents = await getEtapaDocumentos(etapaId);
            documentsTableBody.innerHTML = '';
            documentsTableBody.innerHTML += documents.data.map((data) =>
                `<div class="col-6 col-sm-3 col-md-3">
                            <div id="card-file" class="card card-file">
                                <div class="dropdown-file" style="position: absolute;right: 4px;top: 8px;">
                                    <a class="dropdown-link" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button type="button" class="dropdown-item delete" onclick="deleteFile(${data.id}, ${etapaId})">
                                            <i class="fas fa-trash mr-2"></i>Deletar
                                        </button>
                                        <a target="_blank" class="dropdown-item" href="${data.path}">Visualizar</a>
                                        <a target="_blank" download class="dropdown-item" href="${data.path}">Baixar </a>
                                    </div>
                                </div>
                                <div class="card-file-thumb">
                                <i class="far fas fa-file" style="color:#d43030"></i>
                            </div>
                            <div class="card-body">
                                <span>${data.name}</span>
                            </div>
                        </div>
                    </div>
                `).join(' ');
        }

        const getEtapaDocumentos = async (etapaId) => {
            return await axios.get(`/api/v1/etapas/${etapaId}/get-files`)
                .then(function(response) {
                    return response.data;
                })
                .catch(function(error) {
                    toastr.error(error.response.data.message);
                });
        }

        async function deleteFile(fileId, etapaId) {
            if (!confirm('Tem certeza que deseja excluir este arquivo?')) return;

            try {
                await axios.delete(`/api/v1/uploadeds/${fileId}`);
                toastr.success('Deletado com sucesso');
                initFetchEtapaDocumentos(etapaId);
            } catch (error) {
                console.error('Erro ao deletar arquivo:', error);
                toastr.error('Não foi possivel Deletar');
            }
        }
    </script>
@append
