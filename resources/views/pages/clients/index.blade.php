@extends("pages.clients.app")

@section('title', 'Obras')

@section('content')

    <div class="card">

        <div class="card-body">
            <form id='form-search-clients-obra' role='form' class='needs-validation' action='{{ route('clients.obras') }}' method='get'>
                <div class="row">
                    <div class="col-6 col-md-4">
                        <div class='form-group'>
                            <label for='search'>Nome da Obra</label>
                            <input type='text' class='form-control' name='search' id='input--obr_name' value='{{ Request::input('search') ?? old('search') }}'>
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <button class="btn btn-primary">Buscar</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body">
            <table class='table table-hover'>
                <thead class='thead-light'>
                    <tr>
                        <th>#</th>
                        <th>Razão Social</th>
                        <th>Concessionaria / Serviço</th>
                        <th>Etapas</th>
                        <th width="8%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($obras as $obra)
                        <tr>
                            <th>{{ $obra->id }}</th>
                            <th>{{ limit($obra->razao_social, 30) }}</th>
                            <th> {{ Str::of($obra->concessionaria->name)->append(' - ' . $obra->service->name) }}</th>
                            <th>{!! $obra->getCountEtapas() !!}</th>
                            <th style="text-align: end">
                                <a href="{{ route('clients.obras.show', $obra->id) }}">
                                    <i class=" fas fa-external-link-alt"></i>
                                </a>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
