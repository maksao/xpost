@extends('layouts.app')

@section('content')
    <table class="table table-hover table-sm">
        <thead>
        <tr class="small">
            <th>Дата</th>
            <th>Пользователь</th>
            <th>Событие</th>
            <th>IP</th>
        </tr>
        </thead>
        @foreach($logs as $log)
            <tr class="small">
                <td>{{ $log->created_at->format('d.m.Y H:i') }}</td>
                <td>{{ $log->user->name }} <span class="text-muted">(id:{{ $log->user->id }})</span></td>
                <td>{{ $log->text }}</td>
                <td>{{ $log->ip }}</td>
            </tr>
        @endforeach
    </table>

@endsection