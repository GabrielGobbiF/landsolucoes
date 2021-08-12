<div class="dropdown d-inline-block">
    <button type="button" class="btn header-item noti-icon waves-effect"
        id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        <i class="fas fa-bell"></i>
        <span class="{{ $notifications->count() > 0 ? 'noti-dot' : '' }}"></span>
    </button>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
        aria-labelledby="page-header-notifications-dropdown">
        <div class="p-3">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="m-0"> {{ __('Notificações') }} </h6>
                </div>
                <div class="col-auto">
                    @if ($notifications->count() > 0)
                        <a href="#!" class="small"> {{ __('Marcar todas como lida') }}</a>
                    @endif
                </div>
            </div>
        </div>
        <div data-simplebar style="max-height: 230px;" class="card-maximum-height">
            @if ($notifications && $notifications->count() > 0)
                @foreach ($notifications as $unreadNotification)
                    <a href="javascript:void(0)" data-href="{{ $unreadNotification->data['link'] ?? '#' }}" class="text-reset notification-item notification-item-header"
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
                                    <p class="mb-1">{{ $unreadNotification->data['description'] ?? '' }}</p>
                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i>{{ dateTournamentForHumans($unreadNotification->created_at) }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
        <div class="p-2 border-top">
            <a class="btn btn-sm btn-link font-size-14 btn-block text-center"
                href="{{route('notifications.index')}}">
                <i class="mdi mdi-arrow-right-circle mr-1"></i> {{ __('Ver todas') }}
            </a>
        </div>
    </div>
</div>
