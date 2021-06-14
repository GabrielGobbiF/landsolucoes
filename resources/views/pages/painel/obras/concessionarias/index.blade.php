@extends("app")

@section('title', 'Concessionárias')

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
                <table data-toggle="table" id="table" data-table="concessionarias">
                    <thead>
                        <tr>
                            <th data-field="id" data-sortable="true" data-visible="false">#</th>
                            <th data-field="name" data-width="80%" data-width-unit="%" >Razão Social</th>
                            <th data-field="qnt_services" data-halign="center" data-align="center">Quantidade de Serviços</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
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
