@extends('pages.painel.rh.app')

@section('title', 'Empresa')

@section('content')

    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h1 class="h2">Documentos da Empresa</h1>
            <div class="tollbar btn-toolbar mb-2 mb-md-0 float-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal--insert--document">
                    <i class="fas fa-plus"></i>
                    Novo
                </button>
            </div>
        </div>

        <table class="table">
            <tbody>
                @foreach ($documentos as $documento)
                    <tr data-id="{{ $documento->id }}" data-name="{{ $documento->name }}" data-type="documentos">
                        <th style="width: 44%"> <span data-toggle="tooltip" title="">
                                {{ $documento->description ?? '' }}</span>
                        </th>
                        <th class="text-center">
                            <div class="form-group">
                                <div class="radio">
                                    <label style="margin-right:5px">
                                        <input type="radio" data-collumn="status"
                                            onclick="updateCompanyAuditoryMonth(this,'company')"
                                            name="status_{{ $documento->id }}" id="option_sim_{{ $documento->id }}"
                                            value="1" {{ $documento->status == '1' ? 'checked' : '' }} />
                                        Sim
                                    </label>

                                    @if ($documento->status != '1')
                                        <label>
                                            <input type="radio" data-collumn="status" name="status_{{ $documento->id }}"
                                                id="option_nao_{{ $documento->id }}" value="0"
                                                {{ $documento->status == '0' ? 'checked' : '' }} />
                                            Não
                                        </label>
                                    @endif
                                </div>
                            </div>
                        </th>
                        @if ($documento->status == '1' && $documento->document_link != '')
                            <th class="text-center">
                                <span style="font-size:13px"> Doc enviado por {{ $documento->user_envio }} em
                                    {{ $documento->data_envio }}
                                    <a target="_blank" href="{{ $documento->document_link }}">
                                        ver </a><span>
                            </th>
                        @else
                            <th> </th>
                        @endif
                        <th>
                            <a href="JavaScript:void(0)" data-toggle="tooltip" data-placement="top" title="Deletar" data-href="{{ route('auditory.company.delete',  $documento->id) }}" class="btn btn-xs btn-danger btn-delete">
                                <i class="fa fa-trash"></i>
                            </a>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal" id="modal--save--document-company" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <form id="update--auditory" action="{{ route('auditory.company.update') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="auditory_id" id="auditory_id">
                <input type="hidden" name="document_name" id="document_name">
                <input type="hidden" id="required" value="false">

                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Importe o Documento</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="file" name="file" id="file_document" required>
                            <p class="help-block">somente arquivos <b>PDF</b></p>
                            <br>
                            <p class="help-block">por favor, confirme o documento antes de enviar</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-submit">Salvar</button>
                        <button type="button" class="btn btn-secondary btn-cancel" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal" id="modal--insert--document" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <form action="{{ route('auditory.company.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Novo documento Auditoria Empresa</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input-name">Nome do Documento</label>
                                <input type="text" name="name" class="form-control"
                                    id="input-name" value="" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="button" class="btn btn-secondary btn-cancel" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateCompanyAuditoryMonth(v, type) {

            var id = $(v).closest('tr').data('id');
            var pasta = $(v).closest('tr').data('type');
            var name = $(v).closest('tr').data('name');

            $('#auditory_id').val(id);
            $('#type_pasta').val(pasta);
            $('#document_name').val(name);

            $('#modal--save--document-company').modal({
                show: true
            });

            $('.btn-cancel').on('click', function() {
                $('#option_nao_' + id).prop('checked', true);
            })
        }

    </script>

@endsection
