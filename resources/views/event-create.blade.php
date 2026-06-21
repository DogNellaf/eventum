@extends('layouts.app')

@section('title', 'Добавление мероприятия')

@section('content')
<h1 class="mb-4">Добавление мероприятия</h1>
<form action="{{ route('admin.event-store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="txtTitle" class="form-label">Название</label>
        <input name="title" id="txtTitle" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label for="txtAddress" class="form-label">Адрес</label>
        <textarea name="address" id="txtAddress" class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address') }}</textarea>
        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label for="txtDate" class="form-label">Дата</label>
        <input name="date" id="txtDate" type="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}">
        @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="d-flex gap-2">
        <input type="submit" class="btn btn-primary" value="Добавить">
        <a href="{{ route('admin.event-editor') }}" class="btn btn-outline-secondary">Отмена</a>
    </div>
</form>
@endsection
