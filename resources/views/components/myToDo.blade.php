<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 d-none">

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Notificação</a></li>
            <li><a href="#tab_2" data-toggle="tab">Minha Lista <small style="position: relative;top: 3px;left: 5px;" class="label pull-right bg-red" id="qntListUser">114</small></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <ul class="todo-list ui-sortable" id="toDoDiv">
                    <li> <label class="popver_urgencia" data-target=""> <a href="http://www2.cena.com.br/obras/edit/229?visto=true&amp;notId=3227?visto=true&amp;notId=3227"> <input type="checkbox"
                                    id="checkToDo3227" onclick="checkToDo(3227,60,0)" class="checkbox_desgn" undefined="" name="timeline-photo" value=""> <span style="    display: initial"> <span
                                        class="icon unchecked"> <span class="mdi mdi-check"></span> </span> </span> </a> </label> <a
                            href="http://www2.cena.com.br/obras/edit/229?visto=true&amp;notId=3227"><span class="text"> Nova Obra </span></a> <small> FGV - Privisória - 9 de Julho criado por
                            marcos </small> </li>
                    <li> <label class="popver_urgencia" data-target=""> <a href="http://www2.cena.com.br/obras/edit/225?visto=true&amp;notId=3276?visto=true&amp;notId=3276"> <input type="checkbox"
                                    id="checkToDo3276" onclick="checkToDo(3276,60,0)" class="checkbox_desgn" undefined="" name="timeline-photo" value=""> <span style="    display: initial"> <span
                                        class="icon unchecked"> <span class="mdi mdi-check"></span> </span> </span> </a> </label> <a
                            href="http://www2.cena.com.br/obras/edit/225?visto=true&amp;notId=3276"><span class="text"> Nova Obra </span></a> <small> Voetour - Parametrização criado por marc
                        </small> </li>
                    <li> <label class="popver_urgencia" data-target=""> <a href="http://www2.cena.com.br/obras/edit/230?visto=true&amp;notId=3301?visto=true&amp;notId=3301"> <input type="checkbox"
                                    id="checkToDo3301" onclick="checkToDo(3301,60,0)" class="checkbox_desgn" undefined="" name="timeline-photo" value=""> <span style="    display: initial"> <span
                                        class="icon unchecked"> <span class="mdi mdi-check"></span> </span> </span> </a> </label> <a
                            href="http://www2.cena.com.br/obras/edit/230?visto=true&amp;notId=3301"><span class="text"> Nova Obra </span></a> <small> Trimais - Obra Elétrica criado por marc
                        </small> </li>
                    <li> <label class="popver_urgencia" data-target=""> <a href="http://www2.cena.com.br/obras/edit/233?visto=true&amp;notId=3648?visto=true&amp;notId=3648"> <input type="checkbox"
                                    id="checkToDo3648" onclick="checkToDo(3648,60,0)" class="checkbox_desgn" undefined="" name="timeline-photo" value=""> <span style="    display: initial"> <span
                                        class="icon unchecked"> <span class="mdi mdi-check"></span> </span> </span> </a> </label> <a
                            href="http://www2.cena.com.br/obras/edit/233?visto=true&amp;notId=3648"><span class="text"> Nova Obra </span></a> <small> CLD - Ramal Alimentador Interno criado
                        </small> </li>
                    <li> <label class="popver_urgencia" data-target=""> <a href="http://www2.cena.com.br/obras/edit/236?visto=true&amp;notId=3814?visto=true&amp;notId=3814"> <input type="checkbox"
                                    id="checkToDo3814" onclick="checkToDo(3814,60,0)" class="checkbox_desgn" undefined="" name="timeline-photo" value=""> <span style="    display: initial"> <span
                                        class="icon unchecked"> <span class="mdi mdi-check"></span> </span> </span> </a> </label> <a
                            href="http://www2.cena.com.br/obras/edit/236?visto=true&amp;notId=3814"><span class="text"> Nova Obra </span></a> <small> Vitacon 51 - Baiuca criado por marcos </small>
                    </li>
                </ul>
            </div>
            <div class="tab-pane" id="tab_2">

                <div id="lista">
                    <ul class="todo-list ui-sortable" id="toDoDivListaUser">
                        <li> <label class="popver_urgencia" data-target=""> <input type="checkbox" id="checkToDo5136" onclick="checkToDo(5136,60,0)" class="checkbox_desgn" undefined=""
                                    name="timeline-photo" value=""> <span style="    display: initial"> <span class="icon unchecked"> <span class="mdi mdi-check"></span> </span> </span> </label>
                            <a href="javascript:void(0)" onclick="editTarefa(416)"><span class="text"> teste </span> </a> <small> teste </small> <small class="label label-danger"> ALTA</small>
                        </li>
                    </ul>
                </div>
                <input type="hidden" class="form-control" id="input-concluidos" name="input-concluidos" value="false">

                <div id="add" style="display: none">
                    <form id="formTodo" action="http://www2.cena.com.br/notificacao/add" method="POST">
                        <input type="hidden" class="form-control" id="id_tarefa" name="id_tarefa">

                        <div class="form-group">
                            <label for="">Titulo</label>
                            <input type="text" class="form-control" id="tar_titulo" name="tar_titulo" placeholder="Lembrar de pagar conta">
                        </div>
                        <div class="form-group">
                            <label for="tar_descricao">Descrição</label>
                            <textarea type="text" style="height: 93px;" class="form-control" id="tar_descricao" name="tar_descricao" placeholder="Preciso, lembrar de pagar..."> </textarea>
                        </div>
                        <div class="form-group">
                            <label>Prioridade</label>
                            <select class="form-control" name="tar_prioridade" id="tar_prioridade">
                                <option value="ALTA">ALTA</option>
                                <option value="BAIXA">BAIXA</option>
                                <option value="MÉDIA">MÉDIA</option>
                            </select>
                        </div>
                        <label>Lembrete</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" name="tar_prazo" id="tar_prazo" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                        </div>
                        <input type="hidden" name="tar_tipo" id="tar_tipo" class="form-control pull-right" value="userlista">

                        <div class="box-footer">
                            <div type="" class="btn btn-primary pull-right" id="buttonForm">Salvar</div>
                        </div>
                    </form>
                </div>
                <div class="box-footer clearfix no-border" style="position: static;">
                    <button type="button" id="addListUser" class="btn btn-default pull-right buttonSaved"><i class="fa fa-plus"></i> Add</button>
                    <!--<button type="button" id="updateListUser" class="btn btn-default pull-right buttonSaved" style="display:none;margin-left:5px"><i class="fa fa-edit"></i> Salvar</button>-->
                    <button type="button" id="concluidos" class="btn btn-default pull-left buttonSaved"> Mostrar Concluidos</button>
                    <button type="button" id="notconcluidos" style="display:none" class="btn btn-default pull-left buttonSaved"> Esconder Concluidos</button>
                    <button class="btn btn-danger pull-right" style="display:none;margin-left:5px" data-toggle="popover" title="" id="deleteLista" data-placement="top"
                        data-content="<a href='javascript:void(0)' onclick='deleteLista()' class='btn btn-danger'>Sim</a> <button type='button' class='btn btn-default pop-hide'>Não</button>"
                        data-original-title="Remover?">
                        <i class="fa fa-fw fa-trash"></i>
                    </button>
                    <button type="button" style="display:none" id="backList" class="btn btn-danger pull-right buttonSaved"> Voltar</button>

                </div>
            </div>
        </div>
    </div>
</div>
