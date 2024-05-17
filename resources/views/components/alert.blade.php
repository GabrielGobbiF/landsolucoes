<div id="toast-container" class="toast-bottom-center">
    @if (is_array($message))
        @foreach ($message as $item)
            <div class="toast toast-success {{ $attributes->merge(['class' => 'c-alert c-alert--' . $level]) }}" aria-live="polite" style="">
                <div class="toast-progress" style="width: 13.6333%;"></div>
                <div class="toast-message">{{ $item }}</div>
            </div>
        @endforeach
    @else
        <div class="toast toast-success" aria-live="polite" style="">
            <div class="toast-progress" style="width: 13.6333%;"></div>
            <div class="toast-message">{{ $message }}</div>
        </div>
    @endif
    {{ $slot }}
</div>
