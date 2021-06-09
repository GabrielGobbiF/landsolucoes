@extends("app2")

@section('title', 'Comercial')


@section('content')

    <div class="card">
        <div class="card-body">

            <div class="text-center" id="preloader-content">
                <div class="spinner-border text-primary m-1 align-self-center" role="status">
                    <span class="sr-only"></span>
                </div>
            </div>

            <div class="table table-responsive d-none">

                <div id="toolbar">
                    <div class="form-inline" role="form">
                        <div class="btn-group mr-2">
                            <button type="button" data-toggle="modal" data-target="#modal-add-comercial" class="btn btn-dark waves-effect waves-light">
                                <i class="ri-add-circle-line align-middle mr-2"></i> Novo
                            </button>
                        </div>
                    </div>
                </div>

                <table id="table" data-search="true" data-show-refresh="true"
                    data-show-columns="true" data-show-columns-toggle-all="true" data-show-export="true"
                    data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-cookie="true"
                    data-cookie-id-table="comerciais" data-toolbar="#toolbar" data-buttons-class="dark">
                    <thead>
                        <tr>
                            <th>Ação</th>
                            <th data-field="id" data-visible="false">#</th>
                            <th>Nome Obra</th>
                            <th>Cliente</th>
                            <th class="mobile--hidden">Concessionaria / Serviço </th>
                            <th data-width="170" class="mobile--hidden text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comerciais as $comercialf)
                            <tr>
                                <td>
                                    <a href="{{ route('comercial.show', $comercialf->id) }}" data-toggle="tooltip" data-placement="top" title="Visualizar" class="btn btn-xs btn-dark ">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                                <td>{{ $comercialf->id }}</td>
                                <td>{{ $comercialf->razao_social }}</td>
                                <td>{{ $comercialf->client->username }}</td>
                                <td>{{ $comercialf->concessionaria->name }} / {{ $comercialf->service->name }}</td>
                                <td class="text-center">
                                    <select class='form-control select2'>
                                        @foreach (Config::get('constants.status_build') as $status)
                                            <option {{ $comercialf->status == $status ? 'selected' : '' }} value='{{ $status }}'>
                                                {{ mb_strtoupper($status, 'utf-8') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
