<div class="col-12 col-md-4">
    <div class="card">
        <div class="d-flex card-header justify-content-between align-items-center">
            Histórico de Atividade
            <div class="dropdown d-none">
                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-dots-vertical"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                </div>
            </div>
        </div>

        <div class="card-body py-0 mb-3" data-simplebar class="h-100">
            <div class="timeline-alt py-2">

                @foreach ($logs as $log)
                    <div class="timeline-item my-2">
                        <i class="mdi mdi-upload bg-info-lighten text-info timeline-icon"></i>
                        <div class="timeline-item-info">
                            <a href="#" class="fw-bold mb-1 d-block">
                                <small>
                                    {{ __trans($log->description, ['attribute' => __($log->log_name)]) }}
                                </small>
                            </a>

                            <p class="mb-0 pb-2">
                                <small class="text-muted d-grid">
                                    <span class="">{{ date_format($log->created_at, 'd/m/Y H:s') }}</span>
                                    @if (!empty($log->causer_id))
                                        <a class="fw-semibold" href="#!">
                                            id: {{ $log->id }} - U: {{ $log->causer->name }}
                                        </a>
                                    @endif
                                </small>
                            </p>


                            @if (isset($user))
                                <p class="mb-0 pb-2">
                                    <small class="text-muted">
                                        por: {{ $log->subject->name }}
                                    </small>
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
