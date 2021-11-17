@extends("app")

@section('title', 'Categorias')

@section('content')

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Categorias</h4>
            <div class="row mt-4">
                <div class="col-md-2">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @foreach ($categories as $category)
                            <a class="nav-link mb-2 {{ $loop->index == 0 ? 'active' : null }}" id="v-pills-{{ $category->name }}-tab" data-toggle="pill" href="#v-pills-{{ $category->name }}"
                                role="tab" aria-controls="v-pills-{{ $category->name }}"
                                aria-selected="true">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-10">
                    <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">

                        @foreach ($categories as $category)
                            <div class="tab-pane fade {{ $loop->index == 0 ? 'show active' : null }}" id="v-pills-{{ $category->name }}" role="tabpanel"
                                aria-labelledby="v-pills-{{ $category->name }}-tab">

                                <form action="" method="POST">
                                    @csrf
                                    <select multiple="multiple" size="20" name="sub_categories[]" id="sub_categories" required>
                                        @foreach ($subCategoriesAll as $subCategorie)
                                            <option
                                                {{ in_array_column($subCategorie->name, 'name', $category->subCategories->toArray()) ? 'selected' : '' }}
                                                value="{{ $subCategorie->id }}">{{ $subCategorie->name }}</option>
                                        @endforeach
                                    </select>

                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary float-right">
                                            <i class="fas fa-edit"></i>
                                            Salvar
                                        </button>

                                    </div>
                                </form>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#sub_categories').bootstrapDualListbox({
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
