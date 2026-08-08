<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ArticleEditorialWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_editor_can_unpublish_an_article_and_return_it_to_the_writer_as_a_draft(): void
    {
        $writer = $this->userWithRole('writer');
        $editor = $this->userWithRole('editor');
        $article = Article::factory()->create([
            'user_id' => $writer->id,
            'published_at' => now(),
            'istopnews' => 1,
            'rejected' => 0,
        ]);

        $this->actingAs($editor)
            ->withSession(['_token' => 'test-token'])
            ->patch(route('articles.unpublish', $article), ['_token' => 'test-token'])
            ->assertRedirect();

        $article->refresh();

        $this->assertNull($article->published_at);
        $this->assertFalse((bool) $article->istopnews);
        $this->assertFalse((bool) $article->rejected);
        $this->assertFalse((bool) $article->submitted);

        $this->actingAs($writer)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee($article->headline);
    }

    public function test_editor_can_toggle_top_news_only_for_published_articles(): void
    {
        $writer = User::factory()->create();
        $editor = $this->userWithRole('editor');
        $article = Article::factory()->create([
            'user_id' => $writer->id,
            'published_at' => now(),
            'istopnews' => 0,
        ]);

        $this->actingAs($editor)
            ->withSession(['_token' => 'test-token'])
            ->patch(route('articles.maketopnews', $article), ['_token' => 'test-token'])
            ->assertRedirect();

        $this->assertTrue((bool) $article->fresh()->istopnews);

        $this->actingAs($editor)
            ->withSession(['_token' => 'test-token'])
            ->patch(route('articles.removetopnews', $article), ['_token' => 'test-token'])
            ->assertRedirect();

        $this->assertFalse((bool) $article->fresh()->istopnews);

        $article->published_at = null;
        $article->save();

        $this->actingAs($editor)
            ->withSession(['_token' => 'test-token'])
            ->patch(route('articles.maketopnews', $article), ['_token' => 'test-token'])
            ->assertSessionHasErrors();

        $this->assertFalse((bool) $article->fresh()->istopnews);
    }

    public function test_writer_can_submit_a_draft_and_can_no_longer_modify_it_while_it_is_under_review(): void
    {
        $writer = $this->userWithRole('writer');
        $editor = $this->userWithRole('editor');
        $article = Article::factory()->create([
            'user_id' => $writer->id,
            'published_at' => null,
            'rejected' => 0,
            'submitted' => 0,
        ]);

        $this->actingAs($editor)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertDontSee($article->headline);

        $this->actingAs($writer)
            ->withSession(['_token' => 'test-token'])
            ->patch(route('articles.submit', $article), ['_token' => 'test-token'])
            ->assertRedirect();

        $article->refresh();

        $this->assertTrue($article->submitted);
        $this->assertFalse($article->rejected);

        $this->actingAs($writer)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Submitted Articles')
            ->assertSee($article->headline);

        $this->actingAs($writer)
            ->get(route('articles.edit', $article))
            ->assertStatus(401);

        $this->actingAs($writer)
            ->withSession(['_token' => 'test-token'])
            ->delete(route('articles.destroy', $article), ['_token' => 'test-token'])
            ->assertStatus(401);

        $this->actingAs($editor)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee($article->headline);
    }

    public function test_rejected_article_returns_to_writer_and_can_be_resubmitted(): void
    {
        Mail::fake();

        $writer = $this->userWithRole('writer');
        $editor = $this->userWithRole('editor');
        $article = Article::factory()->create([
            'user_id' => $writer->id,
            'published_at' => null,
            'rejected' => 0,
            'submitted' => 1,
        ]);

        $this->actingAs($editor)
            ->withSession(['_token' => 'test-token'])
            ->patch(route('articles.reject', $article), ['_token' => 'test-token'])
            ->assertRedirect();

        $article->refresh();

        $this->assertTrue($article->rejected);
        $this->assertFalse($article->submitted);
        $this->assertNull($article->published_at);

        $this->actingAs($editor)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertDontSee($article->headline);

        $this->actingAs($writer)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Rejected Articles')
            ->assertSee($article->headline);

        $this->actingAs($writer)
            ->get(route('articles.edit', $article))
            ->assertOk();

        $this->actingAs($writer)
            ->withSession(['_token' => 'test-token'])
            ->patch(route('articles.submit', $article), ['_token' => 'test-token'])
            ->assertRedirect();

        $article->refresh();

        $this->assertFalse($article->rejected);
        $this->assertTrue($article->submitted);

        $this->actingAs($writer)
            ->get(route('articles.edit', $article))
            ->assertStatus(401);

        $this->actingAs($editor)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee($article->headline);
    }

    public function test_editor_cannot_review_an_unsubmitted_draft(): void
    {
        $writer = $this->userWithRole('writer');
        $editor = $this->userWithRole('editor');
        $article = Article::factory()->create([
            'user_id' => $writer->id,
            'published_at' => null,
            'rejected' => 0,
            'submitted' => 0,
        ]);

        $this->actingAs($editor)
            ->get(route('articles.show', $article))
            ->assertStatus(401);

        $this->actingAs($editor)
            ->withSession(['_token' => 'test-token'])
            ->patch(route('articles.publish', $article), ['_token' => 'test-token'])
            ->assertStatus(401);

        $this->actingAs($editor)
            ->withSession(['_token' => 'test-token'])
            ->patch(route('articles.reject', $article), ['_token' => 'test-token'])
            ->assertStatus(401);
    }

    public function test_publishing_a_submitted_article_completes_the_review_state(): void
    {
        Mail::fake();

        $writer = $this->userWithRole('writer');
        $editor = $this->userWithRole('editor');
        $article = Article::factory()->create([
            'user_id' => $writer->id,
            'published_at' => null,
            'rejected' => 0,
            'submitted' => 1,
        ]);

        $this->actingAs($editor)
            ->withSession(['_token' => 'test-token'])
            ->patch(route('articles.publish', $article), ['_token' => 'test-token'])
            ->assertRedirect();

        $article->refresh();

        $this->assertNotNull($article->published_at);
        $this->assertFalse($article->submitted);
        $this->assertFalse($article->rejected);
    }

    public function test_editor_cannot_edit_or_delete_another_writers_articles(): void
    {
        $writer = $this->userWithRole('writer');
        $editor = $this->userWithRole('editor');
        $submitted = Article::factory()->create([
            'user_id' => $writer->id,
            'published_at' => null,
            'rejected' => 0,
            'submitted' => 1,
        ]);
        $published = Article::factory()->create([
            'user_id' => $writer->id,
            'published_at' => now(),
            'rejected' => 0,
            'submitted' => 0,
        ]);

        foreach ([$submitted, $published] as $article) {
            $this->actingAs($editor)
                ->get(route('articles.edit', $article))
                ->assertStatus(401);

            $this->actingAs($editor)
                ->withSession(['_token' => 'test-token'])
                ->delete(route('articles.destroy', $article), ['_token' => 'test-token'])
                ->assertStatus(401);
        }
    }

    public function test_writer_editor_must_reject_or_unpublish_their_own_locked_article_before_editing(): void
    {
        Mail::fake();

        $writerEditor = $this->userWithRole('writer');
        $this->addRole($writerEditor, 'editor');

        $submitted = Article::factory()->create([
            'user_id' => $writerEditor->id,
            'published_at' => null,
            'rejected' => 0,
            'submitted' => 1,
        ]);

        $this->actingAs($writerEditor)
            ->get(route('articles.edit', $submitted))
            ->assertStatus(401);

        $this->actingAs($writerEditor)
            ->withSession(['_token' => 'test-token'])
            ->delete(route('articles.destroy', $submitted), ['_token' => 'test-token'])
            ->assertStatus(401);

        $this->actingAs($writerEditor)
            ->withSession(['_token' => 'test-token'])
            ->patch(route('articles.reject', $submitted), ['_token' => 'test-token'])
            ->assertRedirect();

        $this->actingAs($writerEditor)
            ->get(route('articles.edit', $submitted))
            ->assertOk();

        $published = Article::factory()->create([
            'user_id' => $writerEditor->id,
            'published_at' => now(),
            'rejected' => 0,
            'submitted' => 0,
        ]);

        $this->actingAs($writerEditor)
            ->get(route('articles.edit', $published))
            ->assertStatus(401);

        $this->actingAs($writerEditor)
            ->withSession(['_token' => 'test-token'])
            ->patch(route('articles.unpublish', $published), ['_token' => 'test-token'])
            ->assertRedirect();

        $this->actingAs($writerEditor)
            ->get(route('articles.edit', $published))
            ->assertOk();
    }

    private function userWithRole(string $roleName): User
    {
        $user = User::factory()->create();
        $this->addRole($user, $roleName);

        return $user;
    }

    private function addRole(User $user, string $roleName): void
    {
        $role = Role::firstOrCreate(['role' => $roleName]);
        $user->roles()->attach($role);
        $user->unsetRelation('roles');
    }
}
