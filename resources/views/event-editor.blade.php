@extends('layouts.app')
@section('title', 'Редактор мероприятий')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Мероприятия</h1>
    <a href="{{ route('admin.event-create') }}" class="btn btn-primary">Добавить мероприятие</a>
</div>
<table class="table table-striped table-borderless">
    <thead>
        <tr>
            <th>Название</th>
            <th>Адрес</th>
            <th>Дата</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($events as $event)
        <tr>
            <td><strong>{{ $event->title }}</strong></td>
            <td>{{ $event->address }}</td>
            <td>{{ \Carbon\Carbon::parse($event->date)->format('d.m.Y') }}</td>
            <td class="text-end">
                <a href="{{ route('admin.event-edit', $event) }}" class="btn btn-sm btn-outline-secondary">Редактировать</a>
                <form action="{{ route('admin.event-delete', $event) }}" method="post" class="d-inline" onsubmit="return confirm('Удалить мероприятие?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Удалить</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center text-muted">Мероприятия не найдены</td>
        </tr>
        @endforelse
    </tbody>
</table>
{{ $events->links('pagination::bootstrap-4') }}
@endsection
