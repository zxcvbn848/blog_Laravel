<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryGetTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_category_link_screen_can_be_rendered()
    {
        $response = $this->get('/api/category');

        $response->assertStatus(200);
    }

    public function test_get_category_list_can_be_requested()
    {
        Category::factory()->count(3)->create();

        $response = $this->get('/api/category');

        $response->assertStatus(200);
    }

    public function test_get_category_by_id_can_be_requested()
    {
        Category::factory()->count(5)->create();
        $categoryId = Category::first()->id;

        $response = $this->get('/api/category/'.$categoryId);
        $response->assertStatus(200);
    }
}
