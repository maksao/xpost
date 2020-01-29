{{--

    v.1.2

--}}
<div class="d-flex">
    @if(isset($pagination, $items) || isset($pagination_top, $items))
        <div>{{ $items->links('vendor.pagination.bootstrap-4') }}</div>
    @endif
    @isset($over)
        <div class="ml-auto">{{ $over }}</div>
    @endisset
</div>
@isset($responsive)
    <div class="table-responsive">
@endisset
<table class="table table-hover {{ $size ?? 'table-sm' }} {{ $class ?? '' }}">
    @isset($header)
        @include('components.tables.header')
    @endisset
    {{ $slot }}
</table>
@isset($responsive)
    </div>
@endisset
<div class="d-flex">
    @if(isset($pagination, $items) || isset($pagination_bottom, $items))
        {{ $items->links('vendor.pagination.bootstrap-4') }}
    @endif
    @isset($under)
        <div class="ml-auto">{{ $under }}</div>
    @endisset
</div>
@if(isset($header) && in_array('#check#', $header))
    <form id="checked-actions-form" method="post">{{ csrf_field() }}</form>
@endif