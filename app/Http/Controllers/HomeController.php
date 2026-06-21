<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private const EVENT_RULES = [
        'title'   => 'required|max:100',
        'address' => 'required|max:300',
        'date'    => 'required|date',
    ];

    private const ARTICLE_RULES = [
        'title'    => 'required|max:100',
        'text'     => 'required',
        'event_id' => 'required|integer|exists:events,id',
    ];

    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        return view('admin');
    }

    public function event_editor()
    {
        $events = Event::latest()->paginate(10);
        return view('event-editor', compact('events'));
    }

    public function event_create()
    {
        return view('event-create');
    }

    public function event_store(Request $request)
    {
        $validated = $request->validate(self::EVENT_RULES);
        Event::create($validated);
        return redirect()->route('admin.event-editor');
    }

    public function event_edit(Event $event)
    {
        return view('event-edit', compact('event'));
    }

    public function event_update(Request $request, Event $event)
    {
        $validated = $request->validate(self::EVENT_RULES);
        $event->update($validated);
        return redirect()->route('admin.event-editor');
    }

    public function event_delete(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.event-editor');
    }

    public function article_editor()
    {
        $articles = Article::with('event')->latest()->paginate(10);
        return view('article-editor', compact('articles'));
    }

    public function article_create()
    {
        $events = Event::orderBy('title')->get();
        return view('article-create', compact('events'));
    }

    public function article_store(Request $request)
    {
        $validated = $request->validate(self::ARTICLE_RULES);
        $validated['created'] = now()->toDateString();
        Article::create($validated);
        return redirect()->route('admin.article-editor');
    }

    public function article_edit(Article $article)
    {
        $events = Event::orderBy('title')->get();
        return view('article-edit', compact('article', 'events'));
    }

    public function article_update(Request $request, Article $article)
    {
        $validated = $request->validate(self::ARTICLE_RULES);
        $article->update($validated);
        return redirect()->route('admin.article-editor');
    }

    public function article_delete(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.article-editor');
    }
}
