{{--
    Проверяет наличие в сессии всплывающих сообщений и выводит их если есть
--}}

@if( session('notice_success') )
    <script>
        notices.success( '{!! session('notice_success') !!}' );
    </script>
    {{ session()->forget('notice_success') }}
@endif

@if( session('notice_warning') )
    <script>
        notices.warning( '{!! session('notice_warning') !!}' );
    </script>
    {{ session()->forget('notice_warning') }}
@endif

@if( session('notice_error') )
    <script>
        notices.error( '{!! session('notice_error') !!}' );
    </script>
    {{ session()->forget('notice_error') }}
@endif

@if( session('notice_info') )
    <script>
        notices.info( '{!! session('notice_info') !!}' );
    </script>
    {{ session()->forget('notice_info') }}
@endif

@if( $errors->count() )
    @foreach($errors->all() as $err)
        <script>
            notices.error( '{{ $err }}' );
        </script>
    @endforeach
@endif

