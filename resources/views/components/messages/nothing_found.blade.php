<div class="jumbotron border display-4 text-center my-4">
    @isset($message)
        {{ $message }}
    @endisset
    @empty($message)
        {{ __('messages.db.nothing_found') }}
    @endempty
</div>