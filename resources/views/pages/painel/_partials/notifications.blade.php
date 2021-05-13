<div class="dropdown d-inline-block">
    <button type="button" class="btn header-item noti-icon waves-effect"
        id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        <i class="ri-notification-3-line"></i>
        <span class="noti-dot"></span>
    </button>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
        aria-labelledby="page-header-notifications-dropdown">
        <div class="p-3">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="m-0"> {{ __('Notificações') }} </h6>
                </div>
                <div class="col-auto">
                    <a href="#!" class="small"> {{ __('Marcar todas como lida') }}</a>
                </div>
            </div>
        </div>
        <div data-simplebar style="max-height: 230px;">
            <a href="" class="text-reset notification-item d-none">
                <div class="media">
                    <div class="avatar-xs mr-3">
                        <span class="avatar-title bg-primary rounded-circle font-size-16">
                            <i class="ri-shopping-cart-line"></i>
                        </span>
                    </div>
                    <div class="media-body">
                        <h6 class="mt-0 mb-1">Your order is placed</h6>
                        <div class="font-size-12 text-muted">
                            <p class="mb-1">If several languages coalesce the grammar</p>
                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="p-2 border-top">
            <a class="btn btn-sm btn-link font-size-14 btn-block text-center"
                href="javascript:void(0)">
                <i class="mdi mdi-arrow-right-circle mr-1"></i> {{ __('Ver todas') }}
            </a>
        </div>
    </div>
</div>
