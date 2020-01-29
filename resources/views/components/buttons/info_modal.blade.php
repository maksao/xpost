{{--
    v.1.0
--}}
<button type="button" class="btn btn-{{ $theme ?? 'outline-primary' }} btn-{{ $size ?? 'xs' }}" data-toggle="modal-info" data-title="{{ $title ?? 'Информация' }}" data-target="#{{ $id }}">
    <i class="{{ $icon ?? 'fas fa-book-open' }}"></i>
</button>
<div hidden id="{{ $id }}">{{ $slot }}</div>