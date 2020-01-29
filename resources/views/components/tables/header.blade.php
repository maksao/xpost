{{--
    v.1.3
--}}

<thead>
    <tr class="small">
        @foreach($header as $key => $cell)
            @if(is_array($cell))
                <th class="{{ isset($cell['align']) ? 'text-'.$cell['align'] : '' }}{{ isset($cell['class']) ? ' '.$cell['class'] : '' }}">
                    @isset($cell['content'])
                        {!! $cell['content'] !!}
                    @else
                        {!! $key !!}
                    @endisset
                    @isset($cell['help'])
                        @component('components.tooltips.question_mark')
                            {!! $cell['help'] !!}
                        @endcomponent
                    @endisset
                </th>
            @else
                @switch($cell)
                    @case('#icon#')
                        <th class="icon">&nbsp;</th>
                    @break
                    @case('#check#')
                        <th class="actions-with-checked">
                            @component('components.dropdowns.actions_with_checked')@endcomponent
                        </th>
                    @break
                    @case('#pos#')
                        <th>Поз.</th>
                    @break
                    @case('#actions#')
                        <th>&nbsp;</th>
                    @break
                    @default
                        <th>{!! $cell !!}</th>
                @endswitch
            @endif
        @endforeach
    </tr>
</thead>

{{--
<thead>
<tr class="small">
    @foreach($header as $key => $cell)

        @switch($cell)
            @case('#icon#')
                <th class="icon">&nbsp;</th>
            @break
            @case('#check#')
                <th class="actions-with-checked">
                    @component('components.dropdowns.actions_with_checked')@endcomponent
                </th>
            @break
            @case('#pos#')
                <th>Поз.</th>
            @break
            @case('#actions#')
                <th>&nbsp;</th>
            @break
            @default
                @if(is_array($cell))
                    <th class="{{ isset($cell['align']) ? 'text-'.$cell['align'] : '' }}">
                        @isset($cell['content'])
                            {!! $cell['content'] !!}
                        @else
                            {!! $key !!}
                        @endisset
                        @isset($cell['help'])
                            @component('components.tooltips.question_mark')
                                {!! $cell['help'] !!}
                            @endcomponent
                        @endisset
                    </th>
                @else
                    <th>{!! $cell !!}</th>
                @endif
        @endswitch
    @endforeach
</tr>
</thead>

--}}
