<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_article_link_can_be_requested()
    {
        // user login
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        // add article
        $category = Category::factory()->create();
        $article = Article::factory()->create([
            'author_id' => $user->id,
            'category_id' => $category->id,
        ]);
        $tags = Tag::factory()->count(3)->create();
        $requestTags = [];

        foreach ($tags as $tag) {
            ArticleTag::factory()->create([
                'article_id' => $article->id,
                'tag_id' => $tag->id,
            ]);
            array_push($requestTags, $tag['tag']);
        }

        $response = $this->post('/api/article', [
            'title' => $article['title'],
            'category' => $category['category'],
            'article' => $article['article'],
            'tags' => $requestTags,
        ]);

        $response->assertStatus(201);
    }

    public function test_edit_article_link_can_be_requested()
    {
        // user login
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        // add article
        $category = Category::factory()->create();
        $article = Article::factory()->create([
            'author_id' => $user->id,
            'category_id' => $category->id,
        ]);
        $articleId = $article->id;
        $tags = Tag::factory()->count(3)->create();
        $requestTags = [];

        foreach ($tags as $tag) {
            ArticleTag::factory()->create([
                'article_id' => $article->id,
                'tag_id' => $tag->id,
            ]);
            array_push($requestTags, $tag['tag']);
        }

        // edit article
        $newCategory = Category::factory()->create();
        $newArticle = Article::factory()->create([
            'author_id' => $user->id,
            'category_id' => $newCategory->id,
        ]);
        $newTags = Tag::factory()->count(3)->create();
        $newRequestTags = [];

        foreach ($newTags as $newTag) {
            ArticleTag::factory()->create([
                'article_id' => $article->id,
                'tag_id' => $newTag->id,
            ]);
            array_push($newRequestTags, $newTag['tag']);
        }

        $response = $this->patch('/api/article/'.$articleId, [
            'title' => $newArticle['title'],
            'category' => $newCategory['category'],
            'article' => $newArticle['article'],
            'tags' => $newRequestTags,
        ]);

        $response->assertStatus(200);
    }

    public function test_delete_article_link_can_be_requested()
    {
        // user login
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        // add article
        $category = Category::factory()->create();
        $article = Article::factory()->create([
            'author_id' => $user->id,
            'category_id' => $category->id,
        ]);
        $articleId = $article->id;
        $tags = Tag::factory()->count(3)->create();
        $requestTags = [];

        foreach ($tags as $tag) {
            ArticleTag::factory()->create([
                'article_id' => $article->id,
                'tag_id' => $tag->id,
            ]);
            array_push($requestTags, $tag['tag']);
        }

        // delete article
        $response = $this->delete('/api/article/'.$articleId);

        $response->assertStatus(200);
    }
}
