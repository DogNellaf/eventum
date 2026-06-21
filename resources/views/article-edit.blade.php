@extends('layouts.app')

@section('title', 'Редактирование статьи')

@section('content')
<h1 class="mb-4">Редактирование статьи</h1>
<form action="{{ route('admin.article-update', $article) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="mb-3">
        <label for="txtTitle" class="form-label">Название</label>
        <input name="title" id="txtTitle" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $article->title) }}">
        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label for="txtText" class="form-label">Текст</label>
        <textarea name="text" id="txtText" class="form-control @error('text') is-invalid @enderror" rows="6">{{ old('text', $article->text) }}</textarea>
        @error('text')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label for="selEvent" class="form-label">Мероприятие</label>
        <select name="event_id" id="selEvent" class="form-select @error('event_id') is-invalid @enderror">
            <option value="">— выберите мероприятие —</option>
            @foreach($events as $event)
                <option value="{{ $event->id }}" {{ old('event_id', $article->event_id) == $event->id ? 'selected' : '' }}>
                    {{ $event->title }} ({{ \Carbon\Carbon::parse($event->date)->format('d.m.Y') }})
                </option>
            @endforeach
        </select>
        @error('event_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="d-flex gap-2">
        <input type="submit" class="btn btn-primary" value="Сохранить">
        <a href="{{ route('admin.article-editor') }}" class="btn btn-outline-secondary">Отмена</a>
    </div>
</form>
@endsection
