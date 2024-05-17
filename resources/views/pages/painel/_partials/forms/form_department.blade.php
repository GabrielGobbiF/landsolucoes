<div class="box box-default box-solid">
    <div class="col-md-12">
        <div class="box-header with-border">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                <h3 class="box-title">Departamentos</h3>
                <button type="button" class="btn btn-outline-primary waves-effect waves-light storeDepartment">
                    <i class="ri-add-circle-line align-middle"></i> <span class="ml-2 mobile--hidden"> Novo Departamento</span>
                </button>
            </div>
        </div>
        <div class="box-body">

            <form id="form-store-department" role="form" class="needs-validation" action="{{ route('departments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">
                <input type="hidden" name="typeValue" value="{{ $idType }}">
                <div class="div-store-department"></div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-submit store-department-button d-none float-right">Salvar Departamento(s)</button>
                    </div>
                </div>
            </form>

            @if (count($departments) > 0)
                @foreach ($departments as $department)
                    <form id='form-update-department-{{ $department->id }}' role='form' class='needs-validation' action='{{ route('departments.update', [$department->id]) }}'
                        method='POST'>
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">
                        <input type="hidden" name="typeValue" value="{{ $idType }}">
                        <div class="row">
                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    <label for="input--dep_responsavel">Responsável</label>
                                    <input type="text" name="dep_responsavel" class="form-control" id="input--dep_responsavel"
                                        value="{{ $department->dep_responsavel ?? old('dep_responsavel') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="input--dep_email">Email</label>
                                    <input type="text" name="dep_email" class="form-control" value="{{ $department->dep_email ?? old('dep_email') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    <label for="input--dep_telefone_celular">Celular</label>
                                    <input type="text" name="dep_telefone_celular" class="form-control" id="input--dep_telefone_celular"
                                        value="{{ $department->dep_telefone_celular ?? old('dep_telefone_celular') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    <label for="input--dep_telefone_fixo">Tel Fixo</label>
                                    <input type="text" name="dep_telefone_fixo" class="form-control" id="input--dep_telefone_fixo"
                                        value="{{ $department->dep_telefone_fixo ?? old('dep_telefone_fixo') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    <label for="input--dep_funcao">Função</label>
                                    <input type="text" name="dep_funcao" class="form-control" id="input--dep_funcao"
                                        value="{{ $department->dep_funcao ?? old('dep_funcao') }}">
                                </div>
                            </div>
                            <div class="col-1 align-self-center mobile--hidden">
                                <div style="margin-top: 11px;right: 41%;position: relative;" class="d-flex">
                                    <button type="submit" data-toggle="tooltip" data-placement="top" data-title="Salvar" class="btn btn-info float-right "><i class="fas fa-save"></i></button>
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" data-title="Excuir"
                                        data-href="{{ route('departments.destroy', [$department->id]) }}"
                                        class="btn btn-xs btn-danger btn-delete ml-1"
                                        data-original-title="Excluir Departamento">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr>
                @endforeach
            @endif
        </div>
    </div>
</div>

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.storeDepartment').on('click', function() {
                var html = '';
                html += '<div class="row">';
                html += '    <div class="col-12 col-md-2">';
                html += '        <div class="form-group">';
                html += '            <label for="input--dep_responsavel">Responsável</label>';
                html += '            <input type="text" name="dep[dep_responsavel][]" class="form-control">';
                html += '        </div>';
                html += '    </div>';
                html += '    <div class="col-12 col-md-3">';
                html += '        <div class="form-group">';
                html += '            <label for="input--dep_email">Email</label>';
                html += '            <input type="text" name="dep[dep_email][]" class="form-control">';
                html += '        </div>';
                html += '    </div>';
                html += '    <div class="col-12 col-md-2">';
                html += '        <div class="form-group">';
                html += '            <label for="input--dep_telefone_celular">Celular</label>';
                html += '            <input type="text" name="dep[dep_telefone_celular][]" class="form-control">';
                html += '        </div>';
                html += '    </div>';
                html += '    <div class="col-12 col-md-2">';
                html += '        <div class="form-group">';
                html += '            <label for="input--dep_telefone_fixo">Tel Fixo</label>';
                html += '            <input type="text" name="dep[dep_telefone_fixo][]" class="form-control">';
                html += '        </div>';
                html += '    </div>';
                html += '    <div class="col-12 col-md-2">';
                html += '        <div class="form-group">';
                html += '            <label for="input--dep_funcao">Função</label>';
                html += '            <input type="text" name="dep[dep_funcao][]" class="form-control">';
                html += '        </div>';
                html += '    </div>';
                html += '</div>';
                html += '<hr>';
                $('.div-store-department').append(html);
                $('.store-department-button').removeClass('d-none');
            });
        })

    </script>
@endsection
