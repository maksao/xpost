{{--
    09.02.2018
--}}

<div class="modal fade" id="dConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="myModalLabel"><i class="fa fa-trash fa-fw"> </i> {{ $dTitle ?? 'Удаление' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                @if(isset($slot))
                    {{ $slot }}
                @elseif( isset($message) )
                    <p>{{ $message }}</p>
                @else
                    <p>Вы собираетесь удалить данные, эта процедура необратима.</p>
                    <p>Вы хотите продолжить?</p>
                @endif
                <p class="debug-url"></p>
            </div>

            <div class="modal-footer">
                <form method="post">
                    {{csrf_field()}}{{method_field('DELETE')}}
                    <button type="submit" class="btn btn-danger">Удалить</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                </form>
            </div>
        </div>
    </div>
</div>