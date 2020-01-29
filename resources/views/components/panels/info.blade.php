{{--

    v.1.1

--}}
<div class="card {{ $margin ?? 'mb-2' }} {{ $class ?? '' }}">
    <div class="card-body py-2">
        {{ $slot }}
        @if(isset($item) && !isset($hideDates))
            @if(isset($item->created_at))
                @component('components.panels.info.text', ['title'=>'Дата создания'])
                    {{ $item->created_at->format('d.m.Y H:i:s') }}
                @endcomponent
            @endif
            @if(isset($item->updated_at))
                @component('components.panels.info.text', ['title'=>'Последнее изменение'])
                    {{ $item->updated_at->format('d.m.Y H:i:s') }}
                @endcomponent
            @endif
            @component('components.panels.info.title',['margin'=>'m-0'])
                ID: {{ $item->id }}
            @endcomponent
        @endif
    </div>
</div>

