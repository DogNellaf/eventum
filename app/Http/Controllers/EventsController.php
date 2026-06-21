<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index()
    {
        $articles = Article::with('event')->latest()->paginate(10);
        return view('index', compact('articles'));
    }

    public function detail(Article $article)
    {
        $article->load('event');
        return view('detail', compact('article'));
    }
}
