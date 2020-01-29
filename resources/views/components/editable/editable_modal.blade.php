{{--
    Модальное окно с формой для быстрого редактирования какого либо поля
--}}

<div class="modal fade" tabindex="-1" role="dialog" id="editableModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title ?? 'Редактирование' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @component('components.forms.form',['id'=>'editableModalForm', 'method'=>'post', 'required_notice'=>false])
                    {{-- сюда добавляются элементы, чтобы можно было легко очищать не теряя поле с токеном--}}
                    <div id="editableModalFormBody"></div>
                @endcomponent
            </div>
            <div class="modal-footer">
                {{--<button type="button" class="btn btn-success" id="submitButton">--}}
                    {{--<i class="far fa-check-circle fa-fw"></i> Да--}}
                {{--</button>--}}
                <button type="submit" form="editableModalForm" class="btn btn-success" id="submitButton">
                    <i class="far fa-check-circle fa-fw"></i> Да
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <i class="far fa-times-circle fa-fw"></i> Отмена
                </button>
            </div>
        </div>
    </div>
</div>

