{{--
    Массив строк для выпадающего списка
    v.1.0
--}}
@foreach($options as $option)
    @include('components.forms.elements.option',$option)
@endforeach