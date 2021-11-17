@extends("app")

@section('title', 'Produtos')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="table table-api">
                <div class="table-responsive d-none">
                    <div id="toolbar">
                        <div class="page-button-box">
                            <button type='button' class='btn btn-outline-primary' data-toggle='modal' data-target='#exampleModal'>Novo Orçamento </button>
                        </div>
                    </div>
                    <table data-toggle="table" id="table-api" data-table="produtos">
                        <thead class="thead-light">
                            <tr>
                                <th data-field="id" data-sortable="true" data-visible="false">#</th>
                                <th data-field="nome">Nome</th>
                                <th data-field="unidade">Unidade</th>
                                <th data-field="valor">Valor</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class='modal' id='exampleModal' tabindex='-1' role='dialog'>
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <form id='form-create-orcamento' role='form' class='needs-validation' action='{{ route('orcamento.store') }}' method='POST'>
                    @csrf
                    <div class='modal-header'>
                        <h5 class='modal-title'>Novo Orçamento</h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    <div class='modal-body'>

                        <div class='form-group'>
                            <label>Selecione a Obra</label>
                            <select name='obra_id' class='form-control select2' required>
                                @foreach ($obras as $obra)
                                    <option value='{{ $obra->id }}'>{{ $obra->razao_social }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class='form-group'>
                            <label>Selecione a categoria</label>
                            <select name='categoria' class='form-control select2' required>
                                @foreach (config('admin.atuacao') as $atuacao)
                                    <option {{ request()->input('categoria') && request()->input('categoria') == $atuacao ? 'selected' : '' }} value='{{ $atuacao }}'>
                                        {{ $atuacao }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                        <button type='submit' class='btn btn-primary btn-submit'> Ir <i class="fas fa-long-arrow-alt-right"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop
