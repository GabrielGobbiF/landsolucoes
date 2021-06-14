@extends("app")

@section('title', 'Serviços')

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
                            <button type="button" data-toggle="modal" data-target="#modal-add-service" class="btn btn-dark waves-effect waves-light">
                                <i class="ri-add-circle-line align-middle mr-2"></i> Novo
                            </button>
                        </div>
                    </div>
                </div>

                <table data-toggle="table" id="table" data-table="services">
                    <thead>
                        <tr>
                            <th data-field="id" data-sortable="true" data-visible="false">#</th>
                            <th data-field="name" data-sortable="true">Nome</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-add-service" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastrar novo Serviço</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-add-service" role="form" class="needs-validation" action="{{ route('services.store') }}" method="POST">
                        @include("pages.painel._partials.forms.form_service")
                    </form>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    @if ($errors->isNotEmpty())
        <script>
            $(document).ready(function() {
                $("#modal-add-service").modal("show");
            })

        </script>
    @endif
@endsection
@endsection
