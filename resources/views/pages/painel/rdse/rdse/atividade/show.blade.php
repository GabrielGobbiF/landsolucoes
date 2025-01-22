@extends('app')

@section('title', 'Atividade')

@section('content-max-fluid')


    <div class="row justify-content-center align-content-center">

        <div class="col-12 col-md-9">
            <div class="card text-start">
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('rdse.show', $rdseAtividade->rdse_id) }}">
                            <i class="fa-solid fa-arrow-left-long"></i>
                            Voltar
                        </a>
                    </div>

                    <form id="form-handsworkes" role="form" class="needs-validation" novalidate autocomplete="off"
                          action="{{ route('rdse.atividades.update', $rdseAtividade->id) }}" method="POST" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">

                                <div class="col-12 col-md-7">
                                    <div class="col-12 col-md-10">
                                        @csrf
                                        @method('put')
                                        @include('pages.painel._partials.forms.form-rdse_atividades')

                                        @if ($rdseAtividade->canUpdate())
                                            <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-12 col-md-5 arquivos">

                                    <div class="row">

                                        <div class="col-12 col-md-12">
                                            <div class="card text-start">
                                                <div class="card-body ">
                                                    <div class="d-flex align-center">
                                                        <h4 class="card-title mb-4">Imagens</h4>
                                                        <div class="dropdown-file">
                                                            <a class="dropdown-link" data-toggle="dropdown" aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a type="button" class="dropdown-item "
                                                                   href="{{ route('rdse.atividades.download.images', $rdseAtividade->id) }}">
                                                                    <i class="fas fa-download mr-2"></i>
                                                                    Baixar todas imagens
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">

                                                        <style>
                                                            .arquivos .card-file-thumb {
                                                                font-size: 48px;
                                                                width: 120px;
                                                                height: 120px;
                                                                display: flex;
                                                                align-items: center;
                                                                justify-content: center;
                                                                overflow: hidden;
                                                                border: 1px solid #ddd;
                                                                border-radius: 8px;
                                                                background-color: #f8f8f8;
                                                            }

                                                            .arquivos .card-file-thumb img {
                                                                width: 100%;
                                                                height: 100%;
                                                                object-fit: cover;

                                                            }
                                                        </style>

                                                        @foreach ($imagens as $upload)
                                                            <div class="col-12 col-sm-3 col-md-6">
                                                                <div id="card-file" class="card card-file">
                                                                    <div class="dropdown-file" style="position: absolute;right: 4px;top: 8px;">
                                                                        <a class="dropdown-link" data-toggle="dropdown" aria-expanded="false">
                                                                            <i class="fas fa-ellipsis-v"></i>
                                                                        </a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <button disabled type="button" class="dropdown-item delete"
                                                                                    onclick="deleteFile(${data.id}, ${etapaId})">
                                                                                <i class="fas fa-trash mr-2"></i>Deletar
                                                                            </button>
                                                                            <a target="_blank" class="dropdown-item"
                                                                               href="{{ asset($upload->path) }}">Visualizar</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="card-file-thumb">
                                                                        <img src="{{ asset($upload->path) }}" alt="" class="w-100">
                                                                    </div>
                                                                    <div class="card-body">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div class="card text-start">
                                                <div class="card-body">
                                                    <h4 class="card-title mb-3">Histórico</h4>

                                                    <div class="table-activitiesTableBody">
                                                        <table class="table table-striped ">
                                                            <thead>
                                                                <tr>
                                                                    <th>Usuário</th>
                                                                    <th>Data/Hora</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="activitiesHistoryTableBody">
                                                                @foreach ($rdseActivityHistorys as $rdseActivityHistory)
                                                                    <tr>
                                                                        <td>{{$rdseActivityHistory->causer->name}}</td>
                                                                        <td>{{formatDateAndTime($rdseActivityHistory->created_at, 'd/m/Y H:i')}}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop
