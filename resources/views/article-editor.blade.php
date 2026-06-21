@extends('layouts.app')
@section('title', 'Редактор статей')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Статьи</h1>
    <a href="{{ route('admin.article-create') }}" class="btn btn-primary">Добавить статью</a>
</div>
<table class="table table-striped table-borderless">
    <thead>
        <tr>
            <th>Название</th>
            <th>Мероприятие</th>
            <th>Дата</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($articles as $article)
        <tr>
            <td><strong>{{ $article->title }}</strong></td>
            <td>{{ $article->event->title ?? '—' }}</td>
            <td>{{ \Carbon\Carbon::parse($article->created)->format('d.m.Y') }}</td>
            <td class="text-end">
                <a href="{{ route('admin.article-edit', $article) }}" class="btn btn-sm btn-outline-secondary">Редактировать</a>
                <form action="{{ route('admin.article-delete', $article) }}" method="post" class="d-inline" onsubmit="return confirm('Удалить статью?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Удалить</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center text-muted">Статьи не найдены</td>
        </tr>
        @endforelse
    </tbody>
</table>
{{ $articles->links('pagination::bootstrap-4') }}
@endsection
