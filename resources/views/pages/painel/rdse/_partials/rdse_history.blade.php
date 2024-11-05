<style>
    .timeline {
        position: relative;
        padding: 20px 0;
        margin-top: 20px;
    }

    .timeline-item {
        position: relative;
        padding: 15px 20px;
        background-color: #ffffff;
        border: 1px solid #e3e3e3;
        border-radius: 5px;
        margin-bottom: 20px;
        width: 60%;
        margin-left: 40px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        width: 12px;
        height: 12px;
        background-color: #007bff;
        border-radius: 50%;
        left: -31px;
        top: 15px;
    }

    .timeline-item h4 {
        margin-top: 0;
        color: #007bff;
    }

    .timeline-item p {
        margin: 5px 0;
        color: #333;
    }

    .timeline-item time {
        display: block;
        color: #666;
        font-size: 0.9em;
    }
</style>

<div class="timeline">
    @foreach ($logs as $log)
        @if (isset($log->properties['attributes']['status_execution']) && isset($log->properties['old']))
            @if ($log->description != 'logs.events.badge.created')
                <div class="timeline-item">
                    <h4>Status Saiu de
                        <span class="text-danger">{{ $log->properties['old']['status_execution'] }}</span>
                        para:
                        <span class="text-success">{{ $log->properties['attributes']['status_execution'] }}</span>
                    </h4>
                    <p>Observação: {{ $log->properties['attributes']['observation_status'] ?? null }}</p>
                    <p>Por: {{ $log->causer->name }}</p>
                    <time>{{ $log->created_at->format('d/m/Y h:i') }}</time>
                </div>
            @endif
        @endif
    @endforeach
</div>
