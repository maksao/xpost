{{--

    v.1.1

--}}
<button type="button" class="list-group-item list-group-item-action clickable" data-toggle="modal" data-target="#{{ $mID ?? 'mFileUpload' }}">
    <div class="d-flex align-items-center">
        <i class="fas fa-upload fa-fw text-primary"></i>
        <div class="ml-3">{{ $title ?? 'Загрузить файл' }}</div>
    </div>
</button>
@push('modals')
    @component('components.dialogs.modal_w_form',[
        'id'    =>  $mID ?? 'mFileUpload',
        'title' => $title ?? 'Загрузить файл',
        'url'   =>  $url ?? null,
        'files' => true,
    ])
        @include('components.forms.plain.input',[
            'type' => 'file',
            'label' => 'Укажите файл',
            'name' => $filename ?? 'userfile',
            'required' => true
        ])
    @endcomponent
@endpush
