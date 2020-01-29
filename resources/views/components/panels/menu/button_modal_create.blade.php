{{--

    v.1.1

--}}
<button type="button" class="list-group-item list-group-item-action clickable" data-toggle="modal" data-target="#{{ $mID ?? 'mCreate' }}">
    <i class="fas fa-plus-square fa-fw text-success"></i> {{ $title ?? 'Добавить запись' }}
</button>
@push('modals')
    @component('components.dialogs.modal_w_form',[
        'id'  =>  $mID ?? 'mCreate',
        'title' => $mtitle ?? $title ?? 'Добавить запись',
        'url'       =>  $url ?? null,
    ])
        @isset($mFields){{ $mFields }}@endisset
    @endcomponent
@endpush
