{{-- content of formButton.blade.php --}}
<form method="POST" action="{{ $action }}">
    @csrf
    @method($method ?? 'POST')
    <button
        type="submit"
        class="{{ $class ?? '' }}">
        {{ $slot }}
    </button>
</form>
