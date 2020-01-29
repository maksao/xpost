@component('components.dialogs.modal', [
    'id' => $modal_id ?? null,
    'title' => $title ?? null,
    'modal_footer' => $modal_footer ?? null,

])
    @component('components.forms.form', get_defined_vars()['__data'])
        {{ $slot }}
    @endcomponent
@endcomponent