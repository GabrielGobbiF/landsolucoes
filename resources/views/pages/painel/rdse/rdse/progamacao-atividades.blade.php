@php
    $atividadesRdseProgramacao = $atividades->pluck('atividades');
@endphp

@if (isset($atividadesRdseProgramacao))
    <ul class="">
        @foreach ($atividadesRdseProgramacao as $desc)
            <li class="">{{ $desc }}</li>
        @endforeach
    </ul>
@endif
