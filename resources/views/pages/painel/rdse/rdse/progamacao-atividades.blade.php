@php
    $atividadesRdseProgramacao = $atividades->pluck('atividades');
@endphp

@if (isset($atividadesRdseProgramacao))
    <ul class="">
        @foreach ($atividadesRdseProgramacao as $desc)
            <li style="margin-bottom: 1.5rem;">{{ $desc }}</li>
        @endforeach
    </ul>
@endif
