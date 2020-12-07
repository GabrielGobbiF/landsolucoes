@extends('pages.painel.vehicles.app')

@section('title', 'Editar Veiculo')

@section('content')
    <div class="container">
        <h4 class="text-center">{{ $vehicle->name ?? '' }} </h4>
        <div class="row mt-3">
            <div class="col-md-2">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link mb-2 active" id="v-pills-dados-tab" data-toggle="pill" href="#v-pills-dados" role="tab" aria-controls="v-pills-dados" aria-selected="true">Dados</a>
                    <a class="nav-link mb-2" id="v-pills-history-tab" data-toggle="pill" href="#v-pills-history" role="tab" aria-controls="v-pills-history" aria-selected="false">Atividades</a>
                    <!-- <a class="nav-link mb-2" id="v-pills-maintenance-tab" data-toggle="pill" href="#v-pills-maintenance" role="tab" aria-controls="v-pills-maintenance" aria-selected="false">Histórico</a> -->
                    <a class="nav-link mb-2 " id="v-pills-new-tab" data-toggle="pill" href="#v-pills-new" role="tab" aria-controls="v-pills-new" aria-selected="false">Novo</a>
                </div>
            </div>
            <div class="col-md-10">
                <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                    <div class="tab-pane fade  show active" id="v-pills-dados" role="tabpanel" aria-labelledby="v-pills-dados-tab">
                        <div class="card">
                            <form role="form" class="needs-validation" novalidate id="form" autocomplete="off"
                                action="{{ route('vehicles.update', $vehicle->id) }}" method="POST">
                                @method('PUT')
                                @include('pages.painel.vehicles._partials.form_vehicle')
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-history" role="tabpanel" aria-labelledby="v-pills-history-tab">
                        <div class="card">
                            <div id="toolbar">
                                <h4 class="header mt-0">Histório de Atividades</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table data-toggle="table" id="table" class="table table-borderless" data-search="true"
                                            data-pagination="true" data-page-list="[10, 25, 50, 100, all]" data-cookie="true"
                                            data-cookie-id-table="vehicles" data-buttons-class="dark" data-toolbar="#toolbar">
                                            <thead style="border-bottom: 1px solid rgba(0, 0, 0, 0.125)">
                                                <tr>
                                                    <th>#</th>
                                                    <th style="width: 34%">Descrição</th>
                                                    <th>KM Atual</th>
                                                    <th>Data Inicial </th>
                                                    <th>Data Final </th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($activitys as $activity)
                                                    <tr>
                                                        <td>{{ $activity->id }}</td>
                                                        <td> <a href="javascript:void(0);" onclick="editHistorico(2666)"> {{ ucfirst($activity->title) }} </a> <br> <small>Motorista: <b>
                                                                    {{ $activity->driver_name }} </b> </small>
                                                        </td>
                                                        <td>{{ $activity->km_start ?? '' }}</td>
                                                        <td>{{ $activity->created_at ?? '' }}</td>
                                                        <td>{{ $activity->updated_at ?? '' }}</td>

                                                        @if ($activity->nota_fiscal != '')
                                                            <td><a href="{{ asset('storage/' . $activity->nota_fiscal) }}" target="_blank"> ver </a></td>
                                                        @else
                                                            <td></td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-maintenance" role="tabpanel" aria-labelledby="v-pills-maintenance-tab">
                        <div class="card-body">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                    <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                    <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                    <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                </div>
                            </div>

                            <h4 class="card-title mb-4">Recent Activity Feed</h4>

                            <div data-simplebar="init" style="max-height: 330px;">
                                <div class="simplebar-wrapper" style="margin: 0px;">
                                    <div class="simplebar-height-auto-observer-wrapper">
                                        <div class="simplebar-height-auto-observer"></div>
                                    </div>
                                    <div class="simplebar-mask">
                                        <div class="simplebar-offset" style="right: -17px; bottom: 0px;">
                                            <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll;">
                                                <div class="simplebar-content" style="padding: 0px;">
                                                    <ul class="list-unstyled activity-wid">
                                                        <li class="activity-list">
                                                            <div class="activity-icon avatar-xs">
                                                                <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                                    <i class="ri-edit-2-fill"></i>
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <div>
                                                                    <h5 class="font-size-13">28 Apr, 2020 <small class="text-muted">12:07 am</small></h5>
                                                                </div>

                                                                <div>
                                                                    <p class="text-muted mb-0">Responded to need “Volunteer Activities”</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="activity-list">
                                                            <div class="activity-icon avatar-xs">
                                                                <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                                    <i class="ri-user-2-fill"></i>
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <div>
                                                                    <h5 class="font-size-13">21 Apr, 2020 <small class="text-muted">08:01 pm</small></h5>
                                                                </div>

                                                                <div>
                                                                    <p class="text-muted mb-0">Added an interest “Volunteer Activities”</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="activity-list">
                                                            <div class="activity-icon avatar-xs">
                                                                <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                                    <i class="ri-bar-chart-fill"></i>
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <div>
                                                                    <h5 class="font-size-13">17 Apr, 2020 <small class="text-muted">09:23 am</small></h5>
                                                                </div>

                                                                <div>
                                                                    <p class="text-muted mb-0">Joined the group “Boardsmanship Forum”</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="activity-list">
                                                            <div class="activity-icon avatar-xs">
                                                                <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                                    <i class="ri-mail-fill"></i>
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <div>
                                                                    <h5 class="font-size-13">11 Apr, 2020 <small class="text-muted">05:10 pm</small></h5>
                                                                </div>

                                                                <div>
                                                                    <p class="text-muted mb-0">Responded to need “In-Kind Opportunity”</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="activity-list">
                                                            <div class="activity-icon avatar-xs">
                                                                <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                                    <i class="ri-calendar-2-fill"></i>
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <div>
                                                                    <h5 class="font-size-13">07 Apr, 2020 <small class="text-muted">12:47 pm</small></h5>
                                                                </div>

                                                                <div>
                                                                    <p class="text-muted mb-0">Created need “Volunteer Activities”</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="activity-list">
                                                            <div class="activity-icon avatar-xs">
                                                                <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                                    <i class="ri-edit-2-fill"></i>
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <div>
                                                                    <h5 class="font-size-13">05 Apr, 2020 <small class="text-muted">03:09 pm</small></h5>
                                                                </div>

                                                                <div>
                                                                    <p class="text-muted mb-0">Attending the event “Some New Event”</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="activity-list">
                                                            <div class="activity-icon avatar-xs">
                                                                <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                                    <i class="ri-user-2-fill"></i>
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <div>
                                                                    <h5 class="font-size-13">02 Apr, 2020 <small class="text-muted">12:07 am</small></h5>
                                                                </div>

                                                                <div>
                                                                    <p class="text-muted mb-0">Responded to need “In-Kind Opportunity”</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="simplebar-placeholder" style="width: auto; height: 719px;"></div>
                                </div>
                                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                    <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                                </div>
                                <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                    <div class="simplebar-scrollbar" style="height: 151px; transform: translate3d(0px, 179px, 0px); display: block;"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane fade" id="v-pills-new" role="tabpanel" aria-labelledby="v-pills-new-tab">
                        <div class="card">
                            <form role="form" class="needs-validation" novalidate id="form" autocomplete="off" enctype="multipart/form-data"
                                action="{{ route('vehicles.activitys.store', $vehicle->id) }}" method="POST">
                                @include('pages.painel.vehicles._partials.form_vehicleActivitys')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






    <!-- <h4 class="text-center">{{ $vehicle->name ?? '' }} </h4>
                                                                <div class="col-md-12 mt-3">
                                                                    <div class="card">
                                                                        <form role="form" class="needs-validation" novalidate id="form" autocomplete="off"
                                                                            action="{{ route('vehicles.update', $vehicle->id) }}" method="POST">
                                                                            @@method('PUT')
                                                                            @@include('pages.painel.vehicles._partials.form_vehicle')
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 mt-3">

                                                                </div>
                                                            </div>-->
@stop
