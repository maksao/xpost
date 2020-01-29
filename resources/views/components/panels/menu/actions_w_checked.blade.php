{{--

    v.1.0

--}}
<div class="list-group-item list-group-item-action clickable{{ isset($class) ? ' '.$class : ''}}" href="{{ $url ?? '#' }}" data-toggle="collapse" data-target="#a-w-ch">
    <i class="far fa-check-square fa-fw text-primary"></i> С отмеченными <i class="fas fa-caret-right fa-fw" id="a-w-c-caret"></i>
</div>
<div class="collapse" id="a-w-ch">
    {{ $slot }}
</div>

@push('scripts')
    <script>
        $('#a-w-ch').on('show.bs.collapse', function () {
            $('#a-w-c-caret').toggleClass('fa-caret-right fa-caret-down')
        });
        $('#a-w-ch').on('hide.bs.collapse', function () {
            $('#a-w-c-caret').toggleClass('fa-caret-right fa-caret-down')
        });
    </script>
@endpush