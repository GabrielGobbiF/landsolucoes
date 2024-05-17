@if (isset($permission))
    @if (auth()->user()->can($permission))
        <button type="button"
            {{ isset($dataTarget) ? "data-target=$dataTarget" : '' }}
            {{ isset($dataToggle) ? "data-toggle=$dataToggle" : '' }}

            class="btn mt-3 {{ isset($class) ? $class : 'btn-primary' }}"
            {{ isset($btnText) ? $btnText : '' }}>

            <i class="{{ isset($icon) ? $icon : 'fas fa-save' }}"></i>
            {{ isset($name) ? $name : 'Salvar' }}
        </button>
    @endif
@else
    <button type="button"
        {{ isset($dataTarget) ? "data-target=$dataTarget" : '' }}
        {{ isset($dataToggle) ? "data-toggle=$dataToggle" : '' }}

        class="btn mt-3 {{ isset($class) ? $class : 'btn-primary' }}"
        {{ isset($btnText) ? $btnText : '' }}>

        <i class="{{ isset($icon) ? $icon : 'fas fa-save' }}"></i>
        {{ isset($name) ? $name : 'Salvar' }}
    </button>
@endif
