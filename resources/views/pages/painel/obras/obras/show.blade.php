@extends("app")

@section('title', ucfirst($obra->razao_social))

@section('content')
    <div class="container">
        <h4 class="text-center">{{ $obra->razao_social ?? '' }} </h4>
        <div class="card mt-3">
            <ul class="nav nav-tabs nav-tabs_obra" id="myTab_obra" role="tablist">
                <li class="nav-item">
                    <a class="nav-link nav-link_obra active" id="dados-tab" data-toggle="tab" href="#dados" role="tab"
                        aria-controls="dados" aria-selected="true">Cadastro</a>
                </li>

            </ul>

            <div class="tab-content" id="myTabContent">


            </div>
        </div>
    </div>
@stop
