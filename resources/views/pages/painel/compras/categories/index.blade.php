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
                                    <select multiple="multiple" size="20" name="cursos[]" id="cursos_employee" required>
                                        @foreach ($cursosInEmployee as $curso)
                                            <option value="{{ $curso->id }}"> {{ $curso->description }}</option>
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
