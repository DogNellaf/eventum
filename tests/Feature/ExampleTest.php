<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_returns_ok(): void
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_home_page_shows_articles(): void
    {
        $event = Event::factory()->create();
        Article::factory()->count(3)->create(['event_id' => $event->id]);

        $this->get('/')->assertStatus(200)->assertSee(Article::first()->title);
    }

    public function test_article_detail_page_returns_ok(): void
    {
        $article = Article::factory()->create();

        $this->get("/articles/{$article->id}")->assertStatus(200)->assertSee($article->title);
    }

    public function test_article_detail_returns_404_for_missing_article(): void
    {
        $this->get('/articles/9999')->assertStatus(404);
    }
}
