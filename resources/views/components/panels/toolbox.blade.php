{{--
    v.1.2
--}}
@component('components.panels.menu',['header'=>'Инструменты', 'id'=>'toolbox', 'icon'=>'wrench'])
    {{ $slot }}
    @if( isset($help_modal) || isset($help_template))
        {{-- Обнуляем $slot чтобы он не передаваля дальше по вложениям--}}
        @include('components.panels.menu.link_modal',array_merge(get_defined_vars()['__data'], [
            'slot' => null,
            'title' => 'Помощь',
            'icon' => 'fas fa-question-circle',
            'id' => $help_id ?? 'dHelp',
        ]))
        @isset($help_template)
            @push('modals')
                @component('components.dialogs.modal',['id' => $help_id ?? 'dHelp'])
                    @includeIf($help_template)
                @endcomponent
            @endpush
        @endisset
    @endif
@endcomponent
