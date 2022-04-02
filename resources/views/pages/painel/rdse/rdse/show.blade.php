@extends("app")

@section('title', 'Editar - ' . ucfirst($rdse->description))

@section('content')

    <div class='card'>
        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link " data-toggle="tab" href="#info" role="tab">
                        <span class="d-block d-sm-none"><i class="fas fa-info"></i></span>
                        <span class="d-none d-sm-block">Dados</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#services" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block">Serviços</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content p-3 text-muted">

                <div class="tab-pane" id="info" role="tabpanel">
                    <form role="form" class="needs-validation" novalidate id="form-rdse" autocomplete="off" action="{{ route('rdse.update', $rdse->id) }}" method="POST">
                        @csrf
                        @method("put")
                        @include('pages.painel._partials.forms.form-rdse')
                        <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                    </form>
                </div>


                <div class="tab-pane active" id="services" role="tabpanel">
                    <input type="hidden" id="onfocus" value="0">
                    {{-- @for ($i = 1; $i < 10; $i++)
                        <div class="row row-xs" data-id="{{ $i }}">
                            <div class="form-group col-1" style="min-width:185px">
                                <label>Chegada na obra</label>
                                <input type="time" class="form-control chegada_obra" id="chegada_obra_{{ $i }}" name="chegada_obra[]" data-id="{{ $i }}"
                                    {{ $i > 1 ? 'disabled' : '' }} />
                            </div>

                            <div class="form-group col-1" style="min-width:185px">
                                <label>Qnt Minutos</label>
                                <input type="number" class="form-control qnt_minutos" id="qnt_minutos_{{ $i }}" name="qnt_minutos[]" data-id="{{ $i }}"
                                    value="0" />
                            </div>

                            <div class="form-group col-1" style="min-width:185px">
                                <label>Saida da obra</label>
                                <input class="form-control" name="saida_obra[]" id="saida_obra_{{ $i }}" required disabled />
                            </div>

                            <div class="form-group col-1" style="min-width:185px">
                                <label>Horas</label>
                                <input class="form-control" name="hours" id="hours_{{ $i }}" disabled data-id="{{ $i }}" />
                            </div>
                        </div>
                    @endfor --}}

                    <div id="services">

                        <div class="row row-xs services-rows" data-id="1">
                            <div class="form-group col-1" style="min-width:185px">
                                <label>Chegada na obra</label>
                                <input type="time" class="form-control chegada_obra" onchange="att_lines()" onkeyup="att_lines()" id="chegada_obra_1" name="chegada_obra[]" data-id="1" />
                            </div>

                            <div class="form-group col-1" style="min-width:185px">
                                <label>Qnt Minutos</label>
                                <input type="number" class="form-control qnt_minutos" onchange="att_lines()" onkeyup="att_lines()" id="qnt_minutos_1" name="qnt_minutos[]" data-id="1"
                                    value="0" />
                            </div>

                            <div class="form-group col-1" style="min-width:185px">
                                <label>Saida da obra</label>
                                <input class="form-control saida_obra" name="saida_obra[]" id="saida_obra_1" required disabled />
                            </div>

                            <div class="form-group col-1" style="min-width:185px">
                                <label>Horas</label>
                                <input class="form-control hours" name="hours" id="hours_1" disabled data-id="1" />
                            </div>
                        </div>


                    </div>

                </div>


            </div>
        </div>
    </div>

@stop

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#chegada_obra_1').focus();

        })

        $(function() {
            $('#services').sortable({
                update: function() {
                    console.log('update called');
                },
                start: function(event, ui) {
                    alert('start')
                },
                change: function(event, ui) {
                    alert('change')
                },
            });
        });

        $('body').on('keydown', function(e) {
            // if (e.which === 9) {
            //     let focus = $('#onfocus').val();
            //     let nextFocus = parseInt(focus) + 1;
            //     document.getElementById(`saida_obra_1`).focus({
            //         preventScroll: true
            //     });
            // }

            if (e.which === 9) {
                let count = document.getElementsByClassName("services-rows").length;
                let line = parseInt(count) + 1;

                let html =
                    `<div class="row row-xs services-rows" data-id="${line}">
                            <div class="form-group col-1" style="min-width:185px">
                                <label>Chegada na obra</label>
                                <input type="time" class="form-control chegada_obra" onchange="att_lines()" onkeyup="att_lines()" id="chegada_obra_${line}" name="chegada_obra[]" data-id="${line}" disabled />
                            </div>

                            <div class="form-group col-1" style="min-width:185px">
                                <label>Qnt Minutos</label>
                                <input type="number" class="form-control qnt_minutos" onchange="att_lines()" onkeyup="att_lines()" id="qnt_minutos_${line}" name="qnt_minutos[]" data-id="${line}"
                                    value="0" />
                            </div>

                            <div class="form-group col-1" style="min-width:185px">
                                <label>Saida da obra</label>
                                <input class="form-control saida_obra" name="saida_obra[]" id="saida_obra_${line}" required disabled />
                            </div>

                            <div class="form-group col-1" style="min-width:185px">
                                <label>Horas</label>
                                <input class="form-control hours" name="hours" id="hours_${line}" disabled data-id="${line}" />
                            </div>
                    </div>
                    `

                $('#services').append(html)
                $("#services").sortable("destroy");
                $('#services').sortable({
                    update: function() {
                        console.log('update called');
                    },
                    start: function(event, ui) {
                        alert('start')
                    },
                    change: function(event, ui) {
                        alert('change')
                    },
                });
            }
        });

        function att_lines() {

            $(".services-rows").each(function() {
                let id = $(this).attr("data-id");
                let line = parseInt(id) + 1

                let saida_obra = $(this).find(`.saida_obra`);
                let chegada_obra = $(this).find(`.chegada_obra`).val();
                let minute = $(this).find(`.qnt_minutos`).val();
                let chegada_obra_line = $(`#chegada_obra_${line}`);
                let hours = $(this).find(`.hours`);

                //add minutes 
                var chegada_obra_date = moment(chegada_obra, "HH:mm:ss")
                var saida_obra_date = chegada_obra_date.add(minute, 'minutes');

                saida_obra.val(saida_obra_date.format('HH:mm:ss'));
                chegada_obra_line.val(saida_obra_date.format('HH:mm:ss'));

                var now = saida_obra.val();
                let then = chegada_obra;

                hours.val(moment.utc(moment(now, "HH:mm:ss").diff(moment(then, "HH:mm:ss"))).format("HH:mm:ss"));

            })


        }
    </script>
@endsection
