{{--
    v.1.0
--}}
<div class="modal fade" id="{{ $id ?? 'dInfo' }}">
    <div class="modal-dialog{{ isset($size) ? ' modal-'.$size : '' }}" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title ?? 'Помощь' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- таблицу используем для горизонтальной прокрутки широкого контента --}}
                <div class="table-responsive">
                    <table class="table">
                    <tr><td class="border-0 p-0"><div id="modal-body-content">{{ $slot }}</div></td></tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>