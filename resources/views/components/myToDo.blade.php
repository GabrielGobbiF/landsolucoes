<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
    <div id="page--tasks" style="height:100vh">
        <div class="box box-default box-solid tasks-box">
            <div class="col-md-12">
                <div class="card-body d-flex align-items-center justify-content-between" style="padding: 14px !important;">
                    <h3 class="box-title align-self-center">Tarefas</h3>
                    <div class="task-buttons">
                        <button class="btn btn-sm btn-outline-info js-add-task"><i class="fas fa-plus mr-1"></i> Nova tarefa</button>
                        <button class="btn btn-sm btn-outline-primary js-show-done-task"><i class="fas fa-plus mr-1"></i> Mostrar Concluidos</button>
                        <button class="btn btn-sm btn-outline-primary js-hide-done-task d-none"><i class="fas fa-plus mr-1"></i> Esconder Concluidos</button>
                        <input type="hidden" id="listDone" value="false">
                    </div>
                </div>

                <div class="tasks-container__list">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="message-list" id="tasks-list" style="padding: 5px 0px 0px 1px;"></ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tasks-container__new d-none">
                    <div class="box-body">
                        <form id="form-store-update-task" role="form" class="needs-validation" action="{{ route('task.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12 my-2 mb-4">
                                    <button type="submit" class="btn btn-info btn-submit float-right">Salvar</button>
                                    <button type="button" class="btn btn-danger float-left js-add-cancel-task"><i class="fas fa-arrow-left"></i> Voltar</button>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="tar_titulo">Titulo</label>
                                        <input type="text" class="form-control" name="tar_titulo" id="input--tar_titulo" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="tar_descricao">Descrição</label>
                                        <textarea type="text" class="form-control" name="tar_descricao" id="input--tar_descricao" autocomplete="off" required></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="prioridade">Prioridade</label>
                                    <div class="form-group">
                                        <select class="form-control select2" name="prioridade" id="select--prioridade">
                                            <option value="baixa" selected>Baixa</option>
                                            <option value="alta">Alta</option>
                                            <option value="media">Média</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label mr-2">Lembrar-me</label>
                                            <input class="form-check-input wd-15 ht-15" id="lembrete" type="checkbox">
                                        </div>
                                        <input class="form-control d-none" disabled readonly type="datetime-local" value="{{ somarData('1', 'hours', '', 'Y-m-d\TH:i') }}" id="dateTime" name="data">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts_task')
    <script>
        $(function() {
            all(false);
        })

        /* Contents  */
        var $taskBox = $(".tasks-box");
        var $taskList = $(".tasks-container__list");
        var $taskContainerNew = $(".tasks-container__new");

        /* Buttons  */
        var $btnShowDone = $(".js-show-done-task");
        var $btnHideDone = $(".js-hide-done-task");
        var $btnNewTask = $(".js-add-task");
        var $btnCancelAdd = $(".js-add-cancel-task");

        /* Routes  */
        var $routeTask = `${BASE_URL_API}tasks`;

        $btnShowDone.on("click", function() {
            $taskBox.find('.box-title').html('Concluidos');
            $btnNewTask.addClass('d-none');
            $btnShowDone.addClass('d-none');
            $btnHideDone.removeClass('d-none');
            $('#listDone').val(true);
            all(true);
        })

        $btnHideDone.on("click", function() {
            $taskBox.find('.box-title').html('Tarefas');
            $btnNewTask.removeClass('d-none');
            $btnShowDone.removeClass('d-none');
            $btnHideDone.addClass('d-none');
            $('#listDone').val(false);
            all(false);
        })

        $btnNewTask.on("click", function() {
            $taskBox.find('#form-store-update-task').attr('action', `${$routeTask}`);
            $taskBox.find('.box-title').html('Nova Tarefa');
            $taskList.addClass('d-none');
            $taskContainerNew.removeClass('d-none');

            $('.task-buttons').addClass('d-none');

            $btnCancelAdd.on("click", function() {
                $('.task-buttons').removeClass('d-none');
                $taskBox.find('.box-title').html('Tarefas');
                $taskList.removeClass('d-none');
                $taskContainerNew.addClass('d-none');
            })
            $('#form-store-update-task')[0].reset();
            $('#select--prioridade').val('baixa').trigger('change');
            clearForm();
        })

        $('#lembrete').on('click', function() {
            if ($(this).is(':checked')) {
                $inputDateTime = $('#dateTime');
                $inputDateTime.attr('disabled', false).attr('readonly', false);
                $inputDateTime.removeClass('d-none')
            } else {
                $inputDateTime = $('#dateTime');
                $inputDateTime.attr('disabled', true).attr('readonly', true);
                $inputDateTime.addClass('d-none')
            }
        })

        $("#form-store-update-task").submit(function(event) {
            event.preventDefault();
            var post_url = $(this).attr("action");
            var request_method = $(this).attr("method");
            var form_data = new FormData($("#form-store-update-task")[0]);

            $.ajax({
                url: post_url,
                type: request_method,
                data: form_data,
                processData: false,
                cache: false,
                contentType: false,
                dataType: 'json',
                success: function(r) {
                    $('#form-store-update-task').find('.btn-submit').attr('disabled', false).html('Salvar');
                    $taskBox.find('.box-title').html('Tarefas');
                    $('.task-buttons').removeClass('d-none');
                    $taskBox.find('.box-title').html('Tarefas');
                    $taskList.removeClass('d-none');
                    $taskContainerNew.addClass('d-none');
                    all(false);
                    clearForm();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $.each(XMLHttpRequest.responseJSON.errors, function(index, value) {
                        $(`#input--${index}`).addClass('is-invalid');
                        toastr.error(value[0]);
                    });
                    $('#form-store-update-task').find('.btn-submit').attr('disabled', false).html('Salvar');
                }
            });
        });

        function all(done = false) {
            $.ajax({
                url: `{{ route('tasks.all') }}`,
                type: "GET",
                ajax: true,
                dataType: "JSON",
                data: {
                    done: done
                },
                beforeSend: (jqXHR, settings) => {
                    $('#tasks-list').html(preload());
                },
                success: function(j) {
                    var options = '';
                    tasks = j.data;
                    if (tasks.length > 0) {
                        $.each(tasks, function(index, value) {
                            var check = value.status ? 'checked' : null;
                            options += `<li id="task_${value.id}">`;
                            options += `    <div class="col-mail col-mail-1">`;
                            options += `        <div class="checkbox-wrapper-mail">`;
                            options += `            <input type="checkbox" ${check} onclick="status(this)" class="js-btn-status" data-id="${value.id}" id="chk${value.id}">`;
                            options += `            <label for="chk${value.id}" class="toggle"></label>`;
                            options += `        </div>`;
                            options += `        <a href="javascript:void(0)" data-id="${value.id}" class="title task-show">${value.tar_titulo}</a>`;
                            options += `    </div>`;
                            options += `    <div class="col-mail col-mail-2">`;
                            options += `        <span class="badge-${value.badge} badge mr-2">${value.prioridade}</span>`;
                            options += `        <span class="teaser">${value.dateFormatHuman}</span>`;
                            options += `    </div>`;
                            options += `</li>`;
                        });
                    } else {
                        options = '<h6 class="text-center my-4">Sem tarefas</h6>';
                    }
                    $('#tasks-list').html(options);

                    $('.task-show').on('click', function(e) {
                        if ($(e.target).closest('.checkbox-wrapper-mail, .js-btn-status').length > 0) {
                            return;
                        }
                        show($(this).attr('data-id'))
                    });
                },
                complete: function() {},
            });
        }

        function show(task_id) {
            $.ajax({
                url: `${$routeTask}/${task_id}`,
                type: "GET",
                ajax: true,
                dataType: "JSON",
                beforeSend: (jqXHR, settings) => {},
                success: function(j) {
                    task = j.data;
                    $taskBox.find('.box-title').html(`${task.tar_titulo}`);
                    $taskBox.find('#form-store-update-task').attr('action', `${$routeTask}/${task_id}`);

                    $('#input--tar_descricao').val(task.tar_descricao);
                    $('#input--tar_titulo').val(task.tar_titulo);
                    $('#select--prioridade').val(`${task.prioridade}`).trigger('change');

                    if (task.lembrete) {
                        $('#lembrete').attr('checked', true);
                        $inputDateTime = $('#dateTime');
                        $inputDateTime.attr('disabled', false).attr('readonly', false);
                        $inputDateTime.removeClass('d-none')
                        $inputDateTime.val(task.lembrete);
                    }

                    $('.task-buttons').addClass('d-none');
                    $taskList.addClass('d-none');
                    $taskContainerNew.removeClass('d-none');
                    $btnCancelAdd.on("click", function() {
                        $('.task-buttons').removeClass('d-none');
                        $taskBox.find('.box-title').html('Tarefas');
                        $taskList.removeClass('d-none');
                        $taskContainerNew.addClass('d-none');
                    })
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    toastr.error(errorThrown);
                },
                complete: function() {},
            });
        }
        

        function status(v) {
            var task_id = $(v).attr('data-id');
            var check = $(v).is(":checked") ? 'concluido' : 'em_andamento';
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                url: `${$routeTask}/${task_id}/status`,
                type: 'POST',
                ajax: true,
                dataType: "JSON",
                data: {
                    check: check
                }
            }).done(function(response) {
                $(`#task_${task_id}`).remove();
            });
        }

        function clearForm() {
            $.each($('#form-store-update-task').find('.is-invalid'), function() {
                $(this).removeClass('is-invalid');
            });
            $inputDateTime = $('#dateTime');
            $inputDateTime.attr('disabled', true).attr('readonly', true);
            $inputDateTime.addClass('d-none')
        }

        function preload() {
            var preload = ''
            preload += `<div class="text-center" id="preloader-content-tasks">`;
            preload += `    <div class="spinner-border text-primary m-1 align-self-center" role="status">`;
            preload += `        <span class="sr-only"></span>`;
            preload += `    </div>`;
            preload += `</div>`;
            return preload;
        }
    </script>
@endsection
