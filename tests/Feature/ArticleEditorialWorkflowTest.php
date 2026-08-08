<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
            ->patch(route('articles.unpublish', $article))
            ->assertRedirect();

        $article->refresh();

        $this->assertNull($article->published_at);
        $this->assertFalse((bool) $article->istopnews);
        $this->assertFalse((bool) $article->rejected);

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
            ->patch(route('articles.maketopnews', $article))
            ->assertRedirect();

        $this->assertTrue((bool) $article->fresh()->istopnews);

        $this->actingAs($editor)
            ->patch(route('articles.removetopnews', $article))
            ->assertRedirect();

        $this->assertFalse((bool) $article->fresh()->istopnews);

        $article->published_at = null;
        $article->save();

        $this->actingAs($editor)
            ->patch(route('articles.maketopnews', $article))
            ->assertSessionHasErrors();

        $this->assertFalse((bool) $article->fresh()->istopnews);
    }

    private function userWithRole(string $roleName): User
    {
        $user = User::factory()->create();
        $role = Role::firstOrCreate(['role' => $roleName]);
        $user->roles()->attach($role);

        return $user;
    }
}
