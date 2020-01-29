<form
        @isset($url)
            action="{{ $url }}"
        @endisset

        @isset($id)
            id="{{ $id }}"
        @endisset

        @if( isset($method) && in_array($method = strtolower($method), ['post', 'put', 'delete']) )
            method="post"
        @endif

        @isset($files)
            enctype="multipart/form-data"
        @endisset

        @isset($class)
            {{-- для валидации надо добавить класс "was-validate"--}}
            class="{{ $class }}"
        @endisset
>
    {{ $slot }}

    @if( isset($method) && in_array($method, ['post', 'put', 'delete']) )
        {{ csrf_field() }}
        @if($method != 'post')
            {{ method_field($method) }}
        @endif
    @endif

    @if( !isset($required_notice) || $required_notice !== false)
        <div>
            <b class="text-danger">*</b> - поле должно быть заполнено!
        </div>
    @endif
</form>