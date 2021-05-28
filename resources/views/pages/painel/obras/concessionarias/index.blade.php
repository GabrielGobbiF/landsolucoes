@extends("app")

@section('title', 'Concessionarias')

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
                            <button type="button" data-toggle="modal" data-target="#modal-add-concessionaria" class="btn btn-dark waves-effect waves-light">
                                <i class="ri-add-circle-line align-middle mr-2"></i> Novo
                            </button>
                        </div>
                    </div>
                </div>

                <table data-toggle="table" id="table" data-search="true" data-show-refresh="true"
                    data-show-columns="true" data-show-columns-toggle-all="true" data-show-export="true"
                    data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-cookie="true"
                    data-cookie-id-table="concessionarias" data-toolbar="#toolbar" data-buttons-class="dark">
                    <thead>
                        <tr>
                            <th data-field="id" data-visible="false">#</th>
                            <th class="mobile--hidden">Razão Social</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($concessionarias as $rowConcessionaria)
                            <tr>
                                <td>{{ $rowConcessionaria->id }}</td>
                                <td>{{ $rowConcessionaria->name }}</td>
                                <td>
                                    <a href="{{ route('concessionarias.show', [$rowConcessionaria->slug]) }}" data-toggle="tooltip" data-placement="top" data-title="Ativar"
                                        class="btn btn-xs btn-info"
                                        data-original-title="Editar Concessionaria">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" data-title="Deletar"
                                        data-href="{{ route('concessionarias.destroy', $rowConcessionaria->id) }}"
                                        class="btn btn-xs btn-danger"
                                        data-original-title="Deletar" onclick="btn_delete(this)">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-add-concessionaria" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastrar nova Concessionaria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-add-concessionaria" role="form" class="needs-validation" action="{{ route('concessionarias.store') }}" method="POST">
                        @include("pages.painel._partials.forms.form_concessionaria")
                    </form>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    @if ($errors->isNotEmpty())
        <script>
            $(document).ready(function() {
                $("#modal-add-concessionaria").modal("show");
            })

        </script>
    @endif
@endsection
@endsection
