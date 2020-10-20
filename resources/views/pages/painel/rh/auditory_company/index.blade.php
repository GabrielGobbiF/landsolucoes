@extends('pages.painel.rh.app')

@section('title', 'Empresa')

@section('content')

    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h1 class="h2">Documentos da Empresa</h1>
            <div class="tollbar btn-toolbar mb-2 mb-md-0 float-right"></div>
        </div>

        <div class="acompanhamentoOrCurso">
            <table class="table">
                <tbody>
                    @foreach ($documentos as $documento)
                        <tr data-id="{{ $documento->id }}" data-name="{{ $documento->name }}" data-type="contratacao">
                            <th style="width: 44%"> <span data-toggle="tooltip" title="">
                                    {{ $documento->description ?? '' }}</span>
                            </th>
                            <th class="text-center">
                                <div class="form-group">
                                    <div class="radio">
                                        @if ($documento->applicable == '0')
                                            <div class="radio_doc_applicable_{{ $documento->id }}">
                                                <label style="margin-right:5px">
                                                    <input type="checkbox" class="doc_applicable"
                                                        value="{{ $documento->id }}" />
                                                    Aplicável
                                                </label>
                                            </div>

                                            <div style="display:none" class="radio_doc_applicable_{{ $documento->id }}"
                                                id="yesorno_{{ $documento->id }}">
                                                <label style="margin-right:5px">
                                                    <input type="radio" data-collumn="status"
                                                        class="{{ $documento->status != '1' ? 'status' : '' }}"
                                                        name="status_{{ $documento->id }}"
                                                        id="option_sim_{{ $documento->id }}" value="1"
                                                        {{ $documento->status == '1' ? 'checked' : '' }} />
                                                    Sim
                                                </label>
                                                @if ($documento->status != '1')
                                                    <label>
                                                        <input type="radio" data-collumn="status"
                                                            name="status_{{ $documento->id }}"
                                                            id="option_nao_{{ $documento->id }}" value="0"
                                                            {{ $documento->status == '0' ? 'checked' : '' }} />
                                                        Não
                                                    </label>
                                                @endif
                                            </div>
                                        @else
                                            <label style="margin-right:5px">
                                                <input type="radio" data-collumn="status"
                                                    class="{{ $documento->status != '1' ? 'status' : '' }}"
                                                    name="status_{{ $documento->id }}" id="option_sim_{{ $documento->id }}"
                                                    value="1" {{ $documento->status == '1' ? 'checked' : '' }} />
                                                Sim
                                            </label>

                                            @if ($documento->status != '1')
                                                <label>
                                                    <input type="radio" data-collumn="status"
                                                        name="status_{{ $documento->id }}"
                                                        id="option_nao_{{ $documento->id }}" value="0"
                                                        {{ $documento->status == '0' ? 'checked' : '' }} />
                                                    Não
                                                </label>
                                            @endif
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
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>


    </div>

@endsection
