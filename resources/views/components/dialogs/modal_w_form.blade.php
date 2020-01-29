{{--

    Диалоговое окно с формой
    v.1.2

--}}
<div class="modal fade" id="{{ $id ?? 'dModal' }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title ?? '' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @component('components.forms.form',['url'=>$url ?? '#', 'method'=>$method ?? 'post', 'required_notice'=>false, 'files'=> $files ?? null])
                <div class="modal-body">
                    {{ $slot }}
                    @if( !isset($required_notice) || $required_notice !== false)
                        <div>
                            <b class="text-danger">*</b> - поле должно быть заполнено!
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    @isset($modal_footer)){{ $modal_footer }}@endisset
                    <button type='submit' class="btn btn-success">{{ $submit_text ?? 'Подтвердить' }}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            @endcomponent
        </div>
    </div>
</div>

@empty($url)
    @push('scripts')
        <script>
            $('#{{ $id ?? 'dModal' }}').on('show.bs.modal', function(e){
                let url = $(e.relatedTarget).data('url') ? $(e.relatedTarget).data('url') : $(e.relatedTarget).attr('href');
                $(this).find('form').attr('action', url);
            });
            $('#{{ $id ?? 'dModal' }}').on('hidden.bs.modal', function(e){
                $(this).find('form').trigger('reset');
            });
        </script>
    @endpush
@endempty
