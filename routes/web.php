<?php

use App\Http\Controllers\EventsController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventsController::class, 'index'])->name('index');

Auth::routes();

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');

    Route::get('/events', [HomeController::class, 'event_editor'])->name('event-editor');
    Route::get('/events/create', [HomeController::class, 'event_create'])->name('event-create');
    Route::post('/events', [HomeController::class, 'event_store'])->name('event-store');
    Route::get('/events/{event}/edit', [HomeController::class, 'event_edit'])->name('event-edit');
    Route::patch('/events/{event}', [HomeController::class, 'event_update'])->name('event-update');
    Route::delete('/events/{event}', [HomeController::class, 'event_delete'])->name('event-delete');

    Route::get('/articles', [HomeController::class, 'article_editor'])->name('article-editor');
    Route::get('/articles/create', [HomeController::class, 'article_create'])->name('article-create');
    Route::post('/articles', [HomeController::class, 'article_store'])->name('article-store');
    Route::get('/articles/{article}/edit', [HomeController::class, 'article_edit'])->name('article-edit');
    Route::patch('/articles/{article}', [HomeController::class, 'article_update'])->name('article-update');
    Route::delete('/articles/{article}', [HomeController::class, 'article_delete'])->name('article-delete');
});

Route::get('/articles/{article}', [EventsController::class, 'detail'])->name('detail');
