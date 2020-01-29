<div class="list-group {{ $margin ?? 'mb-2' }}">
    @empty($hideHeader)
        <div class="list-group-item list-group-item-info clickable" data-toggle="collapse" data-target="#panel-info">
            <h6 class="mb-0"><i class="fa fa-info-circle fa-fw text-info"></i> {{ $header ?? 'Информация' }}</h6>
        </div>
    @endempty
    <div class="collapse{{ isset($show) ? ' show' : '' }}" id="panel-info">
        {{-- слот до строк с данными по записям --}}
        {{ $_before ?? '' }}

        {{-- Общее количество записей найденных по условию поиска (без фильтров тоже считается) --}}
        @if(isset($rtotal))
            @component('components.panels.info.count',['count'=>$rtotal])
                Количество записей
            @endcomponent
        @endif

        {{-- Количество записей на странице (rows per page) --}}
        @if(isset($r_pp))
            @component('components.panels.info.count',['count'=>$rpp])
                Отображается на странице
            @endcomponent
        @endif

        {{ $slot }}
    </div>
</div>
