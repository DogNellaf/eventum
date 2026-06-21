@extends('layouts.app')
@section('title', 'Главная')
@section('content')
    <h1>Статьи</h1>
    <table class="table table-striped table-borderless">
        <thead>
            <tr>
                <th>Название статьи</th>
                <th>Мероприятие</th>
                <th>Дата</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($articles as $article)
            <tr>
                <td><h5>{{ $article->title }}</h5></td>
                <td>{{ $article->event->title ?? '—' }}</td>
                <td>{{ \Carbon\Carbon::parse($article->created)->format('d.m.Y') }}</td>
                <td>
                    <a href="{{ route('detail', ['article' => $article]) }}" class="btn btn-sm btn-outline-primary">Подробнее</a>
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
