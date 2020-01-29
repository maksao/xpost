{{--

    v.1.0
    $params = ['model'=>'model_name', 'id'=>$model->id]
--}}
<a class="dropdown-item" href="{{ route('logs.show', $params) }}">
    @if(isset($w_icon))
        <i class="fa fa-history fa-fw"></i>
    @endif
    <span class='title'>{{ $label ?? 'История изменений' }}</span>
</a>