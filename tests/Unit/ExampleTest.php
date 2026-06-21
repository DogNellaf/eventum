<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    // --- Event model ---

    public function test_event_has_fillable_fields(): void
    {
        $event = new Event(['title' => 'T', 'address' => 'A', 'date' => '2025-01-01']);

        $this->assertEquals('T', $event->title);
        $this->assertEquals('A', $event->address);
        $this->assertEquals('2025-01-01', $event->date);
    }

    public function test_event_has_many_articles(): void
    {
        $event    = Event::factory()->create();
        $articles = Article::factory()->count(3)->create(['event_id' => $event->id]);

        $this->assertCount(3, $event->articles);
        $this->assertInstanceOf(Article::class, $event->articles->first());
    }

    // --- Article model ---

    public function test_article_has_fillable_fields(): void
    {
        $event   = Event::factory()->create();
        $article = new Article([
            'title'    => 'Заголовок',
            'text'     => 'Текст',
            'created'  => '2025-01-01',
            'event_id' => $event->id,
        ]);

        $this->assertEquals('Заголовок', $article->title);
        $this->assertEquals('Текст', $article->text);
        $this->assertEquals($event->id, $article->event_id);
    }

    public function test_article_belongs_to_event(): void
    {
        $event   = Event::factory()->create();
        $article = Article::factory()->create(['event_id' => $event->id]);

        $this->assertInstanceOf(Event::class, $article->event);
        $this->assertEquals($event->id, $article->event->id);
    }

    // --- User model ---

    public function test_user_is_not_admin_by_default(): void
    {
        $user = User::factory()->create();

        $this->assertFalse((bool) $user->is_admin);
    }

    public function test_admin_factory_state_sets_is_admin(): void
    {
        $admin = User::factory()->admin()->create();

        $this->assertTrue((bool) $admin->is_admin);
    }

    public function test_user_password_is_hidden(): void
    {
        $user = User::factory()->make();

        $this->assertNotContains('password', array_keys($user->toArray()));
    }
}
