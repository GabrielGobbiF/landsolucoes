@php
    $atividadesRdseProgramacao = $atividades;
@endphp

@if (isset($atividadesRdseProgramacao))
    <ul class="">
        @foreach ($atividadesRdseProgramacao as $desc)
            <li style="margin-bottom: 1.5rem;">
                {{ $desc->equipe->name }} - {{ $desc->data }}
                <br>
                {{ $desc->atividades }}
            </li>
        @endforeach
    </ul>
@endif
