@extends('layouts.app')

@section('content')

    <button onclick="m_pop.notice.success('Проверка связи')">Ок</button>
    <button onclick="m_pop.notice.error()">Ошибка</button>
    <button data-toggle="mp-confirm">Ошибка</button>

    @push('scripts')
        <script src="/js/m_pop.js"></script>
    @endpush

@endsection

