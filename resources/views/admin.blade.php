@extends('layouts.app')

@section('title', 'Панель администратора')

@section('content')
<h1 class="mb-4">Панель администратора</h1>
<div class="row">
    <div class="col-6 col-md-3 mb-3">
        <a href="{{ route('admin.event-editor') }}" class="button">Мероприятия</a>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <a href="{{ route('admin.article-editor') }}" class="button">Статьи</a>
    </div>
</div>
@endsection
