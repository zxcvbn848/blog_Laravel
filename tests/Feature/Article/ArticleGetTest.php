<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleGetTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_article_link_screen_can_be_rendered()
    {
        $response = $this->get('/api/article');

        $response->assertStatus(200);
    }

    public function test_get_article_list_can_be_requested()
    {
        Article::factory()->count(5)->create();

        $response = $this->get('/api/article');

        $response->assertStatus(200);
    }

    public function test_get_article_by_id_can_be_requested()
    {
        Article::factory()->count(5)->create();
        $articleId = Article::first()->id;

        $response = $this->get('/api/article/'.$articleId);
        $response->assertStatus(200);
    }
}
