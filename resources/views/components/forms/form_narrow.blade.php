<div class="d-flex justify-content-center">
    <div class="w-75">
        @component('components.forms.form', get_defined_vars()['__data'])
            {{ $slot }}
        @endcomponent
    </div>
</div>