{{--
    Ячейка с переключателем флага
    v.1.0

    параметр $flag передается без приставки 'is_' она добавляется автоматически где надо
--}}
<td class="{{ $class ?? '' }}">
    @if( !isset($update) || $update === true )
        @include('components.forms.presets.switch',[
            'id' => ltrim($flag, 'is_').$item->id,
            'checked' => $item->isFlag($flag) ? true : null,
            'class' => 'mb-0',
            'attr' => [
                'data-url' => route($route_prefix.'.toggle-flag', [$item->id, ltrim($flag, 'is_')])
            ]
        ])
    @else
        {{ $item->pos }}
    @endif
</td>