@extends('layouts.app')
@section('title', $article->title)
@section('content')
    <div class="row">
        <div class="col-12 col-md-10 offset-md-1">
            <h1>{{ $article->title }}</h1>
            <p class="text-muted">
                Дата публикации: {{ \Carbon\Carbon::parse($article->created)->format('d.m.Y') }}
                @if($article->event)
                    &nbsp;|&nbsp; Мероприятие: <strong>{{ $article->event->title }}</strong>
                @endif
            </p>
            <hr>
            <div class="article-text">
                {!! nl2br(e($article->text)) !!}
            </div>
            <a href="{{ route('index') }}" class="btn btn-outline-secondary mt-3">← Назад к статьям</a>
        </div>
    </div>
@endsection
