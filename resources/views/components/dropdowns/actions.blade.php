{{--

    v.1.0

--}}
<div class="btn-group {{ $group_classes ?? '' }}">
    <button class="btn btn-{{ $size ?? 'xs' }} btn-outline-{{ $theme ?? 'primary' }} dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-cog"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-{{ $menu_align ?? 'right' }}">

        {{ $slot }}

        @if( isset($item) )
            <div class="dropdown-divider"></div>
            <div class="dropdown-info d-flex py-0">
                <span>ID:</span>
                <span class="ml-1" id="iid{{ $item->id }}">{{ $item->id }}</span>
                <i class="far fa-copy ml-auto clickable" style="line-height:1.5" data-clipboard-target="#iid{{ $item->id }}" data-clipboard="copy" data-toggle="tooltip" title="Скопировать в буфер"></i>
            </div>
            @if(isset($item->created_at) || isset($item->updated_at))
                @if(isset($item->created_at))
                    <div class="dropdown-info d-flex justify-content-between py-0">
                        <span>Созд:</span>
                        <span>{{ $item->created_at->format('d.m.Y') }}</span>
                    </div>
                @endif
                @if(isset($item->updated_at))
                    <div class="dropdown-info d-flex justify-content-between py-0">
                        <span>Изм:</span>
                        <span>{{ $item->updated_at->format('d.m.Y') }}</span>
                    </div>
                @endif
            @endif
        @endif
    </div>
</div>
