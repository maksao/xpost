{{--
    v.1.1
--}}
<div class="list-group {{ $margin ?? 'mb-2' }}">
    <div class="list-group-item bg-secondary clickable" data-toggle="collapse" data-target="#panel-filters">
        <h6 class="mb-0 text-white"><i class="fa fa-filter fa-fw"></i> {{ $header ?? 'Фильтр' }}</h6>
    </div>
    <div class="collapse{{ isset($hide) ? '' : ' show' }}" id="panel-filters">
        <div class="list-group-item">
            <form action="{{ $url ?? '' }}" method="get" id="form-filters">
                <div class="text-right">
                    <button type="submit" class="btn btn-xs btn-outline-success" form="form-filters" title="Применить фильтр"><i class="fas fa-check-circle"></i></button>
                    <a href="{{ $reset_url ?? Request::url() }}" class="btn btn-xs btn-outline-danger" title="Сбросить фильтр"><i class="fas fa-times-circle"></i></a>
                </div>
                {{ $slot }}
                @if( isset($published) && $published === true )
                    @component('components.panels.filters.yes_no',[
                        'label'=>'Опубликовано',
                        'name'=>'pub'
                    ])@endcomponent
                @endif
                @if( isset($id) && $id === true )
                    @include('components.forms.plain.input',[
                        'form_group_class' => 'form-group-sm',
                        'label' => 'ID записи',
                        'name' => 'id',
                        'value' => request('id'),
                        'help' => 'Если указан, то остальное игнорируется'
                    ])
                @endif
                @if( isset($sort) && is_array($sort) && count($sort))
                    @component('components.panels.filters.sort',['fields'=>$sort])@endcomponent
                @endif
                <div class="mt-3">
                    <button type="submit" class="btn btn-sm btn-outline-primary" form="form-filters">Применить</button>
                    <a href="{{ $reset_url ?? Request::url() }}" class="btn btn-sm btn-outline-secondary">Сбросить</a>
                </div>
            </form>
        </div>
    </div>
</div>
