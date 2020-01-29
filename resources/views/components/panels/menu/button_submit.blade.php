{{--

    v.1.0

--}}
<button type="submit" form="{{ $form ?? 'form' }}" class="list-group-item list-group-item-action text-primary font-weight-bold clickable">
    <i class="fa fa-check fa-fw"></i>
    {{ $title ?? 'Подтвердить' }}
    @isset($help)
        <div class="text-help">{{ $help }}</div>
    @endisset
</button>
