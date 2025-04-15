<div class="dropdown d-inline-block no-print">
    <button id="page-header-notifications-dropdown" type="button" class="btn header-item noti-icon waves-effect" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
        <i class="fas fa-bell"></i>
        <span class="{{ isset($notifications) && count($notifications) > 0 ? 'noti-dot' : '' }}"></span>
    </button>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-notifications-dropdown">
        <div class="p-3">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="m-0"> {{ __('Notificações') }} </h6>
                </div>
                <div class="col-auto">
                    @if (isset($notifications) && count($notifications) > 0)
                        <a href="{{ route('notifications.read.all') }}" class="small"> {{ __('Marcar todas como lida') }}</a>
                    @endif
                </div>
            </div>
        </div>
        <div data-simplebar="" class="h-4" class="card-maximum-height" style="height: 200px;
    overflow: auto;">
            @if (isset($notifications) && count($notifications) > 0)
                @foreach ($notifications as $unreadNotification)
                    <a href="{{ route('notifications.show', $unreadNotification->id) }}" class="text-reset notification-item notification-item-header"
                       data-id="{{ $unreadNotification->id }}">
                        <div class="media">
                            <div class="avatar-xs mr-3">
                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                    <i class="{{ $unreadNotification->data['icon'] ?? '' }}"></i>
                                </span>
                            </div>
                            <div class="media-body">
                                <h6 class="mt-0 mb-1">{{ $unreadNotification->data['message'] }}</h6>
                                <div class="font-size-12 text-muted">
                                    <p class="mb-1">
                                        {{ isset($unreadNotification?->data['description']) ? $unreadNotification->data['description'] : null }}</p>
                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i>{{ dateTournamentForHumans($unreadNotification->created_at) }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
        <div class="p-2 border-top">
            <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="{{ route('notifications.index') }}">
                <i class="mdi mdi-arrow-right-circle mr-1"></i> {{ __('Ver todas') }}
            </a>
        </div>
    </div>
</div>
