<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    private function regularUser(): User
    {
        return User::factory()->create();
    }

    // --- Access control ---

    public function test_guest_cannot_access_admin_panel(): void
    {
        $this->get('/admin')->assertRedirect('/login');
    }

    public function test_regular_user_cannot_access_admin_panel(): void
    {
        $this->actingAs($this->regularUser())
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_admin_can_access_admin_panel(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin')
            ->assertOk();
    }

    // --- Events CRUD ---

    public function test_admin_can_view_events_list(): void
    {
        $event = Event::factory()->create();

        $this->actingAs($this->admin())
            ->get('/admin/events')
            ->assertOk()
            ->assertSee($event->title);
    }

    public function test_admin_can_open_event_create_form(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/events/create')
            ->assertOk();
    }

    public function test_admin_can_create_event(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/events', [
                'title'   => 'Тестовое мероприятие',
                'address' => 'г. Москва, ул. Тестовая, 1',
                'date'    => '2025-12-01',
            ])
            ->assertRedirect('/admin/events');

        $this->assertDatabaseHas('events', ['title' => 'Тестовое мероприятие']);
    }

    public function test_create_event_validates_required_fields(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/events', [])
            ->assertSessionHasErrors(['title', 'address', 'date']);
    }

    public function test_admin_can_update_event(): void
    {
        $event = Event::factory()->create();

        $this->actingAs($this->admin())
            ->patch("/admin/events/{$event->id}", [
                'title'   => 'Обновлённое мероприятие',
                'address' => 'Новый адрес',
                'date'    => '2025-12-15',
            ])
            ->assertRedirect('/admin/events');

        $this->assertDatabaseHas('events', ['title' => 'Обновлённое мероприятие']);
    }

    public function test_admin_can_delete_event(): void
    {
        $event = Event::factory()->create();

        $this->actingAs($this->admin())
            ->delete("/admin/events/{$event->id}")
            ->assertRedirect('/admin/events');

        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }

    public function test_deleting_event_also_deletes_its_articles(): void
    {
        $event   = Event::factory()->create();
        $article = Article::factory()->create(['event_id' => $event->id]);

        $this->actingAs($this->admin())
            ->delete("/admin/events/{$event->id}");

        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }

    // --- Articles CRUD ---

    public function test_admin_can_view_articles_list(): void
    {
        $article = Article::factory()->create();

        $this->actingAs($this->admin())
            ->get('/admin/articles')
            ->assertOk()
            ->assertSee($article->title);
    }

    public function test_admin_can_open_article_create_form(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/articles/create')
            ->assertOk();
    }

    public function test_admin_can_create_article(): void
    {
        $event = Event::factory()->create();

        $this->actingAs($this->admin())
            ->post('/admin/articles', [
                'title'    => 'Тестовая статья',
                'text'     => 'Текст тестовой статьи',
                'event_id' => $event->id,
            ])
            ->assertRedirect('/admin/articles');

        $this->assertDatabaseHas('articles', ['title' => 'Тестовая статья']);
    }

    public function test_create_article_validates_required_fields(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/articles', [])
            ->assertSessionHasErrors(['title', 'text', 'event_id']);
    }

    public function test_create_article_validates_event_exists(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/articles', [
                'title'    => 'Статья',
                'text'     => 'Текст',
                'event_id' => 9999,
            ])
            ->assertSessionHasErrors(['event_id']);
    }

    public function test_admin_can_update_article(): void
    {
        $article = Article::factory()->create();
        $event   = Event::factory()->create();

        $this->actingAs($this->admin())
            ->patch("/admin/articles/{$article->id}", [
                'title'    => 'Обновлённая статья',
                'text'     => 'Новый текст',
                'event_id' => $event->id,
            ])
            ->assertRedirect('/admin/articles');

        $this->assertDatabaseHas('articles', ['title' => 'Обновлённая статья']);
    }

    public function test_admin_can_delete_article(): void
    {
        $article = Article::factory()->create();

        $this->actingAs($this->admin())
            ->delete("/admin/articles/{$article->id}")
            ->assertRedirect('/admin/articles');

        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }
}
