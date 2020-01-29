{{--

    Ссылка для удажения с подтверждением действия
    v.1.0

--}}
@component('components.dropdowns.link',[
    'title' => $title ?? 'Удалить',
    'url' => $url ?? null,
    'class' => 'danger',
    'attr' => ['data-toggle'=>'confirm-delete']
])
    @isset($help)
        <div class="dropdown-help">{{ $help }}</div>
    @endisset
@endcomponent

