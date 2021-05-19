@extends('app')

@section('title', 'Notificações')

@section('content')

    <div class="container">
        <div class="header">
            <h1 class="header-title">Notificações</h1>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link nav-link-notifications mb-2 active" id="v-pills-not-read-tab" data-toggle="pill" href="#v-pills-not-read" role="tab" aria-controls="v-pills-not-read"
                                        aria-selected="true">Não Lidas</a>
                                    <a class="nav-link nav-link-notifications mb-2" id="v-pills-read-tab" data-toggle="pill" href="#v-pills-read" role="tab" aria-controls="v-pills-read"
                                        aria-selected="false">Lidas</a>
                                    <a class="nav-link nav-link-notifications mb-2" id="v-pills-archived-tab" data-toggle="pill" href="#v-pills-archived" role="tab" aria-controls="v-pills-archived"
                                        aria-selected="false">Arquivadas</a>
                                    <a class="nav-link nav-link-notifications" id="v-pills-trash-tab" data-toggle="pill" href="#v-pills-trash" role="tab" aria-controls="v-pills-trash"
                                        aria-selected="false">Lixeria</a>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                                    <div class="tab-pane tab-pane-notifications fade show active" id="v-pills-not-read" role="tabpanel" aria-labelledby="v-pills-not-read-tab">
                                        @if (count($unreadNotifications) > 0)
                                            <div class="table-responsive table-notification">
                                                <table class="table table-centered ">
                                                    <tbody>
                                                        @foreach ($unreadNotifications as $unreadNotification)
                                                            <tr>
                                                                <th class="text-reset notification-item-noti">
                                                                    <a href="{{ route('notifications.read', $unreadNotification->id) }}" class="">
                                                                        <div class="media">
                                                                            <div class="avatar-xs mr-3">
                                                                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                                                    <i class="{{ $unreadNotification->data['icon'] ?? 'fas fa-bell' }}"></i>
                                                                                </span>
                                                                            </div>
                                                                            <div class="media-body">
                                                                                <h6 class="mt-0 mb-1">{{ $unreadNotification->data['message'] }}</h6>
                                                                                <div class="font-size-12 text-muted">
                                                                                    <p class="mb-1">{{ $unreadNotification->data['description'] ?? '' }}</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </th>
                                                                <td>
                                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i>{{ dateTournamentForHumans($unreadNotification->created_at) }}</p>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="text-center">
                                                <h4 class="">tudo certo por aqui</h4>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane tab-pane-notifications fade" id="v-pills-read" role="tabpanel" aria-labelledby="v-pills-read-tab">
                                        @if (count($readNotifications) > 0)
                                            <div class="table-responsive table-notification">
                                                <table class="table table-centered ">
                                                    <tbody>
                                                        @foreach ($readNotifications as $readNotification)
                                                            <tr>
                                                                <th class="text-reset notification-item-noti">
                                                                    <a href="{{ route('notifications.read', $readNotification->id) }}" class="">
                                                                        <div class="media">
                                                                            <div class="avatar-xs mr-3">
                                                                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                                                    <i class="{{ $readNotification->data['icon'] ?? 'fas fa-bell' }}"></i>
                                                                                </span>
                                                                            </div>
                                                                            <div class="media-body">
                                                                                <h6 class="mt-0 mb-1">{{ $readNotification->data['message'] }}</h6>
                                                                                <div class="font-size-12 text-muted">
                                                                                    <p class="mb-1">{{ $readNotification->data['description'] ?? '' }}</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </th>
                                                                <td>
                                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i>{{ dateTournamentForHumans($readNotification->created_at) }}</p>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('notifications.archived', [$readNotification->id, 'tab' => 'read']) }}" data-toggle="tooltip"
                                                                        data-original-title="Arquivar"
                                                                        class="btn btn-sm"><i class="fas fa-folder-open tx-primary"></i></a>
                                                                    <a href="{{ route('notifications.deleted', [$readNotification->id, 'tab' => 'read']) }}" data-toggle="tooltip"
                                                                        data-original-title="Deletar"
                                                                        class="btn btn-sm"><i class="fas fa-trash tx-primary"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="text-center">
                                                <h4 class="">tudo certo por aqui</h4>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane tab-pane-notifications fade" id="v-pills-archived" role="tabpanel" aria-labelledby="v-pills-archived-tab">
                                        @if (count($archiveds) > 0)
                                            <div class="table-responsive table-notification">
                                                <table class="table table-centered ">
                                                    <tbody>
                                                        @foreach ($archiveds as $archivedNotification)
                                                            <tr>
                                                                <th class="text-reset notification-item-noti">
                                                                    <a href="{{ route('notifications.read', $archivedNotification->id) }}" class="">
                                                                        <div class="media">
                                                                            <div class="avatar-xs mr-3">
                                                                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                                                    <i class="{{ $archivedNotification->data['icon'] ?? 'fas fa-bell' }}"></i>
                                                                                </span>
                                                                            </div>
                                                                            <div class="media-body">
                                                                                <h6 class="mt-0 mb-1">{{ $archivedNotification->data['message'] }}</h6>
                                                                                <div class="font-size-12 text-muted">
                                                                                    <p class="mb-1">{{ $archivedNotification->data['description'] ?? '' }}</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </th>
                                                                <td>
                                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i>{{ dateTournamentForHumans($archivedNotification->created_at) }}</p>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('notifications.deleted', [$archivedNotification->id, 'tab' => 'archived']) }}" data-toggle="tooltip"
                                                                        data-original-title="Deletar"
                                                                        class="btn btn-sm"><i class="fas fa-trash tx-primary"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="text-center">
                                                <h4 class="">tudo certo por aqui</h4>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane tab-pane-notifications fade" id="v-pills-trash" role="tabpanel" aria-labelledby="v-pills-trash-tab">
                                        @if (count($trasheds) > 0)
                                            <div class="table-responsive table-notification">
                                                <table class="table table-centered ">
                                                    <tbody>
                                                        @foreach ($trasheds as $trashedNotification)
                                                            <tr>
                                                                <th class="text-reset notification-item-noti">
                                                                    <a href="{{ route('notifications.read', $trashedNotification->id) }}" class="">

                                                                        <div class="media">
                                                                            <div class="avatar-xs mr-3">
                                                                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                                                    <i class="{{ $trashedNotification->data['icon'] ?? 'fas fa-bell' }}"></i>
                                                                                </span>
                                                                            </div>
                                                                            <div class="media-body">
                                                                                <h6 class="mt-0 mb-1">{{ $trashedNotification->data['message'] }}</h6>
                                                                                <div class="font-size-12 text-muted">
                                                                                    <p class="mb-1">{{ $trashedNotification->data['description'] ?? '' }}</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </th>
                                                                <td>
                                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i>{{ dateTournamentForHumans($trashedNotification->created_at) }}</p>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="text-center">
                                                <h4 class="">tudo certo por aqui</h4>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (Request::input('tab'))
        <script async>
            $(document).ready(function() {
                $('.nav-link-notifications').removeClass('active');
                $("#v-pills-{{ Request::input('tab') }}-tab").addClass('active');
                $('.tab-pane-notifications').removeClass('active');
                $("#v-pills-{{ Request::input('tab') }}").addClass('active');
            });

        </script>
    @endif
@endsection
