<!-- Диалоговое окно -->
<div class="modal fade" id="{{$id ?? 'dConfirm'}}" role="dialog" aria-labelledby="{{$id ?? 'dConfirm'}}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">{{$title ?? 'Подтверждение действия'}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                {!! $body ?? 'Продолжить?' !!}
            </div>

            <div class="modal-footer" id="m-post">
                <form method="{{ $method ?? 'post' }}">
                    @if(isset($_method))
                        <input type="hidden" name="_method" value="{{$_method ?? 'POST'}}">
                    @endif
                    {{ csrf_field() }}
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-success" id="confirm">Продолжить</button>
                </form>
            </div>
            <div class="modal-footer" id="m-get">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                <a class="btn btn-success text-white" id="confirm">Продолжить</a>
            </div>
        </div>
    </div>
</div>
