@extends("app")

@section('title', 'Categorias')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h4 class="card-title">Categorias</h4>
                <div class="align-self-end">
                    <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#add-categorie'>add Categoria</button>
                    <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#add-sub-categorie'>add Sub-Categoria</button>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-2">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @foreach ($categories as $icategory)
                            <a class="nav-link nav-link_category mb-2 {{ $loop->index == 0 ? 'active' : null }}" id="v-pills-{{ $icategory->name }}-tab" data-toggle="pill"
                                href="#v-pills-{{ $icategory->name }}"
                                role="tab" aria-controls="v-pills-{{ $icategory->name }}"
                                aria-selected="true">{{ $icategory->name }}</a>

                        @endforeach
                    </div>
                </div>

                <div class="col-md-10">
                    <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                        @foreach ($categories as $icategory)
                            <div class="tab-pane tab-pane_category fade {{ $loop->index == 0 ? 'show active' : null }}" id="v-pills-{{ $icategory->name }}" role="tabpanel"
                                aria-labelledby="v-pills-{{ $icategory->name }}-tab">
                                <form action="{{ route('categories.update', $icategory->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class='form-group'>
                                                <label for='name'>Categoria</label>
                                                <input type='text' class="form-control @error('name') is-invalid @enderror" name='name' id='input--name' value='{{ $icategory->name ?? old('name') }}'
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">

                                            <select multiple="multiple" size="20" name="sub_categories[]" id="sub_categoriesByCategorie_{{ $icategory->id }}" class="sub_categories">
                                                @foreach ($subCategoriesAll as $isubCategorie)
                                                    <option
                                                        {{ in_array_column($isubCategorie->name, 'name', $icategory->subCategories->toArray()) ? 'selected' : '' }}
                                                        value="{{ $isubCategorie->id }}">{{ $isubCategorie->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <button type="button" class="btn btn-outline-danger js-btn-delete float-right ml-2" data-text="Deletar Categoria"
                                            data-href="{{ route('categories.destroy', $icategory->id) }}"><i class="fas fa-trash"></i> </button>
                                        <button type="submit" class="btn btn-primary btn-submit float-right"><i class="fas fa-edit"></i> Salvar</button>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class='modal' id='add-categorie' tabindex='-1' role='dialog'>
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <form role="form-create-categories" class="needs-validation" novalidate id="form-driver" autocomplete="off" action="{{ route('categories.store') }}" method="POST">
                    <div class='modal-header'>
                        <h5 class='modal-title'>Nova Categoria</h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    <div class='modal-body'>
                        @csrf
                        @include("pages.painel._partials.forms.form-categories")
                    </div>
                    <div class='modal-footer'>
                        <button type='submit' class='btn btn-primary'>Salvar</button>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class='modal' id='add-sub-categorie' tabindex='-1' role='dialog'>
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <form role="form-create-sub-categories" class="needs-validation" novalidate id="form-driver" autocomplete="off" action="{{ route('sub-categories.store') }}" method="POST">
                    <div class='modal-header'>
                        <h5 class='modal-title'>Nova Sub Categoria</h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    <div class='modal-body'>
                        @csrf
                        @include("pages.painel._partials.forms.form-sub-categories")
                    </div>
                    <div class='modal-footer'>
                        <button type='submit' class='btn btn-primary'>Salvar</button>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')

    @if (request()->has('category'))
        <script>
            let reqCategorie = '{{ request()->input('category') }}';
            $('.nav-link_category').removeClass('active');
            $(`#v-pills-${reqCategorie}-tab`).addClass('active');
            $('.tab-pane_category').removeClass('show active');
            $(`#v-pills-${reqCategorie}`).addClass('show active');
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $('.sub_categories').bootstrapDualListbox({
                // default text
                filterTextClear: 'mostrar todos',
                filterPlaceHolder: 'Filtar',
                moveSelectedLabel: 'Move selected',
                moveAllLabel: 'Mover todos',
                removeSelectedLabel: 'Remover selecionados',
                removeAllLabel: 'Remover todos',

                // true/false (forced true on androids, see the comment later)
                moveOnSelect: true,

                // 'all' / 'moved' / false
                preserveSelectionOnMove: false,

                // 'string', false
                selectedListLabel: false,

                // 'string', false
                nonSelectedListLabel: false,

                // 'string_of_postfix' / false
                helperSelectNamePostfix: '_helper',

                // minimal height in pixels
                selectorMinimalHeight: 300,

                // whether to show filter inputs
                showFilterInputs: true,

                // string, filter the non selected options
                nonSelectedFilter: '',

                // string, filter the selected options
                selectedFilter: '',

                // text when all options are visible / false for no info text
                infoText: 'Todos {0}',

                // when not all of the options are visible due to the filter
                infoTextFiltered: '<span class="badge badge-warning">Filtrar</span> {0} from {1}',

                // when there are no options present in the list
                infoTextEmpty: 'Lista vazia',

                // sort by input order
                sortByInputOrder: false,

                // filter by selector's values, boolean
                filterOnValues: false,

                // boolean, allows user to unbind default event behaviour and run their own instead
                eventMoveOverride: false,

                // boolean, allows user to unbind default event behaviour and run their own instead
                eventMoveAllOverride: false,

                // boolean, allows user to unbind default event behaviour and run their own instead
                eventRemoveOverride: false,

                // boolean, allows user to unbind default event behaviour and run their own instead
                eventRemoveAllOverride: false,

                // sets the button style class for all the buttons
                btnClass: 'btn-outline-secondary',

                // string, sets the text for the "Move" button
                btnMoveText: '&gt;',

                // string, sets the text for the "Remove" button
                btnRemoveText: '&lt;',

                // string, sets the text for the "Move All" button
                btnMoveAllText: '&gt;&gt;',

                // string, sets the text for the "Remove All" button
                btnRemoveAllText: '&lt;&lt;'

            });
        })
    </script>

@append
