{{--
    v.1.1
--}}
<div class="modal fade" id="{{ $id ?? 'dModal' }}">
    <div class="modal-dialog{{ isset($size) ? ' modal-'.$size : '' }}" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title ?? 'Помощь' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    {{ $slot }}
                </div>
            <div class="modal-footer">
                @isset($modal_footer)
                    {{ $modal_footer }}
                @endisset
                @isset($submit)
                    <button
                        class="btn btn-success"
                        data-dismiss="modal"
                        @isset($submit['form'])
                            form="{{ $submit['form'] }}"
                        @endisset
                    >{{ $submit['text'] ?? 'Сохранить' }}</button>
                @endisset
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>