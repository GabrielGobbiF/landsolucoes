@isset($response)
    @if (count($response) > 0)
        @foreach ($response as $tipo => $value)
            <div class='mt-3'>
                <table class='table table-hover'>
                    <thead class='thead-light'>
                        <tr>
                            <th>{{ ucfirst($tipo) }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($value as $column)
                            <tr>
                                <th>{{ limit($column['descricao'], 90) }}</th>
                                <th>
                                    <a target="_blank" href="{{ $column['route'] }}" class="">Visualizar <i class=" fas fa-arrow-right"></i></a>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    @else
        <div class='mt-3'>
            <h5 class="">Nada encontrado!</h5>
        </div>
    @endif
@endisset
