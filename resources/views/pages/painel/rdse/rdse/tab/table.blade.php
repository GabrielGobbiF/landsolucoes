<div id="table-rdse-clean">
    @if ($rdse->type != 'Emergencial')
        <table class='table table-hover'>
            <thead class='thead-light'>
                <tr>
                    <th class="d-none"></th>
                    <th>Chegada</th>
                    <th>Qnt Minutos</th>
                    <th>Saida</th>
                    <th>Horas</th>
                    <th>SAP</th>
                    <th>Descrição</th>
                    <th>Horas / <br>Qnt Atividade</th>
                    <th>Preço</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($rdseServices as $service)
                    <tr class="service-row">
                        <th>
                            {{ $service->chegada }}
                        </th>
                        <th>
                            {{ $service->minutos }}
                        </th>

                        <th>
                            {{ !empty($service->saida) ? $service->saida : '' }}
                        </th>

                        <th>
                            {{ !empty($service->horas) ? $service->horas : '' }}
                        </th>

                        <th>
                            {{ !empty($service->handswork) ? $service->handswork->code : '' }}
                        </th>

                        <th>
                            {{ !empty($service->description) ? $service->description : (!empty($service->handswork) ? $service->handswork->description : '') }}
                        </th>

                        <th>
                            {{ !empty($service->qnt_atividade) ? $service->qnt_atividade : '0' }}
                        </th>
                        <th>
                            {{ !empty($service->preco) ? $service->preco : '0' }}
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <table class='table table-hover table-responsive'>
            <thead class='thead-light'>
                <tr>
                    <th class="d-none"></th>
                    <th>Qnt Minutos</th>
                    <th>SAP</th>
                    <th>Descrição</th>
                    <th>Horas / <br>Qnt Atividade</th>
                    <th>Preço</th>
                    
                    {{-- parcial --}}
                    <th>Parcial 1</th>
                    <th>Preço Parc 1</th>
                    {{-- parcial --}}

                    {{-- parcial --}}
                    <th>Parcial 2</th>
                    <th>Preço Parc 2</th>
                    {{-- parcial --}}
                </tr>
            </thead>

            <tbody>
                @foreach ($rdseServices as $service)
                    <tr class="service-row">
                        <th>
                            {{ $service->minutos }}
                        </th>

                        <th>
                            {{ !empty($service->handswork) ? $service->handswork->code : '' }}
                        </th>

                        <th>
                            {{ !empty($service->description) ? $service->description : (!empty($service->handswork) ? $service->handswork->description : '') }}
                        </th>

                        <th>
                            {{ !empty($service->qnt_atividade) ? $service->qnt_atividade : '0' }}
                        </th>
                        <th>
                            {{ !empty($service->preco) ? $service->preco : '0' }}
                        </th>

                        {{-- parcial --}}
                        <th>
                            
                        </th>
                        <th>
                            
                        </th>
                        {{-- parcial --}}

                         {{-- parcial --}}
                         <th>
                            
                        </th>
                        <th>
                            
                        </th>
                        {{-- parcial --}}

                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@section('scripts')
    <script></script>
@append
